<?php


namespace Tests\Unit\Model;

use App\Member;
use Database\Factories\MemberFactory;
use Tests\TestCase;

class MemberTest extends TestCase
{
    public function testPasswordMutator()
    {
        $member = MemberFactory::new()->create();
        $this->assertTrue($member->hasSetMutator('password'));
    }
}
