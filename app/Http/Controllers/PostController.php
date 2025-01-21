<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use illuminate\Support\Facades\Storage;

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

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        // validate from (for storage)
        $this->validate($request, [
            'image'     => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'title'     => 'required|min:5',
            'content'   => 'required|min:10'
        ]);

        //upload image
        $image = $request->file('image');
        $image->storeAs('public/posts', $image->hashName());

        //create post
        Post::create([
            'image'     => $image->hashName(),
            'title'     => $request->title,
            'content'   => $request->content
        ]);

        // redirect
        return redirect()->route('posts.index')->with(['success' => 'Data Successfully Save!']);
        
    }   

    public function edit(Post $post)
    {
        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        $this->validate($request, [
            'image'     => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'title'     => 'required|min:5',
            'content'   => 'required|min:10'
        ]);

        if ($request->hasFile('image'))
        {
            $image  = $request->file('image');
            $image->storeAS('public/post', $image->hashName());

            storage::delete('public/posts/'.$post->image);

            $post->update([
                'image'     => $image->hashName(),
                'title'     => $request->title,
                'content'   => $request->content
            ]);
        } else {

            $post->update([
                'title'     => $request->title,
                'content'   => $request->content
            ]);
        }

        return redirect()->route('post.index')->with(['success' => 'Data Successfully Update!']);
    }

    public function destroy(Post $post)
    {
        storage::delete('public/post'.$post->image);

        $post->delete();

        return redirect()->route('post.index')->with(['success' => 'Data Successfully Delete!']);
    }
}
