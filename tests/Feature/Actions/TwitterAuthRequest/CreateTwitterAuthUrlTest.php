<?php

namespace Tests\Feature\Actions\TwitterAuthRequest;

use App\Actions\TwitterAuthRequest\CreateTwitterAuthUrl;
use Tests\TestCase;

class CreateTwitterAuthUrlTest extends TestCase
{

    public function test_createTwitterAuthUrl_fetches_access_token()
    {
        $createTwitterAuthUrl = resolve(CreateTwitterAuthUrl::class);
        $result = $createTwitterAuthUrl();

        $this->assertMatchesRegularExpression('/https:\/\/api\.twitter\.com\/oauth\/authenticate\?oauth_token=.+/', $result);
    }
}
