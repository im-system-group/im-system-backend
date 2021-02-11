<?php

namespace Database\Factories;

use App\Comment;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    protected $model = Comment::class;

    public function definition()
    {
        return [
            'author_id' => MemberFactory::new(),
            'article_id' => ArticleFactory::new(),
            'content' => $this->faker->realText(),
            'is_banned' => false
        ];
    }
}
