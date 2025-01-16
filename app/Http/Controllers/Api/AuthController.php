<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Authentification;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    protected $authentification;

    public function __construct(Authentification $authentification)
    {
        $this->authentification = $authentification;
    }

    /**
     * Login method to authenticate user and return JWT token.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $credentials = $request->only('phone_number', 'password');

        try {
            $response = $this->authentification->login($credentials);
            return response()->json($response, $response['response_code']);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    public function me(Request $request)
    {
        try {
            if (!$token = JWTAuth::getToken()) {
                return response()->json(['message' => 'Token not provided'], 400);
            }

            $user = JWTAuth::authenticate($token);

            if ($user) {
                return response()->json([
                    'user' => $user
                ]);
            }

            return response()->json([
                'message' => 'User not found'
            ], 404);

        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json(['message' => 'Token is invalid'], 400);
        }
    }
}
