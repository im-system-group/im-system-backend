<?php


namespace Article;


use Illuminate\Http\UploadedFile;
use Tests\Feature\ActingLogin;

class StoreTest extends ActingLogin
{
    public function testStore()
    {
        $title = 'test';
        $content = "test\n test 😀";
        $image =  UploadedFile::fake()->image('test.png');

        $response = $this->postJson(route('articles.store'), [
            'title' => $title,
            'content' => $content,
            'image' => $image
        ]);

        $response->assertStatus(204);

        $this->assertDatabaseHas('articles', [
            'title' => $title,
            'content' => $content,
            'author_id' => $this->member->id
        ]);
    }

}