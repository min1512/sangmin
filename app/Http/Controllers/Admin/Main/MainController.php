<?php

namespace App\Http\Controllers\Admin\Main;

use App\Http\Controllers\Controller;

use App\User;
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

    public function getIndex(Request $request) {
        $host = $request->getHttpHost();
        $host = explode(".",$host);

        $user = User::find(Auth::user()->id);

        return view('admin.'.$this->phone.'.main.'.$host[0],[
            'user' => $user
        ]);
    }
}
