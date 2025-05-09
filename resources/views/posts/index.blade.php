@extends('layout')

@section('content')
    <main class="main">
        <div class="container-fluid">
            <div class="dashboard-01">
                <div class="row justify-content-center mt-4">
                    <div class="col-12 col-lg-8 col-xl-9 mb-1">
                        <div class="row main-contents-group">
                            <div class="col-12">
                                <div>
                                    <ul
                                        class="tool-menu-list d-flex justify-content-start align-items-stretch gap-1 flex-wrap">
                                        <!-- カードリスト -->
                                        <li class="tool-item border rounded flex-shrink-1 p-0" style="overflow: hidden;">
                                            <a href="{{ route('posts.cardlist') }}"
                                                class="btn btn-light w-100 h-100 d-flex flex-column justify-content-center align-items-center gap-1 text-center text-decoration-none">
                                                <i class="mdi mdi-cards-playing-spade lh-1 text-info"
                                                    style="font-size: 45px;"></i>
                                                <span class="text-dark small">カードリスト</span>
                                            </a>
                                        </li>

                                        <!-- デッキシミュレータ -->
                                        <li class="tool-item border rounded flex-shrink-1 p-0" style="overflow: hidden;">
                                            <a href="{{ route('posts.leaderselect') }}"
                                                class="btn btn-light w-100 h-100 d-flex flex-column justify-content-center align-items-center gap-1 text-center text-decoration-none">
                                                <i class="mdi mdi-cards-playing-spade-multiple lh-1 text-info"
                                                    style="font-size: 45px;"></i>
                                                <span class="text-dark small">デッキ作成</span>
                                            </a>
                                        </li>

                                        <!-- 一人回し -->
                                        <li class="tool-item border rounded flex-shrink-1 p-0" style="overflow: hidden;">
                                            <div
                                                class="btn btn-light w-100 h-100 d-flex flex-column justify-content-center align-items-center gap-1 text-center">
                                                <i class="mdi mdi-arrow-projectile-multiple lh-1 text-info"
                                                    style="font-size: 45px;"></i>
                                                <span class="text-dark small">一人回し</span>
                                            </div>
                                        </li>

                                        <!-- あなたのデッキ -->
                                        <li class="tool-item border rounded flex-shrink-1 p-0" style="overflow: hidden;">
                                            <a href="{{ route('posts.yourdeck') }}"
                                                class="btn btn-light w-100 h-100 d-flex flex-column justify-content-center align-items-center gap-1 text-center">
                                                <i class="mdi mdi-cards text-info lh-1" style="font-size: 45px;"></i>
                                                <span class="text-dark small">あなたのデッキ</span>
                                            </a>
                                        </li>

                                        <!-- みんなのデッキ -->
                                        <li class="tool-item border rounded flex-shrink-1 p-0" style="overflow: hidden;">
                                            <a href="{{ route('posts.ourdeck') }}"
                                                class="btn btn-light w-100 h-100 d-flex flex-column justify-content-center align-items-center gap-1 text-center">
                                                <i class="mdi mdi-cards-outline lh-1 text-info"
                                                    style="font-size: 45px;"></i>
                                                <span class="text-dark small">みんなのデッキ</span>
                                            </a>
                                        </li>

                                        <!-- おすすめデッキ -->
                                        <li class="tool-item border rounded flex-shrink-1 p-0" style="overflow: hidden;">
                                            <a href="{{ route('posts.osusumedeck') }}"
                                                class="btn btn-light w-100 h-100 d-flex flex-column justify-content-center align-items-center gap-1 text-center">
                                                <i class="mdi mdi-cards-playing-outline lh-1 text-info"
                                                    style="font-size: 45px;"></i>
                                                <span class="text-dark small">おすすめデッキ</span>
                                            </a>
                                        </li>
                                    </ul>

                                </div>
                            </div>
                        </div>
                        <br />
                        <div class="main-articles">
                            <h3 class="newer-article">このサイトについて</h3>
                            <p>シャドウバースビヨンドの考察・ファンサイトです。</p>
                            <p>世界中の人たちと色々なデッキを共有することが出来ます。</p>
                            <p>また、シャドバに関する記事も載せています。</p>
                            <p>
                                (デッキ共有の他に、一人回しやドローシミュレーターも実装予定です。)
                            </p>
                        </div>
                        <div class="main-articles">
                            <h3 class="newer-article">最新記事</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    @auth
        @if (Auth::user()->is_admin)
            <a href="{{ route('posts.create') }}" class="btn btn-primary mb-3">新規投稿</a>
        @endif
    @endauth

    <form method="GET" action="{{ route('posts.index') }}" class="mb-4">
        <div class="d-flex align-items-center gap-2">
            <label for="sort" class="form-label mb-0">並び替え:</label>
            <select name="sort" id="sort" class="form-select w-auto" onchange="this.form.submit()">
                <option value="newest" {{ request('sort', 'newest') == 'newest' ? 'selected' : '' }}>新しい順</option>
                <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>古い順</option>
                <option value="title" {{ request('sort') == 'title' ? 'selected' : '' }}>タイトル順</option>
            </select>
            <input type="hidden" name="search" value="{{ request('search') }}">
        </div>
    </form>

    <div class="row gx-2 gy-3">
        @foreach ($posts as $post)
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

                $objectPositions = [
                    'ネメシス' => '10% 15px',
                    'エルフ' => '5% 20px',
                    'ロイヤル' => '10% 20px',
                    'ウィッチ' => '10% 20px',
                    'ドラゴン' => '10% 20px',
                    'ナイトメア' => '45% 10px',
                    'ビショップ' => '10% 20px',
                ];

                $leaderImage = $classImages[$post->class] ?? 'https://via.placeholder.com/300x180?text=No+Image';
                $objectPosition = $objectPositions[$post->class] ?? 'center';
            @endphp

            <div class="col-6 col-md-4 col-lg-3 col-xl-2">
                <a href="{{ route('posts.show', $post->id) }}" class="card-image-link text-decoration-none">
                    <div class="card-image-crop position-relative border"
                        style="border: 2px solid black; border-radius: 6px;">
                        <img src="{{ $leaderImage }}" alt="{{ $post->class }}"
                            style="width: 100%; height: 100%; object-fit: cover; object-position: {{ $objectPosition }};">
                        <div class="card-image-name">{{ $post->class }}</div>
                    </div>
                    <div class="text-center mt-2 fw-bold text-dark title-text">
                        {{ $post->title }}
                    </div>
                    <!-- 投稿日を追加 -->
                    <div class="text-center">
                        <p style="color: #6c757d; font-size: 14px; font-style: italic; margin-bottom: 0;">
                            {{ $post->created_at->format('Y/m/d') }}
                        </p>
                    </div>
                </a>
            </div>
        @endforeach
    </div>


    {{-- ページネーションリンク --}}
    <div class="d-flex justify-content-center mt-4">
        {{ $posts->links() }}
    </div>
@endsection
