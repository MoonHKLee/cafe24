<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['CORS'])->post('/register', 'AuthController@register');
Route::middleware(['CORS'])->post('/login', 'AuthController@login')->name('login');
Route::middleware(['CORS'])->middleware('auth:api')->post('/logout', 'AuthController@logout');
Route::middleware(['CORS'])->middleware('auth:api')->get('/me', 'AuthController@getMe');

Route::middleware(['CORS'])->get('/posts','PostController@getPosts');
Route::middleware(['CORS'])->middleware('auth:api')->post('/post','PostController@createPost');
Route::middleware(['CORS'])->get('/post/{postId}','PostController@getPost');
Route::middleware(['CORS'])->middleware('auth:api')->patch('/post/{postId}','PostController@updatePost');
Route::middleware(['CORS'])->middleware('auth:api')->delete('/post/{postId}','PostController@deletePost');


