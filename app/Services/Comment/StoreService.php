<?php


namespace App\Services\Comment;


use App\Article;
use App\Comment;
use App\Http\Requests\Comment\StoreRequest;
use App\Member;

class StoreService
{
    public function store(Member $member, Article $article, StoreRequest $request)
    {
        $comment = new Comment([
            'content' => $request->content,
        ]);

        $comment->author()->associate($member);
        $comment->article()->associate($article);
        $comment->save();
    }

}