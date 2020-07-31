<?php


namespace Tests\Unit\Model;

use App\Member;
use Tests\TestCase;

class MemberTest extends TestCase
{
    public function testPasswordMutator()
    {
        $member = factory(Member::class)->create();
        $this->assertTrue($member->hasSetMutator('password'));
        $this->assertTrue($member->hasGetMutator('photo'));
    }
}
