<?php

namespace App\Http\Controllers\Article;

use App\Article;
use App\Http\Controllers\Controller;
use App\Http\Requests\Article\FavoriteRequest;
use App\Http\Requests\Article\SearchRequest;
use App\Http\Requests\Article\StoreRequest;
use App\Http\Requests\Article\UpdateRequest;
use App\Http\Resources\ArticleResource;
use App\Services\Article\SearchService;
use App\Services\Article\StoreService;
use App\Services\Article\UpdateService;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    public function index(SearchRequest $request, SearchService $service)
    {
        $perPage = $request->perPage ?? 10;

        return ArticleResource::collection($service->search($perPage))
            ->response()
            ->setStatusCode(200);
    }

    public function store(StoreRequest $request, StoreService $service)
    {
        $user = Auth::user();

        $service->store($user, $request);
        return response('', 204);
    }

    public function show(Article $article)
    {
        return (new ArticleResource($article->load('author')))
            ->response()
            ->setStatusCode(200);
    }

    public function update(Article $article, UpdateRequest $request, UpdateService $service)
    {
        $service->update($article, $request);
        return response('', 204);
    }

    public function destroy(Article $article)
    {
        $this->authorize('delete', [
            Article::class,
            $article
        ]);

        $article->delete();
        return response('', 204);
    }

    public function favorite(Article $article, FavoriteRequest $request, UpdateService $service)
    {
        $user = Auth::user();
        $service->favorite($user, $article, $request->favorite);
        return response('', 204);
    }
}
