<?php

namespace App\Http\Controllers;

use App\Http\Requests\Article\SearchRequest;
use App\Http\Resources\ArticleResource;
use App\Services\Article\SearchService;

class ArticleController extends Controller
{
    public function index(SearchRequest $request, SearchService $service)
    {
        $perPage = (int) $request->perPage ?? 10;

        return ArticleResource::collection($service->search($perPage))
            ->response()
            ->setStatusCode(200);
    }
}
