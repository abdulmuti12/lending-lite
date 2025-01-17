<?php

namespace App\Http\Controllers\Api\Borrower;

use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;
use App\Services\BorrowerService;
use App\Http\Controllers\Api\BaseController;

class BorrowerController extends BaseController
{

    protected $borrowerService;

    public function __construct(BorrowerService $borrowerService)
    {
        $this->borrowerService = $borrowerService;
        $this->authCheck();
    }
    public function information(Request $request){

        try {

            $response = $this->borrowerService->information();
            
            return $this->sendResponse($response['data'], $response['message'], $response['response_code']);

        } catch (\Exception $e) {

            return $this->sendError($e->getMessage(), 'Registration failed', 400);
        }
    }
}
