<?php


namespace App\Services\Article;


use App\Article;

class ShowService
{
    public function show(Article $article, ?string $memberId) : Article
    {
        $article->load('author');
        $article->like_status = $memberId;
        return $article;
    }

}