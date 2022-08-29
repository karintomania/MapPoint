<?php

namespace App\Actions\TwitterAuthRequest;

use Abraham\TwitterOAuth\TwitterOAuth;
use App\Actions\TwitterAuthRequest\VerifyCredential;

class GetUserDetailsWithOAuthVerifier {

    public TwitterOAuth $twitterOauth;
    private FetchAccessToken $fetchAccessToken;
    private VerifyCredential $verifyCredential;

    public function __construct(
        TwitterOAuth $twitterOauth,
        FetchAccessToken $fetchAccessToken,
        VerifyCredential $verifyCredential,
        ){
        $this->twitterOauth = $twitterOauth;
        $this->fetchAccessToken = $fetchAccessToken;
        $this->verifyCredential = $verifyCredential;
    }

    public function __invoke(array $data): array{

        $accessTokenResponse = call_user_func($this->fetchAccessToken, $data);

        $verifiedCredential = call_user_func($this->verifyCredential, $accessTokenResponse);

        $userInfo = $accessTokenResponse;
        $userInfo['name'] = $verifiedCredential->name;
        return $userInfo;
    }
}