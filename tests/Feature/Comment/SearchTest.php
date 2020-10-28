<?php


namespace Comment;


use App\Article;
use App\Comment;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class SearchTest extends TestCase
{
    public function testIndex()
    {
        $amount = 11;
        $perPage = 20;
        $article = factory(Article::class)->create();
        factory(Comment::class, $amount)->create([
            'article_id' => $article
        ]);

        $response = $this->getJson(route('articles.comments.index', [
            $article->id,
            'perPage' => $perPage
        ]));

        $response->assertStatus(200);
        $this->assertSame($response->json('meta.total'), $amount);
        $this->assertSame($response->json('meta.last_page'), (int) ceil($amount/$perPage));
        $this->assertStructure($response);
    }

    public function assertStructure(TestResponse $response)
    {
        $response->assertJsonStructure([
            'data' => [
                [
                    'id',
                    'content',
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