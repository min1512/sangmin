<?php

namespace App\Http\Controllers\Api\Error;

use App\Http\Controllers\ApiController;
use App\Models\OrderBasic;
use App\Models\OrderInfo;
use App\Models\UserClient;
use Illuminate\Http\Request;

class ErrorController extends ApiController
{
    public function getError(Request $request) {
        dd($this->code->error);
        dd($request->all());
    }

    public function getTest(Request $request) {
        return view("api.test");
    }

    public function postTest(Request $request) {
        return $request->all();
    }

    public function postPopup(Request $request){
        return view("api.popup");
    }

    public function temp_popup(Request $request){
        $day = $request->day;
        $day = str_replace("년","-",$day);
        $day = str_replace("월","-",$day);
        $day = str_replace("일","",$day);

        $key = $request->key;
        $User_Client = UserClient::where('api_token',$key)->get();

        $OrderBasic = new OrderBasic();
        $OrderBasic->order_name = $request->reservation_name_2;
        $OrderBasic->order_hp = $request->reservation_tel_2;
        $OrderBasic->reserve_name = $request->reservation_name_1;
        $OrderBasic->reserve_hp = $request->reservation_tel_1;
        $OrderBasic->reserve_date = $day;
        $OrderBasic->reserve_total = str_replace(",","",$request->total_price);
        $OrderBasic->reserve_scene = $request->only_option_price;
        $OrderBasic->save();

        $room_id = $request->room_id;
        $term = $request->term;
        foreach ($room_id as $k => $v){
            foreach ($term as $t =>$v2){
                if($k==$t){
                    if($v2==1) {
                        $OrderInfo = new OrderInfo();
                        $OrderInfo->client_id = $User_Client[0]->user_id;
                        $OrderInfo->room_price = str_replace(",","",$request->total_price);
                        $OrderInfo->order_id = $OrderBasic->id;
                        $OrderInfo->room_id = $v;
                        $OrderInfo->reserve_date = $day;
                        $OrderInfo->save();
                    }else{
                        for($i= $v2; $i>=1; $i--){
                            $OrderInfo = new OrderInfo();
                            $OrderInfo->client_id = $User_Client[0]->user_id;
                            $OrderInfo->room_price = str_replace(",","",$request->total_price);
                            $OrderInfo->order_id = $OrderBasic->id;
                            $OrderInfo->room_id = $v;
                            $OrderInfo->reserve_date = date("Y-m-d",strtotime ("+".($i-1)."days", strtotime("$day")));
                            $OrderInfo->save();
                        }
                    }
                }
            }
        }

        return $OrderBasic->id;
    }
}
