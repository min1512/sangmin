<?php

namespace App\Http\Controllers\Api\Price;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Models\ClientTypeRoom;
use Illuminate\Http\Request;

class MainController extends ApiController
{
    public function __construct(Request $request)
    {
        parent::__construct($request);
    }

    public function postPriceDay(Request $request) {
        $info = new ClientTypeRoom();
        $price = $info->roomPriceDay($request->input("room"),$request->input("day"));

        return response()->json($price);
    }
}
