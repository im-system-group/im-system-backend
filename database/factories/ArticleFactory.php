<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Article;
use App\Member;
use Faker\Generator as Faker;

$factory->define(Article::class, function (Faker $faker) {
    return [
        'author_id' => factory(Member::class),
        'title' => $faker->text(),
        'content' => $faker->realText(),
        'image' => null,
        'like_info' => []
    ];
});
