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

        $this->markTestSkipped('This test requires an operation on twitter auth page.');

        $fetchAccessToken = resolve(FetchAccessToken::class);

        $data = [
            'oauth_token' => '9xNwFgAAAAABRJwMAAABgpHWXO8',
            'oauth_verifier' => '0uSJyCSeOtxGK58uPU6xYt4CH0kuRV5u',
        ];
        $result = $fetchAccessToken($data);

        $this->assertNotEmpty($result['oauth_token']);
        $this->assertNotEmpty($result['oauth_token_secret']);
        $this->assertNotEmpty($result['user_id']);
        $this->assertNotEmpty($result['screen_name']);

    }

}