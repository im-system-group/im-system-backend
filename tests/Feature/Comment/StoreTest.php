<?php


namespace Comment;


use Database\Factories\ArticleFactory;
use Database\Factories\CommentFactory;
use Tests\Feature\ActingLogin;

class StoreTest extends ActingLogin
{
    public function testStore()
    {
        $article = ArticleFactory::new()->create();
        $content = "test\n test 😀";

        $response = $this->postJson(route('articles.comments.store', $article->id), [
            'content' => $content
        ]);

        $response->assertStatus(204);

        $this->assertDatabaseHas('comments', [
            'content' => $content,
            'author_id' => $this->member->id,
            'article_id' => $article->id
        ]);
    }

    public function testStoreWithBanned()
    {
        $article = ArticleFactory::new()->create();
        CommentFactory::new([
            'is_banned' => true
        ])
            ->for($article)
            ->for($this->member, 'author')
            ->create();

        $response = $this->postJson(route('articles.comments.store', $article->id), [
            'content' => 'banned test'
        ]);

        $response->assertStatus(403);
    }
}