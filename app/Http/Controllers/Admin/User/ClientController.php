<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Model\UserClientCompany;
use App\Models\Code;
use App\Models\FileData;
use App\Models\UserClient;
use App\Models\UserClientFacility;
use App\Models\UserClientService;
use App\Models\UserClientTorisit;
use App\Models\Users;
use App\User;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

class ClientController extends Controller
{
    protected $data = [];
    protected $phone = true;

    public function __construct() {
        $agent = new Agent();
        $this->phone = $agent->isPhone()?"mobile":"pc";

        $this->data['code'] = 200;
        $this->data['message'] = 'Success';
    }

    public function getList() {
        $this->data['clientList'] = UserClient::leftjoin('users','users.id','=','user_client.user_id')
            ->paginate(20);
        return view('admin.'.$this->phone.'.user.client_list', $this->data);
    }

    public function getSave($id=0) {
        $data['id'] = $id;
        $data['user'] = User::find($id);
        $data['userInfo'] = UserClient::where('user_id',$id)->first();
        $data['file'] = FileData::where('target_id',$id)->where('target',"client")->get();

        $data['db_client_facility'] = UserClientFacility::where('user_id',$id)->get();
        $data['type_facility'] = Code::where('up_id',1)->get();
        $data['db_client_service'] = UserClientService::where('user_id',$id)->get();
        $data['type_service'] = Code::where('up_id',162)->get();
        $data['db_client_torisit'] = UserClientTorisit::where('user_id',$id)->get();
        $data['type_torisit'] = Code::where('up_id',172)->get();

        $data['user_client_facility'] = Code::where('up_id',1)
            ->selectraw('
                code.*
                    , ifnull((select group_concat(code_facility separator ",") from user_client_facility where code_facility=code.code and user_id='.$id.'),null) as code_facility

            ')
            ->get();

        $data['user_client_service'] = Code::where('up_id',162)
            ->selectraw('
                code.*
                    , ifnull((select group_concat(code_facility separator ",") from user_client_service where code_facility=code.code and user_id='.$id.'),null) as code_facility

            ')
            ->get();
        $data['user_client_torisit'] = Code::where('up_id',172)
            ->selectraw('
                code.*
                    , ifnull((select group_concat(code_facility separator ",") from user_client_torisit where code_facility=code.code and user_id='.$id.'),null) as code_facility

            ')
            ->get();

        return view('admin.'.$this->phone.'.user.client_save', $data);
    }

    public function postSave(Request $request, $id=0) {
        dd($request->all());
        $check = str_replace("/user/client/save/2","",$request->input('check'));

        if($id>0)$user = User::find($id);
        else$user = new User();
        $user->save();

        if(isset($user)) $user_client = UserClient::where('user_id',$user->id)->first();
        if(!isset($user_client)) {
            $user_client = new UserClient();
            $user_client->user_id = $user->id;
            $api_token = "";
            $key = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789^/';
            for($i=0;$i<64;$i++) {
                $api_token .= $key[rand(0,63)]; //mt_rand([0-9a-zA-Z])
            }
            $user_client->api_token = $api_token;

        }

        if($request->input('dobule_young')==""){
            $double_young ="N";
            $user_client->dobule_young = $double_young;
        }else{
            $user_client->dobule_young = $request->input('dobule_young');
        }

        if($request->input('young')==""){
            $young ="N";
            $user_client->young = $young;
        }else{
            $user_client->young = $request->input('young');
        }
        if($request->input('child')==""){
            $child ="N";
            $user_client->child = $child;
        }else{
            $user_client->child = $request->input("child");
        }
        if($request->input('adult')==""){
            $adult ="N";
            $user_client->adult = $adult;
        }else{
            $user_client->adult = $request->input("adult");
        }

        if($request->input('sleep_check_value_dobule_young')!=""){
            $user_client->sleep_check_value_dobule_young = $request->input('sleep_check_value_dobule_young');
        }
        if($request->input('sleep_check_value_young')!=""){
            $user_client->sleep_check_value_young = $request->input('sleep_check_value_young');
        }
        if($request->input('sleep_check_value_child')!=""){
            $user_client->sleep_check_value_child = $request->input('sleep_check_value_child');
        }


        if($request->input("clientTel")!=""){
            $clientTel = [];
            foreach($request->input("clientTel") as $v){
                $clientTel[] = $v;
            }
        }

        if($request->input("clientHp")!=""){
            $clientHp = [];
            foreach($request->input("clientHp") as $v){
                $clientHp[] = $v;
            }
        }

        if($request->input("clientHp_recevie")!=""){
            $clientHp_recevie =[];
            foreach($request->input("clientHp_recevie") as $v){
                $clientHp_recevie[] = $v;
            }
        }

        if($request->input('facilityCommon')!=""){
            $tmp=[];
            foreach($request->input('facilityCommon') as $v){
                $user_client_facility = UserClientFacility::where('user_id',$id)->where('code_facility',$v)->first();
                if(isset($user_client_facility)) $user_client_facility = UserClientFacility::where('user_id',$id)->where('code_facility',$v)->first();
                if(!isset($user_client_facility)){
                    $user_client_facility = new UserClientFacility();
                    $user_client_facility->user_id = $user->id;
                }
                $user_client_facility->user_id=$user->id;
                $user_client_facility->code_facility=$v;
                $tmp[] =$user_client_facility->id;
                $user_client_facility->save();
            }
            UserClientFacility::WhereNotIn('id',$tmp)->where('user_id',$user->id)->delete();
        }

        if($request->input('Service')!=""){
            $tmp_service=[];
            foreach($request->input('Service') as $v){
                $user_client_service = UserClientService::where('user_id',$id)->where('code_facility',$v)->first();
                if(isset($user_client_service)) $user_client_service = UserClientService::where('user_id',$id)->where('code_facility',$v)->first();
                if(!isset($user_client_service)){
                    $user_client_service = new UserClientService();
                    $user_client_service->user_id = $user->id;
                }
                $user_client_service->user_id=$user->id;
                $user_client_service->code_facility=$v;
                $tmp_service[] =$user_client_service->id;
                $user_client_service->save();
            }
            UserClientService::WhereNotIn('id',$tmp_service)->where('user_id',$user->id)->delete();
        }

        if($request->input('Nearby_tourist_spots')!=""){
            $tmp_torisit=[];
            foreach($request->input('Nearby_tourist_spots') as $v){
                $user_client_torisit = UserClientTorisit::where('user_id',$id)->where('code_facility',$v)->first();
                if(isset($user_client_torisit)) $user_client_torisit = UserClientTorisit::where('user_id',$id)->where('code_facility',$v)->first();
                if(!isset($user_client_torisit)){
                    $user_client_torisit = new UserClientTorisit();
                    $user_client_torisit->user_id = $user->id;
                }
                $user_client_torisit->user_id=$user->id;
                $user_client_torisit->code_facility=$v;
                $tmp_torisit[] =$user_client_torisit->id;
                $user_client_torisit->save();
            }
            UserClientTorisit::WhereNotIn('id',$tmp_torisit)->where('user_id',$user->id)->delete();
        }

        if($request->input('file_name')!=""){
            $tmp_file1 = [];
            foreach ($request->input('file_name') as $k=>$v){
                if($v!=""){
                    $isset = FileData::where('target_id',$id)->where('target',"client")->where('file_name',$v)->first();
                    $find = FileData::where('target_id',$id)->where('target',"client")->where('file_name',$v)->value('id');
                    if($isset==""){
                        $FileData = new FileData();
                        $FileData->target = "client";
                        $FileData->target_id = $id;
                        $FileData->type="image";
                    }else{
                        $FileData = FileData::find($find);
                    }
                    $FileData->file_name = $v;
                    $FileData->save();
                    $tmp_file1[] = $FileData->id;
                }
            }
            FileData::WhereNotIn('id',$tmp_file1)->where('target_id',$id)->where('target',"client")->delete();
        }

        if($request->file('file')!=""){
            $tmp_file = [];

            foreach ($request->file('file') as $k=>$v){
                $isset = FileData::where('target_id',$id)->where('target',"client")->where('file_name',$v->getClientOriginalName())->first();
                $find = FileData::where('target_id',$id)->where('target',"client")->where('file_name',$v->getClientOriginalName())->value('id');
                if($isset==""){
                    $FileData = new FileData();
                    $FileData->target = "client";
                    $FileData->target_id = $id;
                    $FileData->type="image";
                }else{
                    $FileData = FileData::find($find);
                }
                $filename = $v->getFilename().".".$v->getClientOriginalExtension();
                $FileData->path = 'client/'.$id.'/'.$filename;
                $FileData->file_name = $v->getClientOriginalName();
                if($request->hasFile('file')){
                    if (!file_exists($_SERVER["DOCUMENT_ROOT"].'/data/client/'.$id)) {
                        mkdir($_SERVER["DOCUMENT_ROOT"].'/data/client/'.$id, 0777, true);
                    }
//                    $this->rrmdir($_SERVER["DOCUMENT_ROOT"].'/data/client/'.$id);
                    $v->storeAs('client/'.$id, $filename, 'public');
                }
                $FileData->save();
                $tmp_file[] = $FileData->id;
            }
        }



        $user->email                            = $request->input("email","");
        //$user->password                         = bcrypt($request->input("password",""));
        $user->flag_use                         = 'Y';
        $user_client->agency_id                 = $request->input("agency");


        $card                      = $request->input("card");
        $reserve                   = $request->input("reserve");
        $account                   = $request->input("account");
        $tmp_client_fee = $card.",".$reserve.",".$account;
        $user_client->client_fee                       = $tmp_client_fee;
        $user_client->keyword                          = $request->input("keyword");
        $user_client->client_gubun                     = $request->input("client_gubun");
        $user_client->code_type                        = $request->input("codeType");
        $user_client->code_design                      = $request->input("codeDesign");
        $user_client->client_name                      = $request->input("clientName");
        $user_client->client_name_en                   = $request->input("clientNameEn");
        $user_client->client_post                      = $request->input("clientPost");
        $user_client->client_addr_basic                = $request->input("clientAddrBasic");
        $user_client->client_addr_detail               = $request->input("clientAddrDetail");
        $user_client->client_owner                     = $request->input("clientOwner");
        $user_client->client_site_url                  = $request->input("clientSiteUrl");
        isset($clientTel)?$user_client->client_tel                       = join("-",$clientTel):"";
        isset($clientHp)?$user_client->client_hp                        = join("-",$clientHp):"";
        isset($clientHp_recevie)?$user_client->clientHp_recevie                 = join("-",$clientHp_recevie):"";
        $user_client->client_check_in_start            = $request->input("clientCheckInStart");
        $user_client->client_check_in_end              = $request->input("clientCheckInEnd");
        $user_client->client_check_out_start           = $request->input("clientCheckOutStart");
        $user_client->client_check_out_end             = $request->input("clientCheckOutEnd");
        $user_client->client_fee_agency                = $request->input("clientFeeAgency");
        $user_client->client_fee_agency_unit           = $request->input("clientFeeAgencyUnit");
        $user_client->client_fee_payment               = $request->input("clientFeePayment");
        $user_client->client_fee_payment_unit          = $request->input("clientFeePaymentUnit");
        $user_client->cnt_day                          = $request->input("cnt_day");

        $user->save();
        $user_client->save();

        if($check==""){
            return response()->redirectToRoute('user.client.list');
        }else{
            return response()->redirectToRoute('client');
        }

    }

    public function getCompany($id=0) {
        $data['id'] = $id;
        $data['user'] = User::find($id);
        $data['userClientCompany'] = UserClientCompany::where('user_id',$id)->get();

        return view('admin.'.$this->phone.'.user.client_company', $data);
    }
    public function rrmdir($dir) {
        if (is_dir($dir)) {
            $objects = scandir($dir);
            foreach ($objects as $object) {
                if ($object != "." && $object != "..") {
                    if (filetype($dir."/".$object) == "dir") rrmdir($dir."/".$object); else unlink($dir."/".$object);
                }
            }
            reset($objects);
            rmdir($dir);
        }
    }
}
