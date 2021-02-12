<?php


namespace Member;

use Tests\Feature\ActingLogin;

class IndexTest extends ActingLogin
{
   public function testIndex()
   {
       $response = $this->getJson(route('member.index'));
       $response->assertStatus(200);

       $response->assertJson([
           'data' => [
               'id' => $this->member->id,
               'account' => $this->member->account,
               'name' => $this->member->name,
               'email' => $this->member->email,
               'avatar' => $this->member->avatar,
               'color' => $this->member->color
           ]
       ]);
   }
}