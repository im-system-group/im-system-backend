<?php


namespace Tests\Feature;

use App\Member;
use Database\Factories\MemberFactory;
use Tests\TestCase;

class RegisterTest extends TestCase
{
   public function testStore()
   {
       $member = MemberFactory::new()->make();

       $password = 'testPassword';

       $response = $this->postJson(route('register.store'), [
           'name' => $member->name,
           'account' => $member->account,
           'email' => $member->email,
           'password' => $password,
       ]);

       $response->assertStatus(201);

       $this->assertDatabaseHas('members', [
           'name' => $member->name,
           'account' => $member->account,
           'email' => $member->email,
       ]);

       $this->assertTrue(password_verify($password,  Member::where('account', $member->account)->first()->password));
   }
}