<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>@yield('title', 'シャドバ村 - Shadowverse Beyondのデッキ・最新情報・対戦コミュニティ')</title>

    <meta name="description" content="@yield('description', 'シャドバ村はShadowverse Beyond（シャドウバースビヨンド）プレイヤーのためのコミュニティサイト。デッキ紹介や最新情報、対戦交流など幅広くサポートします。')" />
    <meta name="keywords"
        content="シャドバ, Shadowverse, シャドウバース,Shadowverse Beyond,シャドウバースビヨンド,デッキ作成, カードリスト, コミュニティ, ゲーム,対戦,デッキ紹介,掲示板" />

    <link rel="canonical" href="{{ url()->current() }}" />

    <!-- Open Graph -->
    <meta property="og:title" content="@yield('title', 'シャドバ村 - Shadowverse Beyondのデッキ・最新情報・対戦コミュニティ')" />
    <meta property="og:description" content="@yield('description', 'シャドバ村はShadowverse Beyond（シャドウバースビヨンド）プレイヤーのためのコミュニティサイト。デッキ紹介や最新情報、対戦交流など幅広くサポートします。')" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:image" content="{{ asset('images/og-image.webp') }}" />
    <meta property="og:site_name" content="シャドバ村" />

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="@yield('title', 'シャドバ村 - Shadowverse Beyondのデッキ・最新情報・対戦コミュニティ')" />
    <meta name="twitter:description" content="@yield('description', 'シャドバ村はShadowverse Beyond（シャドウバースビヨンド）プレイヤーのためのコミュニティサイト。デッキ紹介や最新情報、対戦交流など幅広くサポートします。')" />
    <meta name="twitter:image" content="{{ asset('images/og-image.webp') }}" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <!-- Bootstrap 5 CSS & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet" />

    <!-- Material Design Icons -->
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font/css/materialdesignicons.min.css" rel="stylesheet" />

    <!-- Quill Editor -->
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet" />

    <!-- Vue.js -->
    <script src="https://unpkg.com/vue@next"></script>

    <!-- Axios -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <!-- Custom Styles -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/style2.css') }}" rel="stylesheet" />

    <!-- Blade スタックスタイル -->
    @stack('styles')

    <!-- 構造化データ JSON-LD -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "WebSite",
      "name": "シャドバ村",
      "url": "{{ url('/') }}",
      "potentialAction": {
        "@type": "SearchAction",
        "target": "{{ url('/search?q={search_term}') }}",
        "query-input": "required name=search_term"
      }
    }
    </script>

</head>

<body>

    <!-- ナビゲーションバー -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark py-3">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('posts.index') }}">
                <img src="{{ asset('images/logo.webp') }}" alt="シャドバ村" height="40">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar"
                aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="mainNavbar">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    {{-- 他のリンクを追加可能 --}}
                </ul>

                <ul class="navbar-nav ms-auto">
                    @if (Auth::check())
                        <li class="nav-item">
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                            <a class="nav-link text-white" href="#"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                ログアウト
                            </a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{ route('login') }}">ログイン</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{ route('register') }}">新規登録</a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <!-- メインコンテンツ -->
    <div class="container mt-4">
        @yield('content')
    </div>

    <!-- フッター -->
    <footer class="footer mt-5">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <a href="{{ route('konosite') }}">このサイトについて</a> |
                    <a href="{{ route('terms') }}">利用規約</a> |
                    <a href="{{ route('privacy') }}">プライバシーポリシー</a> |
                    <a href="#">YouTube</a>
                </div>
                <div class="col-12">©2025 SHIROMON</div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5 JS (Bundle includes Popper.js) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Quill -->
    <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>

    <!-- Blade スタックスクリプト -->
    @stack('scripts')
</body>

</html>
