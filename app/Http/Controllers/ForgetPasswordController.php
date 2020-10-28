<?php


namespace App\Http\Controllers;


use App\Http\Requests\ForgetPasswordRequest;
use App\Services\ForgetPasswordService;
use App\Services\ResetPasswordService;

class ForgetPasswordController extends Controller
{
    public function store(
        ForgetPasswordRequest $request,
        ForgetPasswordService $forgetPasswordService,
        ResetPasswordService $resetPasswordService
    )
    {
        $member = $forgetPasswordService->getMember($request);
        $newPassword = $forgetPasswordService->getTmpResetPassword();

        if ($resetPasswordService->updatePassword($newPassword, $member)) {
            $forgetPasswordService->sendMail($member, $newPassword);
        }

        return response(204);
    }
}