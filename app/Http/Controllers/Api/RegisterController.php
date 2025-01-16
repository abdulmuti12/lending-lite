<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Services\RegisterService;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\BaseController;


class RegisterController extends BaseController
{

    private $registerService;

    public function __construct(RegisterService $registerService)
    {
        $this->registerService = $registerService;
    }


    public function register(Request $request)
    {

        // $validatedData = $request->validate([
        //     'name' => 'required|string|max:255',
        //     'password' => 'required|string|min:6|confirmed',
        //     'ktp_file' => 'nullable|mimes:jpeg,png,jpg,pdf|max:20482', // Validasi file dengan ukuran maksimal 2MB
        // ]);

        try {
            // Pass data dan file ke service
            $response = $this->registerService->register($request->all(), $request->file('ktp_file'));

            return $this->sendResponse($response['data'], $response['message']);

        } catch (\Exception $e) {

            return $this->sendError($e->getMessage(), 'Registration failed');
        }

    }
}
