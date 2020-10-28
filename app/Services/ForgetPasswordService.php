<?php


namespace App\Services;


use App\Http\Requests\ForgetPasswordRequest;
use App\Member;
use App\Notifications\ForgotPassword;
use Illuminate\Notifications\Notification;

class ForgetPasswordService
{
    public function getMember(ForgetPasswordRequest $request) :Member
    {
        return Member::whereAccount($request->account)
            ->whereEmail($request->email)
            ->first();
    }

    public function getTmpResetPassword() :string
    {
        $newPasswordLength = 15;
        $newPassword = '';
        $word = 'abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $len = strlen($word);

        for($i = 0; $i < $newPasswordLength; $i++)
        {
            $newPassword .= $word[rand() % $len];
        }

        return $newPassword;
    }

    public function sendMail(Member $member, string $newPassword)
    {
        Notification::route('mail', $member->email)
            ->notify(new ForgotPassword($member, $newPassword));
    }
}