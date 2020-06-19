<?php

namespace App;

use Illuminate\Foundation\Auth\User;
use Laravel\Sanctum\HasApiTokens;

class Member extends User
{
    use HasApiTokens;

    protected $attributes = [
        'id', 'account', 'email', 'password', 'photo'
    ];
}
