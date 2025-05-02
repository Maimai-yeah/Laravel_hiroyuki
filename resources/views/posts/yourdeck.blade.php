@extends('layout')

@section('content')
    <main class="main">
        <div class="container mt-4">

            <!-- パンくずリスト -->
            <div class="row">
                <div class="col-12">
                    <ol class="breadcrumb mb-2">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Top</a></li>
                        <li class="breadcrumb-item active">あなたのデッキ</li>
                    </ol>
                </div>
            </div>

            <!-- 見出し -->
            <div class="row mb-3">
                <div class="col-12">
                    <h1 class="fs-1 d-flex align-items-center">
                        <i class="mdi mdi-cards-playing-spade lh-1 me-2" style="font-size: 45px"></i>
                        <span>あなたのデッキ</span>
                        <span class="ms-3 flex-grow-1 d-none d-md-block bg-light" style="height: 8px;"></span>
                    </h1>
                    <p style="color: #6c757d; font-size: 14px; font-style: italic; margin-bottom: 0;">
                        あなたが作ったデッキを見てみましょう。
                    </p>
                    <p style="color: #6c757d; font-size: 14px; font-style: italic; margin-top: 0;  margin-bottom: 0;">
                        デッキを「みんなのデッキ」に投稿することもできます。
                    </p>
                </div>
            </div>

            <!-- デッキ一覧 -->
            <div class="row">
                @forelse($decks as $deck)
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
                            'ロイヤル' => 'center',
                            'ウィッチ' => 'center',
                            'ドラゴン' => 'center',
                            'ナイトメア' => 'center',
                            'ビショップ' => 'center',
                        ];

                        $leaderImage = $classImages[$deck->class] ?? null;
                        $objectPosition = $classObjectPositions[$deck->class] ?? 'center';
                        $totalCards = $deck->cards->sum('pivot.quantity');
                    @endphp

                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card h-100 shadow-sm">
                            <div class="card-body d-flex align-items-center">

                                <!-- リーダー画像（リンクなし） -->
                                <div class="col-5">
                                    <div class="card-image-crop" style="pointer-events: none;">
                                        <img src="{{ $leaderImage }}" alt="{{ $deck->class }}"
                                            style="object-position: {{ $objectPosition }};" />
                                        <div class="card-image-name">{{ $deck->class }}</div>
                                    </div>
                                </div>

                                <!-- デッキ情報（名前、カード数、作成日、ボタン） -->
                                <div class="col-8 col-md-9 ms-3">
                                    <h5 class="card-title mb-1">{{ $deck->name }}</h5>
                                    <p class="text-muted mb-3">作成日: {{ $deck->created_at->format('Y/m/d') }}</p>

                                    <!-- 共有ボタン -->
                                    <div class="d-flex gap-1">
                                        <a href="{{ route('yourdeck.show', $deck->id) }}"
                                            class="btn btn-primary btn-sm">詳細</a>

                                        <!-- 共有ボタン（切り替え） -->
                                        <form
                                            action="{{ route($deck->share ? 'yourdeck.unshare' : 'yourdeck.share', $deck->id) }}"
                                            method="POST" class="d-inline" onsubmit="return confirmShare(event)">
                                            @csrf
                                            @if ($deck->share)
                                                @method('POST')
                                                <button type="submit" class="btn btn-secondary btn-sm">共有済み</button>
                                            @else
                                                <button type="submit" class="btn btn-success btn-sm">共有する</button>
                                            @endif
                                        </form>

                                        <!-- 削除ボタン -->
                                        <form action="{{ route('yourdeck.destroy', $deck->id) }}" method="POST"
                                            class="d-inline" onsubmit="return confirm('本当に削除しますか？');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">削除</button>
                                        </form>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                @empty
                    <div class="col-12">
                        <p class="text-muted">保存されたデッキはありません。</p>
                    </div>
                @endforelse
            </div>

            <!-- ページネーション -->
            <div class="row mt-4">
                <div class="col-12 d-flex justify-content-center">
                    {!! $decks->links() !!}
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

    <!-- 共有ボタン確認用JavaScript -->
    <script>
        function confirmShare(event) {
            const isShareAction = event.target.querySelector('button').innerText === '共有する';
            const confirmationMessage = isShareAction ?
                '本当にデッキを共有しますか？' :
                '本当に共有を取り消しますか？';

            return confirm(confirmationMessage);
        }
    </script>
@endsection
