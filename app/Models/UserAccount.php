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
        'limit_loan',
        'npwp',
        'type',
        'created_at',
        'updated_at',
    ];


    public function getJWTIdentifier()
    {
        return $this->getKey();
    }


    public function getJWTCustomClaims()
    {
        return [];
    }

    public $timestamps = false;
}
