<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Member;
use Faker\Generator as Faker;

$factory->define(Member::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'account' => $faker->unique()->userName,
        'email' => $faker->email,
        'password' => $faker->password,
        'photo' => null,
    ];
});
