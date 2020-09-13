<?php

namespace App\Http\Controllers\Admin\Order;

use App\Http\Controllers\Controller;
use App\Http\Resources\Order;
use App\Models\OrderBasic;
use App\Models\OrderInfo;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;

class MainController extends Controller
{
    protected $data = [];
    protected $phone = true;

    public function __construct(Request $request) {
        $agent = new Agent();
        $this->phone = $agent->isPhone()?"mobile":"pc";

        $this->data['code'] = 200;
        $this->data['message'] = 'Success';

        $state = Controller::getCode("order_state");
        foreach($state as $s){
            $this->data['state'][$s->code] = $s->name;
        }
    }

    public function getList() {
        $this->data['order'] = OrderBasic::whereNotIn('order_basic.state',['ready'])
            ->selectraw('
                order_basic.*,
                (select client_name from user_client where user_id = (select client_id from order_info where order_id = order_basic.id limit 1)) as client_name,
                (select reserve_date from order_info where order_id = order_basic.id order by id asc limit 1) as checkin_date,
                (select count(id) from order_info where order_id = order_basic.id) as cnt_over,
                (select sum(cnt_adult) from order_info where order_id = order_basic.id) as cnt_adult,
                (select sum(cnt_child) from order_info where order_id = order_basic.id) as cnt_child,
                (select sum(cnt_baby) from order_info where order_id = order_basic.id) as cnt_baby
            ')
            ->orderby('order_basic.id','desc')
            ->paginate(5);
        foreach($this->data['order'] as $d => $detail) {
            $this->data['detail'][$detail->id] = OrderInfo::leftJoin('client_type_room','client_type_room.id','=','order_info.room_id')
                ->leftJoin('client_type','client_type_room.type_id','=','client_type.id')
                ->where('order_info.order_id',$detail->id)
                ->selectRaw('
                    order_info.*,
                    client_type_room.room_name,
                    client_type.room_cnt_basic,
                    client_type.room_cnt_max,
                    client_type.id as client_type_id,
                    (select reserve_date from order_info where order_id='.$detail->id.' and room_id=order_info.room_id order by reserve_date desc limit 1) as reserve_date_end
                ')
                ->groupBy('order_info.room_id')
                ->orderBy('order_info.room_id','asc')
                ->get();
        }

        return view('admin.'.$this->phone.'.order.order_list', $this->data);
    }

    public function postSave(Request $request){
        dd($request->all());

        $order = OrderBasic::find($request->input("order_id"));
        if(!isset($order)) $order = new OrderBasic();

        $order->order_name = $request->input("order_name");
        $order->order_hp = $request->input("order_hp");
        $order->reserve_name = $request->input("reserve_name");
        $order->reserve_hp = $request->input("reserve_hp");
        $order->reserve_total = 0;
        $order->reserve_discount = 0;
        $order->reserve_price = 0;
        $order->reserve_request = $request->input("reserve_request");
        $order->reserve_memo = $request->input("reserve_memo");
    }

    public function getSave($id="") {
        if($id=="") return redirect()->route("order.list");

        $this->data['info'] = OrderBasic::find($id);
        $this->data['detail'] = OrderInfo::leftjoin('client_type_room','client_type_room.id','=','order_info.room_id')
            ->where('order_info.order_id',$id)
            ->selectraw('order_info.*, client_type_room.room_name, (select client_name from user_client where user_id = order_info.client_id) as client_name')
            ->get();

        return view('admin.'.$this->phone.'.order.order_save', $this->data);
    }

    public function getView() {
        return view('admin.order.order_view');
    }
}
