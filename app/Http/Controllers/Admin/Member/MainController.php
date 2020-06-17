<?php

namespace App\Http\Controllers\Admin\Member;

use App\Http\Controllers\Controller;
use App\User;
use http\Env\Url;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Jenssegers\Agent\Agent;

class MainController extends Controller
{
    protected $data = [];
    protected $phone = true;

    public function __construct() {
        $agent = new Agent();
        $this->phone = $agent->isPhone()?"mobile":"pc";

        $this->data['code'] = 200;
        $this->data['message'] = 'Success';
    }


    public function getLogin(Request $request) {

        $host = $request->getHttpHost();

        if($host=="staff.einet.co.kr"){
            $this->data['name'] = "관리자";
            $this->data['mean'] = "설명 추가";
        }else if($host=='client.einet.co.kr'){
            $this->data['name'] = "숙박업체";
            $this->data['mean'] = "설명 추가";
        }else if($host=='agency.einet.co.kr'){
            $this->data['name'] = "대행사";
            $this->data['mean'] = "설명 추가";
        }

        return view('admin.'.$this->phone.'.member.login', $this->data);
    }

    public function postLogin(Request $request) {
        $request->session()->regenerate();
        $request->session()->flush();

        $infoLogin = $request->only('email','password');

        if (Auth::attempt($infoLogin)) {
            return redirect()->route('main');
        }
        else {
            return redirect()->route('login');
        }
    }

    public function getLogout() {
        Auth::logout();

        return redirect()->route('login');
    }

    public function getJoin() {
        return view('admin.member.join');
    }
}
