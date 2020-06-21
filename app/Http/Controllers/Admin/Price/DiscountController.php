<?php


namespace App\Http\Controllers\Admin\Price;


use App\Models\ClientDiscount;
use App\Models\ClientDiscountBanDate;
use App\Models\ClientDiscountRoom;
use App\Models\ClientDiscountTerm;
use App\Models\ClientSeason;
use App\Models\ClientSeasonTerm;
use App\Models\ClientTypeRoom;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;
use Illuminate\Support\Facades\Auth;

class DiscountController
{
    protected $data = [];
    protected $phone = true;

    public function __construct() {
        $agent = new Agent();
        $this->phone = $agent->isPhone()?"mobile":"pc";

        $this->data['code'] = 200;
        $this->data['message'] = 'Success';
    }

    public function discount($user_id=""){
        if($user_id==""){
            $user_id = Auth::user()->id;
            $client = 'client';
        }
        //id값 빈 공간값(discount.blade.php 파일에서 파라메터 값을 넘겨야 해서 빈 공간으로 둠)
        //uid값 staff에서 넘겨줄 user_id값
//        $uid = Auth::user()->id;

        $discountList = ClientDiscount::where('user_id',$user_id)
            ->selectraw('
                client_discount.*
                    , ifnull((select group_concat(discount_start separator ",") from client_discount_term where discount_id=client_discount.id),null) as discount_start
                    , ifnull((select group_concat(discount_end separator ",") from client_discount_term where discount_id=client_discount.id),null) as discount_end
                    , ifnull((select date from client_discount_term where discount_id=client_discount.id limit 1),null) as date
                ')
                ->paginate(5);

        $ClientTypeRoom = ClientTypeRoom::where('client_type_room.user_id',$user_id)->get();
        $ClientSeasonTerm = ClientSeasonTerm::where('user_id',$user_id)
            ->selectraw('
                client_season_term.*
                , (select season_name from client_season where id=client_season_term.season_id and user_id='.$user_id.') as season_name
            ')
            ->get();


        return view('admin.pc.price.discount',[
            'discountList' => $discountList
            ,'client'=> isset($client)?$client:""
            ,'user_id'=>$user_id
            ,'ClientTypeRoom'=>$ClientTypeRoom
            ,'ClientSeasonTerm'=>$ClientSeasonTerm
        ]);
    }

    public function getDiscountClient(Request $request, $did=""){
        $discount = self::discount_view($request->all(),"", $did);

        return $discount;
//        return view('admin.pc.price.discount_insert',$discount);
    }
    public function getDiscountStaff(Request $request, $user_id, $did=""){
        $discount = self::discount_view($request->all(), $user_id, $did);

        return $discount;
//        return view('admin.pc.price.discount_insert',$discount);
    }

    public function discount_view($data=[], $user_id="", $did=""){

        //did값은 할인 시즌의 아이디 값임.
        $discount =[];
        if($user_id==""){
            $user_id= Auth::user()->id;
        }
        if($did==""){
            $did=0;
        }
        $discount['did'] = $did;
        $discount['curPath'] = "/info/season";
        $discount['user_id'] = $user_id;


        $discount['ClientTypeRoom'] = ClientTypeRoom::where('client_type_room.user_id',$user_id)
            ->selectraw('
                client_type_room.*
                , (select discount_value from client_discount_room where room_id=client_type_room.id and discount_id='.$did.') as discount_value
                , (select room_id from client_discount_room where room_id=client_type_room.id and discount_id='.$did.') as room_id
                , (select type from client_discount_room where room_id=client_type_room.id and discount_id='.$did.') as type
                , (select unit from client_discount_room where room_id=client_type_room.id and discount_id='.$did.') as unit
                ')
            ->get();

        $discount['isset'] = ClientDiscount::find($did);

        $discount['ClientSeason'] = ClientSeasonTerm::where('user_id',$user_id)
            ->selectraw('
                client_season_term.*
                , ifnull((select group_concat(season_name separator ",") from client_season where id=client_season_term.season_id),null) as season_name
                , ifnull((select group_concat(id separator ",") from client_season where id=client_season_term.season_id),null) as season_id
                ')
            ->get();
        $discount['ClientSeason_Check'] = ClientDiscount::where('user_id',$user_id)->where('id', $did)->value('season_check');
        $discount['ClientSeason_date'] = ClientDiscount::where('user_id',$user_id)->where('id', $did)->value('date');
        $discount['ClientSeason_date'] = explode(",",$discount['ClientSeason_date']);
        $discount['ClientDiscountBanDate'] = ClientDiscountBanDate::where('user_id',$user_id)->where('discount_id',$did)->orderby('date_ban')->get();
        $discount['ClientDiscountTerm'] = ClientDiscountTerm::where('user_id',$user_id)->where('discount_id',$did)
            ->selectraw("
                client_discount_term.*
                , (select season_check from client_discount where id=client_discount_term.discount_id) as season_check
                ")
            ->get();

        $discount['ClientDiscount'] = ClientDiscount::where('user_id',$user_id)->where('id',$did)->first();
        $discount['ClientDiscountBanDateSize'] = ClientDiscountBanDate::where('user_id',$user_id)->where('discount_id',$did)->get();

        return $discount;
    }

    public function discount_save(Request $request, $did=""){
        $did = $request->input('season_id');
        isset($did)?$did:$did="";

        $ClientDiscount = ClientDiscount::find($did);

        if(isset($ClientDiscount)){
            $ClientDiscount = ClientDiscount::find($did);
        }else{
            $ClientDiscount = new ClientDiscount();
        }
        $ClientDiscount->discount_name = $request->discount_name;
        $ClientDiscount->flag_use = $request->discount_check;
        $ClientDiscount->season_check = $request->input('what_date');
        $ClientDiscount -> date = implode(",",$request->input('day'));
        $ClientDiscount->user_id = Auth::user()->id;
        $ClientDiscount->save();


        //직접 입력(할인 기간)
        if($ClientDiscount->season_check=='N'){
            $tmpDeleteClientDiscountTermId1 = [];
            foreach ($request->input('start_season') as $k =>$v){
                if(($request->input('start_season.'.$k))!=""){
                    $end_season = $request->input('end_season.'.$k);
                    $client_discount_term_id = $request->input('client_discount_term_id.'.$k);
                    $isset = ClientDiscountTerm::where('discount_id',$did)->where('user_id',Auth::user()->id)->where('id',$client_discount_term_id)->first();
                    if(isset($isset)){
                        $ClientDiscountTerm = ClientDiscountTerm::find($isset['id']);
                    }else{
                        $ClientDiscountTerm = new ClientDiscountTerm();
                        $ClientDiscountTerm->user_id = Auth::user()->id;
                        $ClientDiscountTerm->discount_id = $did;
                        $ClientDiscountTerm->season_id=null;
                    }
                    $ClientDiscountTerm->discount_start = $v;
                    $ClientDiscountTerm->discount_end = $end_season;
                    $ClientDiscountTerm->save();
                    $tmpDeleteClientDiscountTermId1[] = $ClientDiscountTerm->id;
                }
            }
            ClientDiscountTerm::whereNotIn('id',$tmpDeleteClientDiscountTermId1)->where('user_id',Auth::user()->id)->where('discount_id',$did)->delete();
        }else if($ClientDiscount->season_check=='Y'){
//            dd($request->all());
            //기간 참조(할인 기간)-->시즌 갯수 만큼 돌림(체크된 시즌 갯수)
            $tmpDeleteClientDiscountTermId2 = [];
            foreach ($request->input('no_right_now_id') as $k=>$v){
                $isset = ClientDiscountTerm::where('discount_id',$did)->where('user_id',Auth::user()->id)->where('season_id',$v)->first();
                if(!isset($isset)){
                    $ClientDiscountTerm = new ClientDiscountTerm();
                    $ClientDiscountTerm -> user_id = Auth::user()->id;
                    $ClientDiscountTerm -> discount_id = $did;
                    $ClientDiscountTerm->season_id = $v;
                }else{
                    $ClientDiscountTerm = ClientDiscountTerm::find($isset['id']);
                }
                $ClientDiscountTerm->discount_start =null;
                $ClientDiscountTerm->discount_end =null;
                $ClientDiscountTerm->save();
                $tmpDeleteClientDiscountTermId2[] = $ClientDiscountTerm->id;
            }
            ClientDiscountTerm::whereNotIn('id',$tmpDeleteClientDiscountTermId2)->where('user_id',Auth::user()->id)->where('discount_id',$did)->delete();
        }

        //제외 날짜 값(배열 형식으로 받음)
        $date_ban = $request->input('date_ban');
        $tmpDeleteDateBanId = [];
        foreach ($date_ban as $k =>$v){
            if(($request->input('date_ban.'.$k))!=""){
                $ClientDiscountBanDate = ClientDiscountBanDate::where('discount_id',$did)->where('user_id',Auth::user()->id)->where('date_ban',$v)->first();
                if(isset($ClientDiscountBanDate)){
                    $ClientDiscountBanDate = ClientDiscountBanDate::find($ClientDiscountBanDate['id']);
                }else{
                    $ClientDiscountBanDate = new ClientDiscountBanDate();
                    $ClientDiscountBanDate->user_id = Auth::user()->id;
                    $ClientDiscountBanDate->discount_id = $ClientDiscount->id;
                }
                $ClientDiscountBanDate ->date_ban = $v;
                $ClientDiscountBanDate ->save();
                $tmpDeleteDateBanId[] = $ClientDiscountBanDate->id;
            }
        }
        ClientDiscountBanDate::whereNotIn('id',$tmpDeleteDateBanId)->where('user_id',Auth::user()->id)->where('discount_id',$did)->delete();

        //room_id별로 할인 값 넣기
        $tmpDeleteRoomId = [];
        foreach ($request->input('room_id') as $k=>$v){
            $id = ClientDiscountRoom::where('user_id',Auth::user()->id)->where('discount_id',$did)->where('room_id',$v)->value('id');
            if(isset($id)){
                $ClientDiscountRoom = ClientDiscountRoom::find($id);
            }else {
                $ClientDiscountRoom = new ClientDiscountRoom();
                $ClientDiscountRoom->user_id = Auth::user()->id;
                $ClientDiscountRoom->room_id = $request->input("room_id.".$k);
                $ClientDiscountRoom->discount_id = $ClientDiscount->id;
            }
            $ClientDiscountRoom->discount_value = $request->input("discount.".$k);
            $tmp = explode("|",$request->input("char"));
            $ClientDiscountRoom->unit = $tmp[0];
            $ClientDiscountRoom->type = $tmp[1];
            $ClientDiscountRoom->save();
            $tmpDeleteRoomId[] = $ClientDiscountRoom->id;
        }
        ClientDiscountRoom::whereNotIn('id',$tmpDeleteRoomId)->where('user_id',Auth::user()->id)->where('discount_id',$did)->delete();

        return redirect()->route('info.discount');
    }

    public function staff_discount_save(Request $request, $user_id="", $did=""){
//        dd($request->all());
        $did = $request->input('season_id');
        isset($did)?$did:$did="";
        $ClientDiscount = ClientDiscount::find($did);

        if(isset($ClientDiscount)){
            $ClientDiscount = ClientDiscount::find($did);
        }else{
            $ClientDiscount = new ClientDiscount();
        }
        $ClientDiscount->discount_name = $request->discount_name;
        $ClientDiscount->flag_use = $request->discount_check;
        $ClientDiscount->season_check = $request->input('what_date');
        $ClientDiscount -> date = implode(",",$request->input('day'));
        $ClientDiscount->user_id = $user_id;
        $ClientDiscount->save();


        //직접 입력(할인 기간)
        if($ClientDiscount->season_check=='N'){
            $tmpDeleteClientDiscountTermId1 = [];
            foreach ($request->input('start_season') as $k =>$v){
                if(($request->input('start_season.'.$k))!=""){
                    $end_season = $request->input('end_season.'.$k);
                    $client_discount_term_id = $request->input('client_discount_term_id.'.$k);
                    $isset = ClientDiscountTerm::where('discount_id',$did)->where('user_id',$user_id)->where('id',$client_discount_term_id)->first();
                    if(isset($isset)){
                        $ClientDiscountTerm = ClientDiscountTerm::find($isset['id']);
                    }else{
                        $ClientDiscountTerm = new ClientDiscountTerm();
                        $ClientDiscountTerm->user_id = $user_id;
                        $ClientDiscountTerm->discount_id = isset($did) && $did != "" ?$did:$ClientDiscount->id;
                    }
                    $ClientDiscountTerm->discount_start = $v;
                    $ClientDiscountTerm->discount_end = $end_season;
                    $ClientDiscountTerm->season_id=null;
                    $ClientDiscountTerm->save();
                    $tmpDeleteClientDiscountTermId1[] = $ClientDiscountTerm->id;
                }
            }
            ClientDiscountTerm::whereNotIn('id',$tmpDeleteClientDiscountTermId1)->where('user_id',$user_id)->where('discount_id',$did)->delete();
        }else if($ClientDiscount->season_check=='Y'){
            //기간 참조(할인 기간)-->시즌 갯수 만큼 돌림(체크된 시즌 갯수)
            $tmpDeleteClientDiscountTermId2 = [];
            foreach ($request->input('no_right_now_id') as $k=>$v){
                $isset = ClientDiscountTerm::where('discount_id',$did)->where('user_id',$user_id)->where('season_id',$v)->first();
                if(!isset($isset)){
                    $ClientDiscountTerm = new ClientDiscountTerm();
                    $ClientDiscountTerm -> user_id = $user_id;
                    $ClientDiscountTerm -> discount_id = isset($did) && $did != "" ?$did:$ClientDiscount->id;
                    $ClientDiscountTerm->season_id = $v;
                }else{
                    $ClientDiscountTerm = ClientDiscountTerm::find($isset['id']);
                }
                $ClientDiscountTerm->discount_start =null;
                $ClientDiscountTerm->discount_end =null;
                $ClientDiscountTerm->save();
                $tmpDeleteClientDiscountTermId2[] = $ClientDiscountTerm->id;
            }
            ClientDiscountTerm::whereNotIn('id',$tmpDeleteClientDiscountTermId2)->where('user_id',$user_id)->where('discount_id',$did)->delete();
        }

        //제외 날짜 값(배열 형식으로 받음)
        $date_ban = $request->input('date_ban');
        $tmpDeleteDateBanId = [];
        foreach ($date_ban as $k =>$v){
            if(($request->input('date_ban.'.$k))!=""){
                $ClientDiscountBanDate = ClientDiscountBanDate::where('discount_id',$did)->where('user_id',$user_id)->where('date_ban',$v)->first();
                if(isset($ClientDiscountBanDate)){
                    $ClientDiscountBanDate = ClientDiscountBanDate::find($ClientDiscountBanDate['id']);
                }else{
                    $ClientDiscountBanDate = new ClientDiscountBanDate();
                    $ClientDiscountBanDate->user_id = $user_id;
                    $ClientDiscountBanDate->discount_id = isset($did) && $did != "" ?$did:$ClientDiscount->id;
                }
                $ClientDiscountBanDate ->date_ban = $v;
                $ClientDiscountBanDate ->save();
                $tmpDeleteDateBanId[] = $ClientDiscountBanDate->id;
            }
        }
        ClientDiscountBanDate::whereNotIn('id',$tmpDeleteDateBanId)->where('user_id',$user_id)->where('discount_id',$did)->delete();

        //room_id별로 할인 값 넣기
        $tmpDeleteRoomId = [];
        foreach ($request->input('room_id') as $k=>$v){
            $id = ClientDiscountRoom::where('user_id',$user_id)->where('discount_id',$did)->where('room_id',$v)->value('id');
            if(isset($id)){
                $ClientDiscountRoom = ClientDiscountRoom::find($id);
            }else {
                $ClientDiscountRoom = new ClientDiscountRoom();
                $ClientDiscountRoom->user_id = $user_id;
                $ClientDiscountRoom->room_id = $request->input("room_id.".$k);
                $ClientDiscountRoom->discount_id = isset($did) && $did != "" ?$did:$ClientDiscount->id;
            }
            $ClientDiscountRoom->discount_value = $request->input("discount.".$k);
            $tmp = explode("|",$request->input("char.".$k));
            $ClientDiscountRoom->unit = $tmp[0];
            $ClientDiscountRoom->type = $tmp[1];
            $ClientDiscountRoom->save();
            $tmpDeleteRoomId[] = $ClientDiscountRoom->id;
        }
        ClientDiscountRoom::whereNotIn('id',$tmpDeleteRoomId)->where('user_id',$user_id)->where('discount_id',$did)->delete();

        return redirect()->route('price.discount',['user_id'=>$user_id]);
    }

    public function DeleteDiscountStaff(Request $request, $user_id, $season_id){
        ClientDiscount::where('id',$season_id)->where('user_id',$user_id)->delete();
        ClientDiscountBanDate::where('discount_id',$season_id)->where('user_id',$user_id)->delete();
        ClientDiscountRoom::where('discount_id',$season_id)->where('user_id',$user_id)->delete();
        ClientDiscountTerm::where('discount_id',$season_id)->where('user_id',$user_id)->delete();
        return redirect()->route('price.discount',['user_id'=>$user_id]);
    }
}
