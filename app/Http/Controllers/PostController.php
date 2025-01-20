<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    //
    public function index()
    {
        // get post
        $posts = Post::latest()->paginate(5);

        // return view
        return view('posts.index',compact('posts'));
    }
}
