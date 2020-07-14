<?php


namespace App\Http\Controllers;


use App\Http\Requests\LoginRequest;
use App\Http\Resources\TokenResource;
use App\Member;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function store(LoginRequest $request)
    {
        $member = Member::where('account', $request->account)->first();

        if(!Hash::check($request->password, $member->password)) {
            return response('', 401);
        }

        return (new TokenResource($member->createToken($member->name)))
            ->response()
            ->setStatusCode(201);
    }
}