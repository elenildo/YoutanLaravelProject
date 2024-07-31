<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_endpoint_get_login(): void
    {
        $response = $this->get(route('login'));
        
        $response->assertStatus(200);
    }

    public function test_endpoint_get_register(): void
    {
        $response = $this->get(route('register'));
        
        $response->assertStatus(200);
    }

    public function test_endpoint_get_logout(): void
    {
        $response = $this->get( route('logout'));
        
        $response->assertStatus(302);
    }

    public function test_endpoint_post_login(): void
    {
        $newUser = [
            'name' => 'First user',
            'email' => 'first@teste.com',
            'password' => bcrypt('123123')
        ];

        User::create($newUser);

        $response = $this->post(route('login.auth'), ['email' => 'strangeuser@fail.com', 'password' => 'foo']);
        $response->assertStatus(302);

        $response = $this->post(route('login.auth'), ['email' => $newUser['email'], 'password' => 'foo']);
        $response->assertStatus(302);

        $response = $this->post(route('login.auth'), ['email' => $newUser['email'], 'password' => '123123' ]);
        $response->assertRedirect(route('adm.clientes'));
    }

    public function test_endpoint_post_register(): void
    {
        $newUser = [
            'name' => 'First user',
            'email' => 'first@teste.com',
            'password' => '123123',
            'password_confirmation' => '123123'
        ];

        $response = $this->post(route('register.auth'), $newUser);
        $response->assertRedirect(route('login'));

        $response = $this->post(route('register.auth'), $newUser);
        $response->assertRedirect('/');

        $otherUser = [
            'name' => 'Second user',
            'email' => 'secondt@teste.com',
            'password' => '123123',
            'password_confirmation' => '123120'
        ];

        $response = $this->post(route('register.auth'), $otherUser);
        $response->assertRedirect('/');
    }
}
