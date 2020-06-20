<?php

namespace App\Services;

use App\Http\Requests\register\StoreRequest;
use App\Member;
use Illuminate\Support\Facades\DB;

class RegisterService
{
    public function store(StoreRequest $request)
    {
        return DB::transaction(fn() => Member::create([
            'account' => $request->account,
            'password' => password_hash($request->password, PASSWORD_DEFAULT),
            'name' => $request->name,
            'email' => $request->email
        ]));
    }

}
