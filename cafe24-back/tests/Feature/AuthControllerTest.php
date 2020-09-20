<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use App\User;

class AuthControllerTest extends TestCase
{
    private string $password = 'P@ssw0rd';

    public function test_register()
    {
        //given
        $this->withoutExceptionHandling();
        $data = [
            'name' => 'Moon1',
            'email' => 'test001@gmail.com',
            'password' => $this->password,
            'password_confirmation' => $this->password
        ];

        //when
        $response = $this->post('/api/register', $data);

        //then
        $response->assertStatus(201)
            ->assertJsonStructure(['user']);

        $this->assertDatabaseHas(
            'users',
            [
                'name' => $data['name'],
                'email' => $data['email'],
            ]
        );
    }

    public function test_login()
    {
        //given
        $this->passportInstall();
        $user = factory(User::class)->create(
            [
                'password' => Hash::make($this->password)
            ]
        );

        //when
        $response = $this->post(
            '/api/login',
            [
                'email' => $user->email,
                'password' => $this->password
            ]
        );

        //then
        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure(
                [
                    'token',
                    'me'
                ]
            );

        $this->assertSame(1, DB::table('oauth_access_tokens')->count());
    }

    public function test_logout()
    {
        //given
        $this->passportInstall();
        $user = factory(User::class)->create();

        //when
        $token = $user->createToken('Personal Access Token')->accessToken;
        $response = $this->post('/api/logout', [], ['Authorization' => 'Bearer ' . $token]);

        //then
        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure(['message', 'user']);
        $this->assertEquals(1, DB::table('oauth_access_tokens')->first()->revoked);
    }

    public function test_me()
    {
        //given
        $this->passportInstall();
        $user = factory(User::class)->create();

        //when
        $token = $user->createToken('Personal Access Token')->accessToken;
        $response = $this->post('/api/me', [], ['Authorization' => 'Bearer ' . $token]);

        //then
        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure(['me']);
    }

    public function getPosts(Request $request)
    {
        $posts = Post::with('user')->get();
        return response()->json(
            [
                'posts' => $posts
            ],
            Response::HTTP_OK
        );
    }


    private function passportInstall()
    {
        $this->artisan('passport:install');
    }
}
