<?php


namespace App\Http\Controllers\Article;


use App\Article;
use App\Http\Controllers\Controller;
use App\Http\Requests\Comment\SearchRequest;
use App\Http\Requests\Comment\StoreRequest;
use App\Http\Resources\CommentResource;
use App\Services\Comment\SearchService;
use App\Services\Comment\StoreService;
use Illuminate\Support\Facades\Auth;

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

    public function store(Article $article, StoreRequest $request, StoreService $service)
    {
        $user = Auth::user();

        $service->store($user, $article, $request);
        return response('', 204);
    }

}