<?php

namespace App\Http\Controllers\Admin\Call;

use App\Http\Controllers\Controller;
use App\Models\AdditionEtcPrice;
use App\Models\AdditionEtcPriceRoom;
use App\Models\ClientTypeRoom;
use App\Models\Code;
use App\Models\OrderBasic;
use App\Models\OrderInfo;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;

class ClientController extends Controller
{
    protected $data = [];
    protected $phone = true;

    public function __construct(Request $request) {
        $agent = new Agent();
        $this->phone = $agent->isPhone()?"mobile":"pc";

        $this->data['code'] = 200;
        $this->data['message'] = 'Success';
    }

    public function postRoom(Request $request) {
        $client_id = $request->input("client_id");
        $selected_date = $request->input("ymd",date("Y-m-d"));
        $selected = explode("-",$selected_date);
        $selected_year = $selected[0];
        $selected_month = $selected[1];
        $selected_day = $selected[2];

        $this->data['room'] = ClientTypeRoom::leftJoin('client_type','client_type.id','=','client_type_room.type_id')
            ->where('client_type_room.user_id',$client_id)
            ->where('client_type_room.flag_realtime','Y')
            ->selectraw("
                client_type_room.*
                , client_type.room_cnt_basic
                , client_type.room_cnt_max
                , (select count(id) from order_info where order_info.client_id = '".$client_id."' and order_info.room_id = client_type_room.id and order_info.reserve_date = '".date("Y-m-d",strtotime("+0 days",strtotime($selected_date)))."') as day_0
                , (select count(id) from order_info where order_info.client_id = '".$client_id."' and order_info.room_id = client_type_room.id and order_info.reserve_date = '".date("Y-m-d",strtotime("+1 days",strtotime($selected_date)))."') as day_1
                , (select count(id) from order_info where order_info.client_id = '".$client_id."' and order_info.room_id = client_type_room.id and order_info.reserve_date = '".date("Y-m-d",strtotime("+2 days",strtotime($selected_date)))."') as day_2
                , (select count(id) from order_info where order_info.client_id = '".$client_id."' and order_info.room_id = client_type_room.id and order_info.reserve_date = '".date("Y-m-d",strtotime("+3 days",strtotime($selected_date)))."') as day_3
                , (select count(id) from order_info where order_info.client_id = '".$client_id."' and order_info.room_id = client_type_room.id and order_info.reserve_date = '".date("Y-m-d",strtotime("+4 days",strtotime($selected_date)))."') as day_4
                , (select count(id) from order_info where order_info.client_id = '".$client_id."' and order_info.room_id = client_type_room.id and order_info.reserve_date = '".date("Y-m-d",strtotime("+5 days",strtotime($selected_date)))."') as day_5
                , (select ifnull(client_season.season_name,'비수기') from client_season_term left join client_season on client_season.id = client_season_term.season_id where client_season_term.season_start <= '".date("Y-m-d",strtotime("+5 days",strtotime($selected_date)))."' and client_season_term.season_end >= '".date("Y-m-d",strtotime("+0 days",strtotime($selected_date)))."') as season_0
                , (select ifnull(client_season.season_name,'비수기') from client_season_term left join client_season on client_season.id = client_season_term.season_id where client_season_term.season_start <= '".date("Y-m-d",strtotime("+5 days",strtotime($selected_date)))."' and client_season_term.season_end >= '".date("Y-m-d",strtotime("+1 days",strtotime($selected_date)))."') as season_1
                , (select ifnull(client_season.season_name,'비수기') from client_season_term left join client_season on client_season.id = client_season_term.season_id where client_season_term.season_start <= '".date("Y-m-d",strtotime("+5 days",strtotime($selected_date)))."' and client_season_term.season_end >= '".date("Y-m-d",strtotime("+2 days",strtotime($selected_date)))."') as season_2
                , (select ifnull(client_season.season_name,'비수기') from client_season_term left join client_season on client_season.id = client_season_term.season_id where client_season_term.season_start <= '".date("Y-m-d",strtotime("+5 days",strtotime($selected_date)))."' and client_season_term.season_end >= '".date("Y-m-d",strtotime("+3 days",strtotime($selected_date)))."') as season_3
                , (select ifnull(client_season.season_name,'비수기') from client_season_term left join client_season on client_season.id = client_season_term.season_id where client_season_term.season_start <= '".date("Y-m-d",strtotime("+5 days",strtotime($selected_date)))."' and client_season_term.season_end >= '".date("Y-m-d",strtotime("+4 days",strtotime($selected_date)))."') as season_4
                , (select ifnull(client_season.season_name,'비수기') from client_season_term left join client_season on client_season.id = client_season_term.season_id where client_season_term.season_start <= '".date("Y-m-d",strtotime("+5 days",strtotime($selected_date)))."' and client_season_term.season_end >= '".date("Y-m-d",strtotime("+5 days",strtotime($selected_date)))."') as season_5
                , (select group_concat(code.code_name separator ',') from client_type_facility left join code on code.code = client_type_facility.code_facility where client_type_facility.user_id = '".$client_id."' and client_type_facility.type_id = client_type_room.type_id) as facility
                , (select group_concat(client_type_facility.code_facility separator ',') from client_type_facility where client_type_facility.user_id = '".$client_id."' and client_type_facility.type_id = client_type_room.type_id) as code_facility
                , (select data_price.price_sales from data_price where data_price.room_id = client_type_room.id and data_price.date = '".date("Y-m-d",strtotime("+0 days",strtotime($selected_date)))."') as price_sales_0
                , (select data_price.price_sales from data_price where data_price.room_id = client_type_room.id and data_price.date = '".date("Y-m-d",strtotime("+1 days",strtotime($selected_date)))."') as price_sales_1
                , (select data_price.price_sales from data_price where data_price.room_id = client_type_room.id and data_price.date = '".date("Y-m-d",strtotime("+2 days",strtotime($selected_date)))."') as price_sales_2
                , (select data_price.price_sales from data_price where data_price.room_id = client_type_room.id and data_price.date = '".date("Y-m-d",strtotime("+3 days",strtotime($selected_date)))."') as price_sales_3
                , (select data_price.price_sales from data_price where data_price.room_id = client_type_room.id and data_price.date = '".date("Y-m-d",strtotime("+4 days",strtotime($selected_date)))."') as price_sales_4
                , (select data_price.price_sales from data_price where data_price.room_id = client_type_room.id and data_price.date = '".date("Y-m-d",strtotime("+5 days",strtotime($selected_date)))."') as price_sales_5
                , (select user_client.adult from user_client where user_client.user_id = '".$client_id."') as flag_adult
                , (select user_client.child from user_client where user_client.user_id = '".$client_id."') as flag_child
                , (select user_client.young from user_client where user_client.user_id = '".$client_id."') as flag_baby
            ")
            ->get();
        $fac = AdditionEtcPriceRoom::leftJoin('addition_etc_price','addition_etc_price.id','=','addition_etc_price_room.addition_etc_price_id')
            ->where('addition_etc_price_room.user_id',$client_id)
            ->select('addition_etc_price_room.*')
            ->addSelect('addition_etc_price.etc_price')
            ->addSelect('addition_etc_price.etc_content')
            ->addSelect('addition_etc_price.etc_dan')
            ->get();
        foreach($fac as $f){
            $this->data['facility'][$f->room_id][] = $f;
        }

        return response()->json($this->data);
    }

    public function postRoomReserve(Request $request) {
        $order = new OrderBasic();
        $order->order_name      = $request->input("top_order_name","");
        $order->order_hp        = $request->input("top_order_hp","");
        $order->reserve_name    = $request->input("top_order_name",""); //직접 예약 시 주문자와 신청자 동일하다 가정함
        $order->reserve_hp      = $request->input("top_order_hp",""); //직접 예약 시 주문자와 신청자 동일하다 가정함
        $order->reserve_date    = $request->input("top_reserve_date");
        $order->reserve_total   = str_replace(",","",$request->input("top_price_total"));
        $order->reserve_request = $request->input("top_request","");
        $order->reserve_memo    = $request->input("top_request_memo","");
        $order->save();

        foreach($request->input("room") as $rk => $rv){
            for($o=0; $o<$request->input("overday.".$rk); $o++) {
                //부대시설 신청 내용에 대한 DB 조회
                $fac_list = [];
                $fac_price = [];
                $fac_content = [];
                if($request->input("facility.".$rk)) {
                    foreach ($request->input("facility." . $rk) as $fc) {
                        $tc = AdditionEtcPriceRoom::leftJoin('addition_etc_price', 'addition_etc_price.id', '=', 'addition_etc_price_room.addition_etc_price_id')
                            ->where('addition_etc_price_room.id', $fc)->first();
                        $fac_list[] = $fc;
                        $fac_price[] = $tc->etc_price;
                        $fac_content[] = $fc . "^" . $tc->etc_price . "^" . $tc->etc_content;
                    }
                }

                $info = new OrderInfo();
                $info->order_id = $order->id;
                $info->client_id = $request->input("top_client");
                $info->room_id = $rk;
                $info->reserve_date = date("Y-m-d",strtotime("+".$o." days",strtotime($request->input("top_reserve_date"))));
                $info->reserve_continue = $o>0 ? "Y" : "N";
                $info->cnt_adult = $request->input("cnt_adult." . $rk);
                $info->cnt_child = $request->input("cnt_child." . $rk);
                $info->cnt_baby = $request->input("cnt_baby." . $rk);
                $info->room_facility = array_sum($fac_price);
                $info->room_facility_cont = join(",", $fac_content);
                $info->save();
            }
        }

        return redirect()->route('order.list');
    }
}
