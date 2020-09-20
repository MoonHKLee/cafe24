<?php

namespace App\Http\Controllers;

use App\Post;
use App\User;
use DB;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redis;
use Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate(
            [
                'name' => 'required|string',
                'email' => 'required|string|email|unique:users,email',
                'password' => 'required|string|confirmed'
            ]
        );

        $user = User::create(
            [
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]
        );

        return response()->json(
            [
                'user' => $user
            ],
            201
        );
    }

    public function login(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'email' => 'required|string|email',
                'password' => 'required|string'
            ]
        );

        if ($validator->fails()) {
            return response()->json(
                [
                    'message' => 'Incorrect Email or Password'
                ],
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        $id = DB::table('users')->where('email', $request->email)->value('id');
        $user = User::find($id);

        $token = $user->createToken('Personal Access Token')->accessToken;
        return response()->json(
            [
                'token' => $token,
                'me' => $user
            ],
            Response::HTTP_OK
        );
    }

    public function logout()
    {
        $user = request()->user();
        printf($user);
        $user->token()->revoke();

        return response()->json(
            [
                'message' => 'The user has been successfully logged out',
                'user' => $user
            ],
            Response::HTTP_OK
        );
    }

    public function getMe()
    {
        $me = request()->user();
        return response()->json(
            [
                'me' => $me
            ],
            Response::HTTP_OK
        );
    }
}
