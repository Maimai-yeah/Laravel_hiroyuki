@extends('layout')

@section('content')
    <main class="main">
        <div class="container mt-4">
            <!-- パンくずリスト -->
            <div class="row">
                <div class="col-12">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('home') }}">Top</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('posts.ourdeck') }}">みんなのデッキ</a>
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
                    <p class="text-muted">作成者: {{ $deck->user->name }}</p>
                    <p class="text-muted">作成日: {{ $deck->created_at->format('Y/m/d') }}</p>

                    <!-- カード画像一覧 -->
                    <h4 class="mt-4">カード画像</h4>
                    @if ($deck->cards->isEmpty())
                        <p class="text-muted">このデッキにはカードがありません。</p>
                    @else
                        <div class="border p-3 rounded bg-light">
                            <div class="row row-cols-6 g-0">
                                @foreach ($deck->cards as $card)
                                    @for ($i = 0; $i < $card->pivot->quantity; $i++)
                                        <div class="col">
                                            <img src="{{ $card->image_url ?? asset('images/placeholder.png') }}"
                                                class="img-fluid d-block w-100"
                                                style="aspect-ratio: 3/4; object-fit: cover;" alt="{{ $card->name }}">
                                        </div>
                                    @endfor
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- デッキ説明 -->
                    @if ($deck->description)
                        <div class="mt-4 card shadow-sm mb-4">
                            <div class="card-header bg-primary text-white">
                                <i class="mdi mdi-comment-text-outline me-2"></i>
                                <strong>デッキ説明</strong>
                            </div>
                            <div class="card-body bg-light">
                                <p class="text-black mb-0" style="font-size: 1.1rem;">{{ $deck->description }}</p>
                            </div>
                        </div>
                    @else
                        <div class="card shadow-sm mb-4">
                            <div class="card-header bg-warning text-dark">
                                <i class="mdi mdi-alert-circle-outline me-2"></i>
                                <strong>お知らせ</strong>
                            </div>
                            <div class="card-body bg-light">
                                <p class="text-muted mb-0" style="font-size: 1.1rem;">このデッキには説明がありません。</p>
                            </div>
                        </div>
                    @endif





                    <div class="mt-4">
                        <a href="{{ route('posts.ourdeck') }}" class="btn btn-secondary">
                            <i class="mdi mdi-arrow-left"></i> デッキ一覧に戻る
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const btn = document.getElementById('comment-button');
            const form = document.getElementById('comment-form');
            if (btn && form) {
                btn.addEventListener('click', function() {
                    form.style.display = form.style.display === 'none' ? 'block' : 'none';
                });
            }
        });
    </script>
@endpush
