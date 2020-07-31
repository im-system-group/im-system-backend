<?php


namespace Tests\Feature;

use App\Member;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

abstract class ActingLogin extends TestCase
{
    protected Member $member;

    protected function setUp(): void
    {
        parent::setUp();
        $this->member = Sanctum::actingAs(factory(Member::class)->create(), ['*']);
    }
}