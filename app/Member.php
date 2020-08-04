<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;

class Member extends User
{
    use HasApiTokens;

    public $incrementing = false;

    protected $keyType = 'string';

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

    public function articles(): HasMany
    {
        $this->hasMany(Article::class);
    }

    public function comments(): HasMany
    {
        $this->hasMany(Comments::class);
    }
}
