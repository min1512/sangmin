<?php

namespace App\Http\Controllers\Admin\Order;

use App\Http\Controllers\Controller;
use App\Models\OrderBasic;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;

class MainController extends Controller
{
    protected $data = [];
    protected $phone = true;

    public function __construct(Request $request) {
        $agent = new Agent();
        $this->phone = $agent->isPhone()?"mobile":"pc";

        $this->data['code'] = 200;
        $this->data['message'] = 'Success';
    }

    public function getList() {
        $this->data['order'] = OrderBasic::leftJoin('order_info','order_info.order_id','=','order_basic.id')
            ->selectraw('order_basic.*, (select client_name from user_client where user_id = order_info.client_id) as client_name')
            ->paginate(20);

        return view('admin.'.$this->phone.'.order.order_list', $this->data);
    }

    public function getSave() {
        return view('admin.order.order_save');
    }

    public function getView() {
        return view('admin.order.order_view');
    }
}
