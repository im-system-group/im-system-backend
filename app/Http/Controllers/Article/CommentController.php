<?php


namespace App\Http\Controllers\Article;


use App\Article;
use App\Http\Controllers\Controller;
use App\Http\Requests\Comment\SearchRequest;
use App\Http\Resources\CommentResource;
use App\Services\Comment\SearchService;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->except('index');
    }

    public function index(Article $article, SearchRequest $request, SearchService $service)
    {
        $perPage = $request->perPage ?? 10;

        return CommentResource::collection($service->search($perPage, $article))
            ->response()
            ->setStatusCode(200);
    }

}