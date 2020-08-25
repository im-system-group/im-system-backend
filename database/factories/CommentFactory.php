<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Article;
use App\Comment;
use App\Member;
use Faker\Generator as Faker;

$factory->define(Comment::class, function (Faker $faker) {
    return [
        'author_id' => factory(Member::class),
        'article_id' => factory(Article::class),
        'content' => $faker->realText(),
        'is_banned' => false
    ];
});
