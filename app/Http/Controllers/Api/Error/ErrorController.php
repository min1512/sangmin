<?php

namespace App\Http\Controllers\Api\Error;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;

class ErrorController extends ApiController
{
    public function getError(Request $request) {
        dd($this->code->error);
        dd($request->all());
    }

    public function getTest(Request $request) {
        return view("api.test");
    }
}
