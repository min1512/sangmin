<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        '/config/permit/type',
        '/config/code/call',


        '/calendar/room',
        '/calendar/season',
        '/calendar/reservation',
        '/calendar/price',
        '/order/set',
        '/order/change/day',
        '/price/day',
    ];
}
