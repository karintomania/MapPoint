<?php

namespace App\Actions\TwitterAuth;

use App\Actions\TwitterAuthRequest\GetUserDetailsWithOAuthVerifier;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LoginTwitterUser
{
    public GetUserDetailsWithOAuthVerifier $getUserDetailsWithOAuthVerifier;

    public function __construct(
        GetUserDetailsWithOAuthVerifier $getUserDetailsWithOAuthVerifier,
    ) {
        $this->getUserDetailsWithOAuthVerifier = $getUserDetailsWithOAuthVerifier;
    }

    public function __invoke(array $data): User
    {
        $userDetails = call_user_func($this->getUserDetailsWithOAuthVerifier, $data);

        $user = User::updateOrCreate([
            'twitter_id' => $userDetails['user_id'],
        ], [
            'twitter_token' => $userDetails['oauth_token'],
            'twitter_token_secret' => $userDetails['oauth_token_secret'],
            'name' => $userDetails['name'],
            'email' => 'twitter_login'.$userDetails['user_id'],
            'password' => 'twitter_login',
        ]);
        Auth::login($user);

        return  $user;
    }
}
