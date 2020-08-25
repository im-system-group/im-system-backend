<?php


namespace Comment;


use App\Article;
use App\Comment;
use Tests\Feature\ActingLogin;

class UpdateTest extends ActingLogin
{
    public function testUpdate()
    {
        $article = factory(Article::class)->create();
        $comment = factory(Comment::class)->create([
            'article_id' => $article,
            'author_id' => $this->member,
        ]);

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
        $article = factory(Article::class)->create();
        $comment = factory(Comment::class)->create([
            'article_id' => $article,
        ]);

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
        $article = factory(Article::class)->create();
        $comment = factory(Comment::class)->create([
            'article_id' => $article,
            'author_id' => $this->member,
            'is_banned' => true
        ]);

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
        $article = factory(Article::class)->create([
            'author_id' => $this->member
        ]);

        $comment = factory(Comment::class)->create([
            'article_id' => $article,
        ]);

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

}