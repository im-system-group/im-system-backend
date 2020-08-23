<?php


namespace Comment;


use App\Article;
use App\Comment;
use App\Member;
use Laravel\Sanctum\Sanctum;
use Tests\Feature\ActingLogin;

class StoreTest extends ActingLogin
{
    public function testStore()
    {
        $article = factory(Article::class)->create();
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
        $article = factory(Article::class)->create();
        factory(Comment::class)->create([
            'article_id' => $article,
            'author_id' => $this->member,
            'is_banned' => true
        ]);

        $response = $this->postJson(route('articles.comments.store', $article->id), [
            'content' => 'banned test'
        ]);

        $response->assertStatus(403);
    }
}