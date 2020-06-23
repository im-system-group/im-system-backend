<?php

namespace App\Http\Controllers;

use App\Http\Requests\register\StoreRequest;
use App\Services\RegisterService;

class RegisterController
{
    public function store(StoreRequest $request, RegisterService $service)
    {
        $service->store($request);
        return response('', 201);
    }
}