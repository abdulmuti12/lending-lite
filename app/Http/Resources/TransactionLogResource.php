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
        return [
            'id' => $this->id,
            'name' => $this->investment->userAccount->name,
            'virtual_account' => $this->investment->va_number,
            'amount' => $this->amount,
            'type' => $this->type,
            'transaction_date' => $this->created_at
        ];
    }
}
