<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class EnsureUserIsAuthenticated
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::user() === null) {
            return response()->json([
                'success' => false,
                'response_code' => Response::HTTP_BAD_REQUEST,
                'message' => 'You Don\'t Have Permission',
                'data' => null,
            ], Response::HTTP_BAD_REQUEST);
        }

        return $next($request);
    }
}
