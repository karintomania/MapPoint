<?php

namespace App\Actions\TwitterAuth;

use Abraham\TwitterOAuth\TwitterOAuth;
class FetchAccessToken {

    public TwitterOAuth $twitterOauth;

    public function __construct(TwitterOAuth $twitterOauth){
        $this->twitterOauth = $twitterOauth;
    }

    public function __invoke(array $data): array{

        $access_token = $this->twitterOauth->oauth("oauth/access_token", [
            "oauth_token" => $data['oauth_token'],
            "oauth_verifier" => $data['oauth_verifier'],
        ]);

        return $access_token;
    }
}