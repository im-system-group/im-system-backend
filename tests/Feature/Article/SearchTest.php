<?php


namespace Article;


use App\Article;
use App\Member;
use Illuminate\Testing\TestResponse;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class SearchTest extends TestCase
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

        $member = Sanctum::actingAs(factory(Member::class)->create(), ['*']);

        $token = $member->createToken($member->name)->plainTextToken;

        factory(Article::class)->create([
            'author_id' => $author->id,
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