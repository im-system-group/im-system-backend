<?php


namespace App\Services\Article;


use App\Articles;

class SearchService
{
    public function search($perPage)
    {
        return Articles::with('author')
            ->paginate($perPage);
    }
}