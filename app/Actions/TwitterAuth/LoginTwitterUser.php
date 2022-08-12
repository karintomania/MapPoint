<?php

namespace App\Actions\TwitterAuth;

use Abraham\TwitterOAuth\TwitterOAuth;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LoginTwitterUser {

    public FetchAccessToken $fetchAccessToken;

    public function __construct(FetchAccessToken $fetchAccessToken){
        $this->fetchAccessToken = $fetchAccessToken;
    }

    public function __invoke(array $data): User{

        $accessToken = call_user_func($this->fetchAccessToken, $data);

        // verify token

        /** @var User $user */
        $user = User::updateOrCreate(
            ['twitter_id' => $accessToken['user_id']],
            [
                'name' => $accessToken['screen_name'],
                'email' => 'twitter_login_'.$accessToken['user_id'],
                'password' => 'twitter_login',
                'twitter_token' => $accessToken['oauth_token'],
                'twitter_token_secret' => $accessToken['oauth_token_secret'],
            ]
        );

        dump($user->attributesToArray());

        Auth::login($user);

        return  $user;
    }
}