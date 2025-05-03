@extends('layout')

@section('content')
    <main class="main">
        <div class="container-fluid">
            <div class="dashboard-01">
                <div class="row justify-content-center mt-4">
                    <div class="col-12 col-lg-8 col-xl-9 mb-4">
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
    <h2>掲示板一覧</h2>
    <a href="{{ route('posts.create') }}" class="btn btn-primary mb-3">新規投稿</a>
    <form action="{{ route('posts.index') }}" method="GET" class="mb-4">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="検索キーワード" value="{{ request('search') }}">
            <button type="submit" class="btn btn-primary">検索</button>
        </div>
    </form>
    @foreach ($posts as $post)
        <div class="card mb-3">
            <div class="card-body">
                <h3 class="card-title">{{ $post->title }}</h3>
                <p class="card-text">{{ $post->content }}</p>
                <a href="{{ route('posts.show', $post->id) }}" class="btn btn-info">詳細</a>
            </div>
        </div>
    @endforeach

    {{-- ページネーションリンク --}}
    <div class="d-flex justify-content-center mt-4">
        {{ $posts->links() }}
    </div>
@endsection
