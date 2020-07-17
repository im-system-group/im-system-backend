<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comments extends UuidModel
{
    protected $fillable = [
        'id', 'author_id', 'article_id', 'content'
    ];

    public function article() :BelongsTo
    {
        return $this->belongsTo(Articles::class);
    }

    public function author() :BelongsTo
    {
        return $this->belongsTo(Member::class);
    }
}
