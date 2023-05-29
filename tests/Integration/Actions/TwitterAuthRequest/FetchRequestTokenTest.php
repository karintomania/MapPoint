<?php

namespace Tests\Integration\Actions\TwitterAuthRequest;

use App\Actions\TwitterAuthRequest\FetchRequestToken;
use Tests\TestCase;

class FetchRequestTokenTest extends TestCase
{
    public function test_fetchRequestToken_fetches_request_token()
    {
        $fetchRequestToken = resolve(FetchRequestToken::class);
        $result = $fetchRequestToken();

        $this->assertNotEmpty($result['oauth_token']);
        $this->assertNotEmpty($result['oauth_token_secret']);
        $this->assertEquals('true', $result['oauth_callback_confirmed']);
    }
}
