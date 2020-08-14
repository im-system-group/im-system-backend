<?php


namespace App\Services\Article;


use App\Article;
use App\Http\Requests\Article\UpdateRequest;
use App\Member;
use Illuminate\Support\Facades\DB;

class UpdateService
{
    public function update(Article $article, UpdateRequest $request)
    {
        DB::transaction(function () use ($article, $request) {
            $article->title = htmlentities($request->title, ENT_QUOTES, 'UTF-8');
            $article->content = htmlentities($request->content, ENT_QUOTES, 'UTF-8');
            $article->save();
        });
    }

    public function favorite(Member $member, Article $article, bool $favorite)
    {
        $likeInfoCollection = collect($article->like_info);
        $likeInfo = $favorite ?
            $likeInfoCollection->add($member->id) : $likeInfoCollection->filter(fn($likeMember) => $likeMember != $member->id);

        DB::transaction(function () use ($likeInfo, $article){
            $article->like_info = $likeInfo;
            $article->save();
        });
    }

}