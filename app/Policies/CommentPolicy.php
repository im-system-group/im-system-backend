<?php

namespace App\Policies;

use App\Article;
use App\Comment;
use App\Member;
use App\Util\CheckBanned;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommentPolicy
{
    use HandlesAuthorization, CheckBanned;

    /**
     * Determine whether the user can create models.
     *
     * @param Member $member
     * @param Article $article
     * @return mixed
     */
    public function create(Member $member, Article $article)
    {
        return !$this->isBanned($member, $article);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param Member $member
     * @param Article $article
     * @param Comment $comment
     * @return mixed
     */
    public function update(Member $member, Article $article, Comment $comment)
    {
        return !$this->isBanned($member, $article) && ($member->id == $comment->author_id);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param Member $member
     * @param Article $article
     * @param Comment $comment
     * @return mixed
     */
    public function delete(Member $member, Article $article, Comment $comment)
    {
        return !$this->isBanned($member, $article) && ($member->id == $comment->author_id);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Member  $member
     * @param  \App\Comment  $comment
     * @return mixed
     */
    public function restore(Member $member, Comment $comment)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Member  $member
     * @param  \App\Comment  $comment
     * @return mixed
     */
    public function forceDelete(Member $member, Comment $comment)
    {
        //
    }
}
