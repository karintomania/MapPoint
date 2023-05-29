<?php

namespace Tests\Feature\Actions\TwitterAuthRequest;

use Abraham\TwitterOAuth\TwitterOAuth;
use Abraham\TwitterOAuth\TwitterOAuthException;
use App\Actions\TwitterAuthRequest\VerifyCredential;
use Mockery\MockInterface;
use Tests\TestCase;

/**
 * php artisan test ./tests/Feature/Actions/TwitterAuth/VerifyCredentialTest.php
 */
class VerifyCredentialTest extends TestCase
{
    public function test_VerifyCredential_get_credential()
    {
        $data = [
            'oauth_token' => 'xxxxxx',
            'oauth_token_secret' => 'yyyyyy',
        ];

        $mockResult = json_decode(<<<JSON
        {
            "id": 9999999999999999999,
            "name": "test name",
            "screen_name": "screen name"
        }
        JSON);

        $this->mock(TwitterOAuth::class, function(MockInterface $mock) use ($data, $mockResult){
            $mock->shouldReceive('setOauthToken')
            ->withArgs([$data['oauth_token'], $data['oauth_token_secret']]);

            $mock->shouldReceive('get')
            ->withArgs(['account/verify_credentials'])
            ->andReturn($mockResult);
        });

        $verifyCredential = resolve(VerifyCredential::class);


        $result = $verifyCredential($data);

        $this->assertEquals($mockResult->id, $result->id);
        $this->assertEquals($mockResult->screen_name, $result->screen_name);
        $this->assertEquals($mockResult->name, $result->name);
    }

    public function test_VerifyCredential_throw_error()
    {

        $data = [
            'oauth_token' => 'wrong_token',
            'oauth_token_secret' => 'wrong_token_secret',
        ];

        $mockResult = json_decode(<<<JSON
        {
            "errors": [
                {
                    "message": "test error",
                    "code": "999"
                }
            ]
        }
        JSON);

        $this->mock(TwitterOAuth::class, function(MockInterface $mock) use ($data, $mockResult){
            $mock->shouldReceive('setOauthToken')
            ->withArgs([$data['oauth_token'], $data['oauth_token_secret']]);

            $mock->shouldReceive('get')
            ->withArgs(['account/verify_credentials'])
            ->andReturn($mockResult);
        });

        $verifyCredential = resolve(VerifyCredential::class);

        $this->expectException(TwitterOAuthException::class);
        $result = $verifyCredential($data);
    }
}
