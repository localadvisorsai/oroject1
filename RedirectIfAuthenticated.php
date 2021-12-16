<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            if(!isset(Auth::user()->email_verified_at)) {
                return redirect('/email/verify');
            } else {
                if(!isset(Auth::user()->enterprise_id)) {
                    return redirect('/account/setup');
                } else {
                    return redirect('/home');
                }
            }

        }
        return $next($request);
    }
}
