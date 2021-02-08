<?php

namespace Database\Factories;

use App\Article;
use Illuminate\Database\Eloquent\Factories\Factory;

class ArticleFactory extends Factory
{
    protected $model = Article::class;

    public function definition()
    {
        return [
            'author_id' => MemberFactory::new(),
            'title' => $this->faker->text(),
            'content' => $this->faker->realText(),
            'image' => null,
            'like_info' => []
        ];
    }
}
