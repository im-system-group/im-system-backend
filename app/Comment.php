<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends UuidModel
{
    use SoftDeletes;

    protected $fillable = [
        'id', 'content', 'is_banned'
    ];

    protected $casts = [
        'is_banned' => 'boolean'
    ];


    public function article() :BelongsTo
    {
        return $this->belongsTo(Article::class);
    }

    public function author() :BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public function setContentAttribute(string $content)
    {
        $this->attributes['content'] = htmlentities($content, ENT_QUOTES, 'UTF-8');
    }
}
