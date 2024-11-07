<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\AdminSetting;
use Illuminate\Support\Facades\Auth;
use Helper;
use Illuminate\Support\Facades\View;

class User
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $admin_setting = AdminSetting::where('type', Helper::$admin_setting_type['leaderboard_switch'])->first();
        
        if($admin_setting){
            $leaderboard_switch = $admin_setting->switch;
            View::share('leaderboard_switch', $leaderboard_switch);
        }

        if (Auth::guard('web')->check()) {
            return $next($request);
        }
        else{
            request()->session()->flash('error','You do not have any permission to access this page');
            return redirect()->route('login.form');
        }
    }
}
