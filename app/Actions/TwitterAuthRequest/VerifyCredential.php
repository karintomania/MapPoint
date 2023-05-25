<?php

namespace App\Actions\TwitterAuthRequest;

use Abraham\TwitterOAuth\TwitterOAuth;
use Abraham\TwitterOAuth\TwitterOAuthException;
use Illuminate\Support\Facades\Log;
use stdClass;

class VerifyCredential
{
    public TwitterOAuth $twitterOAuth;

    public function __construct(TwitterOAuth $twitterOAuth)
    {
        $this->twitterOAuth = $twitterOAuth;
    }

    public function __invoke(array $data): stdClass
    {
        $this->twitterOAuth->setOauthToken($data['oauth_token'], $data['oauth_token_secret']);

        $result = $this->twitterOAuth->get('account/verify_credentials');
        // process error

        if (isset($result->errors)) {
            $error = $result->errors[0];
            Log::error(json_encode($result->errors));
            throw new TwitterOAuthException($error->message, $error->code);
        }

        return $result;
    }
}
