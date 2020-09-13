<?php

namespace App\Http\Controllers\Api\Calendar;

use App\Http\Controllers\ApiController;
use App\Http\Resources\Order;
use App\Models\AutosetDiscountHowmuch;
use App\Models\AutosetDiscountRoom;
use App\Models\BlockTable;
use App\Models\ClientDiscountRoom;
use App\Models\ClientDiscountTerm;
use App\Models\ClientSeasonTerm;
use App\Models\ClientTypeRoom;
use App\Models\ClientTypeRoomPrice;
use App\Models\ClientTypeRoomPriceCustom;
use App\Models\DataPrice;
use App\Models\OrderInfo;
use App\Models\UserClient;
use Illuminate\Http\Request;

class MainController extends ApiController
{
    public function __construct(Request $request)
    {
        parent::__construct($request);
    }

    public function getIndex() {
        dd($this->data);
    }

    public function postRoom(Request $request) {
        $year   = $request->input("year",date("Y"));
        $month  = $request->input("month",date("n"));
        $day    = date("t", strtotime($year."-".$month."-1"));

//        $this->data['season'] = ClientSeasonTerm::leftJoin('client_season','client_season.id','=','client_season_term.season_id')
//            ->whereIn('client_season_term.user_id',[$this->data['client']->user_id])
//            ->where('client_season_term.season_start','<=',date("Y-m-t",strtotime($year.'-'.$month.'-'.$day)))
//            ->where('client_season_term.season_end','>=',date("Y-m-01",strtotime($year.'-'.$month.'-'.$day)))
//            ->first();

        $this->data['room'] = ClientTypeRoom::leftJoin('client_type','client_type.id','=','client_type_room.type_id')
            ->where('client_type_room.user_id',$this->data['client']->user_id)
            ->where('client_type_room.flag_realtime','Y')
            ->selectraw('client_type_room.*')
            ->get();

        $this->data['total'] = $day;

        return response()->json($this->data);
    }

    public function postSeason(Request $request) {
        $year   = $request->input("year",date("Y"));
        $month  = $request->input("month",date("n"));

        $cnt_total = date("t",strtotime($year."-".$month."-1"));
        for($i=1; $i<=$cnt_total; $i++) {
            $this->data['season'][$i] = ClientSeasonTerm::leftJoin('client_season','client_season.id','=','client_season_term.season_id')
                ->whereIn('client_season_term.user_id',[$this->data['client']->user_id])
                ->where('client_season_term.season_start','<=',date("Y-m-d",strtotime($year.'-'.$month.'-'.$i)))
                ->where('client_season_term.season_end','>=',date("Y-m-d",strtotime($year.'-'.$month.'-'.$i)))
                ->first();
        }


        return response()->json($this->data);
    }

    public function postReservation(Request $request) {
        $year       = $request->input("year",date("Y"));
        $month      = $request->input("month",date("n"));
        $curDate    = strtotime($year."-".$month."-1");
        $day        = date("t", $curDate);

        $room = ClientTypeRoom::leftJoin('client_type','client_type.id','=','client_type_room.type_id')
            ->where('client_type_room.user_id',$this->data['client']->user_id)
            ->where('client_type_room.flag_realtime','Y')
            ->selectraw('client_type_room.*')
            ->get();

        for($i=0; $i < $day; $i++) {
            foreach ($room as $r) {
                //방막기
                $this->data['block'][$i][$r->id] = BlockTable::leftJoin('client_type_room','client_type_room.id','=','block_table.room_id')
                    ->where('day','=',date("Y-m-d",strtotime("+".$i."days",$curDate)))
                    ->selectraw('block_table.flag');

                //일자별 예약 상태 조회
                $this->data['order'][$i][$r->id] = OrderInfo::leftJoin('order_basic', 'order_basic.id', '=', 'order_info.order_id')
                    ->where(['order_info.room_id' => $r->id, 'order_info.reserve_date' => date("Y-m-d", strtotime("+" . $i . " days", $curDate))])
                    ->selectraw('order_basic.state')
                    ->union($this->data['block'][$i][$r->id])
                    ->first();
            }
        }

        $this->data['total'] = $day;

        return response()->json($this->data);
    }


    public function postPrice(Request $request) {

        $user_id = UserClient::where('api_token',$request->input('key'))->value('user_id');

        $year       = $request->input("year",date("Y"));
        $month      = $request->input("month",date("n"));
        $curDate    = strtotime($year."-".$month."-1");
        $day        = date("t", $curDate);

        $room = ClientTypeRoom::leftJoin('client_type','client_type.id','=','client_type_room.type_id')
            ->where('client_type_room.user_id',$this->data['client']->user_id)
            ->where('client_type_room.flag_realtime','Y')
            ->selectraw('client_type_room.*')
            ->get();

        for($i=0; $i < $day; $i++){
            foreach($room as $r){
                $yoil = date("w",strtotime("+".$i." days",$curDate));
                $data_price = DataPrice::where('room_id',$r->id)
                    ->where('date', date('Y-m-d',strtotime("+".$i." days",$curDate)))
                    ->where('date_type',$yoil)
                    ->first();

                $this->data['price_normal'][$i+1][$r->id] = isset($data_price->price_normal)?$data_price->price_normal:"예약 불가";
                $this->data['price_sales'][$i+1][$r->id] = isset($data_price->price_sales)?$data_price->price_sales:"예약 불가";
            }
        }

        return response()->json($this->data);
//        $year       = $request->input("year",date("Y"));
//        $month      = $request->input("month",date("n"));
//        $curDate    = strtotime($year."-".$month."-1");
//        $day        = date("t", $curDate);
//
//        $tmp_season = ClientSeasonTerm::leftJoin('client_season','client_season.id','=','client_season_term.season_id')
//            ->whereIn('client_season_term.user_id',[$this->data['client']->user_id])
//            ->where('client_season_term.season_start','<=',date("Y-m-t",strtotime($year.'-'.$month.'-'.$day)))
//            ->where('client_season_term.season_end','>=',date("Y-m-01",strtotime($year.'-'.$month.'-'.$day)))
//            ->get();
//        $season = $tmp_season->pluck('season_id')->toArray();
//
//        $room = ClientTypeRoom::leftJoin('client_type','client_type.id','=','client_type_room.type_id')
//            ->where('client_type_room.user_id',$this->data['client']->user_id)
//            ->where('client_type_room.flag_realtime','Y')
//            ->selectraw('client_type_room.*')
//            ->get();
//
//        /** ******************************************************************************************************** **/
//        for($i=0; $i < $day; $i++){
//            foreach($room as $r){
//                unset($tmp_season);
//
//                $yoil = date("w",strtotime("+".$i." days",$curDate));
//
//                $tmp_season = ClientSeasonTerm::whereIn('season_id',$season)
//                    ->where('season_start','<=',date("Y_m-d",strtotime("+".$i." days",$curDate)))
//                    ->where('season_end','>=',date("Y_m-d",strtotime("+".$i." days",$curDate)))
//                    ->first();
//
//                $basic_price = ClientTypeRoomPrice::where('client_type_room_price.room_id', $r->id)
//                    ->where('client_type_room_price.season_id', !$tmp_season?0:$tmp_season->season_id)
//                    ->selectraw('(price_day_' . $yoil . ') as price')
//                    ->orderBy('price_day_' . $yoil, 'desc')
//                    ->first();
//
//                if(!isset($basic_price)) {
//                    $basic_price = ClientTypeRoomPrice::where('client_type_room_price.room_id',$r->id)
//                        ->whereIn('client_type_room_price.season_id',[0])
//                        ->selectraw('(price_day_'.$yoil.') as price')
//                        ->orderBy('price_day_'.$yoil,'desc')
//                        ->first();
//                }
//
//                $this->data['price'][$i+1][$r->id] = !isset($basic_price)?0:$basic_price->price;
//                $this->data['origin'][$i+1][$r->id] = !isset($basic_price)?0:$basic_price->price;
//
//                $custom_price = ClientTypeRoomPriceCustom::where(['client_type_room_price_custom.room_id'=>$r->id, 'client_type_room_price_custom.price_day'=>$yoil])
//                    ->first();
//
//                //직접 수정한 데이터가 있는 경우
//                if(isset($custom_price)) {
//                    $custom_price2 = ClientTypeRoomPrice::where('room_id',$r->id)
//                        ->where('season_id',$custom_price->season_id)
//                        ->selectraw('(price_day_'.$yoil.') as price')
//                        ->first();
//                    $this->data['price'][$i+1][$r->id] = $custom_price2->price;
//                }
//                else {
//                    unset($tmp_discount_price);
//                    $tmp_discount_price1 = [];
//                    $tmp_discount_price2 = [];
//
//                    $discount_price = ClientDiscountRoom::leftJoin('client_discount','client_discount.id','=','client_discount_room.discount_id')
//                        ->where(['client_discount_room.room_id'=>$r->id, 'client_discount.flag_use'=>'Y'])
//                        ->where('client_discount.date','like','%'.$yoil.'%')
//                        ->selectraw('client_discount_room.*, client_discount.season_check')
//                        ->get();
//
//                    foreach($discount_price as $dp){
//                        if($dp->season_check=="N") { //기간지정일경우
//                            $check_price = ClientDiscountTerm::where('discount_id',$dp->discount_id)
//                                ->where('discount_start','<=',date("Y-m-d",strtotime("+".$i." days",$curDate)))
//                                ->where('discount_end','>=',date("Y-m-d",strtotime("+".$i." days",$curDate)))
//                                ->selectraw('
//                                    client_discount_term.*,
//                                    (select count(id) from client_discount_ban_date where discount_id = client_discount_term.discount_id and date_ban = "'.date("Y-m-d",strtotime("+".$i." days",$curDate)).'")
//                                     as cnt_discount
//                                ')
//                                ->get();
//                            foreach($check_price as $cp) {
//                                if($cp->cnt_discount<1) {
//                                    if($dp->type=="discount") {
//                                        if($dp->unit=="원") $tmp_discount_price1[] = $this->data['price'][$i+1][$r->id] - $dp->discount_value;
//                                        else if($dp->unit=="%")$tmp_discount_price1[] = $this->data['price'][$i+1][$r->id] * (100 - $dp->discount_value) / 100;
//                                    }
//                                    if($dp->type=="fixed") {
//                                        $tmp_discount_price1[] = $dp->discount_value;
//                                    }
//                                }
//                            }
//                        }
//                        else if($dp->season_check=="Y") { //시즌참고일경우
//                            $check_price = ClientDiscountTerm::where('client_discount_term.discount_id',$dp->discount_id)
//                                ->selectraw('
//                                    client_discount_term.*,
//                                    (select count(id) from client_discount_ban_date where discount_id = client_discount_term.discount_id and date_ban = "'.date("Y-m-d",strtotime("+".$i." days",$curDate)).'")
//                                     as cnt_discount,
//                                    (select count(id) from client_season_term where
//                                        flag_use = "Y"
//                                        and season_id = client_discount_term.season_id
//                                        and season_start <= "'.date("Y-m-d",strtotime("+".$i." days",$curDate)).'"
//                                        and season_end >= "'.date("Y-m-d",strtotime("+".$i." days",$curDate)).'"
//                                    ) as cnt_season
//                                ')
//                                ->get();
//                            foreach($check_price as $cp) {
//                                if($cp->cnt_discount<1 && $cp->cnt_season>0) {
//                                    if($dp->type=="discount") {
//                                        $tmp_discount_price2[] = $dp->unit=="원" ?
//                                            $this->data['price'][$i + 1][$r->id] - $dp->discount_value :
//                                            $this->data['price'][$i + 1][$r->id] * (100 - $dp->discount_value) / 100;
//                                    }
//                                    if($dp->type=="fixed") {
//                                        $tmp_discount_price2[] = $dp->discount_value;
//                                    }
//                                }
//                            }
//                        }
//                    }
//
//                    //직접입력과 기간참조 모두 해당사항이 있을경우 각각의 경우 중 비싼 가격
//                    if(sizeof($tmp_discount_price1)>0 && sizeof($tmp_discount_price2)>0) {
//                        $tmp_discount_price = max(max($tmp_discount_price1), max($tmp_discount_price2));
//                    }
//                    //직접입력의 경우 중 비싼 가격
//                    else if(sizeof($tmp_discount_price1)>0) {
//                        $tmp_discount_price = max($tmp_discount_price1);
//                    }
//                    //기간참조의 경우 중 비싼 가격
//                    else if(sizeof($tmp_discount_price2)>0) {
//                        $tmp_discount_price = max($tmp_discount_price2);
//                    }
//
//                    //자동할인판매
//                    else {
//                        //기간지정할인여부체크
//                        $autoset = AutosetDiscountRoom::leftJoin('autoset_discount','autoset_discount.id','=','autoset_discount_room.autoset_id')
//                            ->where(['autoset_discount_room.room_id'=>$r->id, 'autoset_discount.term_check'=>'Y'])
//                            ->where('autoset_discount.discount_start','<=',date("Y-m-d",strtotime("+".$i." days",$curDate)))
//                            ->where('autoset_discount.discount_end','>=',date("Y-m-d",strtotime("+".$i." days",$curDate)))
//                            ->first();
//
//                        $chkDate = strtotime("+".$i." days",$curDate);
//                        $todDate = strtotime(date("Y-m-d"));
//                        if($chkDate>=$todDate) $diff_number = ceil(($chkDate-$todDate)/86400);
//                        else $diff_number = 0;
//                        //기간지정 할인의 경우 우선순위 적용
//                        if($diff_number>0) {
//                            if (isset($autoset)) {
//                                $tmp = AutosetDiscountHowmuch::where(['autoset_id' => $autoset->autoset_id, 'date' => $diff_number])->first();
//                                if (isset($tmp)) $tmp_discount_price = $this->data['price'][$i + 1][$r->id] * (100 - $tmp->autoset_discount_howmuch) / 100;
//                            } //상시일 경우 우선순위 미적용
//                            else {
//                                $autoset = AutosetDiscountRoom::leftJoin('autoset_discount', 'autoset_discount.id', '=', 'autoset_discount_room.autoset_id')
//                                    ->where(['autoset_discount_room.room_id' => $r->id, 'autoset_discount.term_check' => 'N'])
//                                    ->first();
//                                if(isset($autoset)) {
//                                    $tmp = AutosetDiscountHowmuch::where(['autoset_id' => $autoset->autoset_id, 'date' => $diff_number])->first();
//                                    if (isset($tmp)) $tmp_discount_price = $this->data['price'][$i + 1][$r->id] * (100 - $tmp->autoset_discount_howmuch) / 100;
//                                }
//                            }
//                        }
//                    }
//
//                    if( isset($tmp_discount_price) ) $this->data['price'][$i+1][$r->id] = $tmp_discount_price;
//                }
//            }
//        }
        /** ******************************************************************************************************** **/

        $this->data['total'] = $day;

        return response()->json($this->data);
    }
}
