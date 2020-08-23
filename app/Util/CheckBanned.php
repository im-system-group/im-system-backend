<?php


namespace App\Util;


use App\Article;
use App\Member;

trait CheckBanned
{
    public function isBanned(Member $member, Article $article)
    {
        return $article->comments()
            ->where('is_banned', true)
            ->where('author_id', $member->id)
            ->exists();
    }
}
