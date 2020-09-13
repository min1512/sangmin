<?php

namespace App\Http\Controllers\Admin\Goods;

use App\Http\Controllers\Controller;
use App\Models\ClientTypeRoom;
use App\Models\Code;
use App\Models\Goods;
use App\Models\GoodsAmanity;
use App\Models\GoodsDateExcept;
use App\Models\GoodsService;
use App\Models\UserClient;
use App\Models\UserClientAmanity;
use App\Models\UserClientFacility;
use App\Models\UserClientService;
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

    public function getGoodsList() {
        $this->data['list'] = Goods::leftJoin('user_client','user_client.user_id','=','goods.client_id')
            ->selectRaw("
                goods.*
                , user_client.client_name
                , (select room_name from client_type_room where id = goods.room_id) as room_name
                , (select group_concat(code_amanity separator ',') from goods_amanity where goods_id = goods.id) as amanity
                , (select group_concat(code_service separator ',') from goods_service where goods_id = goods.id) as service
            ")
            ->orderBy('goods.id','desc')
            ->paginate(15);

        return view('admin.'.$this->phone.'.goods.package',$this->data);
    }

    public function getGoodsSave($id="") {
        $this->data['client'] = UserClient::where('flag_use','Y')->get();

        $this->data['goods'] = Goods::find($id);
        if(isset($this->data['goods'])) {
            $this->data['room'] = ClientTypeRoom::where('user_id', $this->data['goods']->client_id)->where('flag_realtime', 'Y')->get();

            $this->data['amanity'] = GoodsAmanity::where('goods_id', $id)->get();
            $this->data['service'] = GoodsService::where('goods_id', $id)->get();

            $this->data['except'] = GoodsDateExcept::where('goods_id', $id)->get();
        }

        return view('admin.'.$this->phone.'.goods.package_save',$this->data);
    }

    public function postGoodsSave(Request $request, $id="") {
        $goods = Goods::find($id);
        if(!isset($goods)) $goods = new Goods();

        $goods->client_id           = $request->input("client_id");
        $goods->room_id             = $request->input("room_id");
        $goods->goods_name          = $request->input("goods_name");
        for($i=0; $i<7; $i++){
            if(in_array($i,[1,2,3,4])) $j=1;
            else $j=$i;
            $goods->{"goods_price_origin_".$i}  = $request->input("goods_price_origin.".$j);
            $goods->{"goods_price_sales_".$i}  = $request->input("goods_price_sales.".$j);
        }
        $goods->goods_date_start    = $request->input("goods_date_start");
        $goods->goods_date_end      = $request->input("goods_date_end");
        $goods->goods_days          = join(",",$request->input("goods_days"));
        $goods->flag_use            = $request->input("flag_use","Y");
        $goods->save();

        //제외일자
        $date_except = $request->input("date_except");
        if(isset($date_except) && sizeof($date_except)){
            $delDate = [];
            foreach($date_except as $e){
                $date = GoodsDateExcept::where(['goods_id'=>$goods->id,'date'=>$e])->first();
                if(!isset($date)) {
                    $date = new GoodsDateExcept();
                    $date->goods_id = $goods->id;
                }
                $date->date = $e;
                $date->save();
                $delDate[] = $date->id;
            }
            GoodsDateExcept::where('goods_id',$goods->id)->whereNotIn('id',$delDate)->delete();
        }

        //구비시설 포함 체크
        $amanity = $request->input("amanity");
        if(isset($amanity) && sizeof($amanity)>0){
            $check_amanity = [];
            foreach($amanity as $a){
                $tmp_amanity = GoodsAmanity::where(['goods_id'=>$goods->id,'code_amanity'=>$a])->first();
                if(!isset($tmp_amanity)) {
                    $tmp_amanity = new GoodsAmanity();
                    $tmp_amanity->goods_id = $goods->id;
                }

                $tmp_amanity->code_amanity = $a;
                $tmp_amanity->save();

                $check_amanity[] = $tmp_amanity->id;
            }
            if(sizeof($check_amanity)>0) GoodsAmanity::whereNotIn('id',$check_amanity)->where('goods_id',$goods->id)->delete();
        }

        //서비스 포함 체크
        $service = $request->input("service");
        if(isset($service) && sizeof($service)>0){
            $check_service = [];
            foreach($service as $s){
                $tmp_service = GoodsService::where(['goods_id'=>$goods->id,'code_service'=>$s])->first();
                if(!isset($tmp_service)) {
                    $tmp_service = new GoodsService();
                    $tmp_service->goods_id = $goods->id;
                }

                $tmp_service->code_service = $s;
                $tmp_service->save();

                $check_service[] = $tmp_service->id;
            }
            if(sizeof($check_service)>0) GoodsService::whereNotIn('id',$check_service)->where('goods_id',$goods->id)->delete();
        }

        return redirect()->route('goods');
    }

    public function postGoodsRooms($id) {
        $this->data['rooms'] = ClientTypeRoom::leftJoin('client_type','client_type.id','=','client_type_room.type_id')
            ->where('client_type_room.flag_realtime','Y')
            ->where('client_type_room.user_id',$id)
            ->selectRaw('client_type_room.*')
            ->get();

        return response()->json($this->data);
    }

    public function postGoodsFacility($id) {
        //숙박업체에서 제공되는 공통 시설/서비스
        $this->data['service'] = UserClientService::leftJoin('code', 'code.code', '=', 'user_client_service.code_service')
            ->where('user_client_service.user_id', $id)
            ->where('user_client_service.flag_use', 'Y')
            ->selectRaw('user_client_service.*, code.code_name')
            ->get();

        //숙박업체의 객실에서 제공되는 시설/서비스
        $this->data['amanity'] = UserClientAmanity::leftJoin('code', 'code.code', '=', 'user_client_amanity.code_amanity')
            ->where('user_client_amanity.user_id', $id)
            ->where('user_client_amanity.flag_use', 'Y')
            ->selectRaw('user_client_amanity.*, code.code_name')
            ->get();

        return response()->json($this->data);
    }
}
