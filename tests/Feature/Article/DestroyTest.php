<?php


namespace Article;


use App\Article;
use Tests\Feature\ActingLogin;

class DestroyTest extends ActingLogin
{
    public function testDestroy()
    {
        $article = factory(Article::class)->create([
            'author_id' => $this->member->id
        ]);

        $response = $this->deleteJson(route('articles.destroy', [
            'article' => $article->id
        ]));

        $response->assertStatus(204);
        $this->assertSoftDeleted('articles', [
            'id' => $article->id,
        ]);
    }

    public function testDestroyWithNotAuthor()
    {
        $article = factory(Article::class)->create();

        $response = $this->deleteJson(route('articles.destroy', $article->id));

        $response->assertStatus(403);
    }

}