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

    public function getPhotoAttribute()
    {
        if ($this->attributes['photo']) {
            return Storage::disk('public')->url($this->attributes['photo']);
        }
    }

    public function articles(): HasMany
    {
        $this->hasMany(Articles::class);
    }

    public function comments(): HasMany
    {
        $this->hasMany(Comments::class);
    }
}
