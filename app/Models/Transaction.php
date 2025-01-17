<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = 'transactions';

    protected $fillable = [
        'lender_id',
        'account_id',
        'investment_id',
        'debit_id',
        'type_transaction',
        'amount',
        'remark',
        'created_at',
        'updated_at'
    ];

    public $timestamps = false;

}
