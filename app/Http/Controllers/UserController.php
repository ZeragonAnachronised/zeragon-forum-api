<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserController extends Controller
{
    public function registration(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|string|max:255|min:6'
        ], [
            'name.required' => 'Вы не ввели имя',
            'name.max' => 'Имя слишком длинное',
            'email.required' => 'Вы не ввели email',
            'email.max' => 'Email слишком длинный',
            'email.email' => 'Неверно введён email',
            'email.unique' => 'Email уже занят',
            'password.required' => 'Вы не ввели пароль',
            'password.max' => 'Пароль слишком длинный',
            'password.min' => 'Пароль должен быть от 6 символов'
        ]);

        $random_num = dechex(rand(1, 9999));

        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'tag' => $request->name . '#' . "$random_num"
        ]);
        $user->save();

        return response()->json([
            'user' => $user,
            'success' => true
        ], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:255',
            'password' => 'required|string|max:255|min:6'
        ], [
            'email.required' => 'Вы не ввели email',
            'email.max' => 'Email слишком длинный',
            'email.email' => 'Неверно введён email',
            'password.required' => 'Вы не ввели пароль',
            'password.max' => 'Пароль слишком длинный',
            'password.min' => 'Пароль должен быть от 6 символов'
        ]);
        $credentials = $request->only('email', 'password');

        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json([
                'success' => false,
                'message' => 'Неверные данные'
            ], 401);
        }

        return response()->json([
            'success' => true,
            'token' => $token
        ], 200);
    }

    public function logout()
    {
        auth()->logout();

        return response()->json([
            'message' => 'Successfully logged out'
        ], 200);
    }
}
