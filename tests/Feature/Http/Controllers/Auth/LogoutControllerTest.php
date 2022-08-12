<?php

namespace Tests\Feature\Http\Controllers\Auth;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Auth;

/**
 * to run the test
 * php artisan test ./tests/Feature/Http/Controllers/Auth/LogoutControllerTest.php
 */
class LogoutControllerTest extends TestCase{

    use DatabaseMigrations;

    public function test_logout_logouts_user(){
        $user = User::factory()->create();

        // login
        $this->post(route('auth.auth'), [
            'email' => $user->email,
            'password' => 'password',
        ]);
        $this->assertAuthenticatedAs($user);

        $response = $this->get('/logout');
        $this->assertGuest();
        $response->assertRedirect(route('login'));
    }
}