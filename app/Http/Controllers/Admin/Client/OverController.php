<?php

namespace App\Http\Controllers\Admin\Client;

use App\Http\Controllers\Controller;
use App\Models\ClientTypeRoom;
use App\Models\ClientTypeRoomOver;
use App\Models\ClientTypeRoomOverRoom;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;

class OverController extends Controller
{
    protected $data = [];
    protected $phone = true;

    public function __construct() {
        $agent = new Agent();
        $this->phone = $agent->isPhone()?"mobile":"pc";

        $this->data['code'] = 200;
        $this->data['message'] = 'Success';
    }

    public function getOver($id) {
        $this->data['id'] = $id;
        $this->data['over'] = ClientTypeRoomOver::where('over_type','O')
            ->where('user_id',$id)
            ->paginate(10, ['*'], 'over');
        $this->data['discount'] = ClientTypeRoomOver::where('over_type','D')
            ->where('user_id',$id)
            ->paginate(10, ['*'], 'discount');
        $this->data['room'] = ClientTypeRoom::where('user_id',$id)
            ->where('flag_realtime','Y')
            ->get();

        return view('admin.'.$this->phone.'.client.client_over', $this->data);
    }

    public function postOverCall(Request $request, $id) {
        $infoOver = ClientTypeRoomOver::where(['user_id'=>$id, 'id'=>$request->input("id")])
            ->selectraw("client_type_room_over.*, (select group_concat(room_id separator ',') from client_type_room_over_room where over_id='".$request->input("id")."') as room_id")
            ->first();

        return response()->json($infoOver);
    }

    public function postOver(Request $request, $id) {
        //dd($request->all());
        if($request->input("id")!=null && $request->input("id")!="")
            $over = ClientTypeRoomOver::find($request->input("id"));
        else {
            $over = new ClientTypeRoomOver();
            $over->user_id = $id;
        }
        $over->over_type            = $request->input("over_type");
        $over->over_start           = $request->input("over_start");
        $over->over_end             = $request->input("over_end");
        $over->over_day             = $request->input("over_day");
        $over->target_day           = join(",",$request->input("target_day"));
        $over->over_discount_start  = $request->input("over_discount_start",null);
        $over->over_discount_end    = $request->input("over_discount_end",null);
        $over->over_discount_name   = $request->input("over_discount_name",null);
        $over->over_discount_type   = $request->input("over_discount_type",null);
        $over->over_discount_price  = $request->input("over_discount_price",null);
        $over->over_discount_unit   = $request->input("over_discount_unit",null);
        $over->save();

        $tmp_room = [];
        foreach($request->input("room") as $room){
            $over_room = ClientTypeRoomOverRoom::where('over_id',$over->id)->where('room_id',$room)->first();
            if(!$over_room) {
                $over_room = new ClientTypeRoomOverRoom();
                $over_room->over_id = $over->id;
            }
            $over_room->room_id = $room;
            $over_room->save();

            $tmp_room[] = $over_room->id;
        }
        ClientTypeRoomOverRoom::where('over_id',$over->id)->whereNotIn('id',$tmp_room)->delete();

        return redirect()->route('client.over',['id'=>$id]);
    }
}
