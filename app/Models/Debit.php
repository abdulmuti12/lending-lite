<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Debit extends Model
{
    protected $table = 'debit';

    protected $fillable = [
        'id',
        'amount',
        'type',
        'remark',
        'account_id',
        'created_at',
        'updated_at',
    ];

    public function userAccount()
    {
        return $this->belongsTo(UserAccount::class, 'account_id', 'id');
    }
    public $timestamps = false;

}
