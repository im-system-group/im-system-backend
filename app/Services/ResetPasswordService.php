<?php


namespace App\Services;


use App\Member;
use Illuminate\Support\Facades\DB;

class ResetPasswordService
{
    public function updatePassword(string $password, Member $member)
    {
        $member->password = $password;

        return DB::transaction(function () use ($member) {
            return $member->save();
        });
    }

}