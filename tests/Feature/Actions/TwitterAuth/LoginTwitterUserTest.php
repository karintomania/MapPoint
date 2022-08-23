<?php

namespace Tests\Feature\Actions\TwitterAuth;

use App\Actions\TwitterAuth\FetchAccessToken;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Actions\TwitterAuth\LoginTwitterUser;
use App\Actions\TwitterAuth\VerifyCredential;
use App\Models\User;
use Mockery\MockInterface;
use Tests\TestCase;
/**
 * php artisan test ./tests/Feature/Actions/TwitterAuth/LoginTwitterUserTest.php
 */
class LoginTwitterUserTest extends TestCase
{
    use DatabaseMigrations;

    public function test_LoginTwitterUser_registers_new_user(){

        $accessTokenResponse = [
            'oauth_token' => 'test_token',
            'oauth_token_secret' => 'test_token_secret',
            "user_id" => "123456789",
            "screen_name" => "Screen Name",
        ];
        $userName = "Test Name";

        $this->mockFetchAccessToken($accessTokenResponse);
        $this->mockVerifyCredential($accessTokenResponse, $userName);

        $request = [
            'oauth_token' => 'token',
            'oauth_verifier' => 'verifier',
        ];

        $createTwitterAuthUrl = resolve(LoginTwitterUser::class);
        $resultUser = $createTwitterAuthUrl($request);

        $user = User::find($resultUser->id);

        $this->assertAuthenticatedAs($user);
        $this->assertEquals($accessTokenResponse['oauth_token'], $user->twitter_token);
        $this->assertEquals($accessTokenResponse['oauth_token_secret'], $user->twitter_token_secret);
        $this->assertEquals($accessTokenResponse['user_id'], $user->twitter_id);
        $this->assertEquals($userName, $user->name);
    }


    public function test_LoginTwitterUser_logins_user(){

        $user = User::factory()->create();

        $accessTokenResponse = [
            'oauth_token' => $user->twitter_token . '111',
            'oauth_token_secret' => $user->twitter_token_secret . '222',
            "user_id" => $user->twitter_id,
            "screen_name" => 'screen_name',
        ];
        $userName = $user->name . '333';

        $this->mockFetchAccessToken($accessTokenResponse);
        $this->mockVerifyCredential($accessTokenResponse, $userName);

        $request = [
            'oauth_token' => 'token',
            'oauth_verifier' => 'verifier',
        ];

        $createTwitterAuthUrl = resolve(LoginTwitterUser::class);
        $resultUser = $createTwitterAuthUrl($request);

        $this->assertAuthenticatedAs($resultUser);
        $this->assertEquals($user->id, $resultUser->id);
        $this->assertEquals($accessTokenResponse['oauth_token'], $resultUser->twitter_token);
        $this->assertEquals($accessTokenResponse['oauth_token_secret'], $resultUser->twitter_token_secret);
        $this->assertEquals($accessTokenResponse['user_id'], $resultUser->twitter_id);
        $this->assertEquals($userName, $resultUser->name);
    }

    private function mockFetchAccessToken(array $accessTokenResponse){
        $this->mock(FetchAccessToken::class, function (MockInterface $mock) use ($accessTokenResponse) {
            $mock->shouldReceive(['__invoke' => $accessTokenResponse]);
        });
    }

    private function mockVerifyCredential(array $accessTokenResponse, string $userName){
        $this->mock(VerifyCredential::class, function (MockInterface $mock) use ($accessTokenResponse, $userName) {
            $result = json_decode(<<<JSON
                {
                    "id": "{$accessTokenResponse['user_id']}",
                    "name": "$userName",
                    "screen_name": "{$accessTokenResponse['screen_name']}"
                }
            JSON);
            $mock->shouldReceive(['__invoke' => $result]);
        });
    }

}