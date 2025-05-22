<!DOCTYPE html>
<html lang="ja">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>シャドバ村</title>
    <!DOCTYPE html>
    <html lang="ja">

    <head>
        <!-- Google tag (gtag.js) -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-FF1X53MM8K"></script>
        <script>
            window.dataLayer = window.dataLayer || [];

            function gtag() {
                dataLayer.push(arguments);
            }
            gtag('js', new Date());

            gtag('config', 'G-FF1X53MM8K');
        </script>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>シャドバ村</title>
        <!-- Bootstrap 5 CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Bootstrap 5 JS (Bundle includes Popper.js) -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

        <!-- Material Design Icons -->
        <link href="https://cdn.jsdelivr.net/npm/@mdi/font/css/materialdesignicons.min.css" rel="stylesheet">

        <!-- Vue.js (Optional, if you plan to use Vue.js) -->
        <script src="https://unpkg.com/vue@next"></script>

        <!-- Default stylesheets -->
        <link href="{{ asset('css/style.css') }}" rel="stylesheet">
        <link href="{{ asset('css/style2.css') }}" rel="stylesheet">

        <!--quillの導入-->
        <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
        <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

        <!-- Custom styles can be pushed here -->
        @stack('styles') <!-- ここでスタイルの積み重ねを行う -->
    </head>


<body>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap 5 JS (Bundle includes Popper.js) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Material Design Icons -->
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font/css/materialdesignicons.min.css" rel="stylesheet">

    <!-- Vue.js (Optional, if you plan to use Vue.js) -->
    <script src="https://unpkg.com/vue@next"></script>

    <!-- Default stylesheets -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style2.css') }}" rel="stylesheet">

    <!--quillの導入-->
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <!-- Custom styles can be pushed here -->
    @stack('styles') <!-- ここでスタイルの積み重ねを行う -->
    </head>


    <body>


        <!-- 新ナビゲーションバー -->
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
                        {{-- ここに他のリンクを追加したい場合はどうぞ --}}
                    </ul>

                    <ul class="navbar-nav ms-auto">
                        @if (Auth::check())
                            <li class="nav-item">
                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                    style="display: none;">
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
                                <!-- ← Link#1の代わり -->
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white" href="{{ route('register') }}">新規登録</a>
                                <!-- ← Link#2の代わり -->
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>
        <!-- 旧ログインナビバー
    <nav class="navbar navbar-expand-lg bg-primary">
        <div class="container">
            <a class="navbar-brand text-white" href="{{ route('posts.index') }}">掲示板アプリ</a>
            <div class="ml-auto">
                <ul class="navbar-nav">
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
-->


        <div class="container mt-4">
            @yield('content')
        </div>
        <footer class="footer mt-5">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <a href="{{ route('konosite') }}">このサイトについて</a> | <a href="{{ route('terms') }}">利用規約</a> |
                        <a href="{{ route('privacy') }}">プライバシーポリシー</a> |
                        <a href="">Youtube</a>
                    </div>
                    <div class="col-12">©2025 SHIROMON</div>
                </div>
            </div>
        </footer>
        @stack('scripts')
    </body>


</html>
