<?php

namespace App;


use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends UuidModel
{
    use SoftDeletes;

    protected $attributes = [
        'like_info' => "[]"
    ];

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
        return $this->hasMany(Comment::class);
    }

    public function getLikeAttribute()
    {
        return count($this->like_info);
    }

    public function setLikeStatusAttribute(?string $member)
    {
        $this->attributes['like_status'] = ($member) ? in_array($member, $this->like_info) : false;
    }

    public function setTitleAttribute(string $title)
    {
        $this->attributes['title'] = htmlentities($title, ENT_QUOTES, 'UTF-8');
    }

    public function setContentAttribute(string $content)
    {
        $this->attributes['content'] = htmlentities($content, ENT_QUOTES, 'UTF-8');
    }
}
