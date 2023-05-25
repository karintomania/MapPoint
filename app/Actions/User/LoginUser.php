<?php

namespace App\Actions\User;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class LoginUser
{
    public function __invoke(array $data): void
    {
        $credentials = Validator::validate($data, [
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        if (! Auth::attempt($credentials)) {
            throw ValidationException::withMessages([
                'email' => 'The email and password is incorrect.',
            ]);
        }
    }
}
