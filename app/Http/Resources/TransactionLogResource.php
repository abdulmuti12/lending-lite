<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionLogResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        $name = $this->type === 'Debit' 
        ? optional(@$this->debits->userAccount)->name 
        : optional($this->investment->userAccount)->name;

        $bank = $this->type === 'Debit' 
        ? '' 
        : optional($this->investment->banks)->name;
    
        return [
            'id' => $this->id,
            'name' => $name,
            'virtual_account' => optional($this->investment)->va_number,
            "bank_name" => $bank,
            'amount' => $this->amount,
            'type' => $this->type,
            'transaction_date' => $this->created_at,
        ];
    
    }
}
