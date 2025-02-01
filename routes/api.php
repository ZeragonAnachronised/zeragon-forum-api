<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;

Route::middleware('auth:api')->group(function () {
    Route::get('/logout', [UserController::class, 'logout']);
    Route::get('/posts', [PostController::class, 'index']);
    Route::get('/posts/glows');
    Route::get('/posts/likes');
    Route::get('/posts/likes/glows');
    Route::get('/posts/targets');
    Route::get('/posts/targets/glows');
    Route::get('/posts/{id}');
    Route::get('/posts/{id}/glows');
    Route::get('/user/{id}');
    Route::get('/profile');
    Route::get('/posts/{id}/comments');
    Route::post('/posts/create', [PostController::class, 'create']);
});
Route::post('/registration', [UserController::class, 'registration']);
Route::post('/login', [UserController::class, 'login']);