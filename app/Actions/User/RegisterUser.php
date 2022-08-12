<?php

namespace App\Actions\User;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterUser {
    public function __invoke(array $data): User{

        $data = Validator::validate($data, [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'twitter_id' => '',
            'twitter_token' => '',
            'twitter_token_secret' => '',
        ]);

        return $user;
    }
}