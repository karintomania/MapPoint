<?php

namespace Tests\Feature\Actions\User;

use App\Actions\User\RegisterUser;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

/**
 * to run this test
 * php artisan test ./tests/Feature/Actions/User/RegisterUserTest.php 
 */
class RegisterUserTest extends TestCase
{
    use DatabaseMigrations;

    public function test_register_user_registers_user(){
        /** @var RegisterUser $registerUser */
        $registerUser = resolve(RegisterUser::class);
        $data = [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'pasword12345',
        ];

        $registeredUser = $registerUser($data);

        $user = User::find($registeredUser->id);

        $this->assertEquals($data['name'], $user->name);
        $this->assertEquals($data['email'], $user->email);
        $this->assertTrue(Hash::check($data['password'], $user->password));
    }

    /**
     * @dataProvider provider
     */
    public function test_validation($data, $message){

        /** @var RegisterUser $registerUser */
        $registerUser = resolve(RegisterUser::class);

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage($message);
        $registerUser($data);
    }

    public function provider(){
        return [
            [
                [
                    'name' => '',
                    'email' => 'test@example.com',
                    'password' => 'pasword12345',
                ],
                'The name field is required.'
            ],
            [
                [
                    'name' => 'Test User',
                    'email' => '',
                    'password' => 'pasword12345',
                ],
                'The email field is required.'
            ],
            [
                [
                    'name' => 'Test User',
                    'email' => 'test',
                    'password' => 'pasword12345',
                ],
                'The email must be a valid email address.'
            ],
            [
                [
                    'name' => 'Test User',
                    'email' => 'test@example.com',
                    'password' => '',
                ],
                'The password field is required.',
            ],
            [
                [
                    'name' => 'Test User',
                    'email' => 'test@example.com',
                    'password' => 'pasword',
                ],
                'The password must be at least 8 characters.'
            ],
        ];
    }
}