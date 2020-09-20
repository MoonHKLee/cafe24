<?php

namespace Tests\Feature;

use App\Post;
use App\User;
use Request;
use Illuminate\Http\Response;
use Tests\TestCase;

class PostControllerTest extends TestCase
{
    public function test_get_posts()
    {
        //given
        $this->withoutExceptionHandling();
        $this->passportInstall();
        $user = factory(User::class)->create();
        $token = $user->createToken('Personal Access Token')->accessToken;
        $this->savePost($user, '제목1', '내용1');
        $this->savePost($user, '제목2', '내용2');
        $this->savePost($user, '제목2', '내용3');

        //when
        $response = $this->get('/api/posts', ['Authorization' => 'Bearer ' . $token]);

        //then
        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure(['posts']);

        $this->assertDatabaseCount('posts',3);
    }

    public function test_create_post()
    {
        //given
        $this->withoutExceptionHandling();
        $this->passportInstall();
        $user = factory(User::class)->create();
        $token = $user->createToken('Personal Access Token')->accessToken;
        $data = [
            'title' => '제목1',
            'content' => '내용1',
        ];

        //when
        $response = $this->post('/api/post', $data, ['Authorization' => 'Bearer ' . $token]);

        //then
        $response->assertStatus(Response::HTTP_CREATED)
            ->assertJsonStructure(['post']);

        $this->assertDatabaseHas(
            'posts',
            [
                'title' => $data['title'],
                'content' => $data['content'],
            ]
        );
    }

    public function test_get_post()
    {
        //given
        $this->withoutExceptionHandling();
        $this->passportInstall();
        $user = factory(User::class)->create();
        $token = $user->createToken('Personal Access Token')->accessToken;
        $post = $this->savePost($user, '제목1', '내용1');

        //when
        $response = $this->get('/api/post/1', ['Authorization' => 'Bearer ' . $token]);

        //then
        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure(['post']);
    }

    public function test_update_post()
    {
        //given
        $this->withoutExceptionHandling();
        $this->passportInstall();
        $user = factory(User::class)->create();
        $token = $user->createToken('Personal Access Token')->accessToken;
        $post = $this->savePost($user, '제목1', '내용1');
        $data = [
            'title' => '제목수정1',
            'content' => '내용수정1',
        ];

        //when
        $response = $this->patch("/api/post/{$post->id}", $data, ['Authorization' => 'Bearer ' . $token]);

        //then
        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure(['post']);

        $this->assertDatabaseHas(
            'posts',
            [
                'title' => $data['title'],
                'content' => $data['content'],
            ]
        );
    }

    public function test_delete_post()
    {
        //given
        $this->withoutExceptionHandling();
        $this->passportInstall();
        $user = factory(User::class)->create();
        $token = $user->createToken('Personal Access Token')->accessToken;
        $post = $this->savePost($user, '삭제 할 제목', '삭제 할 내용');

        //when
        $response = $this->delete("/api/post/{$post->id}", [],['Authorization' => 'Bearer ' . $token]);

        //then
        $response->assertStatus(Response::HTTP_OK)
            ->assertJson(['post_id'=>$post->id]);

        $this->assertDatabaseHas(
            'posts',
            [
                'title' => $post['title'],
                'content' => $post['content'],
                'is_deleted' => true,
            ]
        );

    }

    private function passportInstall()
    {
        $this->artisan('passport:install');
    }

    private function savePost(User $user, $title, $content)
    {
        $post = new Post;
        $post->title = $title;
        $post->user_id = $user->id;
        $post->content = $content;
        $post->hits = 0;
        $post->is_deleted = false;
        $post->save();
        return $post;
    }
}
