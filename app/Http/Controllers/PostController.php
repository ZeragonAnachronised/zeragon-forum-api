<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class PostController extends Controller
{
    public function create(Request $request)
    {
        $request->validate([
            'content' => 'required|string|min:22',
            'image' => 'nullable|image|mimes:jpeg,jpg,png,gif'
        ]);
        $content = $request->content;
        if($request->hasFile('image'))
        {
            $image = $request->file('image');
            $path = $image->store('images', 'public');
            Auth::user()->posts()->create([
                'content' => $content,
                'picture' => Storage::url($path)
            ]);
    
            return response()->json([
                'success' => true,
            ], 201);
        }
        else {
            Auth::user()->posts()->create([
                'content' => $content,
                'picture' => ''
            ]);
    
            return response()->json([
                'success' => true,
            ], 201);
        }
    }
    public function index($page = 0)
    {
        $authors = [];
        $posts = Post::latest()->skip($page * 10)->take(10)->get();
        foreach($posts as $key => $post) {
            $authors[$key] = User::where('id', $post->user_id)->get()[0]->name;
        }
        if($posts) {
            return response()->json([
                'posts' => $posts,
                'authors' => $authors
            ], 200);
        }
        else {
            return response()->json([
                'message' => 'no posts'
            ], 404);
        }
    }
}
