<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ClientType extends Model
{
    protected $table = "client_type";

    public function clientTypeSave($file, $user_id, $data=[]) {
        if ( isset($data['type_id']) && $data['type_id']!="" ) {
            $clientType = ClientType::find($data['type_id']);
        }
        else {
            $clientType = new ClientType();
            $clientType->type_name = $data['type_name'];
            $clientType->user_id = $data['user_id'];
        }
        $clientType->type_name = $data['type_name'];
        $clientType->room_area = $data['room_area'];
        $clientType->room_shape = $data['room_shape'];
        $clientType->livingroom = $data['inner_livingroom'];
        $clientType->bedroom = $data['inner_bedroom'];
        $clientType->Ondolroom = $data['inner_ondolroom'];
        $clientType->bathroom = $data['inner_bathroom'];
        $clientType->kitchen = $data['inner_kitchen'];
        $clientType->etc = $data['etc'];
        $clientType->room_cnt_max = $data['room_cnt_max'];
        $clientType->room_cnt_min = $data['room_cnt_min'];
        $clientType->room_cnt_basic = $data['room_cnt_basic'];

        $clientType->save();

        $tmpDeleteId = [];
        if(isset($data['room_num'])) {
            if (sizeof($data['room_num']) > 0) {
                foreach ($data['room_num'] as $rk => $r) {
                    $clientTypeRoom = ClientTypeRoom::where('id',$r)->first();
                    if ($clientTypeRoom == "") {
                        $clientTypeRoom = new ClientTypeRoom();
                    }else{
                        $clientTypeRoom = ClientTypeRoom::where('id',$r)->first();
                    }
                    $clientTypeRoom->type_id = $clientType->id;
                    $clientTypeRoom->user_id = $clientType->user_id;
                    $clientTypeRoom->room_name = $data['room_name'][$rk];
                    $clientTypeRoom->flag_realtime = $data['now'][$rk];
                    $clientTypeRoom->flag_online = $data['online'][$rk];
                    $clientTypeRoom->save();

                    if(isset($data['chkAll'])){
                        $clientType->num = count($data['room_num']) - count($data['chkAll']);
                    }else{
                        $clientType->num = count($data['room_num']);
                    }
                    $clientType->save();
                    if(isset($data['chkAll'])){
                        foreach ($data['chkAll'] as $ck => $cv){
                            if($ck == $rk){
                                ClientTypeRoom::where('id',$clientTypeRoom->id)->where('user_id',$user_id)->delete();
                                ClientTypeRoom::where('id',$r)->where('user_id',$user_id)->delete();

                            }
                        }
                    }

                    $tmpDeleteId[] = $clientTypeRoom->id;
                }
            }
        }
        ClientTypeRoom::whereNotIn('id',$tmpDeleteId)->where('type_id',$clientType->id)->delete();

        $tmpDeleteFacilityId = [];

        $code_facility = $data['facility'];
        for ($i=0; $i<sizeof($code_facility); $i++){
            $code = $code_facility[$i];
            $facility = DB::table('client_type_facility')->where('user_id',$user_id)->where('type_id',$clientType->id)->where('code_facility',$code)->first();
            if(!isset($facility)) {
                $facility = new ClientTypeFacility();
                $facility->user_id = $user_id;
                $facility->type_id = $clientType->id;
                $facility->code_facility = $code;
                $facility->save();
            }
            $tmpDeleteFacilityId[] = $facility->id;
        }
        ClientTypeFacility::whereNotIn('id',$tmpDeleteFacilityId)->where('type_id',$facility->type_id)->delete();

        if($data['file_name']!=""){
            $tmp_file1 = [];
            foreach ($data['file_name'] as $k=>$v){
                if($v!=""){
                    $isset = FileData::where('target_id',$clientType->id)->where('target',"client_type")->where('file_name',$v)->first();
                    $find = FileData::where('target_id',$clientType->id)->where('target',"client_type")->where('file_name',$v)->value('id');
                    if($isset==""){
                        $FileData = new FileData();
                        $FileData->target = "client_type";
                        $FileData->target_id = $clientType->id;
                        $FileData->type="image";
                    }else{
                        $FileData = FileData::find($find);
                    }
                    $FileData->file_name = $v;
                    $FileData->save();
                    $tmp_file1[] = $FileData->id;
                }
            }
            FileData::WhereNotIn('id',$tmp_file1)->where('target_id',$clientType->id)->where('target',"client_type")->delete();
        }
        if($file!=""){
            foreach ($file as $k=>$v){
                $isset = FileData::where('target_id',$clientType->id)->where('target',"client_type")->where('file_name',$v->getClientOriginalName())->first();
                $find = FileData::where('target_id',$clientType->id)->where('target',"client_type")->where('file_name',$v->getClientOriginalName())->value('id');

                if($isset==""){
                    $FileData = new FileData();
                    $FileData->target = "client_type";
                    $FileData->target_id = $clientType->id;
                    $FileData->type="image";
                }else{
                    $FileData = FileData::find($find);
                }

                $filename = $v->getFilename().".".$v->getClientOriginalExtension();
                $FileData->path = 'client_type/'.$clientType->id.'/'.$filename;

                if (!file_exists($_SERVER["DOCUMENT_ROOT"].'/data/client_type/'.$clientType->id)) {
                    mkdir($_SERVER["DOCUMENT_ROOT"].'/data/client_type/'.$clientType->id, 0777, true);
                }
//                    $this->rrmdir($_SERVER["DOCUMENT_ROOT"].'/data/client/'.$id);
                $v->storeAs('client_type/'.$clientType->id, $filename, 'public');

                $FileData->save();
            }
        }


        return true;

    }
}
