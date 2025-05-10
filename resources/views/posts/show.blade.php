@extends('layout')

@section('content')
    <h2>{{ $post->title }}</h2>
    <div class="card mb-3">
        <div class="card-body">

            <!-- リッチテキストの表示 -->
            <div class="post-content">
                {!! $post->content !!}
            </div>


            @if (auth()->check() && (auth()->id() === $post->user_id || auth()->user()->isAdmin()))
                <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-warning">編集</a>
                <form action="{{ route('posts.destroy', $post->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">削除</button>
                </form>
            @endif
        </div>
    </div>

    {{-- コメント一覧 --}}
    <h3>コメント一覧</h3>
    @foreach ($comments as $comment)
        <div class="card mb-2">
            <div class="card-body">
                <p class="text-muted fs-6">{{ $comment->position }} 投稿者: {{ $comment->nickname }}| 投稿日時:
                    {{ $comment->created_at->format('Y-m-d H:i') }}</p>
                <div class="d-flex justify-content-between align-items-center">
                    <p class="card-text mb-0" style="max-width: 80%">{{ $comment->content }}</p>
                    <form action="{{ route('comments.like', $comment->id) }}" method="POST" style="margin-left: 10px;">
                        @csrf
                        <!-- いいねボタン -->
                        <button type="button"
                            class="btn {{ $comment->likes->contains('user_id', auth()->id()) ? 'btn-danger' : 'btn-outline-danger' }} like-button"
                            id="like-button-{{ $comment->id }}" style="font-size: 10px;">
                            <i class="bi bi-heart"></i>
                        </button>
                        <span class="like-count" id="like-count-{{ $comment->id }}">{{ $comment->likes->count() }}</span>
                    </form>
                </div>
            </div>
        </div>
    @endforeach

    <!-- コメントフォーム -->
    <h3>コメントを投稿する</h3>
    @if (auth()->check())
        <form action="{{ route('comments.store', $post->id) }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="nickname" class="nickname-label">名前</label>
                <input type="text" id="nickname" name="nickname" class="form-control">
                <label for="content" class="form-label">コメント内容</label>
                <textarea name="content" id="content" class="form-control" rows="3" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">コメント投稿</button>
        </form>
    @else
        <p>コメントを投稿するにはログインしてください。</p>
    @endif
    <div class="d-flex justify-content-center mt-4">
        {{ $comments->links() }}
    </div>
@endsection
