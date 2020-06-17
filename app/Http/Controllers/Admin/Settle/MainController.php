<?php

namespace App\Http\Controllers\Admin\Settle;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function getList() {
        return view('admin.settle.settle_list');
    }
}
