<?php

namespace App\Http\Controllers\Admin\Settle;

use App\Http\Controllers\Controller;
use App\Models\OrderBasic;
use App\Models\UserAgency;
use App\Models\UserClient;
use App\Models\UserStaff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MainController extends Controller
{
    protected $data = [];

    public function __construct() {
    }

    public function getList() {
        return view('admin.settle.settle_list');
    }

    public function getDaily(Request $request) {
        $user_id = Auth::id();

        $checkStaff = UserStaff::where('user_id',$user_id)->count();
        $checkAgency = UserAgency::where('user_id',$user_id)->count();
        $checkClient = UserClient::where('user_id',$user_id)->count();

        if($checkStaff>0) $this->data['user_type'] = "staff";
        else if($checkAgency>0) $this->data['user_type'] = "agency";
        else if($checkClient>0) $this->data['user_type'] = "client";

        $year = $request->query("y",date("Y"));
        $month = $request->query("m",date("n"));
        $day = $request->query("d",date("j"));
        $date = date("Y-m-d",strtotime($year."-".$month."-".$day));

        if ($this->data['user_type']=="staff") $target = UserClient::selectRaw("group_concat(user_id separator ',') as target")->value('target');
        else if ($this->data['user_type']=="agency") $target = UserClient::where('agency_id',Auth::id())->selectRaw("group_concat(user_id separator ',') as target")->value('target');
        else if ($this->data['user_type']=="client") $target = Auth::id();
        $target = explode(",",$target);

        $this->data['order'] = OrderBasic::leftJoin('order_info','order_info.order_id','=','order_basic.id')
            ->whereBetween('order_basic.reserve_date',[date('Y-m-01',strtotime($date)),date('Y-m-t',strtotime($date))])
            //->whereIn('order_basic.user_id',$target)
            ->paginate(20);

        return view('admin.pc.settle.settle_daily', $this->data);
    }
}
