<?php

namespace Tests\Feature\Actions\TwitterAuth;

use App\Actions\TwitterAuth\FetchRequestToken;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

/**
 * php artisan test ./tests/Feature/Actions/TwitterAuth/
 */
class FetchRequestTokenTest extends TestCase
{
    // use DatabaseMigrations;

    public function test_fetchRequestToken_fetches_request_token(){
        $fetchRequestToken = resolve(FetchRequestToken::class);
        $result = $fetchRequestToken();

        $this->assertEquals(200, $result['status']);
        $this->assertNotEmpty($result['oauth_token']);
        $this->assertNotEmpty($result['oauth_token_secret']);
    }

}