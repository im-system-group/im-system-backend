<?php

namespace App;


use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;

class Article extends UuidModel
{
    protected $fillable = [
        'id', 'author_id', 'title', 'content', 'image', 'like_info'
    ];

    protected $appends = [
        'like', 'liked'
    ];

    protected $casts = [
        'like_info' => 'array'
    ];

    public function author() :BelongsTo
    {
        return $this->belongsTo(Member::class, 'author_id');
    }

    public function comments() :HasMany
    {
        return $this->hasMany(Comments::class);
    }

    public function getLikeAttribute()
    {
        return count($this->like_info);
    }

    public function getLikedAttribute()
    {
        return in_array(Auth::id(), $this->like_info);
    }
}
