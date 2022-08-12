<?php

namespace App\Actions\TwitterAuth;

use Abraham\TwitterOAuth\TwitterOAuth;

class FetchRequestToken {

    public TwitterOAuth $twitterOauth;

    public function __construct(TwitterOAuth $twitterOauth){
        $this->twitterOauth = $twitterOauth;
    }

    public function __invoke(): array{

        $response = $this->twitterOauth->oauth('oauth/request_token', [
            'oauth_callback' => config('services.twitter.redirect'),
        ]);

        dump($response);

        return  $response;
    }
}