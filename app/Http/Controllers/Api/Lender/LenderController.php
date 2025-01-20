<?php

namespace App\Http\Controllers\Api\Lender;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\LenderService;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\BaseController;
use App\Http\Resources\TransactionLogResource;
use App\Models\Debit;
use App\Models\Transaction;
use App\Models\TransactionLog;
use App\Services\BankService;
use Illuminate\Support\Facades\Hash;

class LenderController extends BaseController
{
    protected $lenderService;
    private $user;
    private $log;
    private $bankService;

    public function __construct(
        LenderService $lenderService,
        TransactionLog $transactionLog,
        BankService $bankService
    )
    {
        $this->lenderService = $lenderService;
        $this->authCheck();
        $this->user = Auth::user();
        $this->log=$transactionLog;
        $this->bankService = $bankService;
    }

    public function information(Request $request)
    {

        try {

            $response = $this->lenderService->information();

            return $this->sendResponse($response['data'], $response['message'], $response['response_code']);

        } catch (\Exception $e) {

            return $this->sendError($e->getMessage(), 'Access Data Failed', 400);
        }
    }
    public function investmentSubmmission(Request $request)
    {
    
        try {
            // Pass data dan file ke service
            $response = $this->lenderService->invest($request->all());
    
            return $this->sendResponse($response['data'], $response['message'], $response['response_code']);
    
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), 'Access Data Failed', 400);
        }
    }

    public function paymentInvest(Request $request)
    {

        try {

            $response = $this->lenderService->paymentInvest($request->all());
    
            return $this->sendResponse($response['data'], $response['message'], $response['response_code']);
    
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), 'Access Data Failed', 400);
        }
    }

    public function logInvestmentPersonal(Request $request){

        $page = $request->query('page') ?? 1;
        $raw = (bool) $request->query('raw') ?? false;
        $search = $request->all() ?? null;
        // $collection=TransactionLog::where('user_id', $this->user->id);
        $collection=TransactionLog::whereIn('type', ['Kredit', 'Debit']);

        if($request->startdate != null &&  $request->enddate == ''){
            return $this->sendResponse(true, "Failed", "Please Send Data Request Date with Complite Parameters");
        }

        if (count($search) > 0) {
            foreach ($search as $rows => $row) {

                if (isset($request->startdate) && $rows === "startdate") {
                    $startDate = $request->startdate;
                    $endDate = $request->enddate ?? $startDate;

                    $collection->whereBetween('created_at', [$startDate, $endDate]);
                }

                if ($rows == "virtual_account") {
                    $collection->whereHas('investment', function ($q) use ($row) {
                        $q->where('va_number', '=',  $row);
                    });
                }
            }
        }
        
        $collection = $collection->orderBy('id', 'desc')->paginate(10, ['*'], 'page', $page);
        $rawData = TransactionLogResource::collection($collection);
        if ($raw) {
            $datas = $rawData;
        } else {
            $responses = $rawData->response()->getData(true);
            $links = $responses['links'];
            $dataLinks = [];
            unset($responses['links']);
            $meta = $responses['meta'];
            unset($responses['meta']);

            $dataLinks['first_page_url'] = $links['first'];
            $dataLinks['last_page_url'] = $links['last'];
            $dataLinks['prev_page_url'] = $links['prev'];
            $dataLinks['next_page_url'] = $links['next'];

            $datas = array_merge($responses, $meta, $dataLinks);
        }

        return $this->sendResponse($datas, "Success", 200);

        // $collection = Lending::with('lending_borrowers')->where('id','!=',null);


        // dd($logTrasanction);
        // try {

        //     $response = $this->lenderService->logInvestPersonal($request->all());
    
        //     return $this->sendResponse($response['data'], $response['message'], $response['response_code']);
    
        // } catch (\Exception $e) {

        //     return $this->sendError($e->getMessage(), 'Access Data Failed', 400);
        // }
    }

    public function debit(Request $request){

         try {

            $response = $this->lenderService->debit($request->all());
    
            return $this->sendResponse($response['data'], $response['message'], $response['response_code']);
    
        } catch (\Exception $e) {

            return $this->sendError($e->getMessage(), 'Access Data Failed', 400);
        }
    }

    public function getBank(Request $request){
        
        $data = $this->bankService->getBanks();

        return $data;
    }
    
}
