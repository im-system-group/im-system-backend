<?php


namespace Comment;


use App\Article;
use App\Comment;
use Tests\Feature\ActingLogin;

class DeleteTest extends ActingLogin
{
    public function testDelete()
    {
        $article = factory(Article::class)->create();
        $comment = factory(Comment::class)->create([
            'article_id' => $article,
            'author_id' => $this->member,
        ]);

        $response = $this->deleteJson(route('articles.comments.destroy', [
            $article,
            $comment
        ]));

        $response->assertStatus(204);
        $this->assertSoftDeleted('comments', [
            'id' => $comment->id,
            'article_id' => $article->id,
            'author_id' => $this->member->id
        ]);
    }

    public function testDeleteWithBanned()
    {
        $article = factory(Article::class)->create();
        $comment = factory(Comment::class)->create([
            'article_id' => $article,
            'author_id' => $this->member,
            'is_banned' => true
        ]);

        $response = $this->deleteJson(route('articles.comments.destroy', [
            $article,
            $comment
        ]));

        $response->assertStatus(403);
    }

    public function testDeleteWithNotAuthor()
    {
        $article = factory(Article::class)->create();
        $comment = factory(Comment::class)->create([
            'article_id' => $article,
        ]);

        $response = $this->deleteJson(route('articles.comments.destroy', [
            $article,
            $comment
        ]));

        $response->assertStatus(403);
    }

}