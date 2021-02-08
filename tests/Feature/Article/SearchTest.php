<?php


namespace Article;


use Database\Factories\ArticleFactory;
use Database\Factories\MemberFactory;
use Illuminate\Testing\TestResponse;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class SearchTest extends TestCase
{
    public function testIndex()
    {
        ArticleFactory::new()->for(MemberFactory::new(), 'author')->create();

        $response = $this->getJson(route('articles.index'));

        $response->assertStatus(200);
        $this->assertStructure($response);
    }

    public function testLike()
    {
        $member = Sanctum::actingAs(MemberFactory::new()->create(), ['*']);

        $token = $member->createToken($member->name)->plainTextToken;

        ArticleFactory::new()->for(MemberFactory::new(), 'author')->create([
            'like_info' => [$member->id]
        ]);

        $response = $this->withToken($token)
            ->getJson(route('articles.index'));

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