<?php


namespace Article;


use App\Article;
use App\Member;
use Illuminate\Testing\TestResponse;
use Tests\Feature\ActingLogin;

class SearchTest extends ActingLogin
{
    public function testIndex()
    {
        $author = factory(Member::class)->create();

        factory(Article::class)->create([
            'author_id' => $author->id
        ]);

        $response = $this->getJson(route('articles.index'));

        $response->assertStatus(200);
        $this->assertStructure($response);

    }

    public function testLike()
    {
        $author = factory(Member::class)->create();

        factory(Article::class)->create([
            'author_id' => $author->id,
            'like_info' => [$this->member->id]
        ]);

        $response = $this->getJson(route('articles.index'));

        $data = $response->json('data.0');
        $this->assertSame(1, $data['likeNum']);
        $this->assertSame(true, $data['isLiked']);
        $response->assertStatus(200);
        $this->assertStructure($response);
    }


    public function assertStructure(TestResponse $response)
    {
        $response->assertJsonStructure([
            'data' => [
                [
                    'id',
                    'title',
                    'content',
                    'likeNum',
                    'isLiked',
                    'image',
                    'isDeleted',
                    'author' => [
                        'id',
                        'account',
                        'name',
                        'email',
                        'avatar'
                    ]
                ]
            ],
            'links' => [
                'first',
                'last',
                'prev',
                'next'
            ],
            'meta' => [
                'current_page',
                'from',
                'last_page',
                'path',
                'per_page',
                'to',
                'total'
            ]
        ]);
    }

}