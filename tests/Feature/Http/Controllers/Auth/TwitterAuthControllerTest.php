<?php

namespace Tests\Feature\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Actions\TwitterAuthRequest\GetUserDetailsWithOAuthVerifier;
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
        $response = $this->get(route('twitter.login'));

        $response->assertRedirectContains('https://api.twitter.com/oauth/authenticate');

    }

    public function test_redirect_registers_new_user(){

        $userDetails = [
            'oauth_token' => 'test_token',
            'oauth_token_secret' => 'test_token_secret',
            "user_id" => "123456789",
            "screen_name" => "Screen Name",
            "name" => "Test Name",
        ];

        $this->mockGetUserDetailsWithOAuthVerifier($userDetails);

        $url = route('twitter.redirect') . '?oauth_token=xxxxxx&oauth_verifier=yyyyyy';

        $response = $this->get($url);

        $user = User::first();

        $this->assertAuthenticatedAs($user);
        $this->assertEquals($userDetails['name'], $user->name);
        $this->assertEquals($userDetails['oauth_token'], $user->twitter_token);
        $this->assertEquals($userDetails['oauth_token_secret'], $user->twitter_token_secret);
        $this->assertEquals($userDetails['user_id'], $user->twitter_id);

        $response->assertRedirect('/');

    }

    public function test_redirect_logins_existing_user(){
        $user = User::factory()->create();

        $userDetails = [
            'oauth_token' => 'test_token',
            'oauth_token_secret' => 'test_token_secret',
            "user_id" => $user->twitter_id,
            "screen_name" => "Screen Name",
            "name" => $user->name,
        ];

        $this->mockGetUserDetailsWithOAuthVerifier($userDetails);

        $url = route('twitter.redirect') . '?oauth_token=xxxxxx&oauth_verifier=yyyyyy';

        $response = $this->get($url);

        $user = User::find($user->id);
        $this->assertAuthenticatedAs($user);
        $this->assertEquals($userDetails['name'], $user->name);
        $this->assertEquals($userDetails['oauth_token'], $user->twitter_token);
        $this->assertEquals($userDetails['oauth_token_secret'], $user->twitter_token_secret);
        $this->assertEquals($userDetails['user_id'], $user->twitter_id);

        $response->assertRedirect('/');

    }

    private function mockGetUserDetailsWithOAuthVerifier(array $userDetails){
        $this->mock(GetUserDetailsWithOAuthVerifier::class, function (MockInterface $mock) use ($userDetails) {
            $mock->shouldReceive(['__invoke' => $userDetails]);
        });
    }

}