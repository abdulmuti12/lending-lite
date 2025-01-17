<?php
namespace App\Services;

use App\Models\Account;
use App\Models\Bank;
use App\Models\Investment;
use App\Models\Transaction;
use App\Models\TransactionLog;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;

class LenderService
{
    private $user;
   
    public function __construct()
    {
        $this->validateAccess();
        $this->user = auth()->user(); // Get the authenticated user 
    }

    public function information()
    {

        // dd(33);
        $dataCollection['main_info'] =[
            'name'=>$this->user->name
        ];

        foreach ($this->user->account as  $row) {
            $dataCollection['Investasi '.$row->account_type] = [
                'balance' => $row->balance,
                'opening_date' => $row->opening_date,
                'last_update_balance' => $row->updated_at
            ];           
        }

        return [
            'success' => true,
            'response_code' => Response::HTTP_OK,
            'message' => 'Information Access successfully',
            'data' => $dataCollection,
        ];        
    }

    public function invest(array $data): array
    {

        if ($this->user->type != 'lender') {
            return [
                'success' => false,
                'response_code' => Response::HTTP_BAD_REQUEST,
                'message' => 'Borrower Cannot Access this page.',
                'data' => null,
            ];
        }

        $validator = Validator::make($data, [
            'bank_id' => 'required|integer',           
            'invest_type' => 'required|string',    
            'amount' => 'required|numeric|min:0',  
        ]);

        if ($validator->fails()) {
            return [
                'success' => false,
                'response_code' => Response::HTTP_BAD_REQUEST,
                'message' => 'Validation failed',
                'data' => $validator->errors(),
            ];
        }

        $bank =Bank::find($data['bank_id']);
        $virtual_account = $bank->code.$this->user->phone_number;

        $dataCollection =[
            'bank_id' => $data['bank_id'],
            'total_investment' => $data['amount'],
            'va_number' => $virtual_account,
            'lender_id' => $this->user->id,
            'type'=>$data['invest_type'],
            'date_investment' => now(),
            'created_at' => now(),
            'status' => 'Pending',
        ];

        $process = Investment::create($dataCollection);

        $resposeData=[
            'bank_name' =>$bank->name,
            'va_number' =>$virtual_account,
            'invest_type' =>$data['invest_type'],
            'total_investment' =>$data['amount'],
            'status' => "Pending"
        ];

        return [
            'success' => true,
            'response_code' => Response::HTTP_OK,
            'message' => 'User registered successfully',
            'data' => $resposeData,
        ];       
    }

    public function paymentInvest(array $data): array
    {

        if ($this->user->type != 'lender') {
            return [
                'success' => false,
                'response_code' => Response::HTTP_BAD_REQUEST,
                'message' => 'Borrower Cannot Access this page.',
                'data' => null,
            ];
        }

        $investment = Investment::where('lender_id', '=', $this->user->id)
                    ->where('status', '=', 'Pending')
                    ->where('va_number', '=', $data['virtual_account'])
                    ->first();

        if($investment == null){
            return [
                'success' => false,
                'response_code' => Response::HTTP_BAD_REQUEST,
                'message' => 'Investment Not Found',
                'data' => null,
            ];
        }

        $findAccount =Account::where('lender_id', '=', $this->user->id)
                    ->where('account_type', '=', $investment->type)->first();

        $dataCollection =[
            'account_id'=>$findAccount->id,
            'investment_id'=>$investment->id,
            'amount'=>$investment->total_investment,
            'transaction_date'=>now(),
            'type_transaction'=>'Kredit',
            'created_at'=>now(),
            'remark'=>$data['remark'],
        ];
        // dd($dataCollection);
        $transaction =Transaction::create($dataCollection);
        $updatedBalance=$findAccount->balance + $transaction->amount;
        $investment->status = 'Completed';
        $investment->save();
        $findAccount->balance = $updatedBalance;
        $findAccount->updated_at = now();
        $findAccount->save();

        $logData=[
            'user_id'=>$investment->lender_id,
            'type'=>'Kredit',
            'bank_id'=>$investment->bank_id,
            'amount'=>$investment->total_investment,
            'description'=>$data['remark'],
            'created_at'=>now(),
            'investment_id'=>$investment->id
        ];

        $logTransaction = TransactionLog::create($logData);

       return 
        [
            'success' => true,
            'response_code' => Response::HTTP_OK,
            'message' => 'Payment Success',
            'data' => null,
        ];
    }


    public function logInvestPersonal(array $data): array
    {
        
    }

    public function validateAccess(){


        if(auth()->user()  == null){
            return [
                'success' => false,
                'response_code' => Response::HTTP_BAD_REQUEST,
                'message' => 'Borrower Cannot Access this page.',
                'data' => null,
            ];
        }
        
        if (!auth()->user() || auth()->user()->type != 'lender') {
            return [
                'success' => false,
                'response_code' => Response::HTTP_BAD_REQUEST,
                'message' => 'Borrower Cannot Access this page.',
                'data' => null,
            ];
        }
    }
}