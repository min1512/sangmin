<?php

namespace App\Http\Controllers\Admin\Client;

use App\Http\Controllers\Controller;
use App\Models\BoardNotice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Jenssegers\Agent\Agent;
use Symfony\Component\Console\Input\Input;

class ConfigController extends Controller
{
    protected $data = [];
    protected $phone = true;

    public function __construct() {
        $agent = new Agent();
        $this->phone = $agent->isPhone()?"mobile":"pc";

        $this->data['code'] = 200;
        $this->data['message'] = 'Success';
    }

    public function getIndex($user_id) {
        $this->data['id'] = $user_id;

        return view("admin.".$this->phone.".client.client_config",$this->data);
    }

    public function getNotice(Request $request, $user_id) {
        $this->data['id'] = $user_id;

        $this->data['notice'] = BoardNotice::orderby('id','desc')->paginate(20);

        return view("admin.".$this->phone.".client.client_config_notice",$this->data);
    }

    public function getNoticeSave($user_id, $id="") {
        $this->data['id'] = $user_id;

        if($id!="") $this->data['notice'] = BoardNotice::find($id);

        return view("admin.".$this->phone.".client.client_config_notice_save",$this->data);
    }

    public function postNoticeSave(Request $request, $user_id, $id="") {
        if($user_id != $request->input('user_id')) return Redirect::back()->withInput(Input::all());
        if($id != "" && $id != $request->input('id')) return Redirect::back()->withInput(Input::all());
        if($id == "" && $request->input('id') != "") return Redirect::back()->withInput(Input::all());

        if($id!="") $notice = BoardNotice::find($id);
        if(!isset($notice)) $notice = new BoardNotice();

        $tt = $request->input("target_type");

        $notice->user_id        = $user_id;
        $notice->target_type    = isset($tt)&&count($tt)>0?join(",",$tt):"";
        $notice->title          = $request->input("title","");
        $notice->content        = $request->input("content","");
        $notice->date_open      = $request->input("date_open",null);
        $notice->date_close     = $request->input("date_close",null);
        $notice->flag_notice    = $request->input("flag_notice","Y");
        $notice->flag_popup     = $request->input("flag_popup","N");
        $notice->flag_use       = $request->input("flag_use","Y");
        $notice->save();

        return redirect()->route("client.config_notice",['user_id'=>$user_id, 'id'=>isset($id)?$id:'']);
    }

    public function getSns($user_id) {
        $this->data['id'] = $user_id;

        return view("admin.".$this->phone.".client.client_config_sns",$this->data);
    }

    public function getCancel($user_id) {
        $this->data['id'] = $user_id;

        return view("admin.".$this->phone.".client.client_config_cancel",$this->data);
    }

    public function getRefund($user_id) {
        $this->data['id'] = $user_id;

        return view("admin.".$this->phone.".client.client_config_refund",$this->data);
    }

    public function getBooking($user_id) {
        $this->data['id'] = $user_id;

        return view("admin.".$this->phone.".client.client_config_booking",$this->data);
    }

}
