<?php

namespace Tests\Feature\Actions\TwitterAuth;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Actions\TwitterAuth\CreateTwitterAuthUrl;
use Tests\TestCase;
/**
 * php artisan test ./tests/Feature/Actions/TwitterAuth/
 */
class CreateTwitterAuthUrlTest extends TestCase
{
    // use DatabaseMigrations;

    public function test_createTwitterAuthUrl_fetches_access_token(){
        $createTwitterAuthUrl = resolve(CreateTwitterAuthUrl::class);
        $result = $createTwitterAuthUrl();

        $this->assertMatchesRegularExpression('/https:\/\/api\.twitter\.com\/oauth\/authenticate\?oauth_token=.+/', $result);
    }

}