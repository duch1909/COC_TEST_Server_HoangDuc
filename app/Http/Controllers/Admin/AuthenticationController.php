<?php

namespace App\Http\Controllers\Admin;

use App\Concerns\Token;
use App\Exceptions\AuthException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Authentication\LoginRequest;

class AuthenticationController extends Controller
{
    public function login(LoginRequest $request)
    {
        $validated = $request->validated();

        $token = Token::make('users', 'attempt', $validated);
        if (!$token->getToken()) {
            throw AuthException::invalidCredentials();
        }

        return response()->success($token);
    }
}
