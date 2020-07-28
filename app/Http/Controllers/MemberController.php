<?php


namespace App\Http\Controllers;


use App\Http\Requests\Member\UpdateRequest;
use App\Http\Resources\MemberResource;
use App\Member;
use App\Services\Member\UpdateService;
use Illuminate\Support\Facades\Auth;

class MemberController
{
    public function index()
    {
        $user = Auth::user();
        return response(new MemberResource($user));
    }

    public function update(Member $member, UpdateRequest $request, UpdateService $service)
    {
        $service->update($request, $member);
        return response('', 204);
    }
}