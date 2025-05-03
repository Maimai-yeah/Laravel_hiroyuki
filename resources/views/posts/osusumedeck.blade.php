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

                    <!-- デッキ説明 -->
                    @if ($deck->description)
                        <h4 class="mt-4">デッキ説明</h4>
                        <p>{{ $deck->description }}</p>
                    @else
                        <p class="text-muted">このデッキには説明がありません。</p>
                    @endif

                    <h4 class="mt-4">カード一覧</h4>

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

                    <h4 class="mt-4">カード一覧</h4>

                    @if ($deck->cards->isEmpty())
                        <p class="text-muted">このデッキにはカードがありません。</p>
                    @else
                        <div class="table-responsive border p-3 rounded bg-light">
                            <table class="table table-bordered table-striped mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>カード名</th>
                                        <th>枚数</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($deck->cards as $card)
                                        <tr>
                                            <td>{{ $card->name }}</td>
                                            <td>{{ $card->pivot->quantity }}枚</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif

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
