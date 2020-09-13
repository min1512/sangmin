<?php

namespace App\Http\Controllers\Book\Html;

use App\Http\Controllers\Controller;
use App\Models\ClientTypeRoom;
use App\Models\DataFile;
use App\Models\FileData;
use App\Models\Goods;
use App\Models\OrderBasic;
use App\Models\OrderInfo;
use App\Models\UserClient;
use App\Models\UserClientAmanity;
use App\Models\UserClientFacility;
use App\Models\UserClientService;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    protected $data = [];

    public function __construct(Request $request) {
        $token = $request->query("token",null);
        if($token) {
            $client = UserClient::leftJoin('users','users.id','=','user_client.user_id')
                ->where('users.flag_use','Y')
                ->where("user_client.api_token",$token)
                ->first();
            $this->data['client_id'] = $client->user_id;

            $this->data['date'] = $request->query("date",date("Y-m-d"));
        }
    }

    public function getIndex(Request $request, $id) {
        $this->data['id'] = $id;
        $this->data['client_id'] = ClientTypeRoom::where('id',$id)->take(1)->value('user_id');
        $this->data['client']['service'] = UserClientService::leftJoin('code','code.code','=','user_client_service.code_service')
            ->where('user_client_service.user_id',$this->data['client_id'])
            ->selectRaw('user_client_service.*, code.code_name, code.desc_01 as code_icon')
            ->get();
        $this->data['client']['facility'] = UserClientFacility::leftJoin('code','code.code','=','user_client_facility.code_facility')
            ->where('user_client_facility.user_id',$this->data['client_id'])
            ->selectRaw('user_client_facility.*, code.code_name, code.desc_01 as code_icon')
            ->get();
        $this->data['client']['amanity'] = UserClientAmanity::leftJoin('code','code.code','=','user_client_amanity.code_amanity')
            ->where('user_client_amanity.user_id',$this->data['client_id'])
            ->selectRaw('user_client_amanity.*, code.code_name, code.desc_01 as code_icon')
            ->get();

        $this->data['token'] = $request->query("token",null);
        $this->data['goods'] = Goods::leftJoin('client_type_room','client_type_room.id','=','goods.room_id')
            ->leftJoin('client_type','client_type.id','=','client_type_room.type_id')
            ->where('goods.client_id',$this->data['client_id'])
            ->where('goods.room_id',$id)
            ->where('goods.goods_date_start','<=',$this->data['date'])
            ->where('goods.goods_date_end','>=',$this->data['date'])
            ->where('goods.goods_days','like','%'.date("w",strtotime($this->data['date'])).'%')
            ->where('goods.flag_use','Y')
            ->selectRaw("
                goods.*
                , client_type_room.room_name
                , client_type.room_cnt_min
                , client_type.room_cnt_basic
                , client_type.room_cnt_max
                , client_type.room_area
                , (select count(id) from goods_date_except where goods_id = goods.id) as cnt_except
                , (select group_concat(code_amanity separator ',') from goods_amanity where goods_id = goods.id) as amenity
                , (select group_concat(code_service separator ',') from goods_service where goods_id = goods.id) as service
                , (select count(*) from order_info where room_id = goods.room_id and reserve_date between '".$this->data['date']."' and '".$this->data['date']."') as cnt_order
            ")
            ->get();
        foreach($this->data['goods'] as $g){
            $this->data['pics'][$g->room_id] = FileData::leftJoin("client_type","client_type.id","=","file_data.target_id")
                ->where("file_data.type","image")
                ->where("file_data.target","client_type")
                ->whereRaw("file_data.target_id = (select type_id from client_type_room where id = '".$g->room_id."')")
                ->get();
        }

        return view('book.html.search', $this->data);
    }

    public function postCallInfo(Request $request, $id) {
        $ww = [];
        for($d=strtotime($request->input("checkDateSt")), $dateTerm=0; $d<strtotime($request->input("checkDateEn")); $d += 86400, $dateTerm++){
            $ww[] = date("w",$d);
        }
        $this->data['id'] = $id;
        $this->data['token'] = $request->query("token",null);
        $this->data['goods'] = Goods::leftJoin('client_type_room','client_type_room.id','=','goods.room_id')
            ->leftJoin('client_type','client_type.id','=','client_type_room.type_id')
            ->where('goods.client_id',$this->data['client_id'])
            ->where('goods.room_id',$id)
            ->where('goods.goods_date_start','<=',$request->input("checkDateSt"))
            ->where('goods.goods_date_end','>',$request->input("checkDateEn"))
            ->where(function($q)use($ww){
                foreach($ww as $k => $w){
                    if($k==0) $q->Where('goods.goods_days','like','%'.$w.'%');
                    else $q->orWhere('goods.goods_days','like','%'.$w.'%');
                }
            })
            ->where('goods.flag_use','Y')
            ->selectRaw("
                goods.*
                , client_type_room.room_name
                , client_type.room_cnt_min
                , client_type.room_cnt_basic
                , client_type.room_cnt_max
                , client_type.room_area
                , (select count(id) from goods_date_except where goods_id = goods.id) as cnt_except
                , (select group_concat(code_amanity separator ',') from goods_amanity where goods_id = goods.id) as amenity
                , (select group_concat(code_service separator ',') from goods_service where goods_id = goods.id) as service
                , (select count(*) from order_info where room_id = goods.room_id and reserve_date between '".$request->input("checkDateSt")."' and '".date("Y-m-d",strtotime("-1 days",strtotime($request->input("checkDateEn"))))."') as cnt_order
                , (select path from file_data where type='image' and target='client_type' and target_id = client_type.id order by orderby asc limit 1) as thumbnail
                , '".join(",",$ww)."' as yoil
                , '".$dateTerm."' as dayTerm
            ")
            ->get();
        foreach($this->data['goods'] as $g){
            $this->data['pics'][$g->room_id] = FileData::leftJoin("client_type","client_type.id","=","file_data.target_id")
                ->where("file_data.type","image")
                ->where("file_data.target","client_type")
                ->whereRaw("file_data.target_id = (select type_id from client_type_room where id = '".$g->room_id."')")
                ->get();
        }

        return response()->json($this->data);
    }

    public function postIndex(Request $request, $id) {
        $total = 0;
        foreach($request->input("goods_price") as $tk => $gp){
            $total += str_replace(",","",$request->input("goods_price.".$tk,0));
        }

        $order = new OrderBasic();
        $order->order_name = $request->input("reserve_name");
        $order->order_hp = join("-",$request->input("reserve_hp"));
        $order->password = $request->input("password");
        $order->reserve_name = $request->input("reserve_name");
        $order->reserve_name = $request->input("reserve_email_id")."@".$request->input("reserve_email_addr");
        $order->reserve_hp = join("-",$request->input("reserve_hp"));
        $order->reserve_date = date("Y-m-d");
        $order->reserve_total = $total;
        $order->reserve_discount = 0;
        $order->reserve_price = 0;
        $order->reserve_price_out = $total - 0;
        $order->reserve_scene = $request->input("reserve_scene","N")=="N"?0:1;
        $order->reserve_request = $request->input("reserve_request");
        $order->reserve_memo = null;
        $order->reserve_channel = null;
        $order->charge_method = $request->input("reserve_method");
        $order->charge_log = null;
        $order->save();

        foreach($request->input("goods_id") as $gk => $gv){
            $tmp_price = explode(",",$request->input("goods_price_list.".$gk));
            for($s=0; $s<$request->input("reserve_term.".$gk); $s++){
                $e = strtotime("+".$s." days", strtotime($request->input("checkin")));
                $orderInfo = new OrderInfo();
                $orderInfo->order_id = $order->id;
                $orderInfo->reserve_date = date("Y-m-d",$e);
                $orderInfo->reserve_continue = $s==0?"N":"Y";
                $orderInfo->room_price = $tmp_price[$s];
                $orderInfo->save();
            }
        }

        return redirect()->route('html.charge',['id'=>$order->id, 'token'=>$request->query("token")]);

        //return response()->json($id);
    }

    public function getPgCharge($id) {
        $this->data['data'] = OrderBasic::find($id);
        $this->data['date'] = date("YmdHis");
        $orderInfo = OrderInfo::leftJoin('goods','goods.id','=','order_info.goods_id')->where('order_info.order_id',$id)->get();
        $this->data['good'] = '';
        foreach($orderInfo as $oi){
            if($this->data['good']=='') $this->data['good'] = $oi->goods_name;
        }
        $this->data['good'] .= sizeof($orderInfo)>1?"외 ".(sizeof($orderInfo)-1)."건":"";

        $this->data['merchantKey']  = "k2GiPBcpkMebbREl2Wjt+SUlqEpJ8DM7V+9kkM8wsNx/1yldkoqLHVIpiASIHl2Qap31xCm5yAgpa2KWY7hjGw==";  // 상점키
        $this->data['merchantID']   = "IMPpensi1m";

        //$this->data['SignData'] = bin2hex(hash('sha256', $this->data['date'].$this->data['merchantID'].$this->data['data']->reserve_price_out.$this->data['merchantKey'], true));
        $this->data['SignData'] = bin2hex(hash('sha256', $this->data['date'].$this->data['merchantID']."1004".$this->data['merchantKey'], true));

        return view('book.html.charge', $this->data);
    }

    public function getComplete(Request $request, $id) {

    }
}
