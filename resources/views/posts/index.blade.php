@extends('layout')

@section('content')
    <h2>掲示板一覧</h2>
    <a href="{{ route('posts.create') }}" class="btn btn-primary mb-3">新規投稿</a>
    <form action="{{ route('posts.index') }}" method="GET" class="mb-4">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="検索キーワード" value="{{ request('search') }}">
            <button type="submit" class="btn btn-primary">検索</button>
        </div>
    </form>
    @foreach ($posts as $post)
        <div class="card mb-3">
            <div class="card-body">
                <h3 class="card-title">{{ $post->title }}</h3>
                <p class="card-text">{{ $post->content }}</p>
                <a href="{{ route('posts.show', $post->id) }}" class="btn btn-info">詳細</a>
            </div>
        </div>
    @endforeach

    {{-- ページネーションリンク --}}
    <div class="d-flex justify-content-center mt-4">
        {{ $posts->links() }}
    </div>
@endsection
