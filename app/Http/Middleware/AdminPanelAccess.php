<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminPanelAccess
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
        if ((Auth::user()->admin_create == 1 And Auth::user()->status == 1) or Auth::user()->is_admin == 1)
        {
            return $next($request);
        }

        request()->session()->flush();
        request()->session()->regenerate();
        if (Auth::check()) {
            Auth::logout();
        }
        return redirect()->back();
    }
}
