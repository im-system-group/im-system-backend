<?php

namespace Tests\Feature\Auth;

use App\Member;
use Database\Factories\MemberFactory;
use Tests\TestCase;

class LoginTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testLogin()
    {
        $password = 'test123';

        $member = MemberFactory::new()->create([
            'password' => $password
        ]);

        $response = $this->postJson(route('login.store') , [
            'account' => $member->account,
            'password' => $password
        ]);

        $response->assertStatus(201);

        $response->assertJsonStructure([
            'data' => [
                'token'
            ]
        ]);

        $this->assertDatabaseHas('personal_access_tokens', [
            'tokenable_type' => Member::class,
            'tokenable_id' => $member->id,
            'name' => $member->name
        ]);
    }
}
