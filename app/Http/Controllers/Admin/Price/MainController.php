<?php

namespace App\Http\Controllers\Admin\Price;

use App\Http\Controllers\Controller;
use App\Models\ClientDiscount;
use App\Models\ClientSeason;
use App\Models\ClientSeasonTerm;
use App\Models\ClientType;
use App\Models\ClientTypeRoom;
use App\Models\ClientTypeRoomPrice;
use App\Models\ClientTypeRoomPriceCustom;
use App\Models\UserClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

    public function getList(){
        $this->data['UserClient'] = UserClient::selectRaw("
                user_client.*,
                (select count(id) from client_type where user_id = user_client.user_id) as cnt_room_type,
                (select count(id) from client_type_room where user_id = user_client.user_id) as cnt_room,
                (select count(id) from client_type_room where user_id = user_client.user_id and flag_realtime = 'Y') as cnt_room_open
            ")
            ->paginate(5);

        return view('admin.'.$this->phone.'.price.price_list', $this->data);
    }

    public function getInfo(Request $request) {
        $this->data['clientList'] = UserClient::paginate(20);

        return view('admin.'.$this->phone.'.price.info_list', $this->data);
    }

    public function getCalc(Request $request, $id) {
        $this->data['year']     = $request->query("year",date("Y"));
        $this->data['month']    = $request->query("month",date("n"));
        $this->data['day']      = $request->query("day",date("j"));

        $this->data['room']     = ClientTypeRoom::where('user_id',$id)->orderby('type_id','asc')->orderby('room_name','asc')->get();
        $this->data['season']   = ClientSeason::whereIn('user_id',[0,$id])->where('flag_use','Y')->orderby('id','asc')->get();

        //일자별 요금 호출 (시즌)
        $tmp_basic_date = strtotime($this->data['year']."-".$this->data['month']."-".$this->data['day']);
        for($i=1; $i<=date("t",$tmp_basic_date); $i++){
            $tmp_date = date("Y-m-".$i,$tmp_basic_date);
            $tmp_union = ClientSeasonTerm::where('user_id',0);
            $tmp_season = ClientSeasonTerm::where('user_id',$id)
                ->where('season_start','<=',date("Y-m-d",strtotime($tmp_date)))
                ->where('season_end','>=',date("Y-m-t",strtotime($tmp_date)))
                ->unionAll($tmp_union)
                ->get();
            foreach($this->data['room'] as $r) {
                foreach ($tmp_season as $ts) {
                    $price = ClientTypeRoomPrice::where(['user_id'=>$id, 'season_id'=>$ts->season_id, 'room_id'=>$r->id])->select('price_day_'.date('w',strtotime($tmp_date)))->first();
                    $this->data['price_day'][$i][$r->id][date('w',strtotime($tmp_date))][$ts->season_id] = isset($price)?$price->{'price_day_'.date('w',strtotime($tmp_date))}:0;
                }
                $this->data['price_custom'][$i][$r->id] = ClientTypeRoomPriceCustom::where(['user_id'=>$id, 'room_id'=>$r->id, 'custom_date'=>date("Y-m-d",strtotime($tmp_date))])->first();
            }
        }

        return view('admin.'.$this->phone.'.price.calendar', $this->data);
    }

    public function postCalc(Request $request, $id) {
        $delNotIdList = [];
        $targetDays = [];
        foreach($request->price_season as $k => $v){
            $targetDays[] = $k;
            foreach($v as $k2 => $v2){
                $price_daily = $request->price_daily[$k][$k2];
                $custom_season = $request->custom_price_season[$k][$k2];
                $custom_daily = $request->custom_price_daily[$k][$k2];

                if($v2!=$custom_season || $price_daily!=$custom_daily) {
                    $tmp = ClientTypeRoomPriceCustom::where(['user_id' => $id, 'room_id' => $k2, 'custom_date' => $k])->first();
                    if (!isset($tmp)) {
                        $tmp = new ClientTypeRoomPriceCustom();
                        $tmp->user_id = $id;
                        $tmp->room_id = $k2;
                        $tmp->custom_date = $k;
                        $tmp->save();
                    }

                    $tmp->season_id = $custom_season;
                    $tmp->price_day = $custom_daily;
                    $tmp->save();

                    $delNotIdList[] = $tmp->id;
                }
            }
        }
        ClientTypeRoomPriceCustom::where('user_id',$id)->whereIn('custom_date',$targetDays)->whereNotIn('id',$delNotIdList)->delete();

        return redirect()->route('price.list.calc',['id'=>$id]);
    }

    public function getSeason(Request $request, $id="", $sid="") {
        $this->data['curPath'] = "/price/list/season/".$id;
        $this->data['room'] = ClientTypeRoom::where('user_id',$id)->selectraw("client_type_room.*, (select type_name from client_type where id=client_type_room.type_id) as type_name")->selectraw("client_type_room.*, (select room_cnt_basic from client_type where id=client_type_room.type_id) as room_cnt_basic")->get();
        $this->data['seasonList'] = ClientSeason::whereIn('user_id',[$id])->get();
        $this->data['season'] = ClientSeason::whereIn('user_id',[$id,0]);
        $this->data['season_term'] = ClientSeasonTerm::where('user_id',$id)->get();
        $this->data['id'] = $id;
        if($sid!="") $this->data['season'] = $this->data['season']->where('id',$sid);
        $this->data['season'] = $this->data['season']->orderby('id','asc')->get();

        $this->data['roomSeasonPrice'] = [];
        foreach($this->data['room'] as $r) {
            foreach($this->data['season'] as $s) {
                $this->data['roomSeasonPrice'][$r->id][$s->id] = ClientTypeRoomPrice::where(['user_id'=>$id, 'room_id'=>$r->id, 'season_id'=>$s->id])->first();
            }
        }

        return view('admin.'.$this->phone.'.price.season', $this->data);
    }

    public function getDiscount(Request $request, $id=""){
        $this->data['curPath'] = "/price/list/discount/".$id;
        $this->data['discountList'] = ClientDiscount::where('user_id',$id)->selectraw("client_discount.*, (select discount_start from client_discount_term where discount_id=client_discount.id) as discount_start")->selectraw("client_discount.*, (select discount_end from client_discount_term where discount_id=client_discount.id) as discount_end")->get();
        $this->data['id'] = $id;
        $this->data['did'] = "";
        return view('admin.'.$this->phone.'.price.discount', $this->data);
    }

    public function getDiscountView(Request $request, $id="", $did=""){
        $this->data['curPath'] = "/price/list/discount/".$id."/".$did;
        $this->data['discountList'] = ClientDiscount::where('user_id',$id)->get();
        $this->data['id'] = $id;
        $this->data['ClientTypeRoom'] =ClientTypeRoom::where('user_id',$id)->get();
        $this->data['ClientSeason'] =ClientSeasonTerm::where('user_id',$id)->selectraw("client_season_term.*, (select season_name from client_season where id=client_season_term.season_id) as season_name")->get();

        return view('admin.'.$this->phone.'.price.discount_insert', $this->data);
    }

    public function getEtc(Request $request, $id=""){
        $this->data['curPath'] = "/price/list/etc/".$id;
        $this->data['discountList'] = ClientDiscount::where('user_id',$id)->selectraw("client_discount.*, (select discount_start from client_discount_term where discount_id=client_discount.id) as discount_start")->selectraw("client_discount.*, (select discount_end from client_discount_term where discount_id=client_discount.id) as discount_end")->get();
        $this->data['id'] = $id;
        $this->data['did'] = "";

        $search['search1']=$request->query('search1');
        $search['search2']=$request->query('search2');
        $search['search_board']=$request->query('search_board');
        $ClientType = ClientType::orderby('id','desc');
        $ClientTypeRoom = ClientTypeRoom::orderby('id','desc');

        if(isset($search['search1']) && $search['search1']!="") {
            if($search['search1']=="client_list"){
                $search_field1 = "client_list";
                if($search['search2']=="search_group"){
                    //그룹명 검색
                    $search_field2 = "type_name";
                    //그룹명으로 type_id 검색
                    $type_ids = 'type_id';
                    //

                    $ClientType = $ClientType->where($search_field2,'like','%'.$search['search_board'].'%')->where('user_id',$id);
                    if(isset($search['search_board'])){
                        $type_id['id'] = $ClientType->get();
                        foreach($type_id['id'] as $type_id){
                            $keeping =$type_id->id;
                            $ClientTypeRoom = $ClientTypeRoom->orwhere($type_ids,'like','%'.$keeping.'%')->where('user_id',$id);
                        }
                    }else{
                        $ClientTypeRoom = $ClientTypeRoom->where($type_ids,'like','%'.'%')->where('user_id',$id);
                    }
                }elseif ($search['search2']=="search_num"){
                    //판매 객실수 검색
                    $search_field2 = "num";
                    //
                    $type_ids = 'type_id';
                    //

                    $ClientType = $ClientType->where($search_field2,'like','%'.$search['search_board'].'%')->where('user_id',$id);
                    if(isset($search['search_board'])){
                        $type_id['id'] = $ClientType->get();
                        foreach($type_id['id'] as $type_id){
                            $keeping =$type_id->id;
                            $ClientTypeRoom = $ClientTypeRoom->orwhere($type_ids,'like','%'.$keeping.'%')->where('user_id',$id);
                        }
                    }else{
                        $ClientTypeRoom = $ClientTypeRoom->where($type_ids,'like','%'.'%')->where('user_id',$id);
                    }
                }elseif ($search['search2']=="search_basic"){
                    //기준(사람) 검색
                    $search_field2 = "room_cnt_basic";
                    //
                    $type_ids = 'type_id';
                    //

                    $ClientType = $ClientType->where($search_field2,'like','%'.$search['search_board'].'%')->where('user_id',$id);
                    if(isset($search['search_board'])){
                        $type_id['id'] = $ClientType->get();
                        foreach($type_id['id'] as $type_id){
                            $keeping =$type_id->id;
                            $ClientTypeRoom = $ClientTypeRoom->orwhere($type_ids,'like','%'.$keeping.'%')->where('user_id',$id);
                        }
                    }else{
                        $ClientTypeRoom = $ClientTypeRoom->where($type_ids,'like','%'.'%')->where('user_id',$id);
                    }
                }elseif ($search['search2']=="search_max"){
                    //최대(사람) 검색
                    $search_field2 = "room_cnt_max";
                    //
                    $type_ids = 'type_id';
                    //

                    $ClientType = $ClientType->where($search_field2,'like','%'.$search['search_board'].'%')->where('user_id',$id);
                    if(isset($search['search_board'])){
                        $type_id['id'] = $ClientType->get();
                        foreach($type_id['id'] as $type_id){
                            $keeping =$type_id->id;
                            $ClientTypeRoom = $ClientTypeRoom->orwhere($type_ids,'like','%'.$keeping.'%')->where('user_id',$id);
                        }
                    }else{
                        $ClientTypeRoom = $ClientTypeRoom->where($type_ids,'like','%'.'%')->where('user_id',$id);
                    }
                }
            }elseif ($search['search1']=="room_list"){
                $search_field1= "room_list";
                if($search['search2']=="search_room_name"){
                    //객실명 검색
                    $search_field2 = "room_name";
                    //
                    $type_ids = 'id';
                    //
                    $ClientTypeRoom = $ClientTypeRoom->where($search_field2,'like','%'.$search['search_board'].'%')->where('user_id',$id);
                    if(isset($search['search_board'])){
                        $type_id['id'] = $ClientTypeRoom->get();
                        foreach($type_id['id'] as $type_id){
                            $keeping =$type_id->type_id;
                            $ClientType = $ClientType->orwhere($type_ids,'like','%'.$keeping.'%')->where('user_id',$id);
                        }
                    }else{
                        $ClientType = $ClientType->where($type_ids,'like','%'.'%')->where('user_id',$id);
                    }
                }elseif ($search['search2']=="search_realtime"){
                    //실시간 예약 검색
                    $search_field2 = "flag_realtime";
                    //
                    $type_ids = 'id';
                    //
                    $ClientTypeRoom = $ClientTypeRoom->where($search_field2,'like','%'.$search['search_board'].'%')->where('user_id',$id);
                    if(isset($search['search_board'])){
                        $type_id['id'] = $ClientTypeRoom->get();
                        foreach($type_id['id'] as $type_id){
                            $keeping =$type_id->type_id;
                            $ClientType = $ClientType->orwhere($type_ids,'like','%'.$keeping.'%')->where('user_id',$id);
                        }
                    }else{
                        $ClientType = $ClientType->where($type_ids,'like','%'.'%')->where('user_id',$id);
                    }
                }elseif ($search['search2']=="search_online"){
                    //온라인 예약 검색
                    $search_field2 = "flag_online";
                    //
                    $type_ids = 'id';
                    //
                    $ClientTypeRoom = $ClientTypeRoom->where($search_field2,'like','%'.$search['search_board'].'%')->where('user_id',$id);
                    if(isset($search['search_board'])){
                        $type_id['id'] = $ClientTypeRoom->get();
                        foreach($type_id['id'] as $type_id){
                            $keeping =$type_id->type_id;
                            $ClientType = $ClientType->orwhere($type_ids,'like','%'.$keeping.'%')->where('user_id',$id);
                        }
                    }else{
                        $ClientType  = $ClientType->where($type_ids,'like','%'.'%')->where('user_id',$id);
                    }
                }
            }
        }else{
            $ClientType=$ClientType->where('user_id',$id);
            $ClientTypeRoom=$ClientTypeRoom->where('user_id',$id);
        }

        $this->data['uid'] = $id;
        $this->data['clientList'] = $ClientType->paginate(20);
        $this->data['ClientTypeRoom'] = $ClientTypeRoom->get();

        return view('admin.'.$this->phone.'.client1.client1_list', $this->data);
    }
    public function getEtcView(Request $request, $id="", $type_id=""){
        $this->data['curPath'] = "/price/list/etc/".$id."/".$type_id;
        $this->data['id'] = $id;

        $this->data['ClientRoom']=ClientType::find($type_id);
        $this->data['ClientRooms']= ClientType::where('id',$type_id)->get();
        $this->data['room_name']= ClientTypeRoom::where('type_id',$type_id)->where('user_id',$id)->get();
        $this->data['ClientRoomFacilitys']= ClientTypeFacility::where('type_id',$type_id)->selectraw("group_concat(code_facility separator ',') as fac")->first();

        return view('admin.'.$this->phone.'.client1.client1_save', $this->data);
    }
}
