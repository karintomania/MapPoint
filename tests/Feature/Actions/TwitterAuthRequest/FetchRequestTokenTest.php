<?php

namespace Tests\Feature\Actions\TwitterAuthRequest;

use Abraham\TwitterOAuth\TwitterOAuth;
use App\Actions\TwitterAuthRequest\FetchRequestToken;
use Mockery\MockInterface;
use Tests\TestCase;

class FetchRequestTokenTest extends TestCase
{
    // use DatabaseMigrations;

    public function test_fetchAccessToken_fetches_access_token()
    {
        $mockResult = [
            'oauth_token' => 'xxxxxxx',
            'oauth_token_secret' => 'yyyyyyyy',
            'oauth_callback_confirmed' => 'true',
        ];
        $this->mock(TwitterOAuth::class, function (MockInterface $mock) use ($mockResult) {
            $result = $mockResult;
            $mock->shouldReceive(['oauth' => $result])
            ->withArgs(['oauth/request_token',
                ['oauth_callback' => config('services.twitter.redirect')], ]);
        });

        $fetchRequestToken = resolve(FetchRequestToken::class);

        $result = $fetchRequestToken();

        $this->assertEquals($mockResult['oauth_token'], $result['oauth_token']);
        $this->assertEquals($mockResult['oauth_token_secret'], $result['oauth_token_secret']);
        $this->assertEquals($mockResult['oauth_callback_confirmed'], $result['oauth_callback_confirmed']);
    }
}
