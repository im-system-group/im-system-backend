<?php


namespace App\Services\Comment;


use App\Comment;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;

class UpdateService
{
    public function update(Comment $comment, FormRequest $request)
    {
        if ($request->has('content')) {
            $comment->content = $request->content;
        }

        if ($request->has('ban')) {
            $comment->is_banned = $request->ban;
        }

        DB::transaction(fn() => $comment->save());
    }

}