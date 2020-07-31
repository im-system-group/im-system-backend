<?php


namespace App;


use App\Observers\UuidObserver;
use Illuminate\Database\Eloquent\Model;

abstract class UuidModel extends Model
{
    public $incrementing = false;

    protected $keyType = 'string';

    protected $primaryKey = 'id';

    public static function boot()
    {
        parent::boot();
        self::observe(UuidObserver::class);
    }
}