<?php

namespace Http\Controllers\V1\Auth;

use App\Http\Controllers\V1\Auth\AuthController;
use App\Http\Resources\V1\Auth\MeResource;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use JetBrains\PhpStorm\NoReturn;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use DatabaseMigrations;

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



    public function testSuccessfulLogout(): void
    {
        $user = User::factory()->create();

        $token = auth()->attempt([
            'email'    => $user->email,
            'password' => 'password'
        ]);

        $response = $this
            ->withHeader('Authorization', "Bearer $token")
            ->postJson(route('auth.logout'));

        $response
            ->assertOk()
            ->assertJsonStructure([
                'message'
            ]);
    }


    public function testMe()
    {
        $user = User::factory()->create();

        $token = auth()->attempt([
            'email'    => $user->email,
            'password' => 'password'
        ]);

        $response = $this
            ->withHeader('Authorization', "Bearer $token")
            ->postJson(route('auth.me'));


        $response
            ->assertOk()
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'email',
                    'email_verified_at',
                    'created_at',
                    'updated_at'
                ]
            ]);
    }
}
