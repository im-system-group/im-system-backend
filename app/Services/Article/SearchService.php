<?php


namespace App\Services\Article;


use App\Article;
use Illuminate\Pagination\LengthAwarePaginator;

class SearchService
{
    public function search(int $perPage, ?string $memberId) :LengthAwarePaginator
    {
        $articles = Article::with('author')
            ->withTrashed()
            ->paginate($perPage);

        $articles->getCollection()->each(fn($article) => $article->like_status = $memberId);

        return $articles;
    }
}