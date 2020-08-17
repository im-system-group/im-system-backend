<?php


namespace Article;


use App\Article;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\Feature\ActingLogin;

class UpdateTest extends ActingLogin
{
    public function testUpdate()
    {
        Storage::fake();

        $article = factory(Article::class)->create([
            'author_id' => $this->member->id
        ]);
        $newTitle = 'Update title';
        $newContent = 'test content😀';
        $newImage = UploadedFile::fake()->image('test.png');

        $response = $this->patchJson(route('articles.update', [
            'article' => $article->id
        ]), [
            'title' => $newTitle,
            'content' => $newContent,
            'image' => $newImage
        ]);

        $response->assertStatus(204);

        $this->assertDatabaseHas('articles', [
            'id' => $article->id,
            'title' => $newTitle,
            'content' => $newContent
        ]);

        $image = $article->refresh()->image;

        Storage::disk('public')->assertExists($image);
    }

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