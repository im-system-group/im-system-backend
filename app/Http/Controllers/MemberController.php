<?php


namespace App\Http\Controllers;


use App\Http\Requests\Member\UpdateRequest;
use App\Http\Resources\MemberResource;
use App\Member;
use App\Services\Member\UpdateService;
use Illuminate\Support\Facades\Auth;

class MemberController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return (new MemberResource($user))
            ->response()
            ->setStatusCode(200);
    }

    public function update(Member $member, UpdateRequest $request, UpdateService $service)
    {
        $service->update($request, $member);
        return response('', 204);
    }
}