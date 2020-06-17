<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ClientTypeRoomPrice extends Model
{
    protected $table = "client_type_room_price";

//    protected $appends = ['season_name'];
//
//    public function getSeasonNameAttribute() {
//        $tmp = ClientSeason::find($this->season_id);
//        return $tmp->season_name;
//    }

    public function ClientTypeRoomPrice($user_id, $data=[]) {
        $data['tmp_price'] = [
            0 => 'price_day_0'
            , 1 => ['price_day_1','price_day_2','price_day_3','price_day_4']
            , 5 => 'price_day_5'
            , 6 => 'price_day_6'
            , 11 => 'add_adult'
            , 12 => 'add_child'
            , 13 => 'add_baby'
        ];

        foreach ($data['price'] as $p =>$r){
            foreach ($r as $k =>$s ){
                $data['room_id'] = $k;
                foreach ($s as $t =>$v){
                    $data['season_id'] = $t;
                    $isset = ClientTypeRoomPrice::where('room_id',$k)->where('season_id',$data['season_id'])->first();
                    if(!isset($isset)){
                        $ClientTypeRoomPrice = new ClientTypeRoomPrice();
                    }else{
                        $id = ClientTypeRoomPrice::where('room_id',$data['room_id'])->where('season_id',$data['season_id'])->value('id');
                        $ClientTypeRoomPrice = ClientTypeRoomPrice::find($id);
                    }
                    $type_id = DB::table('client_type_room')->where('user_id',$user_id)->where('id',$data['room_id'])->value('type_id');
                    $ClientTypeRoomPrice->user_id = $user_id;
                    $ClientTypeRoomPrice->season_id = $data['season_id'];
                    $price = preg_replace("/[^0-9]/", "",$v);

                    if(is_array($data['tmp_price'][$p])) {
                        foreach ($data['tmp_price'][$p] as $t2) {
                            $ClientTypeRoomPrice->{$t2} = $price;
                        }
                    }
                    else {
                        $ClientTypeRoomPrice->{$data['tmp_price'][$p]} = $price;
                    }
                    $ClientTypeRoomPrice->room_id = $data['room_id'];
                    $ClientTypeRoomPrice->type_id = $type_id;
                    $ClientTypeRoomPrice->save();
                }
            }
        }
    }
}
