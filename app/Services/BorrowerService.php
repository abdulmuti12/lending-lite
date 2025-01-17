<?php
namespace App\Services;

use App\Models\UserAccount;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;

class BorrowerService
{
    /**
     *
     *
     * @param array $data
     * @return array
     * @throws \Exception
     */

    public function information()
    {
        $user = auth()->user();

        if ($user->type != 'borrower') {
            return [
                'success' => false,
                'response_code' => Response::HTTP_BAD_REQUEST,
                'message' => 'Lender Cannot Access this page.',
                'data' => null,
            ];
        }

        $borrowers = UserAccount::select('name', 'email', 'nik', 'phone_number','salary_per_month','limit_loan')->where('phone_number', $user->phone_number)->first()->toArray();

        return [
            'success' => true,
            'response_code' => Response::HTTP_OK,
            'message' => 'Acces Data Success',
            'data' => $borrowers
        ];
    }

}