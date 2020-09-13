<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Models\Code;
use App\Models\FileData;
use App\Models\UserAgency;
use App\Models\UserClient;
use App\Models\UserClientAmanity;
use App\Models\UserClientCompany;
use App\Models\UserClientCompanyLog;
use App\Models\UserClientFacility;
use App\Models\UserClientService;
use App\Models\UserClientTorisit;
use App\Models\Users;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
            ->paginate(5);
        return view('admin.'.$this->phone.'.user.client_list', $this->data);
    }

    public function getSave($id=0) {
        $data['id'] = $id;
        $data['user'] = User::find($id);
        $data['userInfo'] = UserClient::where('user_id',$id)->first();
        $data['file'] = FileData::where('target_id',$id)->where('target',"client")->get();

        $data['db_client_facility'] = UserClientFacility::where('user_id',$id)->selectRaw('group_concat(code_facility separator ",") as facility')->first();
        $data['db_client_amanity'] = UserClientAmanity::where('user_id',$id)->selectRaw('group_concat(code_amanity separator ",") as amanity')->first();
        $data['db_client_service'] = UserClientService::where('user_id',$id)->selectRaw('group_concat(code_service separator ",") as service')->first();

        $data['client_facility'] = self::getCode('type_facility');
        $data['client_amanity'] = self::getCode('type_amanity');
        $data['client_service'] = self::getCode('type_service');

        $data['agency'] = UserAgency::get();

        return view('admin.'.$this->phone.'.user.client_save', $data);
    }

    public function postSave(Request $request, $id=0) {
        $check = $request->query("check","");

        $user = User::find($id);
        if(!isset($user)) {
            $user = new User();
            $user->save();
        }

        if (isset($user)) $user_client = UserClient::where('user_id',$user->id)->first();
        if (!isset($user_client)) {
            $user_client = new UserClient();
            $user_client->user_id = $user->id;
            $api_token = "";
            $key = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
            for($i=0;$i<64;$i++) {
                $api_token .= $key[rand(0,63)]; //mt_rand([0-9a-zA-Z])
            }
            $user_client->api_token = $api_token;

        }

        $password = $request->input("password","");
        $password2 = $request->input("password2","");
        if($password!="" && $password!="" && $password==$password2){
            $user->password = bcrypt($password);
        }

        $user_client->double_young = $request->input('double_young',"N");
        $user_client->young = $request->input('young','N');
        $user_client->child = $request->input("child","N");
        $user_client->adult = $request->input("adult","N");

        $user_client->dobule_young_text = $request->input('dobule_young_text',null);
        $user_client->young_text = $request->input('young_text',null);
        $user_client->child_text = $request->input('child_text',null);

        //부대시설 저장
        $facility = $request->input('facility');
        if(isset($facility) && sizeof($facility)>0){
            $tmp_facility=[];
            foreach($facility as $v){
                $user_client_facility = UserClientFacility::where('user_id',$id)->where('code_facility',$v)->first();
                if(!isset($user_client_facility)){
                    $user_client_facility = new UserClientFacility();
                    $user_client_facility->user_id = $id;
                }
                $user_client_facility->code_facility = $v;
                $user_client_facility->save();

                $tmp_facility[] = $user_client_facility->id;
            }
            if(sizeof($tmp_facility)>0) UserClientFacility::WhereNotIn('id',$tmp_facility)->where('user_id',$id)->delete();
        }

        //구비시설 저장
        $amanity = $request->input('amanity');
        if(isset($amanity) && sizeof($amanity)>0){
            $tmp_amanity=[];
            foreach($amanity as $v){
                $user_client_amanity = UserClientAmanity::where('user_id',$id)->where('code_amanity',$v)->first();
                if(!isset($user_client_amanity)){
                    $user_client_amanity = new UserClientAmanity();
                    $user_client_amanity->user_id = $id;
                }
                $user_client_amanity->code_amanity = $v;
                $user_client_amanity->save();

                $tmp_amanity[] = $user_client_amanity->id;
            }
            if(sizeof($tmp_amanity)>0) UserClientAmanity::WhereNotIn('id',$tmp_amanity)->where('user_id',$id)->delete();
        }

        //서비스 저장
        $service = $request->input('service');
        if(isset($service) && sizeof($service)>0){
            $tmp_service=[];
            foreach($service as $v){
                $user_client_service = UserClientService::where('user_id',$id)->where('code_service',$v)->first();
                if(!isset($user_client_service)){
                    $user_client_service = new UserClientService();
                    $user_client_service->user_id = $id;
                }
                $user_client_service->code_service = $v;
                $user_client_service->save();
                $tmp_service[] = $user_client_service->id;
            }
            if(sizeof($tmp_service)>0) UserClientService::WhereNotIn('id',$tmp_service)->where('user_id',$id)->delete();
        }

        //사진 저장 (썸네일 등 사이즈 조정 추가 할 것)
        $tmp = [];
        foreach ($request->input("file_idx") as $k => $v) {
            if($request->hasFile("file_name.".$k)){
                if($v!=null && $v!="") {
                    $isset = FileData::find($v);
                }
                else {
                    $isset = new FileData();
                    $isset->target_id = $id;
                    $isset->target = "client";
                }
                $isset->file_name = $request->file("file_name.".$k)->getClientOriginalName();
                $file_name = $request->file("file_name.".$k)->getFilename().".".$request->file("file_name.".$k)->getClientOriginalExtension();
                $isset->path = $request->file("file_name.".$k)->storeAs("client/".$id, $file_name, "public");
                $isset->save();
                $tmp[] = $isset->id;
            }
            else {
                $tmp[] = $v;
            }
        }
        FileData::WhereNotIn('id',$tmp)->where('target_id',$id)->where('target',"client")->delete();

        if($request->input("email_ad","")!="" && $request->input("email_id","")!="") {
            $user->email = $request->input("email_id") . "@" . $request->input("email_ad");
        }
        $user->flag_use                         = 'Y';
        $user_client->agency_id                 = $request->input("agency");

        $client_fee[]              = $request->input("card",null);
        $client_fee[]              = $request->input("reserve",null);
        $client_fee[]              = $request->input("account",null);
        $user_client->client_fee                       = join(",",$client_fee);
        $user_client->keyword                          = $request->input("keyword");
        $user_client->client_gubun                     = $request->input("client_gubun");
        $user_client->code_type                        = $request->input("codeType");
        $user_client->code_design                      = $request->input("codeDesign",null);
        $user_client->client_name                      = $request->input("clientName");
        $user_client->client_name_en                   = $request->input("clientNameEn");
        $user_client->client_post                      = $request->input("clientPost");
        $user_client->client_addr_basic                = $request->input("clientAddrBasic");
        $user_client->client_addr_detail               = $request->input("clientAddrDetail");
        $user_client->client_owner                     = $request->input("clientOwner");
        $user_client->client_site_url                  = $request->input("clientSiteUrl");
        $user_client->client_tel                       = join("-",$request->input("clientTel"));
        $user_client->client_hp                        = join("-",$request->input("clientHp"));
        //isset($clientHp_receive)?$user_client->clientHp_receive                 = join("-",$clientHp_receive):"";

        $client_check_in_start = $request->input("client_check_in_start.0")=="오후"?$request->input("client_check_in_start.1")+12:$request->input("client_check_in_start.1");
        $client_check_in_start .= ":".$request->input("client_check_in_start.2");
        $client_check_in_end = $request->input("client_check_in_end.0")=="오후"?$request->input("client_check_in_end.1")+12:$request->input("client_check_in_end.1");
        $client_check_in_end .= ":".$request->input("client_check_in_end.2");
        $client_check_out_start = $request->input("client_check_out_start.0")=="오후"?$request->input("client_check_out_start.1")+12:$request->input("client_check_out_start.1");
        $client_check_out_start .= ":".$request->input("client_check_out_start.2");
        $client_check_out_end = $request->input("client_check_out_end.0")=="오후"?$request->input("client_check_out_end.1")+12:$request->input("client_check_out_end.1");
        $client_check_out_end .= ":".$request->input("client_check_out_end.2");

        $user_client->client_check_in_start            = $client_check_in_start;
        $user_client->client_check_in_end              = $client_check_in_end;
        $user_client->client_check_out_start           = $client_check_out_start;
        $user_client->client_check_out_end             = $client_check_out_end;

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

    public function getSettle($id="") {
        $this->data['company'] = UserClientCompany::where('user_id',$id)->where('flag_use','Y')->get();
        $this->data['history'] = UserClientCompanyLog::where('user_id',$id)->get();

        return view('admin.'.$this->phone.'.user.client_settle', $this->data);
    }

    public function postSettle(Request $request, $id="") {
        foreach($request->input("id") as $k => $v) {
            $history = new UserClientCompanyLog();
            $history->user_id = $id;
            $history->origin_id = $request->input("id.".$k);
            $history->company_name = $request->input("company_name.".$k);
            $history->company_type2 = $request->input("company_type.".$k);
            $history->company_number = $request->input("company_number1.".$k.".0")."-".$request->input("company_number2.".$k.".1")."-".$request->input("company_number3.".$k.".2");
            $history->company_post = $request->input("company_post.".$k);
            $history->company_addr_basic = $request->input("company_addr_basic.".$k);
            $history->company_addr_detail = $request->input("company_addr_detail.".$k);
            $history->company_tel = $request->input("company_tel.".$k);
            $history->company_hp = $request->input("company_hp.".$k);
            $history->company_item1 = $request->input("company_item1.".$k);
            $history->company_item2 = $request->input("company_item2.".$k);
            $history->company_owner = $request->input("company_owner.".$k);
            $history->company_email = $request->input("company_email_id.".$k)."@".$request->input("company_email_ad.".$k);

            $history->code_bank = $request->input("code_bank.".$k);
            $history->settle_account = $request->input("settle_account.".$k);
            $history->settle_name = $request->input("settle_name.".$k);
            $history->settle_type = $request->input("settle_type.".$k);
            $history->settle_date = $request->input("settle_date.".$k);
            $history->save();
        }

        return response()->redirectToRoute('user.client.settle',['id'=>$id]);
    }

    public function postSettleConfirm(Request $request) {
        $data = UserClientCompanyLog::find($request->input("id"));
        if($data->origin_id!=null && $data->origin_id>0) $origin = UserClientCompany::find($data->origin_id);
        else {
            $origin = new UserClientCompany();
            $origin->user_id = $data->user_id;
        }

        $origin->company_name           = $data->company_name;
        $origin->company_type           = $data->company_type;
        $origin->company_type2          = $data->company_type2;
        $origin->company_number         = $data->company_number;
        $origin->company_number2        = $data->company_number2;
        $origin->company_post           = $data->company_post;
        $origin->company_addr_basic     = $data->company_addr_basic;
        $origin->company_addr_detail    = $data->company_addr_detail;
        $origin->company_item1          = $data->company_item1;
        $origin->company_item2          = $data->company_item2;
        $origin->company_owner          = $data->company_owner;
        $origin->company_tel            = $data->company_tel;
        $origin->company_hp             = $data->company_hp;
        $origin->company_email          = $data->company_email;
        $origin->code_bank              = $data->code_bank;
        $origin->settle_account         = $data->settle_account;
        $origin->settle_name            = $data->settle_name;
        $origin->settle_type            = $data->settle_type;
        $origin->settle_date            = $data->settle_date;

        $data->changed_user_id          = Auth::user()->id;
        $data->flag                     = "Y";

        if(!$origin->save()) $this->data['code'] = 101;
        if(!$data->save()) $this->data['code'] = 102;

        return response()->json($this->data);
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
