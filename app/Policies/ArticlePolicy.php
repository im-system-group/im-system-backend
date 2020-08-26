<?php

namespace App\Policies;

use App\Article;
use App\Member;
use Illuminate\Auth\Access\HandlesAuthorization;

class ArticlePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Member  $member
     * @return mixed
     */
    public function viewAny(Member $member)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Member  $member
     * @param  \App\Article  $article
     * @return mixed
     */
    public function view(Member $member, Article $article)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Member  $member
     * @return mixed
     */
    public function create(Member $member)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Member  $member
     * @param  \App\Article  $article
     * @return mixed
     */
    public function update(Member $member, Article $article)
    {
        return $member->id == $article->author_id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Member  $member
     * @param  \App\Article  $article
     * @return mixed
     */
    public function delete(Member $member, Article $article)
    {
        return $member->id == $article->author_id;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Member  $member
     * @param  \App\Article  $article
     * @return mixed
     */
    public function restore(Member $member, Article $article)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Member  $member
     * @param  \App\Article  $article
     * @return mixed
     */
    public function forceDelete(Member $member, Article $article)
    {
        //
    }
}
