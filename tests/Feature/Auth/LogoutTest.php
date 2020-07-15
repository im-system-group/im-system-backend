<?php


namespace Tests\Feature\Auth;

use App\Member;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class LogoutTest extends TestCase
{
    public function testLogout()
    {
        $member = Sanctum::actingAs(factory(Member::class)->create(), ['*']);

        $response = $this->deleteJson(route('logout.destroy'));

        $response->assertStatus(204);

        $this->assertDatabaseMissing('personal_access_tokens', [
            'tokenable_type' => Member::class,
            'tokenable_id' => $member->id,
            'name' => $member->name
        ]);
    }
}