<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comments extends UuidModel
{
    use SoftDeletes;

    protected $fillable = [
        'id', 'content', 'is_banned'
    ];

    public function article() :BelongsTo
    {
        return $this->belongsTo(Article::class);
    }

    public function author() :BelongsTo
    {
        return $this->belongsTo(Member::class);
    }
}
