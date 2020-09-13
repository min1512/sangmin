<?php

namespace App\Http\Controllers\Book\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function __construct() {
    }

    public function getIndex() {
        return view('book.api.search');
    }
}
