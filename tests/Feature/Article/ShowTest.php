<?php


namespace Article;


use App\Article;
use Tests\Feature\ActingLogin;

class ShowTest extends ActingLogin
{
    public function testShow()
    {
        $article = factory(Article::class)->create();
        $author = $article->author;
        $response = $this->getJson(route('articles.show', $article->id));

        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                'id' => $article->id,
                'title' => $article->title,
                'content' => $article->content,
                'likeNum' => count($article->like_info),
                'isLiked' => in_array($this->member->id, $article->like_info),
                'image' => null,
                'isDeleted' => false,
                'author' => [
                    'id' => $author->id,
                    'account' => $author->account,
                    'name' => $author->name,
                    'email' => $author->email,
                    'avatar' => null
                ]
            ]
        ]);
    }

}