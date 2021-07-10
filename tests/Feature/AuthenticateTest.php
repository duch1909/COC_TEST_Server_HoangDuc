<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;
use Symfony\Component\HttpFoundation\Response;

class AuthenticateTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testAdminCanLogin()
    {
        $admin = factory(User::class)->create();

        $response = $this
            ->postJson("api/admin/auth/login", [
                "email" => $admin->email,
                'password' => 'password'
            ]);

        $response->assertStatus(Response::HTTP_OK);

        $response->assertJsonStructure([
            'access_token',
            'token_type',
            'expires_at',
            'jti'
        ]);
    }

    public function testAnonymousCanNotLogin()
    {
        factory(User::class)->create();

        $response = $this
            ->postJson("api/admin/auth/login", [
                "email" => 'anonymous@gmail.com',
                'password' => 'anonymous'
            ]);

        $response->assertStatus(Response::HTTP_BAD_REQUEST);
    }
}
