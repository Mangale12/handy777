<?php

namespace App\Http\Middleware;

use Closure;
use Torann\GeoIP\Facades\GeoIP;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
class RestrictCountryMiddleware
{
    public function handle(Request $request, Closure $next, $allowedCountry = 'US')
    {
        try{
        
        $userIpAddress = request()->ip();
        $userLocation = GeoIP::getLocation($userIpAddress);
    
        // Access the time zone from the user's location
        $userTimeZone = $userLocation->timezone;
        // dd($userTimeZone);
        $userCountry = GeoIP::getLocation()->iso_code;
        // dd($userCountry);

        if ($userCountry == 'US') {
            $contains = Str::contains($request->time_zone, 'America');
            if($contains){
                return $next($request);
            }else{
                // return redirect()->back()->with("time_zone","you can't use vpn");
                return response()->view("frontend.vpnlock");
            }
        }else{
            // return redirect()->back()->with("ip_restrict","Your Country Can't use");
            return response()->view("frontend.403");
        }
    }catch(Exception $e){
        return redirect()->route('homePage');
    }
        
    }
    public function getUserTimeZone()
    {
        $userIpAddress = request()->ip();
        $userLocation = GeoIP::getLocation($userIpAddress);
    
        // Access the time zone from the user's location
        $userTimeZone = $userLocation->timezone;
    
        return $userTimeZone;
    }
}
