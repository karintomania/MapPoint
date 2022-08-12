<?php

namespace App\Actions\TwitterAuth;

use Abraham\TwitterOAuth\TwitterOAuth;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LoginTwitterUser {

    public function __invoke(array $data): User{
        /** @var User $user */
        $user = User::updateOrCreate(
            ['twitter_id' => $data['user_id']],
            [
                'name' => $data['screen_name'],
                'email' => 'twitter_login_'.$data['user_id'],
                'password' => 'twitter_login',
                'twitter_token' => $data['oauth_token'],
                'twitter_token_secret' => $data['oauth_token_secret'],
            ]
        );

        dump($user->attributesToArray());

        Auth::login($user);

        return  $user;
    }
}