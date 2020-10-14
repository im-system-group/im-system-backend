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
use App\Services\Article\ShowService;
use App\Services\Article\StoreService;
use App\Services\Article\UpdateService;
use App\Util\CheckToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    use CheckToken;

    public function __construct()
    {
        $this->middleware('auth:sanctum')->except('index', 'show');
    }

    public function index(SearchRequest $request, SearchService $service)
    {
        $memberId = $this->getMember($request->bearerToken());

        $perPage = $request->perPage ?? 10;

        return ArticleResource::collection($service->search($perPage, $memberId))
            ->response()
            ->setStatusCode(200);
    }

    public function store(StoreRequest $request, StoreService $service)
    {
        $user = Auth::user();

        $service->store($user, $request);
        return response('', 204);
    }

    public function show(Article $article, ShowService $service, Request $request)
    {
        $memberId = $this->getMember($request->bearerToken());

        return (new ArticleResource($service->show($article, $memberId)))
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
