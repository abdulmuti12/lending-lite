<?php

namespace App\Services;

use App\Models\Bank;
use Illuminate\Support\Facades\Validator;

class BankService
{
    private $model;

    public function __construct(Bank $model)
    {
        $this->model = $model;
    }

    /**
     * Retrieve all banks.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getBanks()
    {
        return $this->model->all();
    }

    /**
     * Find a bank by ID.
     *
     * @param int $id
     * @return Bank|null
     */
    public function findBankById($id)
    {
        return $this->model->find($id);
    }

    /**
     * Create a new bank record.
     *
     * @param array $data
     * @return Bank|\Illuminate\Validation\Validator
     */
    public function createBank(array $data)
    {
        $validator = Validator::make($data, [
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:10|unique:banks,code',
        ]);

        if ($validator->fails()) {
            return $validator;
        }

        return $this->model->create($data);
    }

    /**
     * Update an existing bank record.
     *
     * @param int $id
     * @param array $data
     * @return Bank|\Illuminate\Validation\Validator|null
     */
    public function updateBank($id, array $data)
    {
        $bank = $this->findBankById($id);

        if (!$bank) {
            return null;
        }

        $validator = Validator::make($data, [
            'name' => 'sometimes|string|max:255',
            'code' => 'sometimes|string|max:10|unique:banks,code,' . $id,
        ]);

        if ($validator->fails()) {
            return $validator;
        }

        $bank->update($data);
        return $bank;
    }

    /**
     * Delete a bank record by ID.
     *
     * @param int $id
     * @return bool
     */
    public function deleteBank($id)
    {
        $bank = $this->findBankById($id);

        if (!$bank) {
            return false;
        }

        return $bank->delete();
    }
}
