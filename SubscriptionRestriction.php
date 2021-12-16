<?php

namespace App\Http\Middleware;

use Closure;
use DateTime;
use Illuminate\Support\Facades\Auth;

class SubscriptionRestriction
{
        /**
         * Handle an incoming request.
         *
         * @param  \Illuminate\Http\Request  $request
         * @param  \Closure  $next
         * @return mixed
         */
        public function handle($request, Closure $next, $module)
    {
        return $next($request);

        if ($request->user() and ! $request->user()->subscribed($module))
            return redirect('/'.$module.'/subscribe');

        return $next($request);
    }
}
