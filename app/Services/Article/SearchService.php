<?php


namespace App\Services\Article;


use App\Article;

class SearchService
{
    public function search($perPage)
    {
        return Article::with('author')
            ->paginate($perPage);
    }
}