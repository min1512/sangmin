<?php

namespace App\Http\Controllers\Admin\State;

use App\Http\Controllers\Controller;
use App\Models\ClientTypeRoom;
use App\Models\OrderInfo;
use App\Models\UserClient;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;

class MainController extends Controller
{
    protected $data = [];
    protected $phone = true;

    public function __construct() {
        $agent = new Agent();
        $this->phone = $agent->isPhone()?"mobile":"pc";

        $this->data['code'] = 200;
        $this->data['message'] = 'Success';
    }

    public function getList() {
        $this->data['list'] = UserClient::where('flag_use','Y')->paginate(20);

        return view('admin.'.$this->phone.'.state.list',$this->data);
    }

    public function getRoom(Request $request, $id="") {
        $this->data['id'] = $id;

        $yy = $request->query("yy",date("Y"));
        $mm = $request->query("mm",date("n"));
        $dd = $request->query("dd",date("j"));
        $date = $yy."-".$mm."-".$dd;

        $this->data['date']['prev'] = strtotime("-1 days",strtotime($date));
        $this->data['date']['curr'] = strtotime($date);
        $this->data['date']['next'] = strtotime("+1 days",strtotime($date));
        $this->data['date']['yoil'] = ['일','월','화','수','목','금','토'];

        $this->data['rooms'] = ClientTypeRoom::where('user_id',$id)->get();
        foreach($this->data['rooms'] as $r) {
            $this->data['state'][$r->id] = OrderInfo::leftJoin('order_basic', 'order_basic.id', '=', 'order_info.order_id')
                ->where('order_info.reserve_date', date("Y-m-d", strtotime($date)))
                ->where('order_info.room_id',$r->id)
                ->selectRaw('order_info.*, order_basic.order_hp, order_basic.order_name, order_basic.reserve_hp, order_basic.reserve_name, order_basic.reserve_scene, order_basic.reserve_request, order_basic.reserve_request')
                ->first();
        }

        return view('admin.'.$this->phone.'.state.list_room',$this->data);
    }

    public function postRoomState(Request $request, $id){
        $field = $request->input("field");
        $info = OrderInfo::find($id);
        $info->{$field} = $info->{$field}==null?date("Y-m-d H:i:s"):null;
        $info->save();

        return response()->json($this->data);
    }

    public function getOrder(Request $request, $id="") {
        $this->data['id'] = $id;

        $yy = $request->query("yy",date("Y"));
        $mm = $request->query("mm",date("n"));
        $dd = $request->query("dd",date("j"));
        $date = $yy."-".$mm."-".$dd;

        $this->data['date']['start'] = date("Y-m-d",strtotime($date));
        $this->data['date']['end'] = date("Y-m-d",strtotime("+21 days",strtotime($date)));
        $this->data['yoil'] = ['일','월','화','수','목','금','토'];

        $this->data['rooms'] = ClientTypeRoom::where('user_id',$id)->get();
        foreach($this->data['rooms'] as $k => $r){
            $tmp_order = OrderInfo::leftJoin('order_basic','order_basic.id','=','order_info.order_id')
                ->where('order_info.room_id',$r->id)
                ->where('order_info.client_id',$id)
                ->whereBetween('order_info.reserve_date',[date("Y-m-d",strtotime($date)),date("Y-m-d",strtotime("+21 days",strtotime($date)))])
                ->selectRaw('
                    order_info.*
                    , order_basic.reserve_name
                    , order_basic.reserve_hp
                    , order_basic.reserve_price_out
                    , order_basic.reserve_price
                    , order_basic.reserve_scene
                ')
                ->get();
            foreach($tmp_order as $to) {
                $this->data['order'][$to->reserve_date][$r->id]['name'] = $to->reserve_name;
                $this->data['order'][$to->reserve_date][$r->id]['hp'] = $to->reserve_hp;
                $this->data['order'][$to->reserve_date][$r->id]['price_reserve'] = $to->reserve_price+$to->reserve_price_out;
                $this->data['order'][$to->reserve_date][$r->id]['price_charge'] = $to->reserve_price;
                $this->data['order'][$to->reserve_date][$r->id]['price_scene'] = $to->reserve_scene;
                $this->data['order'][$to->reserve_date][$r->id]['over_start'] = OrderInfo::where('reserve_continue','N')->where('room_id',$to->room_id)->where('order_id',$to->order_id)->value('reserve_date');
                $this->data['order'][$to->reserve_date][$r->id]['over_end'] = OrderInfo::where('room_id',$to->room_id)->where('order_id',$to->order_id)->orderBy('reserve_date','desc')->take(1)->value('reserve_date');
            }
        }

        return view('admin.'.$this->phone.'.state.list_order',$this->data);
    }

    public function postOrderMore(Request $request, $id="") {
        $this->data['id'] = $id;

        $tmp = $request->input("type","next");
        $type = $tmp=="next"?"+7":"-7";
        $yy = $request->input("yy",date("Y", strtotime($request->input("date"))));
        $mm = $request->input("mm",date("n", strtotime($request->input("date"))));
        $dd = $request->input("dd",date("j", strtotime($request->input("date"))));
        $date = $yy."-".$mm."-".$dd;

        if($tmp=="next") {
            $this->data['date']['start'] = date("Y-m-d", strtotime($date));
            $this->data['date']['end'] = date("Y-m-d",strtotime($type." days",strtotime($date)));
        }
//        else {
//            $this->data['date']['start'] = date("Y-m-d",strtotime($type." days",strtotime($date)));
//            $this->data['date']['end'] = date("Y-m-d", strtotime($date));
//        }
        $this->data['yoil'] = ['일','월','화','수','목','금','토'];

        $this->data['rooms'] = ClientTypeRoom::where('user_id',$id)->get();
        foreach($this->data['rooms'] as $k => $r){
            $tmp_order = OrderInfo::leftJoin('order_basic','order_basic.id','=','order_info.order_id')
                ->where('order_info.room_id',$r->id)
                ->where('order_info.client_id',$id)
                ->whereBetween('order_info.reserve_date',[date("Y-m-d",strtotime($this->data['date']['start'])),date("Y-m-d",strtotime($this->data['date']['end']))])
                ->selectRaw('
                    order_info.*
                    , order_basic.reserve_name
                    , order_basic.reserve_hp
                    , order_basic.reserve_price_out
                    , order_basic.reserve_price
                    , order_basic.reserve_scene
                ')
                ->get();
            foreach($tmp_order as $to) {
                $this->data['order'][$to->reserve_date][$r->id]['name'] = $to->reserve_name;
                $this->data['order'][$to->reserve_date][$r->id]['hp'] = $to->reserve_hp;
                $this->data['order'][$to->reserve_date][$r->id]['price_reserve'] = $to->reserve_price+$to->reserve_price_out;
                $this->data['order'][$to->reserve_date][$r->id]['price_charge'] = $to->reserve_price;
                $this->data['order'][$to->reserve_date][$r->id]['price_scene'] = $to->reserve_scene;
                $this->data['order'][$to->reserve_date][$r->id]['over_start'] = OrderInfo::where('reserve_continue','N')->where('room_id',$to->room_id)->where('order_id',$to->order_id)->value('reserve_date');
                $this->data['order'][$to->reserve_date][$r->id]['over_end'] = OrderInfo::where('room_id',$to->room_id)->where('order_id',$to->order_id)->orderBy('reserve_date','desc')->take(1)->value('reserve_date');
            }
        }

        return response()->json($this->data);
    }
}
