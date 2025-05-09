@extends('layout')

@section('content')
    <h2>投稿詳細</h2>
    <div class="card mb-3">
        <div class="card-body">
            <h3 class="card-title">{{ $post->title }}</h3>
            <div class="card-text">{!! $post->content !!}</div>
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
                <p class="text-muted fs-6">{{ $comment->position }} 投稿者: {{ $comment->nickname }}|
                    投稿日時:{{ $comment->created_at->format('Y-m-d H:i') }}
                </p>
                <div class="d-flex justify-content-between align-items-center">
                    <p class="card-text mb-0" style="max-width: 80%">{{ $comment->content }}</p>
                    <form action="{{ route('comments.like', $comment->id) }}" method="POST" style="margin-left: 10px;">
                        @csrf
                        <!-- ボタンの部分 -->
                        <button type="button"
                            class="btn  {{ $comment->likes->contains('user_id', auth()->id()) ? 'btn-danger' : 'btn-outline-danger' }}"
                            id="like-button-{{ $comment->id }}" style="font-size: 10px;">
                            <i class="bi bi-heart"></i>
                        </button>
                        <span class="like-count" id="like-count-{{ $comment->id }}">{{ $comment->likes->count() }}</span>

                    </form>
                </div>
            </div>

        </div>
    @endforeach

    <!--コメントフォーム-->

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
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const likeButtons = document.querySelectorAll('.btn-outline-danger, .btn-danger');

            likeButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const commentId = this.id.replace('like-button-', '');

                    fetch(`/comments/${commentId}/toggle-like`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector(
                                    'meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify({})
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.error) {
                                alert(data.error);
                                return;
                            }

                            const button = document.getElementById(`like-button-${commentId}`);
                            const likeCount = document.getElementById(
                                `like-count-${commentId}`);

                            if (data.action === 'added') {
                                button.classList.remove('btn-outline-danger');
                                button.classList.add('btn-danger');
                            } else {
                                button.classList.remove('btn-danger');
                                button.classList.add('btn-outline-danger');
                            }

                            likeCount.textContent = data.likeCount;
                        })
                        .catch(error => {
                            console.error('Error:', error);
                        });
                });
            });
        });
    </script>
@endpush
