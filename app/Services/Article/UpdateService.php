<?php


namespace App\Services\Article;


use App\Article;
use App\Member;
use Illuminate\Support\Facades\DB;

class UpdateService
{
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