<?php

namespace Tests\Feature\Actions\TwitterAuthRequest;

use App\Actions\TwitterAuthRequest\FetchRequestToken;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

/**
 * php artisan test ./tests/Feature/Actions/TwitterAuth/
 */
class FetchRequestTokenTest extends TestCase
{
    // use DatabaseMigrations;

    public function test_fetchRequestToken_fetches_request_token()
    {
        $fetchRequestToken = resolve(FetchRequestToken::class);
        $result = $fetchRequestToken();

        $this->assertNotEmpty($result['oauth_token']);
        $this->assertNotEmpty($result['oauth_token_secret']);
        $this->assertEquals('true', $result['oauth_callback_confirmed']);
    }
}
