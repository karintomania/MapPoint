<?php

namespace Tests\Integration\Actions\TwitterAuthRequest;

use Abraham\TwitterOAuth\TwitterOAuthException;
use App\Actions\TwitterAuthRequest\VerifyCredential;
use Tests\TestCase;

/**
 * php artisan test ./tests/Feature/Actions/TwitterAuth/VerifyCredentialTest.php
 */
class VerifyCredentialTest extends TestCase
{
    public function test_VerifyCredential_get_credential()
    {
        $verifyCredential = resolve(VerifyCredential::class);

        $data = [
            'oauth_token' => '1558049723507941376-o27qUaNct7mUbsmvxfFuIeeS8qtHIz',
            'oauth_token_secret' => 'VJCyWmcbBs9GoxeW989pp32jTxmGsFfhvRTbm49pqZFgl',
        ];

        $result = $verifyCredential($data);

        $this->assertNotEmpty($result->id);
        $this->assertNotEmpty($result->screen_name);
        $this->assertNotEmpty($result->name);
    }

    public function test_VerifyCredential_throw_error()
    {
        $verifyCredential = resolve(VerifyCredential::class);

        $data = [
            'oauth_token' => 'wrong_token',
            'oauth_token_secret' => 'wrong_token_secret',
        ];

        $this->expectException(TwitterOAuthException::class);
        $result = $verifyCredential($data);
    }
}
