<?php

namespace App\Http\Middleware;

use App\Models\User_app;
use \Firebase\JWT\JWT;
use Closure;
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response; 
use \Firebase\JWT\ExpiredException;
use \Firebase\JWT\SignatureInvalidException;

class BearerTokenAuthentication
{
    public function handle(Request $request, Closure $next): Response
    {  
        $token = $request->bearerToken();

        if (!$token) {
            return response()->json(['error' => 'Authorization header missing'], 401);
        }
        
        try {
            // Decode the token payload
            $payload = base64_decode(explode('.', $token)[1]);
            // Convert the JSON payload to an array
            $tokenData = json_decode($payload, true);
          
        } catch (\Exception $e) {
            return response()->json(['error' => true,
            'message' => 'Invalid token format',
            ], 401); 
        }
        
       

        // Check if the "sub" claim is present in the token data
        if (!isset($tokenData['sub'])) {
            return response()->json(['error' => true,
            'message' => 'Unauthorized user!',
            ], 401);
        }

        // Retrieve the user ID from the "sub" claim
        $userId = $tokenData['sub'];
      
        // Retrieve the user using the user ID
        $user = User_app::where('user_id', $userId)->first();


        if (!$user) {
            return response()->json(['error' => true,
            'message' => 'User not found',
            ], 401);
            
        }
        

        // Attach the authenticated user to the request
        $request->merge(['user' => $user]);

        return $next($request);
    }
}
