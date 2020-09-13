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

    public function postPopup(Request $request){
        $url = getenv("QUERY_STRING");
        $total_price = $request->input('total_price');
        return view("api.popup", ['total_price' => $total_price, 'url' =>$url]);
    }

    public function postPopups(Request $request){
        $total_price = $request->input('total_price');
        return $total_price;
    }

}
