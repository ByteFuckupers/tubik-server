<?php

namespace Http\Controllers\V1\Auth;

use App\Http\Controllers\V1\Auth\AuthController;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use JetBrains\PhpStorm\NoReturn;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use DatabaseMigrations,
        RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
    }

    #[NoReturn]
    public function testSuccessfulLogin(): void
    {
        $user = User::factory()->create();

        $response = $this->postJson(route('auth.login'), [
            'email'    => $user->email,
            'password' => 'password'
        ]);

        $response
            ->assertOk()
            ->assertJsonStructure([
                'access_token',
                'token_type',
                'expires_in'
            ]);
    }


    public function testFailedLogin(): void
    {
        $user = User::factory()->create();

        $response = $this->postJson(route('auth.login'), [
            'email'    => $user->email,
            'password' => 'wrong-password'
        ]);

        $response
            ->assertStatus(401)
            ->assertJsonStructure([
                'error'
            ]);
    }

    public function testLoginWithInvalidCredentials(): void
    {
        $response = $this->postJson(route('auth.login'), [
            'email'    => 'invalid-email@gmail.com',
            'password' => 'invalid-password'
        ]);

        $response
            ->assertStatus(422)
            ->assertJsonStructure([
                'errors' => [
                    'email'
                ]
            ]);
    }


    public function testSuccessfulRegister(): void
    {
        $response = $this->postJson(route('auth.register'), [
                'name'     => 'John Doe',
                'email'    => 'email@gmail.com',
                'password' => 'password'
            ]);


        $response
            ->assertOk()
            ->assertJsonStructure([
                'access_token',
                'token_type',
                'expires_in'
            ]);
    }


    public function testValidatorRegistrationFailed(): void
    {
        $response = $this->postJson(route('auth.register'), [
            'name'     => 'John',
            'email'    => 'invalid-email3',
            'password' => 'password'
        ]);

        $response
            ->assertStatus(422)
            ->assertJsonStructure([
                'errors'
            ]);
    }
}
