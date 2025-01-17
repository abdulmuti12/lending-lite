<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Investment extends Model
{
    
    protected $table = 'investments';

    protected $fillable = [
        'lender_id',
        'bank_id',
        'date_investment',
        'date_investment_paid',
        'total_investment',
        'va_number',
        'status',
        'type',
        'created_at',
        'updated_at',
    ];

    public function userAccount()
    {
        return $this->belongsTo(UserAccount::class, 'lender_id', 'id');
    }

    public $timestamps = false;
}
