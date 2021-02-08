<?php


namespace Tests\Feature;

use App\Member;
use Database\Factories\MemberFactory;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

abstract class ActingLogin extends TestCase
{
    protected Member $member;

    protected function setUp(): void
    {
        parent::setUp();
        $this->member = Sanctum::actingAs(MemberFactory::new()->create(), ['*']);
    }
}