<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ApiAuthentication extends Middleware
{
    public function handle($request, Closure $next, ...$guards)
    {
        // Check if the "Authorization" header is empty
        $token = $request->header('Authorization');
        if (!$token) {
            return response()->json(['error' => 'Authentication failed. Token not provided. Please include the Authorization header with a valid format.'], Response::HTTP_UNAUTHORIZED);
        }

        try {
            $user = Auth::user();

            // Check if the user is authenticated
            if (!$user) {
                return response()->json(['error' => 'Authentication failed. Unable to authenticate user with the provided token.'], Response::HTTP_FORBIDDEN);
            }

            // Check if the "hino_role" claim is missing or null
            $hinoRole = $user->ms_role_name;
            if (!$hinoRole) {
                return response()->json(['error' => 'Unauthorized. Your user role is not provided or invalid. Please contact support for assistance.'], Response::HTTP_FORBIDDEN);
            }

            // Check if the token has expired
            $tokenExpiration = $user->exp ?? null;
            if ($tokenExpiration && $tokenExpiration < time()) {
                return response()->json(['error' => 'Authentication failed. The provided token has expired.'], Response::HTTP_UNAUTHORIZED);
            }

            // Additional checks based on your payload
            $hinoId = $user->ms_user_id;

            if (!$hinoId) {
                return response()->json(['error' => 'Unauthorized. Missing required user information. Please contact support for assistance.'], Response::HTTP_FORBIDDEN);
            }

            // Ensure the user's role matches the expected roles
            $validRoles = ['hmsi', 'admin', 'checker', 'approver'];
            if (!in_array($hinoRole, $validRoles)) {
                return response()->json(['error' => 'Unauthorized. Invalid user role. Please contact support for assistance.'], Response::HTTP_FORBIDDEN);
            }

            return $next($request);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Authentication failed. Unable to authenticate your request. Please check your token and try again or contact support for assistance.'], Response::HTTP_UNAUTHORIZED);
        }
    }
}
