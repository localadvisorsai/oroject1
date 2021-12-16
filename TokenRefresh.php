<?php

namespace App\Http\Middleware;

use App\Library\Adapters\SignatureService;
use Closure;
use DateTime;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Log;

class TokenRefresh
{

    public function handle($request, Closure $next, $module)
    {

        $location = $next($request);
        //Log::debug("SR called" );
        //Log::debug("SR location:" . json_encode($location) );
		switch($module) {
			case "dm":
				$service = new SignatureService();
				$token = $service->client->getRefreshToken();
                Log::debug("(SR) token: " . $token );
				if(isset($token)) {
                    $access = $service->client->getAccessToken();
                    Log::debug("(SR) Access: " . $access );
					if (!isset($access)) {
                        //Log::debug("(SR) Access token needs update." );
						$location = redirect("subscriptions/" . $module . "/authorize");
					}
				} else {
					$location = redirect("subscriptions/" . $module);
				}

			//Additional cases to go here later if needed.
		}
        //Log::debug("SR location end: " . json_encode($location) );
		return $location;
    }
}
