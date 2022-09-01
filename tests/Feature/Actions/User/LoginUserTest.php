<?php

namespace Tests\Feature\Actions\User;

use App\Actions\User\LoginUser;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

/**
 * to run this test
 * php artisan test ./tests/Feature/Actions/User/LoginUserTest.php 
 */
class LoginUserTest extends TestCase
{
    use DatabaseMigrations;

    public function test_login_user_logins_user(){
        /** @var LoginUser $loginUser */
        $loginUser = resolve(LoginUser::class);
        
        $user = User::factory()->create();

        $data = [
            'email' => $user->email,
            'password' => 'password',
        ];

        $this->assertNull($loginUser($data));
        $this->assertAuthenticatedAs($user);

    }

    public function test_login_user_shows_credential_error(){
        /** @var LoginUser $loginUser */
        $loginUser = resolve(LoginUser::class);
        
        $user = User::factory()->create();

        $data = [
            'email' => $user->email,
            'password' => 'wrong-password',
        ];

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The email and password is incorrect.');
        $loginUser($data);

    }


    public function test_email_is_required()
    {
        /** @var LoginUser $loginUser */
        $loginUser = resolve(LoginUser::class);

        $data = [
            'email' => '',
            'password' => 'pasword12345',
        ];

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The email field is required.');
        $loginUser($data);

    }

    public function test_email_should_be_in_right_format()
    {
        /** @var LoginUser $loginUser */
        $loginUser = resolve(LoginUser::class);

        $data = [
            'email' => 'test',
            'password' => 'pasword12345',
        ];

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The email must be a valid email address.');
        $loginUser($data);
    }

    Public function test_password_is_required()
    {
        /** @var LoginUser $loginUser */
        $loginUser = resolve(LoginUser::class);

        $data = [
            'email' => 'test@example.com',
            'password' => '',
        ];

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The password field is required.');
        $loginUser($data);
    }

}