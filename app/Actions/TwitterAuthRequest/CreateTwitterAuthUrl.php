<?php

namespace App\Actions\TwitterAuthRequest;

use Abraham\TwitterOAuth\TwitterOAuth;

class CreateTwitterAuthUrl
{
    public TwitterOAuth $twitterOauth;

    public FetchRequestToken $fetchRequestToken;

    public function __construct(
        FetchRequestToken $fetchRequestToken,
        TwitterOAuth $twitterOAuth
    ) {
        $this->fetchRequestToken = $fetchRequestToken;
        $this->twitterOauth = $twitterOAuth;
    }

    public function __invoke(): string
    {
        $token = call_user_func($this->fetchRequestToken);

        $url = $this->twitterOauth->url('oauth/authenticate', [
            'oauth_token' => $token['oauth_token'],
        ]);

        return $url;
    }
}
