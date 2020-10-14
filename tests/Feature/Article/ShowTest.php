<?php


namespace Article;


use App\Article;
use App\Member;
use Laravel\Sanctum\Sanctum;
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
                'isDeleted' => false,
                'image' => null,
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

    public function testLike()
    {
        $member = Sanctum::actingAs(factory(Member::class)->create(), ['*']);

        $token = $member->createToken($member->name)->plainTextToken;

        $article = factory(Article::class)->create([
            'like_info' => [$member->id]
        ]);

        $author = $article->author;

        $response = $this->withToken($token)
            ->getJson(route('articles.show', $article->id));

        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                'id' => $article->id,
                'title' => $article->title,
                'content' => $article->content,
                'likeNum' => count($article->like_info),
                'isLiked' => true,
                'isDeleted' => false,
                'image' => null,
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