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

            <!-- 成功またはエラーメッセージの表示 -->
            @if (session('success'))
                <div class="alert alert-success mt-3">
                    {{ session('success') }}
                </div>
            @elseif (session('error'))
                <div class="alert alert-danger mt-3">
                    {{ session('error') }}
                </div>
            @endif

            <div class="row">
                <div class="col-12">
                    <h1 class="fs-1 mt-3 d-flex align-items-center">
                        <i class="mdi mdi-cards-outline me-2" style="font-size: 45px"></i>
                        {{ $deck->name }}
                    </h1>
                    <p class="text-muted">作成日: {{ $deck->created_at->format('Y/m/d') }}</p>



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
                    <h4 class="mt-4">デッキ説明</h4>
                    <form action="{{ route('yourdeck.updateDescription', $deck->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <textarea name="description" class="form-control" rows="4">{{ old('description', $deck->description) }}</textarea>
                        <button type="submit" class="btn btn-primary mt-2">保存</button>
                    </form>

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
