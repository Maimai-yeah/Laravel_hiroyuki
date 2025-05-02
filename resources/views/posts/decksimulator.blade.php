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
                        <li class="breadcrumb-item">デッキシミュレーター</li>
                    </ol>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <h1 class="fs-1 mt-2 mb-0 d-flex align-items-center">
                        <i class="mdi mdi-cards-playing-spade lh-1" style="font-size: 45px"></i>
                        <span>デッキシミュレーター</span>
                        <span class="ms-3 flex-grow-1 flex-shrink-1 bg-light d-none d-md-block" style="height: 8px"></span>
                    </h1>
                    <p style="color: #6c757d; font-size: 14px; font-style: italic; margin-top: 10px;">
                        画像をクリックすると、右下のデッキボタンに追加されます。
                    </p>

                </div>
            </div>
            <div class="col-12 mb-1">
                <div class="d-grid">
                    <button type="button" class="btn btn-success js-card-search-filter" data-bs-toggle="modal"
                        data-bs-target="#cardSearchModal">
                        カード検索
                    </button>
                </div>
            </div>
            <!-- カード検索のモーダル -->
            <div class="modal fade" id="cardSearchModal" tabindex="-1" aria-labelledby="cardSearchModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <form id="cardSearchForm" class="modal-content" method="GET"
                        action="{{ route('posts.decksimulator') }}">
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
                                            {{ request('card_type') == $type ? 'selected' : '' }}>{{ $type }}
                                        </option>
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
                                            {{ request('rarity') == $rarity ? 'selected' : '' }}>{{ $rarity }}
                                        </option>
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

            <div class="col-md-12">
                <div class="row">
                    <div class="col-12">
                        <div class="widget-box mb-4">
                            <p class="text-start text-muted">
                                全 {{ $cards->total() }} 件中 {{ $cards->firstItem() }} - {{ $cards->lastItem() }} 件を表示中
                            </p>

                            <div class="row" id="cardList">
                                @foreach ($cards as $card)
                                    <div class="col-4 col-md-2 mb-3 p-0">
                                        <div class="card-item-area" data-card-id="{{ $card->id }}">
                                            <div class="card-item-area-inner">
                                                <div class="card-item-element">
                                                    <figure>
                                                        <img src="{{ $card->image_url }}" alt="{{ $card->name }}"
                                                            class="img-fluid" />
                                                    </figure>
                                                    <div class="mt-2">
                                                        {{-- 任意の詳細表示 --}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>


                            <div class="row mt-1">
                                <div class="col-12 mt-4 mb-0 d-flex justify-content-center">
                                    {!! $cards->links() !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- デッキカウンター（固定表示ボタン） -->
            <button id="deckCounterBtn" type="button" class="btn"
                style="position: fixed; bottom: 20px; right: 20px; background-color: rgba(0,0,0,0.8); color: white; padding: 20px; border-radius: 12px; z-index: 1050; font-size: 18px; display: flex; flex-direction: column; align-items: center; justify-content: center;"
                data-bs-toggle="modal" data-bs-target="#deckModal">
                <i class="mdi mdi-cards" style="font-size: 32px; margin-bottom: 5px;"></i>
                <span><span id="deckCount">0</span>/40</span>
            </button>

            <!-- デッキ内容モーダル -->
            <div class="modal fade" id="deckModal" tabindex="-1" aria-labelledby="deckModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl w-100" style="max-width: 95%;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deckModalLabel">デッキ内容</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="閉じる"></button>
                        </div>

                        <div class="modal-body" style="max-height: 70vh; overflow-y: auto;">
                            <!-- デッキカード数の表示 -->
                            <div class="deck-summary mb-3 d-flex justify-content-between align-items-center">
                                <span><strong>デッキ枚数:</strong> <span id="deckCountDisplay">0</span>/40</span>
                            </div>

                            <!-- カードリスト（3分割表示） -->
                            <div id="deckList" class="deck-grid">
                                <!-- JSで .col-md-4 が動的に追加される -->
                            </div>
                        </div>
                        <div class="mb-3 px-3">
                            <label for="deckName" class="form-label">デッキ名</label>
                            <input type="text" class="form-control" id="deckName" placeholder="デッキ名を入力してください">
                        </div>

                        <!-- 本来のフッターはここ -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">閉じる</button>
                            <button type="button" class="btn btn-primary" onclick="saveDeck()">デッキを保存する</button>
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




            <div class="row">
                <div class="col-12">
                    <div class="d-flex justify-content-center align-items-center">
                        <a href="{{ route('home') }}" class="btn btn-light mb-2">
                            <i class="mdi mdi-arrow-left me-2">トップページに戻る</i>

                        </a>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@push('scripts')
    <script>
        let currentCardId = null;
        let deck = {}; // デッキを保持
        let deckCount = 0; // デッキのカード枚数
        let cardDetails = []; // カードの詳細情報
        let currentCardIndex = -1; // 現在表示中のカードのインデックス
        let isAnimating = false; // アニメーション中かどうか
        const selectedClass = "{{ request('class') }}"; // 'ネメシス' や 'エルフ' など
        const isLoggedIn = {{ Auth::check() ? 'true' : 'false' }}; // ログイン状態

        document.addEventListener("DOMContentLoaded", function() {
            bindCardClickEvents();

            // デッキリスト内でカードをクリックした場合
            document.getElementById('deckList').addEventListener('click', function(event) {
                if (event.target.closest('button.btn-danger') || event.target.closest('select'))
                    return; // 削除ボタンやセレクトボックスの場合は詳細表示しない
                const cardElement = event.target.closest('.deck-card-wrapper');
                if (cardElement) {
                    const cardId = cardElement.getAttribute('data-deck-card-id');
                    showCardDetailsModal(cardId);
                }
            });

            // モーダルで前後のカードを切り替え
            document.getElementById('nextCardBtn')?.addEventListener('click', function() {
                if (currentCardIndex < cardDetails.length - 1) {
                    currentCardIndex++;
                    showModalWithCardDetails(cardDetails[currentCardIndex]);
                }
            });

            document.getElementById('prevCardBtn')?.addEventListener('click', function() {
                if (currentCardIndex > 0) {
                    currentCardIndex--;
                    showModalWithCardDetails(cardDetails[currentCardIndex]);
                }
            });

            // カード検索フォームの送信処理
            document.getElementById("cardSearchForm")?.addEventListener("submit", function(e) {
                e.preventDefault();
                const formData = new FormData(e.target);
                const query = new URLSearchParams(formData).toString();

                fetch(e.target.action + "?" + query, {
                        headers: {
                            "X-Requested-With": "XMLHttpRequest"
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        document.getElementById("cardList").innerHTML = data.cards;
                        bindCardClickEvents();
                        const modal = bootstrap.Modal.getInstance(document.getElementById(
                            'cardSearchModal'));
                        modal.hide();
                    })
                    .catch(error => console.error("検索エラー:", error));
            });

            // ローカルストレージからの復元を削除（今回はローカル保存しないため）
            // loadDeckFromLocalStorage();

            // ログインしていない場合に保存ボタンを無効化
            if (!isLoggedIn) {
                const saveBtn = document.getElementById('saveDeckBtn');
                if (saveBtn) {
                    saveBtn.disabled = true;
                    saveBtn.classList.add('disabled');
                    saveBtn.title = '保存にはログインが必要です';
                }
            }
        });

        // カードクリックイベントをバインド
        function bindCardClickEvents() {
            document.querySelectorAll('.card-item-area').forEach(card => {
                card.addEventListener('click', function() {
                    const cardId = parseInt(card.getAttribute('data-card-id'));
                    if (deckCount < 40) {
                        addCardToDeck(cardId, card);
                    } else {
                        showMessage('デッキの最大カード数(40)に達しました');
                    }
                });
            });
        }

        // デッキにカードを追加
        function addCardToDeck(cardId, cardElement = null) {
            if (!deck[cardId]) deck[cardId] = 0;
            if (deck[cardId] < 3) {
                deck[cardId]++;
                deckCount++;
                document.getElementById('deckCount').textContent = deckCount;
                fetchCardDetails(cardId);
                const deckCounterBtn = document.getElementById('deckCounterBtn');
                deckCounterBtn.classList.remove('bounce');
                deckCounterBtn.offsetHeight;
                deckCounterBtn.classList.add('bounce');
                deckCounterBtn.addEventListener('animationend', () => {
                    deckCounterBtn.classList.remove('bounce');
                }, {
                    once: true
                });
            } else {
                showMessage('同じカードは3枚までしか追加できません');
            }
        }

        // カードの詳細情報を取得
        function fetchCardDetails(cardId) {
            fetch(`/card-info/${cardId}`)
                .then(response => response.json())
                .then(data => {
                    const deckList = document.getElementById('deckList');
                    const existing = deckList.querySelector(`[data-deck-card-id="${cardId}"]`);
                    if (existing) {
                        existing.querySelector('select').value = deck[cardId];
                        return;
                    }

                    const col = document.createElement('div');
                    col.className = 'deck-card-wrapper';
                    col.setAttribute('data-deck-card-id', cardId);
                    col.innerHTML = `
                <div class="deck-card text-center">
                    <img src="${data.image_url}" alt="${data.name}" class="img-fluid mb-1" />
                    <p class="mb-2">${data.name}</p>
                    <div class="mb-1">
                        <select class="form-select form-select-sm" style="width: 90px;" onchange="updateCardCount(${cardId}, this)">
                            <option value="1" ${deck[cardId] == 1 ? "selected" : ""}>1</option>
                            <option value="2" ${deck[cardId] == 2 ? "selected" : ""}>2</option>
                            <option value="3" ${deck[cardId] == 3 ? "selected" : ""}>3</option>
                        </select>
                    </div>
                    <button class="btn btn-sm btn-danger" style="width: 90%;" onclick="removeCard(${cardId})">削除</button>
                </div>
            `;
                    deckList.appendChild(col);
                    document.getElementById('deckCountDisplay').textContent = deckCount;
                })
                .catch(error => console.error("カード詳細取得エラー:", error));
        }

        // カードの枚数を更新
        function updateCardCount(cardId, selectEl) {
            const newCount = parseInt(selectEl.value);
            const oldCount = deck[cardId];
            deckCount += newCount - oldCount;
            deck[cardId] = newCount;
            document.getElementById('deckCount').textContent = deckCount;
            document.getElementById('deckCountDisplay').textContent = deckCount;
        }

        // デッキからカードを削除
        function removeCard(cardId) {
            const cardEl = document.querySelector(`[data-deck-card-id="${cardId}"]`);
            if (cardEl) cardEl.remove();
            deckCount -= deck[cardId];
            delete deck[cardId];
            document.getElementById('deckCount').textContent = deckCount;
            document.getElementById('deckCountDisplay').textContent = deckCount;
        }

        // メッセージを表示
        function showMessage(message) {
            const messageElement = document.createElement('div');
            messageElement.classList.add('alert', 'alert-warning', 'message-alert');
            messageElement.textContent = message;
            document.body.appendChild(messageElement);
            setTimeout(() => {
                messageElement.style.display = 'none';
            }, 1000);
        }

        // カード詳細モーダルを表示
        function showCardDetailsModal(cardId) {
            fetch(`/card-info/${cardId}`)
                .then(response => response.json())
                .then(data => {
                    cardDetails = [data];
                    currentCardIndex = 0;
                    showModalWithCardDetails(data);
                })
                .catch(error => console.error('カード詳細取得エラー:', error));
        }

        // カード詳細情報をモーダルに表示
        function showModalWithCardDetails(data) {
            document.getElementById('modalCardImage').src = data.image_url;
            document.getElementById('modalCardName').textContent = data.name;
            document.getElementById('modalCardEffect').textContent = data.effect;
            document.getElementById('modalCardClass').textContent = data.class;
            document.getElementById('modalCardRarity').textContent = data.rarity;
            document.getElementById('modalCardEvolvedName').textContent = data.evolved_name;
            document.getElementById('modalCardVersion').textContent = data.version;
            new bootstrap.Modal(document.getElementById('cardModal')).show();
        }

        // デッキを保存する処理
        function saveDeck() {
            if (deckCount < 10) {
                showMessage('デッキは10枚でなければ保存できません');
                return;
            }

            if (!isLoggedIn) {
                showMessage('ログインが必要です');
                return;
            }

            const deckName = document.getElementById('deckName').value.trim();
            if (!deckName) {
                showMessage('デッキ名を入力してください');
                return;
            }

            const deckData = Object.entries(deck).map(([cardId, count]) => ({
                card_id: parseInt(cardId),
                count: count
            }));
            fetch("/save-deck", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    },
                    body: JSON.stringify({
                        name: deckName, // デッキ名
                        deck: deckData,
                        class: selectedClass
                    })
                })
                .then(response => response.text()) // まずテキストとして受け取る
                .then(data => {
                    console.log('サーバーからのレスポンス:', data); // デバッグ用にレスポンスを表示
                    try {
                        const jsonData = JSON.parse(data); // JSONとしてパース
                        if (jsonData.success) {
                            alert('デッキが保存されました！');
                        } else {
                            alert('保存に失敗しました: ' + jsonData.message);
                        }
                    } catch (e) {
                        console.error('エラーが発生しました:', e);
                        alert('サーバーエラー: 予期しないレスポンスが返されました');
                    }
                })
                .catch(error => {
                    console.error('保存エラー:', error);
                    alert('デッキの保存に失敗しました');
                });


        }
    </script>
@endpush
