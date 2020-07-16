<?php

namespace App;

use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;

class Member extends User
{
    use HasApiTokens;

    public $incrementing = false;

    protected $fillable = [
        'id', 'account', 'name', 'email', 'password', 'photo'
    ];

    protected static function boot()
    {
        parent::boot();

        self::creating(fn($model) => $model->id = Str::orderedUuid());
    }

    public function setPasswordAttribute(string $password)
    {
        $this->attributes['password'] = Hash::make($password);
    }
}
