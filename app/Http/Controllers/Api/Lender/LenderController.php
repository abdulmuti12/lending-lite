<?php

namespace App\Http\Controllers\Api\Lender;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\InvestmentService;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\BaseController;

class LenderController extends BaseController
{
    protected $investmentService;
    protected $lenderService;

    public function __construct(
        InvestmentService $investmentService,
    )
    {
        $this->investmentService = $investmentService;
    }

    public function information(Request $request)
    {

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
            $response = $this->investmentService->information();

            return $this->sendResponse($response['data'], $response['message'], $response['response_code']);

        } catch (\Exception $e) {

            return $this->sendError($e->getMessage(), 'Registration failed', 400);
        }
    }
    public function investmentSubmmission(Request $request)
    {
        if (Auth::user() === null) {
            return [
                'success' => false,
                'response_code' => Response::HTTP_BAD_REQUEST,
                'message' => 'You Don\'t Have Permission',
                'data' => null,
            ]; 
        }
    
        try {
            // Pass data dan file ke service
            $response = $this->investmentService->invest($request->all());
    
            return $this->sendResponse($response['data'], $response['message'], $response['response_code']);
    
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), 'Registration failed', 400);
        }
    }

    public function paymentInvest(Request $request)
    {
        if (Auth::user() === null) {
            return [
                'success' => false,
                'response_code' => Response::HTTP_BAD_REQUEST,
                'message' => 'You Don\'t Have Permission',
                'data' => null,
            ]; 
        }
    
        try {

            $response = $this->investmentService->paymentInvest($request->all());
    
            return $this->sendResponse($response['data'], $response['message'], $response['response_code']);
    
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), 'Registration failed', 400);
        }
    }
    
}
