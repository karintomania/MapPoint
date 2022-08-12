<?php

namespace Tests\Feature\Http\Controllers\Auth;

use App\Actions\TwitterAuth\FetchAccessToken;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Mockery\MockInterface;
use Tests\TestCase;

/**
 * to run the test
 * php artisan test ./tests/Feature/Http/Controllers/Auth/TwitterAuthControllerTest.php 
 */
class TwitterAuthControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function test_login_redirects_to_twitter_auth(){
        $this->markTestSkipped();
        $response = $this->get(route('twitter.login'));

        $response->assertRedirectContains('https://api.twitter.com/oauth/authenticate');

    }

    public function test_redirect_register_new_user(){

        $userInfo = [
            'oauth_token' => 'test_token',
            'oauth_token_secret' => 'test_token_secret',
            "user_id" => "123456789",
            "screen_name" => "Screen Name",
        ];
        $mock = $this->mock(FetchAccessToken::class, function (MockInterface $mock) use($userInfo) {
            $mock->shouldReceive(['__invoke' => $userInfo]);
        });

        $url = '/twitter-redirect/?oauth_token=xxxxxx&oauth_verifier=xxxxxx';
        $response = $this->get($url);

        $user = User::first();

        $this->assertEquals($userInfo['screen_name'], $user->name);
        $this->assertEquals($userInfo['user_id'], $user->twitter_id);
        $this->assertEquals($userInfo['oauth_token'], $user->twitter_token);
        $this->assertEquals($userInfo['oauth_token_secret'], $user->twitter_token_secret);

    }
    

}