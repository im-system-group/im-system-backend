<?php


namespace Comment;


use Database\Factories\ArticleFactory;
use Database\Factories\CommentFactory;
use Tests\Feature\ActingLogin;

class DeleteTest extends ActingLogin
{
    public function testDelete()
    {
        $article = ArticleFactory::new()->create();
        $comment = CommentFactory::new()
            ->for($article)
            ->for($this->member, 'author')
            ->create();

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
        $article = ArticleFactory::new()->create();
        $comment = CommentFactory::new([
            'is_banned' => true
        ])
            ->for($article)
            ->for($this->member, 'author')
            ->create();

        $response = $this->deleteJson(route('articles.comments.destroy', [
            $article,
            $comment
        ]));

        $response->assertStatus(403);
    }

    public function testDeleteWithNotAuthor()
    {
        $article = ArticleFactory::new()->create();
        $comment = CommentFactory::new()
            ->for($article)
            ->create();

        $response = $this->deleteJson(route('articles.comments.destroy', [
            $article,
            $comment
        ]));

        $response->assertStatus(403);
    }

}