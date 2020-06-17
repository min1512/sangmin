<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Models\UserAgency;
use App\Models\Users;
use App\User;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;

class AgencyController extends Controller
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
        $this->data['agency'] = UserAgency::leftjoin('users','users.id','=','user_agency.user_id')->paginate(20);

        return view('admin.'.$this->phone.'.user.agency_list', $this->data);
    }

    public function getSave($id=0) {
        if($id>0) $this->data['agency'] = UserAgency::leftjoin('users','users.id','=','user_agency.user_id')->where('user_agency.user_id',$id)->first();

        return view('admin.'.$this->phone.'.user.agency_save', $this->data);
    }

    public function postSave(Request $request, $id='') {
        $id = $request->input("id",0);
        $user = Users::find($id);
        if(isset($user)) $agency = UserAgency::where('user_id',$id)->first();
        else {
            $user = new Users();
            $user->save();
        }
        if(!isset($agency)) {
            $agency = new UserAgency();
            $agency->user_id = $user->id;
        }

        $user->email        = $request->input("email");
        $user->flag_use     = "Y";
        $user->save();

        $agency->agency_name        = $request->input("agency_name","");
        $agency->agency_type        = $request->input("agency_type","I");
        $agency->agency_number      = $request->input("agency_number","");
        $agency->agency_number2     = $request->input("agency_number2","");
        $agency->agency_post        = $request->input("agency_post","");
        $agency->agency_addr_basic  = $request->input("agency_addr_basic","");
        $agency->agency_addr_detail = $request->input("agency_addr_detail","");
        $agency->agency_item1       = $request->input("agency_item1","");
        $agency->agency_item2       = $request->input("agency_item2","");
        $agency->agency_tax         = $request->input("agency_tax","Y");
        $agency->agency_owner       = $request->input("agency_owner","");
        $agency->agency_tel         = $request->input("agency_tel","");
        $agency->agency_hp          = $request->input("agency_hp","");
        $agency->save();

        return redirect()->route('user.agency.list');
    }
}
