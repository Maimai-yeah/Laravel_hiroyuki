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
                    <p style="color: #6c757d; font-size: 14px; font-style: italic; margin-bottom: 0;">
                        デッキ説明を加えておくと、みんなのデッキ投稿時に表示されます。
                    </p>

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
                    <!-- カード一覧表 -->
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

                    <h4 class="mt-4">デッキ説明</h4>
                    <form action="{{ route('yourdeck.updateDescription', $deck->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <textarea name="description" class="form-control" rows="4">{{ old('description', $deck->description) }}</textarea>
                        <button type="submit" class="btn btn-primary mt-2">保存</button>
                    </form>
                    <div class="form-check mt-3">
                        <input type="checkbox" name="is_recommended" id="is_recommended" class="form-check-input"
                            {{ old('is_recommended', true) ? 'checked' : '' }}>
                        <label for="is_recommended" class="form-check-label">
                            おすすめデッキに掲載を許可する
                        </label>
                    </div>


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
