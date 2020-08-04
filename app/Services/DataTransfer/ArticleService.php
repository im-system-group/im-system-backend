<?php


namespace App\Services\DataTransfer;


use App\Article;
use App\Comments;
use App\Member;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ArticleService
{
    public function dataTransfer()
    {
        $articles = $this->getOldArticles();
        $articleComments = $this->toNewData($articles);

        DB::transaction(function () use ($articles) {
            DB::statement("set session sql_mode='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION'");
            Article::insert($articles->filter()->toArray());
        });

        echo "Article Data Complete.\n";

        $insertCommentData = collect();
        $articleComments->each(function ($comments, $articleId) use ($insertCommentData) {
            $this->toNewComment($comments, $articleId);
            $insertCommentData->push($comments);
        });

        DB::transaction(fn() => Comments::insert($insertCommentData->flatten(1)->filter()->toArray()));

        echo "Comments Data Complete.\n";

    }

    private function getOldArticles(): Collection
    {
        $articles = DB::connection('imold')->table('article')
            ->select('ID', 'poster', 'title', 'text', 'photo', 'post_time')
            ->get();

        $articles->each(function ($article) {
            $article->like_info = DB::connection('imold')->table('like_num')
                ->where('post_id', $article->ID)
                ->where('flag', 1)
                ->pluck('account')->transform(function($account) {
                    $member = Member::where('account', $account)->first();
                    if ($member) {
                        return $member->id;
                    }
                });
        });

        return $articles;
    }

    private function toNewData(Collection $articles): Collection
    {
        $articleComments = collect();

        $articles->transform(function ($article) use ($articleComments) {
            if (!Member::where('account', $article->poster)->first()) {
                return;
            }

            $article->id = Str::orderedUuid();
            $article->author_id = Member::where('account', $article->poster)->first()->id;
            $article->content = $article->text;

            $article->image = (substr($article->photo, 0, 2) == '..') ?
                substr($article->photo, 3) :
                null;

            $article->created_at = $article->updated_at = $article->post_time;

            $article->like_info = $article->like_info->filter()->toJson();

            // comment
            $articleComments->put($article->id->toString(), DB::connection('imold')->table('comments')
                ->where('post_id', $article->ID)
                ->select('text', 'commenter', 'post_time')
                ->get()
            );

            unset($article->ID, $article->poster, $article->photo, $article->post_time, $article->text);

            return (array) $article;
        });

        return $articleComments;
    }

    private function toNewComment(Collection $comments, string $articleId)
    {
        $comments->transform(function ($comment) use ($articleId){
            if (!Member::where('account', $comment->commenter)->first()) {
                return;
            }

            $comment->id = Str::orderedUuid();
            $comment->author_id = Member::where('account', $comment->commenter)->first()->id;
            $comment->article_id = $articleId;
            $comment->created_at = $comment->updated_at = $comment->post_time;
            $comment->content = $comment->text;

            unset($comment->commenter, $comment->post_time, $comment->text);
            return (array) $comment;
        });
    }
}