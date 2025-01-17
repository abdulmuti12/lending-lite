<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $table = 'accounts';

    protected $fillable = [
        'lender_id',
        'account_type',
        'balance',
        'opening_date',
        'created_at',
        'updated_at'
    ];

    public $timestamps = false;
}
