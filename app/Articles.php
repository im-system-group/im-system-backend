<?php

namespace App;


use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Articles extends UuidModel
{
    protected $attributes = [
        'like_info' => []
    ];


    protected $fillable = [
        'id', 'author_id', 'title', 'content', 'image', 'like_info'
    ];

    protected $casts = [
        'like_info' => 'array'
    ];

    public function member() :BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public function comments() :HasMany
    {
        return $this->hasMany(Comments::class);
    }
}
