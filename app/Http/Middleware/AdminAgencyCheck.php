<?php


namespace App\Http\Middleware;


use App\Models\UserAgency;
use Closure;
use Illuminate\Support\Facades\Auth;

class AdminAgencyCheck
{
    public function handle($request, Closure $next)
    {
        if(!Auth::check()){
            return redirect('login');
        }

        $user = Auth::user();

        //사용불가 회원은 로그인으로
        if ($user->flag_use!="Y") {
            Auth::logout();
            return redirect('login');
        }

        //사용자 Agency체크
        $userType = UserAgency::where('user_id',$user->id)->first();
        if(!isset($userType)){
            Auth::logout();
            return redirect('login');
        }

        if(!$user){
            Auth::logout();
            $request->session()->flush();
            $request->session()->regenerate();
            return redirect('login');
        }

        return $next($request);
    }

}
