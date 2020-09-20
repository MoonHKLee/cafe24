<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PostController extends Controller
{
    public function getPosts(Request $request)
    {
        $posts = Post::with('user')->where("is_deleted", "=", false)->orderByDesc("id")->get();
        return response()->json(
            [
                'posts' => $posts
            ],
            Response::HTTP_OK
        );
    }

    public function createPost(Request $request)
    {
        $user = request()->user();

        $post = new Post;
        $post->title = $request->get('title');
        $post->user_id = $user->id;
        $post->content = $request->get('content');
        $post->hits = 0;
        $post->is_deleted = false;
        $post->save();

        return response()->json(
            [
                'post' => $post
            ],
            Response::HTTP_CREATED
        );
    }

    public function getPost(Request $request)
    {
        $postId = $request->postId;
        $post = Post::with('user')->find($postId);

        return response()->json(
            [
                'post' => $post
            ],
            Response::HTTP_OK
        );
    }

    public function updatePost(Request $request)
    {
        $postId = $request->postId;
        $post = Post::find($postId);
        $post->title = $request->get('title');
        $post->content = $request->get('content');
        $post->save();

        return response()->json(
            [
                'post' => $post
            ],
            Response::HTTP_OK
        );
    }

    public function deletePost(Request $request)
    {
        $postId = $request->postId;
        $post = Post::find($postId);
        $post->is_deleted = true;
        $post->save();

        return response()->json(
            [
                'post_id' => $post->id
            ],
            Response::HTTP_OK
        );
    }
}
