<?php


namespace Tests\Feature\Auth;;


use Database\Factories\MemberFactory;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;
use Tests\Feature\ActingLogin;

class ResetPasswordTest extends ActingLogin
{
    public function testResetPassword()
    {
        $oldPassword = 'test123';
        $newPassword = 'new456';

        $this->member = Sanctum::actingAs(MemberFactory::new()->create([
            'password' => $oldPassword,
        ]), ['*']);

        $response = $this->patchJson(route('auth.passwordReset'), [
            'old_password' => $oldPassword,
            'password' => $newPassword,
            'confirm_password' => $newPassword
        ]);

        $response->assertStatus(204);
        $this->member->refresh();
        $this->assertTrue(Hash::check($newPassword, $this->member->password));
    }

}