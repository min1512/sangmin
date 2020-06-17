<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function getList() {
        return view('admin.user.customer_list');
    }

    public function getSave() {
        return view('admin.user.customer_save');
    }

    public function getView() {
        return view('admin.user.customer_view');
    }
}
