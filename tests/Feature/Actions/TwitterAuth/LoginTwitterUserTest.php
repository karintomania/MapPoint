<?php

namespace Tests\Feature\Actions\TwitterAuth;

use App\Actions\TwitterAuth\LoginTwitterUser;
use App\Actions\TwitterAuthRequest\GetUserDetailsWithOAuthVerifier;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Mockery\MockInterface;
use Tests\TestCase;

/**
 * php artisan test ./tests/Feature/Actions/TwitterAuth/LoginTwitterUserTest.php
 */
class LoginTwitterUserTest extends TestCase
{
    use DatabaseMigrations;

    public function test_LoginTwitterUser_registers_new_user()
    {
        $userDetails = [
            'oauth_token' => 'test_token',
            'oauth_token_secret' => 'test_token_secret',
            'user_id' => '123456789',
            'screen_name' => 'Screen Name',
            'name' => 'Test Name',
        ];

        $this->mockGetUserDetailsWithOAuthVerifier($userDetails);

        $createTwitterAuthUrl = resolve(LoginTwitterUser::class);

        $request = [
            'oauth_token' => 'token',
            'oauth_verifier' => 'verifier',
        ];
        $resultUser = $createTwitterAuthUrl($request);

        $user = User::find($resultUser->id);

        $this->assertAuthenticatedAs($user);
        $this->assertEquals($userDetails['oauth_token'], $user->twitter_token);
        $this->assertEquals($userDetails['oauth_token_secret'], $user->twitter_token_secret);
        $this->assertEquals($userDetails['user_id'], $user->twitter_id);
        $this->assertEquals($userDetails['name'], $user->name);
    }

    public function test_LoginTwitterUser_logins_user()
    {
        $user = User::factory()->create();

        $userDetails = [
            'oauth_token' => $user->twitter_token.'111',
            'oauth_token_secret' => $user->twitter_token_secret.'222',
            'user_id' => $user->twitter_id,
            'screen_name' => 'screen_name',
            'name' => $user->name.'333',
        ];

        $this->mockGetUserDetailsWithOAuthVerifier($userDetails);

        $createTwitterAuthUrl = resolve(LoginTwitterUser::class);

        $request = [
            'oauth_token' => 'token',
            'oauth_verifier' => 'verifier',
        ];
        $resultUser = $createTwitterAuthUrl($request);

        $this->assertAuthenticatedAs($resultUser);
        $this->assertEquals($user->id, $resultUser->id);
        $this->assertEquals($userDetails['oauth_token'], $resultUser->twitter_token);
        $this->assertEquals($userDetails['oauth_token_secret'], $resultUser->twitter_token_secret);
        $this->assertEquals($userDetails['user_id'], $resultUser->twitter_id);
        $this->assertEquals($userDetails['name'], $resultUser->name);
    }

    private function mockGetUserDetailsWithOAuthVerifier(array $userDetails)
    {
        $this->mock(GetUserDetailsWithOAuthVerifier::class, function (MockInterface $mock) use ($userDetails) {
            $mock->shouldReceive(['__invoke' => $userDetails]);
        });
    }
}
