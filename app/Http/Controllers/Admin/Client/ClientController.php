<?php

namespace App\Http\Controllers\Admin\Client;

use App\Http\Controllers\Controller;
use App\Models\UserClient;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    protected $data = [];

    public function __construct() {
        $this->data['code'] = 200;
        $this->data['message'] = 'Success';
    }

    public function getList(Request $request) {
        $this->data['clientList'] = UserClient::leftjoin('users','users.id','=','user_client.user_id')
            ->paginate(20);
        //dd($this->data['clientList']);
        return view('admin.client.client_list',$this->data);        
    }

    public function getSave() {
        return view('admin.client.client_save',$this->data);
    }

    public function postSave() {
        
        return view('admin.client.client_save',$this->data);
    }


    public function getInfoBasic($id=0) {


        return view('admin.client.client_info_basic');
    }
}
