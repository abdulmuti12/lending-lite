<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;



class UserAccount extends Authenticatable implements JWTSubject
{
    protected $table = 'user_account';


    protected $fillable = [
        'id',
        'name',
        'born_place',
        'born_date',
        'phone_number',
        'nik',
        'email',
        'ktp_file',
        'salary_per_month',
        'password',
        'address',
        'limit_loan',
        'npwp',
        'type',
        'created_at',
        'updated_at',
    ];

    protected $hidden = [
        'password',
    ];


    public function getJWTIdentifier()
    {
        return $this->getKey();
    }


    public function getJWTCustomClaims()
    {
        return [];
    }

    public function account(){

        return $this->hasMany( Account::class, 'lender_id', 'id');

    }
    
    public $timestamps = false;
}
