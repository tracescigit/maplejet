<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Http;
class CaptureIpAndLocation
{
    public function handle(Request $request, Closure $next)
    {
        $ip = $request->ip();

        if (!in_array($ip, ['127.0.0.1', '::1'])) {
            // Use a geolocation service to get location data if not localhost
            $location = $this->getLocationFromIp($ip);

            // Attach IP and location data to the request
            $request->merge([
                'ip_address' => $ip,
                'location' => $location
            ]);
        } else {
            // Attach null values for IP and location if localhost
            $request->merge([
                'ip_address' => null,
                'location' => null
            ]);
        }

        return $next($request);
    }

    private function getLocationFromIp($ip)
    {
        // Example using ipinfo.io API, you can use any geolocation API
        $response = Http::get("http://ipinfo.io/{$ip}/json");

        if ($response->successful()) {
            return $response->json();
        }

        return null;
    }
}
