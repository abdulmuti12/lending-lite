<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionLog extends Model
{
    protected $table = 'transactions_log';
    protected $fillable = [
        'id',
        'name',
        'investment_id',
        'user_id',
        'bank_id',
        'debit_id',
        'type',
        'amount',
        'description',
        'created_at',
        'updated_at',
    ];

    public $timestamps = false;

    public function investment()
    {
        return $this->belongsTo(Investment::class, 'investment_id', 'id');
    }

}
