<?php

namespace App\Http\Controllers\Api\Calendar;

use App\Http\Controllers\ApiController;
use App\Models\AutosetDiscountHowmuch;
use App\Models\AutosetDiscountRoom;
use App\Models\ClientDiscountRoom;
use App\Models\ClientDiscountTerm;
use App\Models\ClientSeason;
use App\Models\ClientSeasonTerm;
use App\Models\ClientTypeRoom;
use App\Models\ClientTypeRoomPrice;
use App\Models\ClientTypeRoomPriceCustom;
use App\Models\OrderBasic;
use App\Models\OrderInfo;
use Illuminate\Http\Request;

class MonthController extends ApiController
{
    public function __construct(Request $request)
    {
        parent::__construct($request);
    }

    public function postMonth(Request $request) {
        $time_start = microtime(true); // Top of page

        $year   = $request->input("year",date("Y"));
        $month  = $request->input("month",null);
        if($month==null) $month = date("n"); else $month = $month+1;
        $day    = $request->input("day",date("j"));

        $this->data['season'] = ClientSeasonTerm::leftJoin('client_season','client_season.id','=','client_season_term.season_id')
            ->whereIn('client_season_term.user_id',[$this->data['client']->user_id])
            ->where('client_season_term.season_start','<=',date("Y-m-t",strtotime($year.'-'.$month.'-'.$day)))
            ->where('client_season_term.season_end','>=',date("Y-m-01",strtotime($year.'-'.$month.'-'.$day)))
            ->get();
        $season = $this->data['season']->pluck('season_id')->toArray();
        //$season[] = 0;

        $this->data['room'] = ClientTypeRoom::leftJoin('client_type','client_type.id','=','client_type_room.type_id')
            ->where('client_type_room.user_id',$this->data['client']->user_id)
            ->where('client_type_room.flag_realtime','Y')
            ->selectraw('client_type_room.*')
            ->get();

        /** ******************************************************************************************************** **/
        /** Request: $year, $month, $day *************************************************************************** **/
        $curDate        = strtotime($year."-".$month."-".$day);
        $basicDateStart = strtotime($year."-".$month."-1");
        $basicDateEnd   = strtotime($year."-".$month."-".date("t",$curDate));
        $dayPerMonth    = date("t",$curDate);
        $yoilStart      = date("w",strtotime($year."-".$month."-1"));

        $prevMonth      = strtotime("-1 month",$curDate);
        $nextMonth      = strtotime("+1 month",$curDate);

        for($i=0; $i < date("t",$curDate); $i++){
            foreach($this->data['room'] as $r){
                unset($tmp_season);

                $yoil = date("w",strtotime("+".$i." days",$basicDateStart));
                $this->data['info'][$i+1][$r->id]['color'] = $yoil==0?'red':$yoil==6?'blue':'black';
                $this->data['info'][$i+1][$r->id]['id'] = $r->id;
                $this->data['info'][$i+1][$r->id]['name'] = $r->room_name;

                $tmp_season = ClientSeasonTerm::whereIn('season_id',$season)
                    ->where('season_start','<=',date("Y-m-d",strtotime("+".$i." days",$basicDateStart)))
                    ->where('season_end','>=',date("Y-m-d",strtotime("+".$i." days",$basicDateStart)))
                    ->first();

                $basic_price = ClientTypeRoomPrice::where('client_type_room_price.room_id', $r->id)
                    ->where('client_type_room_price.season_id', !$tmp_season?0:$tmp_season->season_id)
                    ->selectraw('(price_day_' . $yoil . ') as price')
                    ->orderBy('price_day_' . $yoil, 'desc')
                    ->first();

                if(isset($basic_price)) {
                    $this->data['info'][$i+1][$r->id]['price'] = $basic_price->price;
                }
                else {
                    $basic_price = ClientTypeRoomPrice::where('client_type_room_price.room_id',$r->id)
                        ->whereIn('client_type_room_price.season_id',[0])
                        ->selectraw('(price_day_'.$yoil.') as price')
                        ->orderBy('price_day_'.$yoil,'desc')
                        ->first();
                    $this->data['info'][$i+1][$r->id]['price'] = $basic_price->price;
                }


                $custom_price = ClientTypeRoomPriceCustom::where(['client_type_room_price_custom.room_id'=>$r->id, 'client_type_room_price_custom.price_day'=>$yoil])
                    ->first();

                //직접 수정한 데이터가 있는 경우
                if(isset($custom_price)) {
                    $custom_price2 = ClientTypeRoomPrice::where('room_id',$r->id)
                        ->where('season_id',$custom_price->season_id)
                        ->selectraw('(price_day_'.$yoil.') as price')
                        ->first();
                    $this->data['info'][$i+1][$r->id]['price'] = $custom_price2->price;
                }
                else {
                    unset($tmp_discount_price);
                    $tmp_discount_price1 = [];
                    $tmp_discount_price2 = [];

                    $discount_price = ClientDiscountRoom::leftJoin('client_discount','client_discount.id','=','client_discount_room.discount_id')
                        ->where(['client_discount_room.room_id'=>$r->id, 'client_discount.flag_use'=>'Y'])
                        ->where('client_discount.date','like','%'.$yoil.'%')
                        ->selectraw('client_discount_room.*, client_discount.season_check')
                        ->get();
                    foreach($discount_price as $dp){
                        if($dp->season_check=="N") { //기간지정일경우
                            $check_price = ClientDiscountTerm::where('discount_id',$dp->discount_id)
                                ->where('discount_start','<=',date("Y-m-d",strtotime("+".$i." days",$basicDateStart)))
                                ->where('discount_end','>=',date("Y-m-d",strtotime("+".$i." days",$basicDateStart)))
                                ->selectraw('
                                    client_discount_term.*,
                                    (select count(id) from client_discount_ban_date where discount_id = client_discount_term.discount_id and date_ban = "'.date("Y-m-d",strtotime("+".$i." days",$basicDateStart)).'")
                                     as cnt_discount
                                ')
                                ->get();
                            foreach($check_price as $cp) {
                                if($cp->cnt_discount<1) {
                                    if($dp->type=="discount") {
                                        if($dp->unit=="원") $tmp_discount_price1[] = $this->data['info'][$i+1][$r->id]['price'] - $dp->discount_value;
                                        else $tmp_discount_price1[] = $this->data['info'][$i+1][$r->id]['price'] * (100 - $dp->discount_value) / 100;
                                        $tmp_discount_price1[] = $dp->unit=="원"?$this->data['info'][$i+1][$r->id]['price'] - $dp->discount_value : $this->data['info'][$i+1][$r->id]['price'] * (100 - $dp->discount_value) / 100;
                                    }
                                    if($dp->type=="fixed") {
                                        $tmp_discount_price1[] = $dp->discount_value;
                                    }
                                }
                            }
                        }
                        else if($dp->season_check=="Y") { //시즌참고일경우
                            $check_price = ClientDiscountTerm::where('client_discount_term.discount_id',$dp->discount_id)
                                ->selectraw('
                                    client_discount_term.*,
                                    (select count(id) from client_discount_ban_date where discount_id = client_discount_term.discount_id and date_ban = "'.date("Y-m-d",strtotime("+".$i." days",$basicDateStart)).'")
                                     as cnt_discount,
                                    (select count(id) from client_season_term where
                                        flag_use = "Y"
                                        and season_id = client_discount_term.season_id
                                        and season_start <= "'.date("Y-m-d",strtotime("+".$i." days",$basicDateStart)).'"
                                        and season_end >= "'.date("Y-m-d",strtotime("+".$i." days",$basicDateStart)).'"
                                    ) as cnt_season
                                ')
                                ->get();
                            foreach($check_price as $cp) {
                                if($cp->cnt_discount<1 && $cp->cnt_season>0) {
                                    if($dp->type=="discount") {
                                        $tmp_discount_price2[] = $dp->unit=="원" ?
                                            $this->data['info'][$i + 1][$r->id]['price'] - $dp->discount_value :
                                            $this->data['info'][$i + 1][$r->id]['price'] * (100 - $dp->discount_value) / 100;
                                    }
                                    if($dp->type=="fixed") {
                                        $tmp_discount_price2[] = $dp->discount_value;
                                    }
                                }
                            }
                        }
                    }

                    //직접입력과 기간참조 모두 해당사항이 있을경우 각각의 경우 중 비싼 가격
                    if(sizeof($tmp_discount_price1)>0 && sizeof($tmp_discount_price2)>0) {
                        $tmp_discount_price = max(max($tmp_discount_price1), max($tmp_discount_price2));
                    }
                    //직접입력의 경우 중 비싼 가격
                    else if(sizeof($tmp_discount_price1)>0) {
                        $tmp_discount_price = max($tmp_discount_price1);
                    }
                    //기간참조의 경우 중 비싼 가격
                    else if(sizeof($tmp_discount_price2)>0) {
                        $tmp_discount_price = max($tmp_discount_price2);
                    }

                    //자동할인판매
                    else {
                        //기간지정할인여부체크
                        $autoset = AutosetDiscountRoom::leftJoin('autoset_discount','autoset_discount.id','=','autoset_discount_room.autoset_id')
                            ->where(['autoset_discount_room.room_id'=>$r->id, 'autoset_discount.term_check'=>'Y'])
                            ->where('autoset_discount.discount_start','<=',date("Y-m-d",strtotime("+".$i." days",$basicDateStart)))
                            ->where('autoset_discount.discount_end','>=',date("Y-m-d",strtotime("+".$i." days",$basicDateStart)))
                            ->first();

                        $chkDate = strtotime("+".$i." days",$basicDateStart);
                        $todDate = strtotime(date("Y-m-d"));
                        if($chkDate>=$todDate) $diff_number = ceil(($chkDate-$todDate)/86400);
                        else $diff_number = 0;
                        //기간지정 할인의 경우 우선순위 적용
                        if($diff_number>0) {
                            if (isset($autoset)) {
                                $tmp = AutosetDiscountHowmuch::where(['autoset_id' => $autoset->autoset_id, 'date' => $diff_number])->first();
                                if (isset($tmp)) $tmp_discount_price = $this->data['info'][$i + 1][$r->id]['price'] * (100 - $tmp->autoset_discount_howmuch) / 100;
                            } //상시일 경우 우선순위 미적용
                            else {
                                $autoset = AutosetDiscountRoom::leftJoin('autoset_discount', 'autoset_discount.id', '=', 'autoset_discount_room.autoset_id')
                                    ->where(['autoset_discount_room.room_id' => $r->id, 'autoset_discount.term_check' => 'N'])
                                    ->first();
                                if(isset($autoset)) {
                                    $tmp = AutosetDiscountHowmuch::where(['autoset_id' => $autoset->autoset_id, 'date' => $diff_number])->first();
                                    if (isset($tmp)) $tmp_discount_price = $this->data['info'][$i + 1][$r->id]['price'] * (100 - $tmp->autoset_discount_howmuch) / 100;
                                }
                            }
                        }
                    }

                    if( isset($tmp_discount_price) ) $this->data['info'][$i+1][$r->id]['price'] = $tmp_discount_price;
                }

                //일자별 예약 상태 조회
                $this->data['info'][$i+1][$r->id]['order'] = OrderInfo::leftJoin('order_basic','order_basic.id','=','order_info.order_id')
                    ->where(['order_info.room_id'=>$r->id, 'order_info.reserve_date'=>date("Y-m-d",strtotime("+".$i." days",$basicDateStart))])
                    ->select('order_basic.state')
                    ->first();
            }
        }
        /** ******************************************************************************************************** **/

        $time_end = microtime(true); // Bottom of page
        //printf("Page loaded in %f seconds", $time_end - $time_start );

        return response()->json($this->data);
    }
}
