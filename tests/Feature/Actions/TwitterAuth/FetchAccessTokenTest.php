<?php

namespace Tests\Feature\Actions\TwitterAuth;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Actions\TwitterAuth\FetchAccessToken;
use Tests\TestCase;
/**
 * php artisan test ./tests/Feature/Actions/TwitterAuth/
 */
class FetchAccessTokenTest extends TestCase
{
    // use DatabaseMigrations;

    public function test_fetchAccessToken_fetches_access_token(){
        $fetchAccessToken = resolve(FetchAccessToken::class);
        $result = $fetchAccessToken();

        $this->assertEquals(200, $result['status']);
        $this->assertNotEmpty($result['oauth_token']);
        $this->assertNotEmpty($result['oauth_token_secret']);
    }

}