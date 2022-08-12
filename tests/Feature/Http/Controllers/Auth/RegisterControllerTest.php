<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

/**
 * to run the test
 * php artisan test ./tests/Feature/Http/Controllers/UserControllerTest.php 
 */
class RegisterControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function test_register_shows_register(){
        $response = $this->get(route('auth.register'));

        $response->assertStatus(200);
        $response->assertViewIs('auth.register');
        $response->assertSeeInOrder([
            'name="name"',
            'name="email"',
            'name="password"',
        ], $escape = false);

    }

    public function test_store_stores_user(){
        $data = [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'pasword12345',
        ];
        
        $response = $this->post('/register', $data);

        $user = User::where('email', $data['email'])->first();

        $this->assertEquals($data['name'], $user->name);
        $this->assertEquals($data['email'], $user->email);
        $this->assertTrue(Hash::check($data['password'], $user->password));

        return $response;

    }

    /**
     * @depends test_store_stores_user
     */
    public function test_store_redirects_index_on_success(TestResponse $response){
        $response->assertRedirect('/');
    }

    public function test_store_validates_request(){
        $data = [
            'name' => '',
            'email' => 'test@example.com',
            'password' => 'pasword12345',
        ];
        
        session()->setPreviousUrl(route('auth.register'));
        $response = $this->post('/register', $data);

        $response->assertInvalid(['name']);
        $response->assertRedirect(route('auth.register'));
    }

}