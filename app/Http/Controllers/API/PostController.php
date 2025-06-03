<?php
namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index() {
        return Post::whereNotNull('published_at')
                   ->orderBy('published_at','desc')
                   ->get(['slug','title','excerpt','published_at']);
    }
    public function show($slug) {
        $post = Post::where('slug',$slug)->firstOrFail();
        return response()->json($post);
    }
    // Admin CRUD you already have via pages—add posts similarly if desired
}
