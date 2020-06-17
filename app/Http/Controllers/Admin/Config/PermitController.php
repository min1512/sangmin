<?php

namespace App\Http\Controllers\Admin\Config;

use App\Http\Controllers\Controller;
use App\Models\ClientSeasonTerm;
use App\Models\ConfigPermit;
use App\Models\ConfigPermitView;
use App\Models\User;
use App\Models\UserAgency;
use App\Models\UserClient;
use App\Models\UserStaff;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;

class PermitController extends Controller
{
    protected $data = [];
    protected $phone = true;

    public function __construct() {
        $agent = new Agent();
        $this->phone = $agent->isPhone()?"mobile":"pc";

        $this->data['code'] = 200;
        $this->data['message'] = 'Success';
    }

    public function getPermit() {
        $this->data['list_permit'] = ConfigPermit::where('flag_use','Y')->get();
        $this->data['menu_list'] = Controller::getCategory();
        $userStaff = UserStaff::leftJoin("users","users.id","=","user_staff.user_id")->where('users.flag_use','Y')->selectraw("users.*, user_staff.permit_id, user_staff.staff_name as user_name, 'staff' as type");
        $userAgency = UserAgency::leftJoin("users","users.id","=","user_agency.user_id")->where('users.flag_use','Y')->selectraw("users.*, user_agency.permit_id, user_agency.agency_name as user_name, 'agency' as type");
        $this->data['user_list'] = UserClient::leftJoin("users","users.id","=","user_client.user_id")->where('users.flag_use','Y')->selectraw("users.*, user_client.permit_id, user_client.client_name as user_name, 'client' as type")
            ->unionAll($userAgency)
            ->unionAll($userStaff)
            ->get();


        return view('admin.'.$this->phone.'.config.permit_list', $this->data);
    }

    public function postPermit(Request $request) {
        $saveListId = [];
        $id = $request->input("permit_id");
        $permit = ConfigPermit::find($id);
        if(!isset($permit)) {
            $permit = new ConfigPermit();
        }
        $permit->code_user_type = $request->permit_type;
        $permit->permit_name = $request->permit_name;
        $permit->save();

        foreach($request->input("permit") as $k => $p){
            $list = $request->input("permit.".$k.".list","N");
            $view = $request->input("permit.".$k.".view","N");
            $save = $request->input("permit.".$k.".save","N");
            $del = $request->input("permit.".$k.".del","N");

            $permit2 = ConfigPermitView::where('permit_id',$permit->id)->where('code_admin',$k)->first();
            if(!isset($permit2)) $permit2 = new ConfigPermitView();
            $permit2->permit_id     = $permit->id;
            $permit2->code_admin    = $k;
            $permit2->list          = $list;
            $permit2->view          = $view;
            $permit2->write         = $save;
            $permit2->delete        = $del;
            $permit2->save();

            $saveListId[] = $permit2->id;
        }

        ConfigPermitView::where('permit_id',$permit->id)->whereNotIn('id',$saveListId)->delete();

        return redirect()->route('config.permit');
    }

    public function postInfo(Request $request) {
        $data['id'] = $request->input("id");
        $data['info'] = ConfigPermit::find($data['id']);
        $data['permit'] = ConfigPermitView::where('permit_id',$data['id'])->get();

        return response()->json($data);
    }

    public function postUser(Request $request) {
        foreach($request->input("user_permit") as $type => $permit){
            foreach($request->input("user_permit.".$type) as $user_id => $permit_id) {
                if($type=="staff" && $permit_id!="") {
                    $userStaff = UserStaff::where('user_id',$user_id)->first();
                    if(!isset($userStaff)){
                        $userStaff = new UserStaff();
                        $userStaff->user_id = $user_id;
                    }

                    $userStaff->permit_id = $permit_id;
                    $userStaff->save();
                }
                elseif($type=="agency" && $permit_id!="") {
                    $userAgency = UserAgency::where('user_id',$user_id)->first();
                    if(!isset($userAgency)){
                        $userAgency = new UserAgency();
                        $userAgency->user_id = $user_id;
                    }

                    $userAgency->permit_id = $permit_id;
                    $userAgency->save();
                }
                elseif($type=="client" && $permit_id!="") {
                    $userClient = UserClient::where('user_id',$user_id)->first();
                    if(!isset($userClient)){
                        $userClient = new UserClient();
                        $userClient->user_id = $user_id;
                    }

                    $userClient->permit_id = $permit_id;
                    $userClient->save();
                }
            }
        }

        return redirect()->route('config.permit');
    }

    public function getSave() {
        return view('admin.config.permit_save');
    }

    public function getView() {
        return view('admin.config.permit_view');
    }


}
