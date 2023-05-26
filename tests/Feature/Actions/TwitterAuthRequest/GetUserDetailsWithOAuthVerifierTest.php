<?php

namespace Tests\Feature\Actions\TwitterAuthRequest;

use Abraham\TwitterOAuth\TwitterOAuth;
use App\Actions\TwitterAuthRequest\FetchAccessToken;
use App\Actions\TwitterAuthRequest\GetUserDetailsWithOAuthVerifier;
use App\Actions\TwitterAuthRequest\VerifyCredential;
use Mockery\MockInterface;
use Tests\TestCase;

class GetUserDetailsWithOAuthVerifierTest extends TestCase
{
    public function test_GetUserDetailsWithOAuthVerifierTest_returns_user_details()
    {

        // mock TwitterOAuth classes
        $accessTokenResponse = [
            'oauth_token' => 'test_token',
            'oauth_token_secret' => 'test_token_secret',
            'user_id' => '123456789',
            'screen_name' => 'Screen Name',
        ];
        $userName = 'Test Name';

        $this->mockFetchAccessToken($accessTokenResponse);
        $this->mockVerifyCredential($accessTokenResponse, $userName);

        $input = [
            'oauth_token' => 'token',
            'oauth_token_secret' => 'token_secret',
        ];
        $GetUserDetailsWithOAuthVerifier = resolve(GetUserDetailsWithOAuthVerifier::class);
        $result = $GetUserDetailsWithOAuthVerifier($input);

        $this->assertEquals($accessTokenResponse['oauth_token'], $result['oauth_token']);
        $this->assertEquals($accessTokenResponse['oauth_token_secret'], $result['oauth_token_secret']);
        $this->assertEquals($accessTokenResponse['user_id'], $result['user_id']);
        $this->assertEquals($accessTokenResponse['screen_name'], $result['screen_name']);
        $this->assertEquals($userName, $result['name']);
    }

    private function mockFetchAccessToken(array $accessTokenResponse)
    {
        $this->mock(FetchAccessToken::class, function (MockInterface $mock) use ($accessTokenResponse) {
            $mock->shouldReceive(['__invoke' => $accessTokenResponse]);
        });
    }

    private function mockVerifyCredential(array $accessTokenResponse, string $userName)
    {
        $this->mock(VerifyCredential::class, function (MockInterface $mock) use ($accessTokenResponse, $userName) {
            $result = json_decode(<<<JSON
                {
                    "id": "{$accessTokenResponse['user_id']}",
                    "name": "$userName",
                    "screen_name": "{$accessTokenResponse['screen_name']}"
                }
            JSON);
            $mock->shouldReceive(['__invoke' => $result]);
        });
    }
}
