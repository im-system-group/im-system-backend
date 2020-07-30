<?php


namespace Member;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\Feature\ActingLogin;

class UpdateTest extends ActingLogin
{
    public function testUpdate()
    {
        Storage::fake();

        $newName = 'test';
        $newEmail = 'test@test.com.tw';
        $newAvatar = UploadedFile::fake()->image('test.png');

        $response = $this->patchJson(route('member.update', [
            'member' => $this->member->id
        ]), [
            'name' => $newName,
            'email' => $newEmail,
            'avatar' => $newAvatar
        ]);

        $response->assertStatus(204);

        $this->assertDatabaseHas('members', [
            'id' => $this->member->id,
            'name' => $newName,
            'email' => $newEmail
        ]);

        $avatar = $this->member->refresh()->photo;

        Storage::disk('public')->assertExists($avatar);
    }

}