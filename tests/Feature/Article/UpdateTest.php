<?php


namespace Article;


use App\Article;
use Tests\Feature\ActingLogin;

class UpdateTest extends ActingLogin
{
    public function testSetFavorite()
    {
        $article = factory(Article::class)->create();

        $response = $this->patchJson(route('articles.favorite.update', $article->id), [
            'favorite' => true
        ]);

        $response->assertStatus(204);

        $article->refresh();

        $this->assertTrue(in_array($this->member->id, $article->like_info));
    }

    public function testRemoveFavorite()
    {
        $article = factory(Article::class)->create([
            'like_info' => [$this->member->id]
        ]);

        $response = $this->patchJson(route('articles.favorite.update', $article->id), [
            'favorite' => false
        ]);

        $response->assertStatus(204);

        $article->refresh();

        $this->assertFalse(in_array($this->member->id, $article->like_info));
    }
}