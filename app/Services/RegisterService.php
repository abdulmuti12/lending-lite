<?php

namespace App\Services;

use App\Models\UserAccount;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class RegisterService
{
    /**
     * Register a new UserAccount.
     *
     * @param array $data
     * @param \Illuminate\Http\UploadedFile|null $ktpFile
     * @return array
     * @throws \Exception
     */
    public function register(array $data, $ktpFile = null): array
    {
        if (empty($data['name']) || empty($data['password'])) {
            throw new \Exception("Missing required fields.");
        }

        try {

            $ktpFilePath = null;
            if ($ktpFile) {
                $ktpFilePath = $ktpFile->store('ktp_files', 'public');
            }

            $existingAccount = UserAccount::where('email', $data['email'])->orWhere('nik', $data['nik'])
                                ->orWhere('phone_number', $data['phone_number'])
                                ->first();

            if ($existingAccount) {
                return [
                    'success' => false,
                    'response_code' => Response::HTTP_ACCEPTED,
                    'message' => 'Email, NIK, or Phone Number has been registered before',
                    'data' =>null
                ];
            }

            $userData = [
                'name' => $data['name'],
                'password' => Hash::make($data['password']),
                'phone_number' => $data['phone_number'],
                'born_place' => $data['born_place'],
                'born_date' => $data['born_date'],
                'email' => $data['email'],
                'nik' => $data['nik'],
                'ktp_file' => $ktpFilePath, // Menyimpan path file
                'type' => $data['type'],
            ];

            if ($data['type'] == 'borrower') {
                $userData['salary_per_month'] = $data['salary_per_month'];
                $userData['limit_loan'] = 0.30 * $data['salary_per_month']; // 30% dari gaji
            } else {
                $userData['salary_per_month'] = $data['salary_per_month'] ?? 0;
                $userData['npwp'] = $data['npwp'];
            }

            $userAccount = UserAccount::create($userData);

            return [
                'success' => true,
                'response_code' => Response::HTTP_OK,
                'message' => 'User registered successfully',
                'data' => $userAccount,
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'response_code' => Response::HTTP_BAD_REQUEST,
                'errors' => $e->getMessage(),
                'message' => $e->getMessage(),
                'data' => null,
            ];
        }
    }
}
