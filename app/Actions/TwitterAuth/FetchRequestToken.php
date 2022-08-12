<?php

namespace App\Actions\TwitterAuth;

class FetchRequestToken {
    public function __invoke(): array{

        return [
            'status' => 200,
            'oauth_token' => 200,
            'oauth_token_secret' => 200,
            'oauth_callback_confirmed' => true,
        ];
    }
}