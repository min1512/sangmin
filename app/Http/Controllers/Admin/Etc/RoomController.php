<?php

namespace App\Http\Controllers\Admin\Etc;

use App\Http\Controllers\Controller;
use App\Models\ClientTypeRoomPrice;
use App\Models\ClientType;
use App\Models\ClientTypeFacility;
use App\Models\ClientTypeRoom;
use App\Models\FileData;
use App\Models\UserClient;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RoomController extends Controller
{
    protected $data = [];

    public function __construct(Request $request) {
        $this->data['code'] = 200;
        $this->data['message'] = 'Success';
    }

    public function getList(Request $request, $user_id="") {

        //        if(isset($search['search1']) && $search['search1']!="") {
//            if($search['search1']=="client_list"){
//                $search_field1 = "client_list";
//                if($search['search2']=="search_group"){
//                    //그룹명 검색
//                    $search_field2 = "type_name";
//                    //그룹명으로 type_id 검색
//                    $type_ids = 'type_id';
//                    //
//
//                    $ClientType = $ClientType->where($search_field2,'like','%'.$search['search_board'].'%')->where('user_id',$uid);
//                    if(isset($search['search_board'])){
//                        $type_id['id'] = $ClientType->get();
//                        foreach($type_id['id'] as $type_id){
//                            $keeping =$type_id->id;
//                            $ClientTypeRoom = $ClientTypeRoom->orwhere($type_ids,'like','%'.$keeping.'%')->where('user_id',$uid);
//                        }
//                    }else{
//                        $ClientTypeRoom = $ClientTypeRoom->where($type_ids,'like','%'.'%')->where('user_id',$uid);
//                    }
//                }elseif ($search['search2']=="search_num"){
//                    //판매 객실수 검색
//                    $search_field2 = "num";
//                    //
//                    $type_ids = 'type_id';
//                    //
//
//                    $ClientType = $ClientType->where($search_field2,'like','%'.$search['search_board'].'%')->where('user_id',$uid);
//                    if(isset($search['search_board'])){
//                        $type_id['id'] = $ClientType->get();
//                        foreach($type_id['id'] as $type_id){
//                            $keeping =$type_id->id;
//                            $ClientTypeRoom = $ClientTypeRoom->orwhere($type_ids,'like','%'.$keeping.'%')->where('user_id',$uid);
//                        }
//                    }else{
//                        $ClientTypeRoom = $ClientTypeRoom->where($type_ids,'like','%'.'%')->where('user_id',$uid);
//                    }
//                }elseif ($search['search2']=="search_basic"){
//                    //기준(사람) 검색
//                    $search_field2 = "room_cnt_basic";
//                    //
//                    $type_ids = 'type_id';
//                    //
//
//                    $ClientType = $ClientType->where($search_field2,'like','%'.$search['search_board'].'%')->where('user_id',$uid);
//                    if(isset($search['search_board'])){
//                        $type_id['id'] = $ClientType->get();
//                        foreach($type_id['id'] as $type_id){
//                            $keeping =$type_id->id;
//                            $ClientTypeRoom = $ClientTypeRoom->orwhere($type_ids,'like','%'.$keeping.'%')->where('user_id',$uid);
//                        }
//                    }else{
//                        $ClientTypeRoom = $ClientTypeRoom->where($type_ids,'like','%'.'%')->where('user_id',$uid);
//                    }
//                }elseif ($search['search2']=="search_max"){
//                    //최대(사람) 검색
//                    $search_field2 = "room_cnt_max";
//                    //
//                    $type_ids = 'type_id';
//                    //
//
//                    $ClientType = $ClientType->where($search_field2,'like','%'.$search['search_board'].'%')->where('user_id',$uid);
//                    if(isset($search['search_board'])){
//                        $type_id['id'] = $ClientType->get();
//                        foreach($type_id['id'] as $type_id){
//                            $keeping =$type_id->id;
//                            $ClientTypeRoom = $ClientTypeRoom->orwhere($type_ids,'like','%'.$keeping.'%')->where('user_id',$uid);
//                        }
//                    }else{
//                        $ClientTypeRoom = $ClientTypeRoom->where($type_ids,'like','%'.'%')->where('user_id',$uid);
//                    }
//                }
//            }elseif ($search['search1']=="room_list"){
//                $search_field1= "room_list";
//                if($search['search2']=="search_room_name"){
//                    //객실명 검색
//                    $search_field2 = "room_name";
//                    //
//                    $type_ids = 'id';
//                    //
//                    $ClientTypeRoom = $ClientTypeRoom->where($search_field2,'like','%'.$search['search_board'].'%')->where('user_id',$uid);
//                    if(isset($search['search_board'])){
//                        $type_id['id'] = $ClientTypeRoom->get();
//                        foreach($type_id['id'] as $type_id){
//                            $keeping =$type_id->type_id;
//                            $ClientType = $ClientType->orwhere($type_ids,'like','%'.$keeping.'%')->where('user_id',$uid);
//                        }
//                    }else{
//                        $ClientType = $ClientType->where($type_ids,'like','%'.'%')->where('user_id',$uid);
//                    }
//                }elseif ($search['search2']=="search_realtime"){
//                    //실시간 예약 검색
//                    $search_field2 = "flag_realtime";
//                    //
//                    $type_ids = 'id';
//                    //
//                    $ClientTypeRoom = $ClientTypeRoom->where($search_field2,'like','%'.$search['search_board'].'%')->where('user_id',$uid);
//                    if(isset($search['search_board'])){
//                        $type_id['id'] = $ClientTypeRoom->get();
//                        foreach($type_id['id'] as $type_id){
//                            $keeping =$type_id->type_id;
//                            $ClientType = $ClientType->orwhere($type_ids,'like','%'.$keeping.'%')->where('user_id',$uid);
//                        }
//                    }else{
//                        $ClientType = $ClientType->where($type_ids,'like','%'.'%')->where('user_id',$uid);
//                    }
//                }elseif ($search['search2']=="search_online"){
//                    //온라인 예약 검색
//                    $search_field2 = "flag_online";
//                    //
//                    $type_ids = 'id';
//                    //
//                    $ClientTypeRoom = $ClientTypeRoom->where($search_field2,'like','%'.$search['search_board'].'%')->where('user_id',$uid);
//                    if(isset($search['search_board'])){
//                        $type_id['id'] = $ClientTypeRoom->get();
//                        foreach($type_id['id'] as $type_id){
//                            $keeping =$type_id->type_id;
//                            $ClientType = $ClientType->orwhere($type_ids,'like','%'.$keeping.'%')->where('user_id',$uid);
//                        }
//                    }else{
//                        $ClientType  = $ClientType->where($type_ids,'like','%'.'%')->where('user_id',$uid);
//                    }
//                }
//            }
//        }else{
//            $ClientType=$ClientType->where('user_id',$uid);
//            $ClientTypeRoom=$ClientTypeRoom->where('user_id',$uid);
//        }


        isset($user_id)?$uid=$user_id:$uid=Auth::user()->id;
        if($uid==""){
            $uid=Auth::user()->id;
        }
        //etc_search에서 select 값 받아옴
        $search['search2']=$request->query('search2');
        //etc_search에서 검색어 입력 한부분
        $search['search_board']=$request->query('search_board');
        //etc_search1에서 객실명 검색 부분
        $search['search_room_list']=$request->query('search_room_list');
        //etc_search1에서 실시간 예약 검색 부분
        $search['search_room_list_check']=$request->query('search_room_list_check');


        $ClientType = ClientType::orderby('id','desc');
        $ClientTypeRoom = ClientTypeRoom::orderby('id','desc');

        //etc_search 페이지있는 검색 기능 했을때
        if(isset($search['search2']) && !isset($search['search_room_list'])){
            if($search['search2']=="search_group"){
                //그룹명 검색
                $search_field2 = "type_name";
                //그룹명으로 type_id 검색
                $type_ids = 'type_id';
                //

                $ClientType = $ClientType->where($search_field2,'like','%'.$search['search_board'].'%')->where('user_id',$uid);
                //그룹명 검색 select 하고, 검색어 입력
                if(isset($search['search_board'])){
                    $type_id['id'] = $ClientType->get();
                    foreach($type_id['id'] as $type_id){
                        $keeping =$type_id->id;
                        $ClientTypeRoom = $ClientTypeRoom->orwhere($type_ids,'like','%'.$keeping.'%')->where('user_id',$uid);
                    }
                }else{
                    $ClientTypeRoom = $ClientTypeRoom->where($type_ids,'like','%'.'%')->where('user_id',$uid);
                }
            }elseif ($search['search2']=="search_num"){
                //판매 객실수 검색
                $search_field2 = "num";
                //
                $type_ids = 'type_id';
                //

                $ClientType = $ClientType->where($search_field2,'like','%'.$search['search_board'].'%')->where('user_id',$uid);
                //판매 객실수 검색 하고 검색어 입력
                if(isset($search['search_board'])){
                    $type_id['id'] = $ClientType->get();
                    foreach($type_id['id'] as $type_id){
                        $keeping =$type_id->id;
                        $ClientTypeRoom = $ClientTypeRoom->orwhere($type_ids,'like','%'.$keeping.'%')->where('user_id',$uid);
                    }
                }else{
                    $ClientTypeRoom = $ClientTypeRoom->where($type_ids,'like','%'.'%')->where('user_id',$uid);
                }
            }elseif ($search['search2']=="search_basic"){
                //기준(사람) 검색
                $search_field2 = "room_cnt_basic";
                //
                $type_ids = 'type_id';
                //

                $ClientType = $ClientType->where($search_field2,'like','%'.$search['search_board'].'%')->where('user_id',$uid);
                //기준 검색 하고 검색어 입력
                if(isset($search['search_board'])){
                    $type_id['id'] = $ClientType->get();
                    foreach($type_id['id'] as $type_id){
                        $keeping =$type_id->id;
                        $ClientTypeRoom = $ClientTypeRoom->orwhere($type_ids,'like','%'.$keeping.'%')->where('user_id',$uid);
                    }
                }else{
                    $ClientTypeRoom = $ClientTypeRoom->where($type_ids,'like','%'.'%')->where('user_id',$uid);
                }
            }elseif ($search['search2']=="search_max") {
                //최대(사람) 검색
                $search_field2 = "room_cnt_max";
                //
                $type_ids = 'type_id';
                //

                $ClientType = $ClientType->where($search_field2, 'like', '%' . $search['search_board'] . '%')->where('user_id', $uid);
                //최대 검색 하고 검색어 입력
                if (isset($search['search_board'])) {
                    $type_id['id'] = $ClientType->get();
                    foreach ($type_id['id'] as $type_id) {
                        $keeping = $type_id->id;
                        $ClientTypeRoom = $ClientTypeRoom->orwhere($type_ids, 'like', '%' . $keeping . '%')->where('user_id', $uid);
                    }
                } else {
                    $ClientTypeRoom = $ClientTypeRoom->where($type_ids, 'like', '%' . '%')->where('user_id', $uid);
                }
            }
        }else{
            $ClientType = $ClientType->where('user_id',$uid);
            $ClientTypeRoom = $ClientTypeRoom->where('user_id',$uid);
        }

        //etc_search1에 검색어 하고, 첫번째 페이지에 검색어 있을때
        if(isset($search['search_room_list']) && isset($search['search_board'])){
            if(isset($search['search2']) && isset($search['search_board']) && !isset($search['search_room_list_check']) ){

                //그룹명 검색
                $search_field2 = "type_name";

                $ClientType = $ClientType->where($search_field2,'like','%'.$search['search_board'].'%')->where('user_id',$uid);


                $type_id['id'] = $ClientType->get();
                foreach($type_id['id'] as $type_id){
                    $keeping =$type_id->id;
                    $ClientTypeRoom = $ClientTypeRoom->where('room_name','like','%'.$search['search_room_list'].'%')->where('type_id','like','%'.$keeping.'%')->where('user_id',$uid);
                }
            }else if(isset($search['search2']) && isset($search['search_board']) && isset($search['search_room_list_check'])){
                //그룹명 검색
                $search_field2 = "type_name";

                $ClientType = $ClientType->where($search_field2,'like','%'.$search['search_board'].'%')->where('user_id',$uid);

                $type_id['id'] = $ClientType->get();
                foreach($type_id['id'] as $type_id){
                    $keeping =$type_id->id;
                    $ClientTypeRoom = $ClientTypeRoom->where('room_name','like','%'.$search['search_room_list'].'%')->where('flag_realtime',$search['search_room_list_check'])->where('type_id','like','%'.$keeping.'%')->where('user_id',$uid);
                }
            }else{
                $ClientTypeRoom = $ClientTypeRoom->where('room_name','lkie','%'.$search['search_room_list'].'%')->where('user_id',$uid);
                $ClientType = $ClientType->where('user_id',$uid);
            }
            //etc_search1에 검색어 하고, 실시간 예약 관련 검색 안할때
        }else if(isset($search['search_room_list']) && !isset($search['search_room_list_check'])){
            $ClientTypeRoom = $ClientTypeRoom->where('room_name','like','%'.$search['search_room_list'].'%')->where('user_id',$uid);
            //실시간 예약 관련 검색 하고 etc_search1에 검색 안할때,
        }else if(isset($search['search_room_list_check']) && !isset($search['search_room_list'])){
            $ClientTypeRoom = $ClientTypeRoom->where('room_name','like','%'.$search['search_room_list'].'%')->where('flag_realtime',$search['search_room_list_check'])->where('user_id',$uid);
            //둘다 검색
        }else if(isset($search['search_room_list']) && isset($search['search_room_list_check'])){
            $ClientTypeRoom = $ClientTypeRoom->where('room_name','like','%'.$search['search_room_list'].'%')->where('flag_realtime',$search['search_room_list_check'])->where('user_id',$uid);
        }

        $this->data['clientList'] = $ClientType->paginate(5, ['*'], 'clientList');
        $this->data['ClientTypeRoom'] = $ClientTypeRoom->paginate(2000, ['*'], 'ClientTypeRoom');
        $url = $_SERVER['HTTP_HOST'];
        $url = explode(".",$url);
        if($url[0]=="staff"){
            $this->data['staff'] = $url[0];
            $this->data['staffList_user_id'] = $uid;
        }

        $id=0;
        $this->data['id'] = $id;


        return view('admin.pc.price.etc',$this->data, ['ClientType'=>$ClientType, 'search'=>$search]);
    }

    public function getSave($data=[], $user_id="", $type_id="") {

        $room = [];
        $room['ClientRoom'] = ClientType::find($type_id);
        $room['ClientRooms'] = ClientType::where('id', $type_id)->get();
        $room['room_name'] = ClientTypeRoom::where('type_id', $type_id)->where('user_id', $user_id == "" ? Auth::user()->id : $user_id)->get();
        $room['ClientRoomFacilitys'] = ClientTypeFacility::where('type_id', $type_id)->selectraw("group_concat(code_facility separator ',') as fac")->first();
        $room['user_id'] = $user_id;
        $room['type_id'] = $type_id;
        $room['file'] = FileData::where('target_id',$type_id)->where('target',"client_type")->orderby('orderby','asc')->get();

        return $room;
    }

    public function getSaveClient(Request $request, $type_id){
        $room = self::getSave($request->all(), "", $type_id);

        return view('admin.pc.include.price.etc_view',$room);
    }
    public function getSaveStaff(Request $request, $user_id, $type_id=""){

        $room = self::getSave($request->all(), $user_id, $type_id);

        return view('admin.pc.include.price.etc_view',$room);
    }


    public function postSave(Request $request) {

        $tmp = new ClientType();
        $tmp->clientTypeSave($request->file('file'),$request->input("user_id"),$request->all());

        $url = $_SERVER['HTTP_HOST'];
        $url = explode(".",$url);

        if($url[0] =="staff"){
            return redirect()->route('room.list', ['user_id' => $request->input("user_id") ]);
        }else{
            return redirect()->route('etc.room');
        }


    }

    public function live_check(Request $request, $user_id=1){

        $all = $request->all();
        $all=array($all);
        foreach ($all as $k=>$v){
            for($i=1; $i<=(sizeof($v)-1)/4; $i++){
                $client_type_room_id= "client_type_room_id_$i";
                $client_type_room_group = "client_type_room_group_$i";
                $now = "now_$i";
                $online = "online_$i";
                $delete = "delete_$i";
                $delete_value = $request->input($delete);
                $client_type_room_group_value = $v[$client_type_room_group];
                $client_type_room_id_value = $v[$client_type_room_id];
                $now_value = $v[$now];
                $online_value = $v[$online];
                DB::table('client_type_room')->where('id',$client_type_room_id_value)->update(['flag_realtime'=>$now_value,'flag_online'=>$online_value]);
                if(isset($delete_value)){
                    DB::table('client_type_room')->where('id',$client_type_room_id_value)->delete();
                    $num = DB::table('client_type')->where('type_name',$client_type_room_group_value)->value('num');
                    DB::table('client_type')->where('type_name',$client_type_room_group_value)->update(['num'=>$num-1]);
                }
            }
        }
        if($user_id==""){
            return redirect()->route('etc.room');
        }else{
            return redirect()->route('room.list',['user_id'=>$user_id]);
        }

    }
}
