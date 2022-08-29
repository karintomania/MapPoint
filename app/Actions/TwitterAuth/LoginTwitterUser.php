<?php

namespace App\Actions\TwitterAuth;

use Abraham\TwitterOAuth\TwitterOAuth;
use App\Actions\TwitterAuthRequest\FetchAccessToken;
use App\Actions\TwitterAuthRequest\VerifyCredential;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LoginTwitterUser {

    public FetchAccessToken $fetchAccessToken;
    public VerifyCredential $verifyCredential;

    public function __construct(
        FetchAccessToken $fetchAccessToken,
        VerifyCredential $verifyCredential,
        ){
        $this->fetchAccessToken = $fetchAccessToken;
        $this->verifyCredential = $verifyCredential;
    }

    public function __invoke(array $data): User{

        $accessToken = call_user_func($this->fetchAccessToken, $data);

        $userDetails = call_user_func($this->verifyCredential, $accessToken);

        $user = User::updateOrCreate([
            'twitter_id' => $accessToken['user_id']
        ],[
            'twitter_token' => $accessToken['oauth_token'],
            'twitter_token_secret' => $accessToken['oauth_token_secret'],
            'name' => $userDetails->name,
            'email' => 'twitter_login'.$accessToken['user_id'],
            'password' => 'twitter_login',
        ]);
        Auth::login($user);

        return  $user;
    }
}