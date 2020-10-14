<?php


namespace App\Util;


use Laravel\Sanctum\PersonalAccessToken;

trait CheckToken
{
    public function getMember(?string $bearerToken)
    {
        if ($bearerToken) {
            return PersonalAccessToken::findToken($bearerToken)->tokenable_id;
        }

        return null;
    }

}