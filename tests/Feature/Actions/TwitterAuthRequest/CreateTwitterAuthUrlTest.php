<?php

namespace Tests\Feature\Actions\TwitterAuthRequest;

use App\Actions\TwitterAuthRequest\CreateTwitterAuthUrl;
use App\Actions\TwitterAuthRequest\FetchRequestToken;
use Mockery\MockInterface;
use Tests\TestCase;

class CreateTwitterAuthUrlTest extends TestCase
{
    public function test_createTwitterAuthUrl_fetches_access_token()
    {
        $fetchTokenResponse = ['oauth_token' => 'test-oauth-token'];
        $this->mock(FetchRequestToken::class, function (MockInterface $mock) use ($fetchTokenResponse) {
            $mock->shouldReceive(['__invoke' => $fetchTokenResponse]);
        });
        $createTwitterAuthUrl = resolve(CreateTwitterAuthUrl::class);
        $result = $createTwitterAuthUrl();

        $expectedUrl = sprintf(
            'https://api.twitter.com/oauth/authenticate?oauth_token=%s',
            $fetchTokenResponse['oauth_token']
        );
        $this->assertEquals($expectedUrl, $result);
    }
}
