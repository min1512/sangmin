<?php

namespace App\Http\Controllers\Schedule;

use App\Http\Controllers\Controller;
use App\Models\AutosetDiscountHowmuch;
use App\Models\AutosetDiscountRoom;
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

class PriceController extends Controller
{
    public static function updatePriceAll()
    {
        //전체 실시간 예약중인 객실 호출
        $room_all = ClientTypeRoom::where("flag_realtime", "Y")->get();
        $selected_room_price = [];
        foreach ($room_all as $room_a) {
            //펜션 고객정보
            $tmp_client_view_day = UserClient::where('user_id',$room_a->user_id)->first();
            $cnt_view_day = $tmp_client_view_day->cnt_day;

            //가격노출을 위한 일별 가격정보
            for($d=0; $d<$cnt_view_day; $d++) {
                $tmp_day = date("Y-m-d", strtotime("+".$d." days"));
                $tmp_room_id = $room_a->id;
                $tmp_user_id = $room_a->user_id;

                $data_price = DataPrice::where(['room_id'=>$tmp_room_id, 'user_id'=>$tmp_user_id, 'date'=>$tmp_day])->first();
                if(!$data_price) {
                    $data_price = new DataPrice();
                    $data_price->room_id = $tmp_room_id;
                    $data_price->user_id = $tmp_user_id;
                    $data_price->date = $tmp_day;
                    $data_price->save();
                }

                //시즌 등록
                $season = ClientSeasonTerm::leftJoin('client_season', 'client_season.id', '=', 'client_season_term.season_id')
                    ->whereIn('client_season_term.user_id', [$tmp_user_id])
                    ->where('client_season_term.season_start', '<=', $tmp_day)
                    ->where('client_season_term.season_end', '>=', $tmp_day)
                    ->selectraw('client_season.*')
                    ->first();
                if(!$season) { //비수기
                    $data_price->season_id = 0;
                    $data_price->season_name = "비수기";
                }
                else {
                    $data_price->season_id = $season->id;
                    $data_price->season_name = $season->season_name;
                }

                $room = ClientTypeRoom::find($tmp_room_id);

                $season = ClientSeasonTerm::leftJoin('client_season', 'client_season.id', '=', 'client_season_term.season_id')
                    ->whereIn('client_season_term.user_id', [$tmp_user_id])
                    ->where('client_season_term.season_start', '<=', date("Y-m-d", strtotime("+".$d." days")))
                    ->where('client_season_term.season_end', '>=', date("Y-m-d", strtotime("+".$d." days")))
                    ->get();
                $season = $season->pluck('season_id')->toArray();

                $tmp_season = ClientSeasonTerm::whereIn('season_id', $season)
                    ->where('season_start', '<=', date("Y-m-d", strtotime("+".$d." days")))
                    ->where('season_end', '>=', date("Y-m-d", strtotime("+".$d." days")))
                    ->first();
                $basic_price = ClientTypeRoomPrice::where('client_type_room_price.room_id', $tmp_room_id)
                    ->where('client_type_room_price.season_id', !$tmp_season ? 0 : $tmp_season->season_id)
                    ->selectraw('(price_day_' . date("w", strtotime("+".$d." days")) . ') as price')
                    ->orderBy('price_day_' . date("w", strtotime("+".$d." days")), 'desc')
                    ->first();

                if (!isset($basic_price)) {
                    $basic_price = ClientTypeRoomPrice::where('client_type_room_price.room_id', $tmp_room_id)
                        ->whereIn('client_type_room_price.season_id', [0])
                        ->selectraw('(price_day_' . date("w", strtotime("+".$d." days")) . ') as price')
                        ->orderBy('price_day_' . date("w", strtotime("+".$d." days")), 'desc')
                        ->first();
                }

                //기본 가격
                $temp_price = isset($basic_price->price)?$basic_price->price:0;
                $temp_price_origin = isset($basic_price->price)?$basic_price->price:0;

                //달력에서 직접 시즌과 요일 구분을 수동으로 변경한 경우
                $custom_price = ClientTypeRoomPriceCustom::where(['client_type_room_price_custom.room_id' => $tmp_room_id, 'client_type_room_price_custom.custom_date' => date("Y-m-d", strtotime("+".$d." days"))])
                    ->first();

                //직접 수정한 데이터가 있는 경우
                if (isset($custom_price)) {
                    $custom_price2 = ClientTypeRoomPrice::where('room_id', $tmp_room_id)
                        ->where('season_id', $custom_price->season_id)
                        ->selectraw('(price_day_' . $custom_price->price_day . ') as price')
                        ->first();
                    $temp_price = isset($custom_price2->price)?$custom_price2->price:0;
                }
                else {
                    unset($tmp_discount_price);
                    $tmp_discount_price1 = [];
                    $tmp_discount_price2 = [];

                    $discount_price = ClientDiscountRoom::leftJoin('client_discount', 'client_discount.id', '=', 'client_discount_room.discount_id')
                        ->where(['client_discount_room.room_id' => $tmp_room_id, 'client_discount.flag_use' => 'Y'])
                        ->where('client_discount.date', 'like', '%' . date("w", strtotime("+".$d." days")) . '%')
                        ->selectraw('client_discount_room.*, client_discount.season_check')
                        ->get();

                    foreach ($discount_price as $dp) {
                        if ($dp->season_check == "N") { //기간지정일경우
                            $check_price = ClientDiscountTerm::where('discount_id', $dp->discount_id)
                                ->where('discount_start', '<=', date("Y-m-d", strtotime("+".$d." days")))
                                ->where('discount_end', '>=', date("Y-m-d", strtotime("+".$d." days")))
                                ->selectraw('
                                            client_discount_term.*,
                                            (select count(id) from client_discount_ban_date where discount_id = client_discount_term.discount_id and date_ban = "' . date("Y-m-d", strtotime("+".$d." days")) . '")
                                             as cnt_discount
                                        ')
                                ->get();
                            foreach ($check_price as $cp) {
                                if ($cp->cnt_discount < 1) {
                                    if ($dp->type == "discount") {
                                        if ($dp->unit == "원") $tmp_discount_price1[] = $temp_price - $dp->discount_value;
                                        else $tmp_discount_price1[] = $temp_price * (100 - $dp->discount_value) / 100;
//                                        $tmp_discount_price1[] = $dp->unit == "원" ? $temp_price - $dp->discount_value : $temp_price * (100 - $dp->discount_value) / 100;
                                    }
                                    if ($dp->type == "fixed") {
                                        $tmp_discount_price1[] = $dp->discount_value;
                                    }
                                }
                            }
                        } else if ($dp->season_check == "Y") { //시즌참고일경우
                            $check_price = ClientDiscountTerm::where('client_discount_term.discount_id', $dp->discount_id)
                                ->selectraw('
                                            client_discount_term.*,
                                            (select count(id) from client_discount_ban_date where discount_id = client_discount_term.discount_id and date_ban = "' . date("Y-m-d", strtotime("+".$d." days")) . '")
                                             as cnt_discount,
                                            (select count(id) from client_season_term where
                                                flag_use = "Y"
                                                and season_id = client_discount_term.season_id
                                                and season_start <= "' . date("Y-m-d", strtotime("+".$d." days")) . '"
                                                and season_end >= "' . date("Y-m-d", strtotime("+".$d." days")) . '"
                                            ) as cnt_season
                                        ')
                                ->get();
                            foreach ($check_price as $cp) {
                                if ($cp->cnt_discount < 1 && $cp->cnt_season > 0) {
                                    if ($dp->type == "discount") {
                                        $tmp_discount_price2[] = $dp->unit == "원" ?
                                            $temp_price - $dp->discount_value :
                                            $temp_price * (100 - $dp->discount_value) / 100;
                                    }
                                    if ($dp->type == "fixed") {
                                        $tmp_discount_price2[] = $dp->discount_value;
                                    }
                                }
                            }
                        }
                    }
                    //직접입력과 기간참조 모두 해당사항이 있을경우 각각의 경우 중 비싼 가격
                    if (sizeof($tmp_discount_price1) > 0 && sizeof($tmp_discount_price2) > 0) {
                        $tmp_discount_price = max(max($tmp_discount_price1), max($tmp_discount_price2));
                    } //직접입력의 경우 중 비싼 가격
                    else if (sizeof($tmp_discount_price1) > 0) {
                        $tmp_discount_price = max($tmp_discount_price1);
                    } //기간참조의 경우 중 비싼 가격
                    else if (sizeof($tmp_discount_price2) > 0) {
                        $tmp_discount_price = max($tmp_discount_price2);
                    } //자동할인판매
                    else {
                        //기간지정할인여부체크
                        $autoset = AutosetDiscountRoom::leftJoin('autoset_discount', 'autoset_discount.id', '=', 'autoset_discount_room.autoset_id')
                            ->where(['autoset_discount_room.room_id' => $tmp_room_id, 'autoset_discount.term_check' => 'Y'])
                            ->where('autoset_discount.discount_start', '<=', date("Y-m-d", strtotime("+".$d." days")))
                            ->where('autoset_discount.discount_end', '>=', date("Y-m-d", strtotime("+".$d." days")))
                            ->first();
                        $chkDate = strtotime("+".$d." days");
                        $todDate = strtotime(date("Y-m-d"));


                        if ($chkDate >= $todDate) $diff_number = floor(($chkDate - $todDate) / 86400);
                        else $diff_number = 0;
                        //기간지정 할인의 경우 우선순위 적용

                        if ($diff_number >= 0) {
                            if (isset($autoset)) {
                                $tmp = AutosetDiscountHowmuch::where(['autoset_id' => $autoset->autoset_id, 'date' => (int)$diff_number])->first();
                                if (isset($tmp)){
                                    if ($tmp->autoset_discount_type == "discount") {
                                        $tmp_discount_price = $tmp->autoset_discount_unit == "원" ?
                                            $temp_price - $tmp->autoset_discount_howmuch :
                                            $temp_price * (100 - $tmp->autoset_discount_howmuch) / 100;
                                    }
                                    if ($tmp->autoset_discount_type == "fixed") {
                                        $tmp_discount_price = $tmp->autoset_discount_howmuch;
                                    }
                                }
//                                if (isset($tmp)) $tmp_discount_price = $temp_price * (100 - $tmp->autoset_discount_howmuch) / 100;
                            } //상시일 경우 우선순위 미적용
                            else {
                                $autoset = AutosetDiscountRoom::leftJoin('autoset_discount', 'autoset_discount.id', '=', 'autoset_discount_room.autoset_id')
                                    ->where(['autoset_discount_room.room_id' => $tmp_room_id, 'autoset_discount.term_check' => 'N'])
                                    ->first();
                                if (isset($autoset)) {
                                    $tmp = AutosetDiscountHowmuch::where(['autoset_id' => $autoset->autoset_id, 'date' => (int)$diff_number])->first();

                                    if (isset($tmp)){
                                        if ($tmp->autoset_discount_type == "discount") {
                                            $tmp_discount_price = $tmp->autoset_discount_unit == "원" ?
                                                $temp_price - $tmp->autoset_discount_howmuch :
                                                $temp_price * (100 - $tmp->autoset_discount_howmuch) / 100;
                                        }
                                        if ($tmp->autoset_discount_type == "fixed") {
                                            $tmp_discount_price = $tmp->autoset_discount_howmuch;
                                        }
                                    }

//                                    if (isset($tmp)) $tmp_discount_price = $temp_price * (100 - $tmp->autoset_discount_howmuch) / 100;
                                }
                            }
                        }
                    }

                    if (isset($tmp_discount_price)) $temp_price = $tmp_discount_price;
                }

                //일자별 예약 상태 조회
                $order = OrderInfo::leftJoin('order_basic', 'order_basic.id', '=', 'order_info.order_id')
                    ->where(['order_info.room_id' => $tmp_room_id, 'order_info.reserve_date' => date("Y-m-d", strtotime("+".$d." days"))])
                    ->select('order_basic.state')
                    ->first();

                $data_price->date_type = date("w", strtotime("+".$d." days"));
                $data_price->date = date("Y-m-d", strtotime("+".$d." days"));
                $data_price->price_normal = $temp_price_origin;
                $data_price->price_sales = $temp_price;
                $data_price->state = isset($order)?$order->state:"Y";
                $data_price->save();

                $selected_room_price[] = $data_price->id;
            }
        }
        DataPrice::whereNotIn('id',$selected_room_price)->delete();
    }

    public static function updatePriceDaily($selected_day) {

    }

    public static function updatePriceClient($client_id) {

    }
}
