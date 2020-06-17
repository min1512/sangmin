<?php


namespace App\Http\Controllers\Admin\Price;


use App\Models\ClientSeason;
use App\Models\ClientSeasonTerm;
use App\Models\ClientTypeRoom;
use App\Http\Controllers\Controller;
use App\Models\ClientTypeRoomPrice;
use App\Models\ClientType;
use App\Models\ClientTypeFacility;
use App\Models\ClientTypeRoomPriceCustom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Jenssegers\Agent\Agent;


class PriceController
{
    protected $data = [];
    protected $phone = true;

    public function __construct() {
        $agent = new Agent();
        $this->phone = $agent->isPhone()?"mobile":"pc";

        $this->data['code'] = 200;
        $this->data['message'] = 'Success';
    }

    public function getCalc(Request $request, $user_id="") {
        if($user_id== ""){
            $user_id = Auth::user()->id;
        }

        $this->data['year']     = $request->query("year",date("Y"));
        $this->data['month']    = $request->query("month",date("n"));
        $this->data['day']      = $request->query("day",date("j"));

        $this->data['room']     = ClientTypeRoom::where('user_id',$user_id)->orderby('type_id','asc')->orderby('room_name','asc')->get();
        $this->data['season']   = ClientSeason::wherein('user_id',[0,$user_id])->where('flag_use','Y')->orderby('id','asc')->get();

        //일자별 요금 호출 (시즌)
        $tmp_basic_date = strtotime($this->data['year']."-".$this->data['month']."-".$this->data['day']);
        for($i=1; $i<=date("t",$tmp_basic_date); $i++){
            $tmp_date = date("Y-m-".$i,$tmp_basic_date);
            $tmp_union = ClientSeasonTerm::where('user_id',0);
            $tmp_season = ClientSeasonTerm::where('user_id',$user_id)
                ->where('season_start','<=',date("Y-m-d",strtotime($tmp_date)))
                ->where('season_end','>=',date("Y-m-t",strtotime($tmp_date)))
                ->unionAll($tmp_union)
                ->get();
            foreach($this->data['room'] as $r) {
                foreach ($tmp_season as $ts) {
                    $price = ClientTypeRoomPrice::where(['user_id'=>$user_id, 'season_id'=>$ts->season_id, 'room_id'=>$r->id])->select('price_day_'.date('w',strtotime($tmp_date)))->first();
                    $this->data['price_day'][$i][$r->id][date('w',strtotime($tmp_date))][$ts->season_id] = isset($price)?$price->{'price_day_'.date('w',strtotime($tmp_date))}:0;
                }
                $this->data['price_custom'][$i][$r->id] = ClientTypeRoomPriceCustom::where(['user_id'=>$user_id, 'room_id'=>$r->id, 'custom_date'=>date("Y-m-d",strtotime($tmp_date))])->first();
            }

        }

        return view('admin.'.$this->phone.'.price.calendar', $this->data);
    }

    public function postCalc(Request $request, $user_id="") {

        $delNotIdList = [];
        $targetDays = [];
        foreach($request->price_season as $k => $v){
            $targetDays[] = $k;
            foreach($v as $k2 => $v2){
                $price_daily = $request->price_daily[$k][$k2];
                $custom_season = $request->custom_price_season[$k][$k2];
                $custom_daily = $request->custom_price_daily[$k][$k2];

                if($v2!=$custom_season || $price_daily!=$custom_daily) {
                    $tmp = ClientTypeRoomPriceCustom::where(['user_id' => $user_id, 'room_id' => $k2, 'custom_date' => $k])->first();
                    if (!isset($tmp)) {
                        $tmp = new ClientTypeRoomPriceCustom();
                        $tmp->user_id = $user_id;
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
        ClientTypeRoomPriceCustom::where('user_id',$user_id)->whereIn('custom_date',$targetDays)->whereNotIn('id',$delNotIdList)->delete();

        return redirect()->route('price.calendar',['user_id'=>$user_id]);
    }

    public function season($data=[], $user_id="",$id=""){

        $price =[];
        if($user_id==""){
            $user_id= Auth::user()->id;
        }
        $price['user_id'] = $user_id;
        $price['curPath'] = "/info/season";
        $price['curPathstaff'] = "/price/season";
        $price['room'] = ClientTypeRoom::where('user_id', $user_id)->selectraw("client_type_room.*, (select type_name from client_type where id=client_type_room.type_id) as type_name")->selectraw("client_type_room.*, (select room_cnt_basic from client_type where id=client_type_room.type_id) as room_cnt_basic")->get();
        $price['seasonList'] = ClientSeason::whereIn('user_id',[$user_id])->get();
        $price['season'] = ClientSeason::whereIn('user_id',[$user_id,0]);
        $price['season_term_all'] = ClientSeasonTerm::whereIn('user_id',[$user_id,0])->where('season_id','<>',$id)->get();
        $price['season_term'] = ClientSeasonTerm::whereIn('user_id',[$user_id,0]);
        if($id!=""){
            $price['season'] = $price['season']->where('id',$id);
            $price['season_term'] = $price['season_term']->where('season_id',$id);
        }
        $price['season'] = $price['season']->orderby('id','asc')->get();
        $price['season_term'] = $price['season_term']->orderby('season_id','asc')->get();


        $roomSeasonPrice = [];
        foreach($price['room'] as $r) {
            foreach($price['season'] as $s) {
                $price['roomSeasonPrice'][$r->id][$s->id] = ClientTypeRoomPrice::where(['user_id'=>$user_id, 'room_id'=>$r->id, 'season_id'=>$s->id])->first();
            }
        }

        return $price;
    }

    public function getSeasonClient(Request $request, $id=""){
        $price = self::season($request->all(),"", $id);

        return view('admin.pc.price.season',$price);
    }
    public function getSeasonStaff(Request $request, $user_id, $id=""){
        $price = self::season($request->all(), $user_id, $id);

        return view('admin.pc.price.season',$price);
    }

    public function season_add(Request $request, $user_id="" ){

        $tmp = new ClientSeasonTerm();
        $tmp->ClientSeasonTerm($request->input("user_id"),$request->all());

        $url = $_SERVER['HTTP_HOST'];
        $url = explode(".",$url);
        if($url[0] =="staff"){
            return redirect()->route('price.list',['user_id'=>$request->input("user_id")]);
        }else{
            return redirect()->route('info.season');
        }

    }

    public function season_delete(Request $request){
        $user_id = $request->input('user_id');
        $season_id = $request->input('season_id');
        if(isset($season_id)){
            for($i=0; $i<sizeof($season_id); $i++){
                $delete_id = $season_id[$i];
                ClientSeason::where('id',$delete_id)->where('user_id',$user_id)->delete();
                ClientSeasonTerm::where('season_id',$delete_id)->where('user_id',$user_id)->delete();
                ClientTypeRoomPrice::where('season_id',$delete_id)->where('user_id',$user_id)->delete();
            }
        }

        $url = $_SERVER['HTTP_HOST'];
        $url = explode(".",$url);

        if($url[0] =="staff"){
            return redirect()->route('price.list',['user_id'=>$user_id]);
        }else{
            return redirect()->route('info.season');
        }

    }


    public function season_price_insert(Request $request, $user_id=""){

        $tmp = new ClientTypeRoomPrice();
        $tmp->ClientTypeRoomPrice($request->input("user_id"),$request->all());

        $url = $_SERVER['HTTP_HOST'];
        $url = explode(".",$url);

        if($url[0] =="staff"){
            return redirect()->route('price.list',['user_id'=>$user_id]);
        }else{
            return redirect()->route('info.season');
        }

    }

//    public function season_term(Request $request, $season_ids=""){
//
//        $user_id=$request->input('user_id');
//        $season_id = $request->input('season_id');
//        $tmpDeleteFacilityId = [];
//        foreach ($request->input('season_term_id') as $k=>$v){
//            if($request->input("season_term_id.".$k) ==""){
//                $ClientSeasonTerm = new ClientSeasonTerm();
//            }else{
//                $id = $request->input("season_term_id.".$k);
//                $ClientSeasonTerm = ClientSeasonTerm::find($id);
//            }
//            $ClientSeasonTerm->season_start = $request->input("start_season.".$k);
//            $ClientSeasonTerm->season_end = $request->input("end_season.".$k);
//            $ClientSeasonTerm->flag_view = $request->input("check_season.".$k);
//            $ClientSeasonTerm->user_id = $user_id;
//            $ClientSeasonTerm->season_id = $season_id;
//            $ClientSeasonTerm->save();
//            $tmpDeleteFacilityId[] = $ClientSeasonTerm->id;
//        }
//        ClientSeasonTerm::whereNotIn('id',$tmpDeleteFacilityId)->where('season_id',$ClientSeasonTerm->season_id)->delete();
//
//        return redirect()->route('info.season',['id'=>$season_ids]);
//    }
}
