<?php

namespace App\Actions\TwitterAuth;

class CreateTwitterAuthUrl {

    public function __invoke(): string{

        return 'https://api.twitter.com/oauth/authenticate?oauth_token=xxx';
    }
}
