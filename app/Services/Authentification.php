<?php
namespace App\Services;

use App\Models\UserAccount;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;
use  Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\JWTException;

class Authentification
{
    /**
     *
     *
     * @param array $credentials
     * @return array
     * @throws \Exception
     */
    public function login(array $credentials): array
    {
        if (empty($credentials['phone_number']) || empty($credentials['password'])) {
            throw new \Exception("Missing required fields.");
        }

        try {
            $user = UserAccount::where('phone_number', $credentials['phone_number'])->first();

            // dd($user);
            if (!$user || !Hash::check($credentials['password'], $user->password)) {
                return [
                    'success' => false,
                    'response_code' => Response::HTTP_UNAUTHORIZED,
                    'message' => 'Invalid credentials',
                    'data' => null,
                ];
            }

            $token = JWTAuth::fromUser($user);
            // dd(vars: $user);

            $this->respondWithToken($token);

            return [
                'success' => true,
                'response_code' => Response::HTTP_OK,
                'message' => 'Login successful',
                'data' => [
                    'username' => $user->name,
                    'token' => $token,
                ]
            ];

        } catch (JWTException $e) {
            return [
                'success' => false,
                'response_code' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => 'Could not create token',
                'data' => null,
            ];
        }
    }

    protected  function  respondWithToken($token)
    {
       return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::factory()->getTTL() * 60
        ]);
    }
}


