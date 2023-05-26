<?php

namespace Tests\Feature\Actions\TwitterAuthRequest;

use Abraham\TwitterOAuth\TwitterOAuth;
use App\Actions\TwitterAuthRequest\FetchAccessToken;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Mockery\MockInterface;
use Tests\TestCase;

class FetchAccessTokenTest extends TestCase
{
    // use DatabaseMigrations;

    public function test_fetchAccessToken_fetches_access_token()
    {
        $this->mock(TwitterOAuth::class, function (MockInterface $mock) {
            $result = [
                'oauth_token' => 'token',
                'oauth_token_secret' => 'token_secret',
                'user_id' => 'id_xxxx',
                'screen_name' => 'screen_name',
            ];
            $mock->shouldReceive(['oauth' => $result]);
        });

        $fetchAccessToken = resolve(FetchAccessToken::class);

        $data = [
            'oauth_token' => 'xxxxxxx',
            'oauth_verifier' => 'yyyyyyyy',
        ];

        $result = $fetchAccessToken($data);

        $this->assertNotEmpty($result['oauth_token']);
        $this->assertNotEmpty($result['oauth_token_secret']);
        $this->assertNotEmpty($result['user_id']);
        $this->assertNotEmpty($result['screen_name']);
    }
}
