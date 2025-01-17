<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;


class BaseController extends Controller
{

    
    public function sendResponse($result, $message = null)
    {
        return response()->json([
            'success' => true,
            'response_code'=>Response::HTTP_OK,
            'message' => $message,
            'data' => $result
        ], Response::HTTP_OK);
    }

    // Fungsi untuk response gagal
    public function sendError($error, $message = null, $code = Response::HTTP_INTERNAL_SERVER_ERROR)
    {
        return response()->json([
            'success' => false, 
            'response_code'=>$code,
            'message' => $message,
            'error' => $error
        ], $code);
    }

    public function authCheck(){

        if (Auth::user() === null) {
            return [
                'success' => false,
                'response_code' => Response::HTTP_BAD_REQUEST,
                'message' => 'You Don\'t Have Permission ',
                'data' => null,
            ];
        }
    }
}
