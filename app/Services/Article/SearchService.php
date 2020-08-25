<?php


namespace App\Services\Article;


use App\Article;

class SearchService
{
    public function search(int $perPage)
    {
        return Article::with('author')
            ->withTrashed()
            ->paginate($perPage);
    }
}