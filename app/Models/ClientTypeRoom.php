<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientTypeRoom extends Model
{
    protected $table = "client_type_room";

    public function roomPriceDay($room_id, $day) {
        $room = ClientTypeRoom::find($room_id);

        $season = ClientSeasonTerm::leftJoin('client_season','client_season.id','=','client_season_term.season_id')
            ->whereIn('client_season_term.user_id',[$room->user_id])
            ->where('client_season_term.season_start','<=',date("Y-m-t",strtotime($day)))
            ->where('client_season_term.season_end','>=',date("Y-m-01",strtotime($day)))
            ->get();
        $season = $season->pluck('season_id')->toArray();

        $tmp_season = ClientSeasonTerm::whereIn('season_id',$season)
            ->where('season_start','<=',date("Y-m-d",strtotime($day)))
            ->where('season_end','>=',date("Y-m-d",strtotime($day)))
            ->first();

        $basic_price = ClientTypeRoomPrice::where('client_type_room_price.room_id', $room_id)
            ->where('client_type_room_price.season_id', !$tmp_season?0:$tmp_season->season_id)
            ->selectraw('(price_day_' . date("w",strtotime($day)) . ') as price, add_adult,add_child,add_baby')
            ->orderBy('price_day_' . date("w",strtotime($day)), 'desc')
            ->first();

        if(!isset($basic_price)) {
            $basic_price = ClientTypeRoomPrice::where('client_type_room_price.room_id',$room_id)
                ->whereIn('client_type_room_price.season_id',[0])
                ->selectraw('(price_day_'.date("w",strtotime($day)).') as price')
                ->orderBy('price_day_'.date("w",strtotime($day)),'desc')
                ->first();
        }

        $temp_price = $basic_price->price;
        $temp_price_origin = $basic_price->price;

        $custom_price = ClientTypeRoomPriceCustom::where(['client_type_room_price_custom.room_id'=>$room_id, 'client_type_room_price_custom.price_day'=>date("w",strtotime($day))])
            ->first();

        //직접 수정한 데이터가 있는 경우
        if(isset($custom_price)) {
            $custom_price2 = ClientTypeRoomPrice::where('room_id',$room_id)
                ->where('season_id',$custom_price->season_id)
                ->selectraw('(price_day_'.date("w",strtotime($day)).') as price')
                ->first();
            $temp_price = $custom_price2->price;
        }
        else {
            unset($tmp_discount_price);
            $tmp_discount_price1 = [];
            $tmp_discount_price2 = [];

            $discount_price = ClientDiscountRoom::leftJoin('client_discount','client_discount.id','=','client_discount_room.discount_id')
                ->where(['client_discount_room.room_id'=>$room_id, 'client_discount.flag_use'=>'Y'])
                ->where('client_discount.date','like','%'.date("w",strtotime($day)).'%')
                ->selectraw('client_discount_room.*, client_discount.season_check')
                ->get();
            foreach($discount_price as $dp){
                if($dp->season_check=="N") { //기간지정일경우
                    $check_price = ClientDiscountTerm::where('discount_id',$dp->discount_id)
                        ->where('discount_start','<=',date("Y-m-d",strtotime($day)))
                        ->where('discount_end','>=',date("Y-m-d",strtotime($day)))
                        ->selectraw('
                                    client_discount_term.*,
                                    (select count(id) from client_discount_ban_date where discount_id = client_discount_term.discount_id and date_ban = "'.date("Y-m-d",strtotime($day)).'")
                                     as cnt_discount
                                ')
                        ->get();
                    foreach($check_price as $cp) {
                        if($cp->cnt_discount<1) {
                            if($dp->type=="discount") {
                                if($dp->unit=="원") $tmp_discount_price1[] = $temp_price - $dp->discount_value;
                                else $tmp_discount_price1[] = $temp_price * (100 - $dp->discount_value) / 100;
                                $tmp_discount_price1[] = $dp->unit=="원"?$temp_price - $dp->discount_value : $temp_price * (100 - $dp->discount_value) / 100;
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
                                    (select count(id) from client_discount_ban_date where discount_id = client_discount_term.discount_id and date_ban = "'.date("Y-m-d",strtotime($day)).'")
                                     as cnt_discount,
                                    (select count(id) from client_season_term where
                                        flag_use = "Y"
                                        and season_id = client_discount_term.season_id
                                        and season_start <= "'.date("Y-m-d",strtotime($day)).'"
                                        and season_end >= "'.date("Y-m-d",strtotime($day)).'"
                                    ) as cnt_season
                                ')
                        ->get();
                    foreach($check_price as $cp) {
                        if($cp->cnt_discount<1 && $cp->cnt_season>0) {
                            if($dp->type=="discount") {
                                $tmp_discount_price2[] = $dp->unit=="원" ?
                                    $temp_price - $dp->discount_value :
                                    $temp_price * (100 - $dp->discount_value) / 100;
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
                    ->where(['autoset_discount_room.room_id'=>$room_id, 'autoset_discount.term_check'=>'Y'])
                    ->where('autoset_discount.discount_start','<=',date("Y-m-d",strtotime($day)))
                    ->where('autoset_discount.discount_end','>=',date("Y-m-d",strtotime($day)))
                    ->first();

                $chkDate = strtotime($day);
                $todDate = strtotime(date("Y-m-d"));
                if($chkDate>=$todDate) $diff_number = ceil(($chkDate-$todDate)/86400);
                else $diff_number = 0;
                //기간지정 할인의 경우 우선순위 적용
                if($diff_number>0) {
                    if (isset($autoset)) {
                        $tmp = AutosetDiscountHowmuch::where(['autoset_id' => $autoset->autoset_id, 'date' => $diff_number])->first();
                        if (isset($tmp)) $tmp_discount_price = $temp_price * (100 - $tmp->autoset_discount_howmuch) / 100;
                    } //상시일 경우 우선순위 미적용
                    else {
                        $autoset = AutosetDiscountRoom::leftJoin('autoset_discount', 'autoset_discount.id', '=', 'autoset_discount_room.autoset_id')
                            ->where(['autoset_discount_room.room_id' => $room_id, 'autoset_discount.term_check' => 'N'])
                            ->first();
                        if(isset($autoset)) {
                            $tmp = AutosetDiscountHowmuch::where(['autoset_id' => $autoset->autoset_id, 'date' => $diff_number])->first();
                            if (isset($tmp)) $tmp_discount_price = $temp_price * (100 - $tmp->autoset_discount_howmuch) / 100;
                        }
                    }
                }
            }

            if( isset($tmp_discount_price) ) $temp_price = $tmp_discount_price;
        }

        //일자별 예약 상태 조회
        $order = OrderInfo::leftJoin('order_basic','order_basic.id','=','order_info.order_id')
            ->where(['order_info.room_id'=>$room_id, 'order_info.reserve_date'=>date("Y-m-d",strtotime($day))])
            ->select('order_basic.state')
            ->first();

        $data['add_adult']=$basic_price->add_adult;
        $data['add_child']=$basic_price->add_child;
        $data['add_baby']=$basic_price->add_baby;
        $data['price'] = $temp_price;
        $data['price_origin'] = $temp_price_origin;
        $data['order'] = $order;
        $data['room'] = $room_id;
        $data['day'] = date("Y-m-d",strtotime($day));
        $data['yoil'] = date("w",strtotime($day));

        return $data;
    }
}
