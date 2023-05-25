<?php

namespace Tests\Feature\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

/**
 * to run the test
 * php artisan test ./tests/Feature/Http/Controllers/Auth/LoginControllerTest.php
 */
class LoginControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function test_login_shows_login()
    {
        $response = $this->get(route('login'));

        $response->assertOk();
        $response->assertViewIs('auth.login');
        $response->assertSeeInOrder([
            'name="email"',
            'name="password"',
        ], $escape = false);
    }

    public function test_auth_authorises_user()
    {
        $user = User::factory()->create();

        $data = [
            'email' => $user->email,
            'password' => 'password',
        ];

        session()->setPreviousUrl(route('login'));
        $response = $this->post(route('auth.auth'), $data);

        $this->assertAuthenticatedAs($user);

        return $response;
    }

    /**
     * @depends test_auth_authorises_user
     */
    public function test_auth_redirects_to_index_on_success(TestResponse $response)
    {
        $response->assertRedirect('/');
    }

    public function test_auth_validates_invalid_input()
    {
        $data = [
            'email' => 'test',
            'password' => 'password',
        ];

        session()->setPreviousUrl(route('login'));
        $response = $this->post(route('auth.auth'), $data);

        $response->assertRedirect(route('login'));
        $response->assertInvalid(['email' => 'The email must be a valid email address.']);
    }

    public function test_auth_validates_incorrect_credential()
    {
        $data = [
            'email' => 'test@example.com',
            'password' => 'password',
        ];

        session()->setPreviousUrl(route('login'));
        $response = $this->post(route('auth.auth'), $data);

        $response->assertRedirect(route('login'));
        $response->assertInvalid(['email' => 'The email and password is incorrect.']);
    }

    public function test_auth_shows_invalid_input_message()
    {
        $data = [
            'email' => 'test@example.com',
            'password' => 'password',
        ];

        session()->setPreviousUrl(route('login'));
        $response = $this->followingRedirects()->post(route('auth.auth'), $data);

        $response->assertViewIs('auth.login');
        $response->assertSee(['The email and password is incorrect.']);
    }
}
