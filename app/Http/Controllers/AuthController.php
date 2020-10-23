<?php


namespace App\Http\Controllers;


use App\Http\Requests\LoginRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Resources\TokenResource;
use App\Member;
use App\Services\ResetPasswordService;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function store(LoginRequest $request)
    {
        $member = Member::where('account', $request->account)->first();

        if(!Auth::attempt($request->only('account', 'password'))) {
            return response('', 401);
        }

        return (new TokenResource($member->createToken($member->name)))
            ->response()
            ->setStatusCode(201);
    }

    public function destroy()
    {
        $user = Auth::user();
        $user->tokens()->where('id', $user->currentAccessToken()->id)->delete();
        return response('', 204);
    }

    public function passwordReset(ResetPasswordRequest $request, ResetPasswordService $service)
    {
        $member = Auth::user();
        $service->updatePassword($request->password, $member);
        return response('', 204);
    }
}