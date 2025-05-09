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
        $query = Post::query();

        if ($request->has('search') && $request->filled('search')) {
            $query->where('title', 'like', '%' . $request->input('search') . '%');
        }

        // 並び替え処理
        $sort = $request->input('sort', 'newest'); // デフォルトは newest

        if ($sort === 'oldest') {
            $query->orderBy('created_at', 'asc');
        } elseif ($sort === 'title') {
            $query->orderBy('title', 'asc');
        } else {
            $query->orderBy('created_at', 'desc'); // newest
        }

        $posts = $query->paginate(10);

        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // 管理者でない場合、リダイレクト
        if (!auth()->user() || !auth()->user()->is_admin) {
            return redirect()->route('home')->with('error', '管理者権限が必要です');
        }

        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'class' => 'required|in:ネメシス,エルフ,ロイヤル,ウィッチ,ドラゴン,ナイトメア,ビショップ',
            'content' => 'required|string'
        ]);

        $post = new Post();
        $post->title = $validated['title'];
        $post->class = $validated['class'];
        $post->content = $validated['content'];
        $post->user_id = auth()->id(); // 投稿者情報

        $post->save();

        return redirect()->route('posts.index')->with('success', '投稿が作成されました');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $post = Post::with('comments.user')->findOrFail($id);
        $comments = $post->comments()->with('user', 'likes')->paginate(10);
        return view('posts.show', compact('post', 'comments'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $post = Post::findOrFail($id);
        return view('posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required'
        ]);
        
        $post = Post::findOrFail($id);
        $post->update([
            'title' => $request->title,
            'content' => $request->content
        ]);

        return redirect()->route('posts.show', ['post' => $post->id]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = Post::findOrFail($id);
        $post->delete();
        return redirect()->route('posts.index');
    }
}
