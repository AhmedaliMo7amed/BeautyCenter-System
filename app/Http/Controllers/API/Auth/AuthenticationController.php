<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Traits\ConfirmationTrait;
use App\Traits\GeneralTrait;

class AuthenticationController extends Controller
{

    use GeneralTrait , ConfirmationTrait;

    public function login(StoreUserRequest $request)
    {
        return $this->sendCode($request);
    }

    public function resendCode(StoreUserRequest $request)
    {
        return $this->sendCode($request->validated());
    }

}
