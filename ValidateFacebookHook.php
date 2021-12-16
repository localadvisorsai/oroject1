<?php

namespace App\Http\Middleware;

use Closure;

class ValidateFacebookHook
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
        return ($request->isMethod('post'))
            ? $this->validatePayload($request, $next) //JSON payload
            : $this->verificationHandshake($request); //Endpoint verification request or unauthorized
    }

    protected function verificationHandshake($request)
    {
        return (isset($request->hub_mode) &&
            $request->hub_mode == "subscribe" &&
            //$request->hub_verify_token === config("credentials.Facebook.verify_token")
            $request->hub_verify_token === '07261980'
        )
            ? response()->json((int)$request->hub_challenge)
            : abort(404);
    }

    protected function validatePayload($request, $next)
    {
        // $app_secret = config("credentials.Facebook.app_secret");
        //validate payload code here


        $valid = true; //set valid to true temporarily until above verification code done.
        return ($valid) ? $next($request) : abort(404);
    }
}
