@extends('layout')

@section('content')
    <main class="main">
        <div class="container mt-4">

            <!-- パンくずリスト -->
            <div class="row">
                <div class="col-12">
                    <ol class="breadcrumb mb-2">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Top</a></li>
                        <li class="breadcrumb-item active">おすすめデッキ</li>
                    </ol>
                </div>
            </div>

            <!-- 見出し -->
            <div class="row mb-3">
                <div class="col-12">
                    <h1 class="fs-1 d-flex align-items-center">
                        <i class="mdi mdi-cards-playing-spade lh-1 me-2" style="font-size: 45px"></i>
                        <span>おすすめデッキ</span>
                        <span class="ms-3 flex-grow-1 d-none d-md-block bg-light" style="height: 8px;"></span>
                    </h1>
                    <p style="color: #6c757d; font-size: 14px; font-style: italic; margin-bottom: 0;">
                        ここにはおすすめデッキが表示されます。
                    </p>
                    <p style="color: #6c757d; font-size: 14px; font-style: italic; margin-top: 0;  margin-bottom: 0;">
                        流行りのデッキのほかに、投稿してくださった面白いデッキをご紹介させていただく事もございます。
                        (共有されたくない場合は、デッキ詳細の中からチェックを外してください。)
                    </p>
                </div>
            </div>

            <!-- デッキ一覧 -->
            <div class="row">
                @forelse($recommendedDecks as $deck)
                    @php
                        $classImages = [
                            'ネメシス' => 'https://pbs.twimg.com/media/Gl6dJQhbYAI94qY?format=jpg&name=medium',
                            'エルフ' => 'https://pbs.twimg.com/media/Gl6dPUXbEAE1HCr?format=jpg&name=medium',
                            'ロイヤル' => 'https://pbs.twimg.com/media/Gl6dUvba4AEGHUE?format=jpg&name=medium',
                            'ウィッチ' => 'https://pbs.twimg.com/media/Gl6dZoIbYAIp8Cb?format=jpg&name=medium',
                            'ドラゴン' => 'https://pbs.twimg.com/media/Gl6dekbbYAMuH1A?format=jpg&name=medium',
                            'ナイトメア' => 'https://pbs.twimg.com/media/Gl6doo_bEAAlacW?format=jpg&name=medium',
                            'ビショップ' => 'https://pbs.twimg.com/media/Gl6dyWyawAAyuAi?format=jpg&name=medium',
                        ];

                        $classObjectPositions = [
                            'ネメシス' => '10% 15px',
                            'エルフ' => '5% 20px',
                            'ロイヤル' => '10% 20px',
                            'ウィッチ' => '10% 20px',
                            'ドラゴン' => '10% 20px',
                            'ナイトメア' => '45% 10px',
                            'ビショップ' => '10% 20px',
                        ];

                        $leaderImage = $classImages[$deck->class] ?? null;
                        $objectPosition = $classObjectPositions[$deck->class] ?? 'center';
                        $totalCards = $deck->cards->sum('pivot.quantity');
                    @endphp

                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card h-100 shadow-sm">
                            <div class="card-body d-flex align-items-center">

                                <!-- リーダー画像 -->
                                <div class="col-5">
                                    <div class="card-image-crop" style="pointer-events: none;">
                                        <img src="{{ $leaderImage }}" alt="{{ $deck->class }}"
                                            style="object-position: {{ $objectPosition }};" />
                                        <div class="card-image-name">{{ $deck->class }}</div>
                                    </div>
                                </div>

                                <!-- デッキ情報 -->
                                <div class="col-8 col-md-9 ms-3">
                                    <h5 class="card-title mb-1">{{ $deck->name }}</h5>
                                    <p class="text-muted mb-3">作成日: {{ $deck->created_at->format('Y/m/d') }}</p>

                                    <div class="d-flex gap-1">
                                        <a href="{{ route('posts.osusumedeck.show', $deck->id) }}"
                                            class="btn btn-primary btn-sm">詳細</a>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                @empty
                    <div class="col-12">
                        <p class="text-muted">おすすめデッキはまだ登録されていません。</p>
                    </div>
                @endforelse
            </div>

            <!-- ページネーション -->
            <div class="row mt-4">
                <div class="col-12 d-flex justify-content-center">
                    {!! $recommendedDecks->links() !!}
                </div>
            </div>

            <!-- トップに戻る -->
            <div class="row mt-5">
                <div class="col-12 text-center">
                    <a href="{{ route('home') }}" class="btn btn-light">
                        <i class="mdi mdi-arrow-left me-2"></i>トップページに戻る
                    </a>
                </div>
            </div>
        </div>
    </main>
@endsection
