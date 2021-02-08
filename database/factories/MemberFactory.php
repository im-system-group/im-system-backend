<?php

namespace Database\Factories;

use App\Member;
use Illuminate\Database\Eloquent\Factories\Factory;

class MemberFactory extends Factory
{
    protected $model = Member::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'account' => $this->faker->unique()->userName,
            'email' => $this->faker->email,
            'password' => $this->faker->password,
            'photo' => null,
        ];
    }
}
