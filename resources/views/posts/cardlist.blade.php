@extends('layout')

@section('content')
    <main class="main">
        <div class="container">
            <div class="row mt-3"></div>
            <div class="row">
                <div class="col-12">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('home') }}">Top</a>
                        </li>
                        <li class="breadcrumb-item">カードリスト</li>
                    </ol>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <h1 class="fs-1 mt-2 mb-0 d-flex align-items-center">
                        <i class="mdi mdi-cards-playing-spade lh-1" style="font-size: 45px"></i>
                        <span>カードリスト</span>
                        <span class="ms-3 flex-grow-1 flex-shrink-1 bg-light d-none d-md-block" style="height: 8px"></span>
                    </h1>
                </div>
            </div>
            <div class="col-md-12">
                <div class="row">
                    <div class="col-12">
                        <div class="d-grid mt-4">
                            <button type="button" class="btn btn-success js-card-search-filter" data-bs-toggle="modal"
                                data-bs-target="#cardSearchModal">
                                カード検索
                            </button>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="widget-box mt-4 mb-4">
                            <h2
                                class="fs-4 pb-2 mb-3 border border-2 border-top-0 border-start-0 border-end-0 border-warning">
                                カードリスト一覧 けつけつおけつうおおおおおおおお
                            </h2>

                            <form action="{{ route('posts.cardlist') }}" method="GET">
                                <div class="row my-3">
                                    <div class="col-12 d-flex flex-column justify-content-start">
                                        <div class="d-sm-block me-2 mb-2 mb-sm-0">
                                            <!-- ソートセレクト -->
                                            <select class="form-select" name="sort_by" style="width: 100%; height: 40px;"
                                                onchange="this.form.submit()">
                                                <option value="created_at"
                                                    {{ request('sort_by') == 'created_at' ? 'selected' : '' }}>新しいカード順
                                                </option>
                                                <option value="cost" {{ request('sort_by') == 'cost' ? 'selected' : '' }}>
                                                    コストの小さいカード順</option>
                                                <option value="attack"
                                                    {{ request('sort_by') == 'attack' ? 'selected' : '' }}>攻撃力順</option>
                                                <option value="hp" {{ request('sort_by') == 'hp' ? 'selected' : '' }}>
                                                    HP順</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!-- ▼ 検索条件を保持する hidden input を追加 -->
                                <input type="hidden" name="name" value="{{ request('name') }}">
                                <input type="hidden" name="class" value="{{ request('class') }}">
                                <input type="hidden" name="version" value="{{ request('version') }}">
                                <input type="hidden" name="cost" value="{{ request('cost') }}">
                                <input type="hidden" name="rarity" value="{{ request('rarity') }}">
                                <input type="hidden" name="card_type" value="{{ request('card_type') }}">

                            </form>

                            <p class="text-start text-muted">
                                全 {{ $cards->total() }} 件中 {{ $cards->firstItem() }} - {{ $cards->lastItem() }} 件を表示中
                            </p>

                            <div class="row">
                                @foreach ($cards as $card)
                                    <div class="col-4 col-md-2 mb-3 p-0">
                                        <div class="card-item-area" data-card-id="{{ $card->id }}">
                                            <div class="card-item-area-inner">
                                                <div class="card-item-element">
                                                    <figure>
                                                        <img src="{{ asset('images/' . $card->class_en . '/' . $card->image_url) }}"
                                                            alt="{{ $card->name }}" class="img-fluid" />
                                                    </figure>
                                                    <p>{{ $card->class }}</p>
                                                    <p>{{ $card->class_en }}</p>
                                                    <p>{{ asset('images/' . $card->class_en . '/' . $card->image_url) }}
                                                    </p>
                                                    <div class="mt-2">
                                                        <!-- <p>{{ $card->name }}</p> -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- ページネーションを追加 -->
                            <div class="row mt-4">
                                <div class="col-12 mt-4 mb-0 d-flex justify-content-center">
                                    {!! $cards->links() !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="d-flex justify-content-center align-items-center">
                        <a href="{{ route('home') }}" class="btn btn-light mb-4">
                            <i class="mdi mdi-arrow-left me-2">トップページに戻る</i>

                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- カード詳細モーダル -->
        <div class="modal fade" id="cardModal" tabindex="-1" aria-labelledby="cardModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm d-flex align-items-center justify-content-center"
                style="max-width: 400px; margin-top: 10vh;"> <!-- 少し小さめに調整 -->
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="cardModalLabel">カード詳細</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="閉じる"></button>
                    </div>
                    <div class="modal-body" style="max-height: 60vh; overflow-y: auto;">
                        <div class="card-detail text-center">
                            <figure>
                                <img id="modalCardImage" src="" alt="カード画像" class="img-fluid"
                                    style="max-width: 100%; max-height: 300px;"> <!-- 画像サイズ制限 -->
                            </figure>
                            <h5 id="modalCardName"></h5>
                            <p><strong>効果:</strong> <span id="modalCardEffect"></span></p>
                            <p><strong>クラス:</strong> <span id="modalCardClass"></span></p>
                            <p><strong>レアリティ:</strong> <span id="modalCardRarity"></span></p>
                            <p><strong>進化後:</strong> <span id="modalCardEvolvedName"></span></p>
                            <p><strong><span id="modalCardVersion"></span></strong> 収録</p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">閉じる</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- カード検索のモーダル -->
        <div class="modal fade" id="cardSearchModal" tabindex="-1" aria-labelledby="cardSearchModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <form id="cardSearchForm" class="modal-content" method="GET" action="{{ route('posts.cardlist') }}">
                    <div class="modal-header">
                        <h5 class="modal-title" id="cardSearchModalLabel">カード検索</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="閉じる"></button>
                    </div>
                    <div class="modal-body">
                        <!-- カード名 -->
                        <div class="mb-3">
                            <label for="searchName" class="form-label">カード名</label>
                            <input type="text" class="form-control" id="searchName" name="name"
                                value="{{ request('name') }}">
                        </div>
                        <!-- カードタイプ -->
                        <div class="mb-3">
                            <label for="searchCardType" class="form-label">カードタイプ</label>
                            <select class="form-select" id="searchCardType" name="card_type">
                                <option value="">指定なし</option>
                                @foreach (['フォロワー', 'スペル', 'アミュレット'] as $type)
                                    <option value="{{ $type }}"
                                        {{ request('card_type') == $type ? 'selected' : '' }}>{{ $type }}</option>
                                @endforeach
                            </select>
                        </div>


                        <!-- クラス -->
                        <div class="mb-3">
                            <label for="searchClass" class="form-label">クラス</label>
                            <select class="form-select" id="searchClass" name="class">
                                <option value="">指定なし</option>
                                @foreach (['エルフ', 'ロイヤル', 'ウィッチ', 'ドラゴン', 'ナイトメア', 'ビショップ', 'ネメシス', 'ニュートラル'] as $class)
                                    <option value="{{ $class }}"
                                        {{ request('class') == $class ? 'selected' : '' }}>{{ $class }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- バージョン -->
                        <div class="mb-3">
                            <label for="searchVersion" class="form-label">バージョン</label>
                            <select class="form-select" id="searchVersion" name="version">
                                <option value="">指定なし</option>
                                @foreach (['v1.0', 'ベーシック', 'ワイルドウエスト'] as $version)
                                    <option value="{{ $version }}"
                                        {{ request('version') == $version ? 'selected' : '' }}>{{ $version }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- コスト -->
                        <div class="mb-3">
                            <label for="searchCost" class="form-label">コスト</label>
                            <input type="number" class="form-control" id="searchCost" name="cost" min="0"
                                value="{{ request('cost') }}">
                        </div>

                        <!-- レアリティ -->
                        <div class="mb-3">
                            <label for="searchRarity" class="form-label">レアリティ</label>
                            <select class="form-select" id="searchRarity" name="rarity">
                                <option value="">指定なし</option>
                                @foreach (['ブロンズ', 'シルバー', 'ゴールド', 'レジェンド'] as $rarity)
                                    <option value="{{ $rarity }}"
                                        {{ request('rarity') == $rarity ? 'selected' : '' }}>{{ $rarity }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">検索</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">閉じる</button>
                    </div>
                </form>
            </div>
        </div>




    </main>
@endsection

@push('scripts')
    <script>
        let currentCardId = null;

        document.querySelectorAll('.card-item-area').forEach(card => {
            card.addEventListener('click', function() {
                const id = parseInt(card.getAttribute('data-card-id'));
                loadCardDetail(id);
            });
        });

        // ボタンイベント
        document.getElementById('nextCardButton').addEventListener('click', function() {
            if (currentCardId !== null) {
                loadCardDetail(currentCardId + 1);
            }
        });

        document.getElementById('prevCardButton').addEventListener('click', function() {
            if (currentCardId !== null && currentCardId > 1) {
                loadCardDetail(currentCardId - 1);
            }
        });

        function loadCardDetail(cardId) {
            fetch(`/card-info/${cardId}`)
                .then(response => {
                    if (!response.ok) throw new Error('not_found');
                    return response.json();
                })
                .then(data => {
                    currentCardId = cardId;

                    document.getElementById('modalCardName').textContent = data.name;
                    document.getElementById('modalCardVersion').textContent = data.version;
                    document.getElementById('modalCardEffect').textContent = data.effect;
                    document.getElementById('modalCardClass').textContent = data.class;
                    document.getElementById('modalCardRarity').textContent = data.rarity;
                    document.getElementById('modalCardEvolvedName').textContent = data.evolved_name;
                    document.getElementById('modalCardImage').src = data.image_url;

                    // モーダル表示
                    const modal = bootstrap.Modal.getOrCreateInstance(document.getElementById('cardModal'));
                    modal.show();

                    // ボタン制御
                    updateNavButtons(currentCardId);
                })
                .catch(error => {
                    if (error.message === 'not_found') {
                        alert('そのカードは存在しません');
                    } else {
                        console.error(error);
                    }
                });
        }

        function updateNavButtons(cardId) {
            // 試しに一つ前と一つ後が存在するかをfetchでチェック
            fetch(`/card-info/${cardId - 1}`)
                .then(res => {
                    document.getElementById('prevCardButton').disabled = !res.ok;
                });

            fetch(`/card-info/${cardId + 1}`)
                .then(res => {
                    document.getElementById('nextCardButton').disabled = !res.ok;
                });
        }
    </script>
@endpush
