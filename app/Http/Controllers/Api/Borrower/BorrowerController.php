<?php

namespace App\Http\Controllers\Api\Borrower;

use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\BorrowerService;
use App\Http\Controllers\Api\BaseController;

class BorrowerController extends BaseController
{

    protected $borrowerService;

    public function __construct(BorrowerService $borrowerService)
    {
        $this->borrowerService = $borrowerService;
    }
    public function information(Request $request){


        if (Auth::user() === null) {
            return [
                'success' => false,
                'response_code' => Response::HTTP_BAD_REQUEST,
                'message' => 'You Don\'t Have Permission ',
                'data' => null,
            ];
        }

        try {
            // Pass data dan file ke service
            $response = $this->borrowerService->information();

            return $this->sendResponse($response['data'], $response['message'], $response['response_code']);

        } catch (\Exception $e) {

            return $this->sendError($e->getMessage(), 'Registration failed', 400);
        }


    }
}
