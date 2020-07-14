<?php

namespace App;

use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class Member extends User
{
    use HasApiTokens;

    protected $fillable = [
        'id', 'account', 'name', 'email', 'password', 'photo'
    ];

    public function setPasswordAttribute(string $password)
    {
        $this->attributes['password'] = Hash::make($password);
    }
}
