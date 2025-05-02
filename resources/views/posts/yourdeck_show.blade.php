@extends('layout')

@section('content')
    <main class="main">
        <div class="container mt-4">
            <div class="row">
                <div class="col-12">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('home') }}">Top</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('posts.yourdeck') }}">あなたのデッキ</a>
                        </li>
                        <li class="breadcrumb-item active">{{ $deck->name }}</li>
                    </ol>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <h1 class="fs-1 mt-3 d-flex align-items-center">
                        <i class="mdi mdi-cards-outline me-2" style="font-size: 45px"></i>
                        {{ $deck->name }}
                    </h1>
                    <p class="text-muted">作成日: {{ $deck->created_at->format('Y/m/d') }}</p>


                    <h4 class="mt-4">カード一覧</h4>
                    <ul class="list-group mt-2">
                        @forelse ($deck->cards as $card)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ $card->name }}
                                <span class="badge bg-primary rounded-pill">{{ $card->pivot->quantity }} 枚</span>
                            </li>
                        @empty
                            <li class="list-group-item text-muted">このデッキにはカードがありません。</li>
                        @endforelse
                    </ul>

                    <div class="mt-4">
                        <a href="{{ route('posts.yourdeck') }}" class="btn btn-secondary">
                            <i class="mdi mdi-arrow-left"></i> デッキ一覧に戻る
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
