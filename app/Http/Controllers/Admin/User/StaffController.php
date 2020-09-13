<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Users;
use App\Models\UserStaff;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;

class StaffController extends Controller
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
        $this->data['staff'] = UserStaff::leftjoin('users','users.id','=','user_staff.user_id')->paginate(20);

        return view('admin.'.$this->phone.'.user.staff_list', $this->data);
    }

    public function getSave($id=0) {
        if($id>0) $this->data['staff'] = UserStaff::leftjoin('users','users.id','=','user_staff.user_id')->where('user_staff.user_id',$id)->first();

        return view('admin.'.$this->phone.'.user.staff_save', $this->data);
    }

    public function postSave(Request $request, $id='') {
        $id = $request->input("id",0);

        $email_check = $request->input("email_chk","N");
        if($email_check=="N") return redirect()->back();

        $user = Users::find($id);
        if(isset($user)) {
            $staff = UserStaff::where('user_id',$id)->first();
        }
        else {
            $user = new Users();
            $user->save();
            $staff = new UserStaff();
            $staff->user_id = $user->id;
        }

        $password   = $request->input("password","");
        $password2  = $request->input("password2","");

        if($request->input("email_ad","")!="" && $request->input("email_id","")!="") {
            $user->email = $request->input("email_id") . "@" . $request->input("email_ad");
        }
        if($password!="" && $password==$password2) $user->password = bcrypt($password);
        $user->flag_use     = "Y";
        $user->save();

        $staff->staff_name  = $request->input("staff_name","");
        $staff->staff_hp    = join("-",$request->input("staff_hp",""));
        $staff->staff_birth = $request->input("staff_birth",null);
        $staff->staff_lunar = $request->input("staff_lunar",null);
        $staff->save();

        return redirect()->route('user.staff.list');
    }

    public function getView() {
        return view('admin.user.staff_view');
    }

    public function emailcheck(Request $request){
        $email = $request->input('email',null);
        $isset = Users::where('email',$email)->count();
        if($isset>0){
            return response()->json(false);
        }else{
            return response()->json(true);
        }
    }
}
