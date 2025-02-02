<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;

Route::middleware('auth:api')->group(function () {
    Route::get('/logout', [UserController::class, 'logout']);
    Route::get('/posts/page/{page?}', [PostController::class, 'index']);
    Route::get('/posts/glows/{page?}', [PostController::class, 'glows']);
    Route::get('/posts/targets/{page?}', [PostController::class, 'targets']);
    Route::get('/posts/post/{id}', [PostController::class, 'about']);
    Route::get('/user/{id}', [UserController::class, 'about']);
    Route::get('/profile', [UserController::class, 'profile']);
    Route::get('/posts/post/{id}/comments/{page}', [PostController::class, 'comments']);
    Route::post('/posts/create', [PostController::class, 'create']);
});
Route::post('/registration', [UserController::class, 'registration']);
Route::post('/login', [UserController::class, 'login']);