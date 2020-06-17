<?php

namespace App\Http\Controllers\Admin\Config;

use App\Http\Controllers\Controller;
use App\Models\Code;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;

class CodeController extends Controller
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
        $this->data['codeList'] = [];
        $tmpCode = Code::where('depth',0)->orderby('order_by','asc')->get();
        foreach($tmpCode as $c) {
            $this->data['codeList'][$c->id]['info'] = $c;
            $tmpCode2 = Code::where('depth',1)->where('up_id',$c->id)->orderby('order_by','asc')->get();
            foreach($tmpCode2 as $c2) {
                $this->data['codeList'][$c->id]['sub'][$c2->id]['info'] = $c2;
                $tmpCode3 = Code::where('depth',2)->where('up_id',$c2->id)->orderby('order_by','asc')->get();
                foreach($tmpCode3 as $c3) {
                    $this->data['codeList'][$c->id]['sub'][$c2->id]['sub'][$c3->id]['info'] = $c3;
                    $tmpCode4 = Code::where('depth',3)->where('up_id',$c3->id)->orderby('order_by','asc')->get();
                    foreach($tmpCode4 as $c4) {
                        $this->data['codeList'][$c->id]['sub'][$c2->id]['sub'][$c3->id]['sub'][$c4->id]['info'] = $c4;
                    }
                }
            }
        }

        return view('admin.'.$this->phone.'.config.code_list', $this->data);
    }

    public function postCall(Request $request) {
        $id = $request->input("id");

        $this->data['info'] = Code::find($id);

        return response()->json($this->data);
    }

    public function postSave(Request $request) {
        $id = $request->input("id",'');
        $up_id = $request->input("up_id",'');
        $up = Code::find($up_id);

        if($id!='') $code = Code::find($id);
        if(!isset($code)) $code = new Code();

        $code->up_id        = $up_id;
        $code->depth        = $up->depth+1;
        $code->code         = $request->input("code");
        $code->code_name    = $request->input("code_name");
        $code->simple       = $request->input("simple");
        $code->flag_use     = $request->input("flag_use");
        $code->flag_view    = $request->input("flag_view");
        $code->save();

        return redirect()->route('config.code');
    }

    public function getView() {
        return view('admin.config.code_view');
    }
}
