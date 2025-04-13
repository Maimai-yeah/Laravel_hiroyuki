@extends('layout')

@section('content')
    <h2>投稿詳細</h2>
    <div class="card mb-3">
        <div class="card-body">
            <h3 class="card-title">{{ $post->title }}</h3>
            <p class="card-text">{{ $post->content }}</p>
            <a href="{{ route('posts.index') }}" class="btn btn-info">戻る</a>
            @if (auth()->check() && auth()->id() === $post->user_id)
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
                <p class="card-text">{{ $comment->content }}</p>
                <p class="text-muted">投稿者: {{ $comment->user->name }}| 投稿日時:{{ $comment->created_at->format('Y-m-d H:i') }}
                </p>
                <form action="{{ route('comments.like', $comment->id) }}" method="POST" style="display:inline">
                    @csrf
                    <button type="submit"
                        class="btn {{ $comment->likes->contains('user_id', auth()->id()) ? 'btn-danger' : 'btn-outline-danger' }}">
                        <i class="bi bi-heart"></i>
                    </button>
                </form>
            </div>

        </div>
    @endforeach

    <!--コメントフォーム-->

    <h3>コメントを投稿する</h3>
    @if (auth()->check() && auth()->id() === $post->user_id)
        <form action="{{ route('comments.store', $post->id) }}" method="POST">
            @csrf
            <div class="mb-3">
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
