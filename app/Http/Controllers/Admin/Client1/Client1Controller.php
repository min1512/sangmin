<?php

namespace App\Http\Controllers\Admin\Client1;

use App\Http\Controllers\Controller;
use App\Models\ClientType;
use App\Models\ClientTypeFacility;
use App\Models\ClientTypeRoom;
use App\Models\UserClient;
use Illuminate\Http\Request;

class Client1Controller extends Controller
{
    protected $data = [];

    public function __construct() {
        $this->data['code'] = 200;
        $this->data['message'] = 'Success';
    }

    public function getList(Request $request, $id="") {
        $this->data['clientList'] = ClientType::where('user_id',$id)->paginate(20);
        $this->data['ClientTypeRoom'] = ClientTypeRoom::where('user_id',$id)->get();
//        $this->data['clientList'] = UserClient::leftjoin('users','users.id','=','user_client.user_id')
//            ->paginate(20);
        //dd($this->data['clientList']);
        return view('admin.client1.client1_list',$this->data);
    }

    public function getSave(Request $request, $id="") {
        $id=2;
        $user_id=2;
        $url = $request->path();
        $url = str_replace("room/2/room_insert/","",$url);
        $ClientRoom=ClientType::find($url);
        $ClientRooms = ClientType::where('id',$url)->get();
        $room_name = ClientTypeRoom::where('type_id',$user_id)->where('user_id',$user_id)->get();
        $ClientRoomFacilitys = ClientTypeFacility::where('type_id',$url)->value('code_facility');
        $ClientRoomFacilitys=json_decode($ClientRoomFacilitys,true);

        return view('admin.client1.client1_save',['ClientRoom'=>$ClientRoom,'ClientRooms'=>$ClientRooms,'ClientRoomFacilitys'=>$ClientRoomFacilitys, 'room_name'=>$room_name]);
    }

    public function live_check(Request $request, $id=""){
        $id="2";
        echo 123;
    }

    public function postSave() {

        return view('admin.client.client_save',$this->data);
    }


    public function getInfoBasic($id=0) {


        return view('admin.client.client_info_basic');
    }
}
