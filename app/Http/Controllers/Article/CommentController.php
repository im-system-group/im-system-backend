<?php


namespace App\Http\Controllers\Article;


use App\Article;
use App\Comment;
use App\Http\Controllers\Controller;
use App\Http\Requests\Comment\SearchRequest;
use App\Http\Requests\Comment\StoreRequest;
use App\Http\Requests\Comment\UpdateRequest;
use App\Http\Resources\CommentResource;
use App\Services\Comment\SearchService;
use App\Services\Comment\StoreService;
use App\Services\Comment\UpdateService;
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

    public function update(Article $article, Comment $comment, UpdateRequest $request, UpdateService $service)
    {
        $service->update($comment, $request);
        return response('', 204);
    }

    public function destroy(Article $article, Comment $comment)
    {
        $this->authorize('delete', [
            Comment::class,
            $article,
            $comment
        ]);

        $comment->delete();
        return response('', 204);
    }

}