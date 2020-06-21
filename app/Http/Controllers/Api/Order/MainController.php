<?php

namespace App\Http\Controllers\Api\Order;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Models\AdditionEtcPriceRoom;
use App\Models\ClientDiscount;
use App\Models\ClientDiscountTerm;
use App\Models\ClientSeasonTerm;
use App\Models\ClientTypeRoom;
use App\Models\FileData;
use Illuminate\Http\Request;

class MainController extends ApiController
{
    public function __construct(Request $request)
    {
        parent::__construct($request);
    }

    public function postSet(Request $request) {
        $this->data['room'] = ClientTypeRoom::leftJoin('client_type','client_type.id','=','client_type_room.type_id')
            ->where('client_type_room.id','=',$request->input("room"))
            ->first();
        $this->data['facility'] = AdditionEtcPriceRoom::leftJoin('addition_etc_price','addition_etc_price.id','=','addition_etc_price_room.addition_etc_price_id')
            ->where('addition_etc_price_room.room_id','=',$request->input("room"))
            ->selectraw('addition_etc_price.*')
            ->get();
        $this->data['room_list'] = ClientTypeRoom::leftJoin('client_type','client_type.id','=','client_type_room.type_id')
            ->where('client_type_room.user_id',$this->data['room']->user_id)
            ->where('client_type_room.flag_realtime','Y')
            ->selectraw('client_type_room.*, client_type.type_name, client_type.room_cnt_basic, client_type.room_cnt_max')
            ->get();
        $this->data['season'] = ClientSeasonTerm::leftJoin('client_season','client_season.id','=','client_season_term.season_id')
            ->whereIn('client_season_term.user_id',[0,$this->data['room']->user_id])
            ->get();

        $this->data['discount'] = ClientDiscount::RightJoin('client_discount_term','client_discount_term.discount_id','=','client_discount.id')
            ->where('client_discount.user_id',$this->data['client']->user_id)
            ->where('flag_use',"Y")
            ->get();



        return response()->json($this->data);
    }

    public function postChangeDay(Request $request) {
        $this->data['room_list'] = ClientTypeRoom::leftJoin('client_type','client_type.id','=','client_type_room.type_id')
            ->where('client_type_room.user_id',$this->data['client']->user_id)
            ->where('client_type_room.flag_realtime','Y')
            ->selectraw('client_type_room.*, client_type.type_name, client_type.room_cnt_basic, client_type.room_cnt_max')

            ->get();
        foreach($this->data['room_list'] as $r){
            $temp = FileData::where(['type'=>'image', 'target'=>'client_type', 'target_id'=>$r->type_id])->get();
            if(!$temp) $this->data['room_img'][$r->id] = [];
            else $this->data['room_img'][$r->id] = $temp;
        }

        foreach($this->data['room_list'] as $r) {
            $this->data['facility'][$r->id] = AdditionEtcPriceRoom::leftJoin('addition_etc_price','addition_etc_price.id','=','addition_etc_price_room.addition_etc_price_id')
                ->where('addition_etc_price_room.room_id','=',$r->id)
                ->selectraw('addition_etc_price.*')
                ->get();
        }


        return response()->json($this->data);
    }

    public function postFacility(Request $request) {
        $this->data['facility'] = AdditionEtcPriceRoom::leftJoin('addition_etc_price','addition_etc_price.id','=','addition_etc_price_room.addition_etc_price_id')
            ->where('addition_etc_price_room.room_id','=',$request->input("room"))
            ->selectraw('addition_etc_price.*')
            ->get();

        return response()->json($this->data);
    }
}
