<?php


namespace App\Services\Comment;


use App\Article;

class SearchService
{
    public function search(int $perPage, Article $article)
    {
        return $article->comments()
            ->with('author')
            ->withTrashed()
            ->paginate($perPage);
    }

    public function searchAll(Article $article)
    {
        return $article->comments()
            ->with('author')
            ->withTrashed()
            ->get();
    }

}