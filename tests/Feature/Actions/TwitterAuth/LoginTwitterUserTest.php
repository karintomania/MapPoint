<?php

namespace Tests\Feature\Actions\TwitterAuth;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Actions\TwitterAuth\LoginTwitterUser;
use App\Models\User;
use Tests\TestCase;
/**
 * php artisan test ./tests/Feature/Actions/TwitterAuth/LoginTwitterUserTest.php
 */
class LoginTwitterUserTest extends TestCase
{
    use DatabaseMigrations;

    public function test_LoginTwitterUser_registers_new_user(){
        $createTwitterAuthUrl = resolve(LoginTwitterUser::class);

        $data = [
            'oauth_token' => 'test_token',
            'oauth_token_secret' => 'test_token_secret',
            "user_id" => "123456789",
            "screen_name" => "Screen Name",
        ];

        $resultUser = $createTwitterAuthUrl($data);

        $user = User::find($resultUser->id);

        $this->assertAuthenticatedAs($user);
        $this->assertEquals($data['oauth_token'], $user->twitter_token);
        $this->assertEquals($data['oauth_token_secret'], $user->twitter_token_secret);
        $this->assertEquals($data['user_id'], $user->twitter_id);
        $this->assertEquals($data['screen_name'], $user->name);
    }


    public function test_LoginTwitterUser_logins_user(){

        $user = User::factory()->create();

        $createTwitterAuthUrl = resolve(LoginTwitterUser::class);

        $data = [
            'oauth_token' => $user->twitter_token . '111',
            'oauth_token_secret' => $user->twitter_token_secret . '222',
            "user_id" => $user->twitter_id,
            "screen_name" => $user->name . '3333',
        ];

        $resultUser = $createTwitterAuthUrl($data);

        $user = User::find($resultUser->id);

        $this->assertAuthenticatedAs($user);
        $this->assertEquals($data['oauth_token'], $user->twitter_token);
        $this->assertEquals($data['oauth_token_secret'], $user->twitter_token_secret);
        $this->assertEquals($data['user_id'], $user->twitter_id);
        $this->assertEquals($data['screen_name'], $user->name);
    }
}