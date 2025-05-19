@extends('layout')

@section('content')
    <main class="main">
        <div class="container mt-4">

            <!-- パンくずリスト -->
            <div class="row">
                <div class="col-12">
                    <ol class="breadcrumb mb-2">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Top</a></li>
                        <li class="breadcrumb-item active">みんなのデッキ</li>
                    </ol>
                </div>
            </div>

            <!-- 見出し -->
            <div class="row mb-3">
                <div class="col-12">
                    <h1 class="fs-1 d-flex align-items-center">
                        <i class="mdi mdi-account-group-outline lh-1 me-2" style="font-size: 45px"></i>
                        <span>みんなのデッキ</span>
                        <span class="ms-3 flex-grow-1 d-none d-md-block bg-light" style="height: 8px;"></span>
                    </h1>
                    <p class="text-muted fst-italic mb-0">みんなが作ったデッキを見てみましょう。</p>
                    <p class="text-muted fst-italic mt-0 mb-0">気に入ったデッキはいいねしてみましょう。</p>
                </div>
            </div>



            <!-- 検索フォーム -->
            <form method="GET" action="{{ route('posts.ourdeck') }}" class="mb-4 row g-2 align-items-center">

                <div class="col-md-6">
                    <input type="text" name="keyword" value="{{ request('keyword') }}" class="form-control"
                        placeholder="デッキ名で検索">
                </div>
                <div class="col-md-4">
                    <select name="sort" class="form-select">
                        <option value="">並び替え</option>
                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>新着順</option>
                        <option value="likes" {{ request('sort') == 'likes' ? 'selected' : '' }}>いいね順</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">検索</button>
                </div>
            </form>

            <!-- デッキ一覧 -->
            <div class="row">
                @forelse($publicDecks as $deck)
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
                    @endphp

                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card h-100 shadow-sm">
                            <div class="card-body d-flex align-items-center">
                                <div class="col-5">
                                    <div class="card-image-crop" style="pointer-events: none;">
                                        <img src="{{ $leaderImage }}" alt="{{ $deck->class }}"
                                            style="object-position: {{ $objectPosition }};" />
                                        <div class="card-image-name">{{ $deck->class }}</div>
                                    </div>
                                </div>
                                <div class="col-8 col-md-9 ms-3">
                                    <h5 class="card-title mb-1">{{ $deck->name }}</h5>
                                    <p class="mb-1 text-muted small">作者: {{ $deck->user->name }}</p>
                                    <p class="text-muted mb-3">作成日: {{ $deck->created_at->format('Y/m/d') }}</p>
                                    <a href="{{ route('ourdeck.show', $deck->id) }}" class="btn btn-primary btn-sm">詳細</a>

                                    @if (auth()->check())
                                        @php $liked = $deck->isLikedByUser(auth()->id()); @endphp
                                        <form action="{{ route('ourdeck.like', $deck->id) }}" method="POST"
                                            class="d-inline-block mt-2 like-form" id="like-form-{{ $deck->id }}">
                                            @csrf
                                            <button type="submit"
                                                class="btn btn-sm like-btn {{ $liked ? 'btn-danger liked' : 'btn-light' }}">
                                                <i class="mdi {{ $liked ? 'mdi-heart' : 'mdi-heart-outline' }} me-2"></i>
                                            </button>
                                            <span class="ms-2 like-count"
                                                id="like-count-{{ $deck->id }}">{{ $deck->likes->count() }}</span>
                                        </form>
                                    @else
                                        <p class="text-muted mt-2">いいねをするにはログインしてください。</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <p class="text-muted">公開されているデッキはまだありません。</p>
                    </div>
                @endforelse
            </div>

            <!-- ページネーション -->
            <div class="row mt-4">
                <div class="col-12 d-flex justify-content-center">
                    {!! $publicDecks->links() !!}
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

    @push('scripts')
        <script>
            $(document).ready(function() {
                $('form.like-form').on('submit', function(event) {
                    event.preventDefault();

                    const form = $(this);
                    const formData = form.serialize();

                    $.post(form.attr('action'), formData)
                        .done(function(response) {
                            const {
                                deckId,
                                likeCount,
                                liked
                            } = response;

                            // 数値更新
                            $('#like-count-' + deckId).text(likeCount);

                            // ボタン状態更新
                            const button = form.find('button.like-btn');
                            const icon = button.find('i');

                            if (liked) {
                                button.removeClass('btn-light').addClass('btn-danger');
                                icon.removeClass('mdi-heart-outline').addClass('mdi-heart');
                            } else {
                                button.removeClass('btn-danger').addClass('btn-light');
                                icon.removeClass('mdi-heart').addClass('mdi-heart-outline');
                            }
                        })
                        .fail(function() {
                            alert('エラーが発生しました');
                        });
                });
            });
        </script>
    @endpush
@endsection
