<?php


namespace Comment;


use Database\Factories\ArticleFactory;
use Database\Factories\CommentFactory;
use Tests\Feature\ActingLogin;

class UpdateTest extends ActingLogin
{
    public function testUpdate()
    {
        $article = ArticleFactory::new()->create();
        $comment = CommentFactory::new()
            ->for($article)
            ->for($this->member, 'author')
            ->create();

        $content = "update test\n update test 😀";

        $response = $this->patchJson(route('articles.comments.update', [
            $article,
            $comment
        ]), [
            'content' => $content
        ]);

        $response->assertStatus(204);

        $this->assertDatabaseHas('comments', [
            'author_id' => $this->member->id,
            'article_id' => $article->id,
            'content' => $content
        ]);
    }

    public function testUpdateWithNotAuthor()
    {
        $article = ArticleFactory::new()->create();
        $comment = CommentFactory::new()
            ->for($article)
            ->create();

        $content = "update test\n update test 😀";

        $response = $this->patchJson(route('articles.comments.update', [
            $article,
            $comment
        ]), [
            'content' => $content
        ]);

        $response->assertStatus(403);
    }

    public function testUpdateWithBanned()
    {
        $article = ArticleFactory::new()->create();
        $comment = CommentFactory::new([
            'is_banned' => true
        ])
            ->for($article)
            ->for($this->member, 'author')
            ->create();

        $content = "update test\n update test 😀";

        $response = $this->patchJson(route('articles.comments.update', [
            $article,
            $comment
        ]), [
            'content' => $content
        ]);

        $response->assertStatus(403);
    }

    public function testSetBanned()
    {
        $article = ArticleFactory::new()
            ->for($this->member, 'author')
            ->create();
        
        $comment = CommentFactory::new()
            ->for($article)
            ->create();

        $isBanned = true;

        $response = $this->patchJson(route('articles.comments.ban', [
            $article,
            $comment
        ]), [
            'ban' => $isBanned
        ]);

        $response->assertStatus(204);
        $this->assertDatabaseHas('comments', [
            'id' => $comment->id,
            'article_id' => $article->id,
            'is_banned' => $isBanned
        ]);
    }

    public function testSetBannedWithNotArticleAuthor()
    {
        $article = ArticleFactory::new()->create();

        $comment = CommentFactory::new()
            ->for($article)
            ->create();

        $isBanned = true;

        $response = $this->patchJson(route('articles.comments.ban', [
            $article,
            $comment
        ]), [
            'ban' => $isBanned
        ]);

        $response->assertStatus(403);
    }

}