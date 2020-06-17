<?php


namespace App\Http\Middleware;

use App\Models\UserClient;
use Closure;

class ApiInformation
{
    public function handle($request, Closure $next)
    {

        return $next($request);
    }
}
