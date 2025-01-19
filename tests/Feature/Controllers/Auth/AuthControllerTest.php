<?php

namespace Tests\Feature\Controllers\Auth;

use App\Models\User;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{

    public function testLogout()
    {
    }

    public function testMe()
    {
    }

    public function testLogin()
    {
        $user = User::inRandomOrder()->first();
        $response = $this->postJson(route('login', [
            'email' => $user->email,
            'password' => 'password',
        ]));

        $response->assertStatus(200);
    }

    public function testRefresh()
    {

    }
}
