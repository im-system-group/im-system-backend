<?php

namespace App;


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
}
