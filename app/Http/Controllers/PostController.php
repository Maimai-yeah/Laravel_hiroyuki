<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query=post::query();

        if($request->has('search') && $request->filled('search')) {
            $searchKeyword=$request->input('search');

            $query->where('title', 'like', '%' . $searchKeyword . '%');
        }

        $posts=$query->paginate(10);
        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if(!Auth::check()) {
            return redirect()->route('login');
        }
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'content' =>'required'
        ]);

        Post::create([
            'title' =>$request->title,
            'content' =>$request->content,
            'user_id' =>Auth::id()
        ]);
        return redirect()->route('posts.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {    
        $post=Post::with('comments.user')->findOrFail($id);
        $comments=$post->comments()->with('user','likes')->paginate(10);
        return view('posts.show',compact('post','comments'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $post=Post::findOrFail($id);
        return view('posts.edit',compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'required|max:255',
            'content' =>'required'
        ]);
        $post=Post::findOrFail($id);
        $post->update([
            'title' =>$request->title,
            'content' =>$request->content
        ]);
        return redirect()->route('posts.show',['post'=>$post->id]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post=Post::findOrFail($id);
        $post->delete();
        return redirect()->route('posts.index');
    }
}
