<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Purifier;


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
    // 送信されたデータの内容をログに記録
    \Log::info('Store request received:', $request->all());

    try {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'class' => 'required|in:ネメシス,エルフ,ロイヤル,ウィッチ,ドラゴン,ナイトメア,ビショップ',
            'content' => 'required|string'
        ]);

        $post = new Post();
        $post->title = $validated['title'];
        $post->class = $validated['class'];
        $post->content = $validated['content'];
        $post->user_id = auth()->id();
        $post->save();

        return redirect()->route('posts.index')->with('success', '投稿が作成されました');
    } catch (\Exception $e) {
        \Log::error('Store failed: ' . $e->getMessage());
        return redirect()->back()->withInput()->with('error', '投稿の保存に失敗しました。');
    }
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
    
        if (auth()->id() !== $post->user_id && !auth()->user()->is_admin) {
            return redirect()->route('posts.index')->with('error', 'この投稿を編集する権限がありません。');
        }
    
        return view('posts.edit', compact('post'));
    }
    
    public function update(Request $request, string $id)
    {
        $post = Post::findOrFail($id);
    
        if (auth()->id() !== $post->user_id && !auth()->user()->is_admin) {
            return redirect()->route('posts.index')->with('error', 'この投稿を更新する権限がありません。');
        }
    
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required'
        ]);
    
        $post->update([
            'title' => $request->title,
            'content' => $request->content
        ]);
    
        return redirect()->route('posts.show', ['post' => $post->id])->with('success', '投稿が更新されました。');
    }
    
    public function destroy(string $id)
    {
        $post = Post::findOrFail($id);
    
        if (auth()->id() !== $post->user_id && !auth()->user()->is_admin) {
            return redirect()->route('posts.index')->with('error', 'この投稿を削除する権限がありません。');
        }
    
        $post->delete();
    
        return redirect()->route('posts.index')->with('success', '投稿が削除されました。');
    }

    public function uploadImage(Request $request)
    {
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('images', 'public');
            return response()->json(['image_url' => asset('storage/' . $path)]);
        }

        return response()->json(['error' => 'No image uploaded.'], 400);
    }
    
}
