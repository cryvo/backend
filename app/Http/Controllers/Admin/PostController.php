<?php
// app/Http/Controllers/Admin/PostController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    public function index()
    {
        return Post::orderBy('published_at','desc')->get();
    }

    public function show($slug)
    {
        return Post::where('slug',$slug)->firstOrFail();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'slug'         => 'required|unique:posts',
            'title'        => 'required|string',
            'excerpt'      => 'required|string',
            'content'      => 'required|string',
            'published_at' => 'nullable|date',
        ]);

        return Post::create($data);
    }

    public function update(Request $request, Post $post)
    {
        $data = $request->validate([
            'title'        => 'sometimes|string',
            'excerpt'      => 'sometimes|string',
            'content'      => 'sometimes|string',
            'published_at' => 'nullable|date',
        ]);

        $post->update($data);
        return $post;
    }

    public function destroy(Post $post)
    {
        $post->delete();
        return response()->noContent();
    }
}
