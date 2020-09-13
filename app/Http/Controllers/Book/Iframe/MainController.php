<?php

namespace App\Http\Controllers\Book\Iframe;

use App\Http\Controllers\ApiController;
use App\Models\DataPrice;
use Illuminate\Http\Request;

class MainController extends ApiController
{
    public function __construct(Request $request) {
        parent::__construct($request);
    }

    public function getCalendar() {
        $this->data['data'] = DataPrice::whereBetween('date',array(date("Y-m-d"),date("Y-m-t")))->get();

        return view("book.iframe.calendar",$this->data);
    }
}
