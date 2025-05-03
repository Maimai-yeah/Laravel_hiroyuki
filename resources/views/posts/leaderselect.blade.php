@extends('layout')

@section('content')
    <main class="main">
        <div class="container">
            <div class="row mt-3"></div>
            <div class="row">
                <div class="col-12">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('posts.index') }}">Top</a>
                        </li>
                        <li class="breadcrumb-item">デッキシミュレーター</li>
                    </ol>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <h1 class="fs-1 mt-2 mb-0 d-flex align-items-center">
                        <i class="mdi mdi-cards-playing-spade-multiple lh-1" style="font-size: 45px"></i>
                        <span>デッキシミュレーター</span>
                        <span class="ms-3 flex-grow-1 flex-shrink-1 bg-light d-none d-md-block" style="height: 8px"></span>
                    </h1>
                </div>
            </div>
            <div class="col-md-12">
                <div class="row">
                    <div class="col-12 col-lg-7 col-xl-8">
                        <div class="widget-box mt-4 mb-4">
                            <!-- widget-boxとかいう謎の箱。これの中身に色んなjs詰まってたら嫌だなぁ -->
                            <h2
                                class="fs-4 pb-2 mb-3 border border-2 border-top-0 border-start-0 border-end-0 border-warning">
                                リーダーを選択してください
                            </h2>
                            <div class="row">
                                <div class="col-12 d-flex justify-content-between">
                                    <div class="nazono-modal-tokaiuyatu"></div>
                                </div>

                                <div class="col-12">
                                    <div class="card-item-area">
                                        <div class="card-item-area-inner">
                                            <div class="row gx-2 gy-3">
                                                <div class="col-6 col-md-4 col-lg-3 col-xl-2">
                                                    <a href="{{ route('posts.decksimulator', ['class' => 'ネメシス']) }}"
                                                        class="card-image-link">
                                                        <div class="card-image-crop">
                                                            <img src="https://pbs.twimg.com/media/Gl6dJQhbYAI94qY?format=jpg&name=medium"
                                                                alt="ネメシス" style="object-position: 10% 15px;" />
                                                            <div class="card-image-name">ネメシス</div>
                                                        </div>
                                                    </a>
                                                </div>


                                                <div class="col-6 col-md-4 col-lg-3 col-xl-2">
                                                    <a href="{{ route('posts.decksimulator', ['class' => 'エルフ']) }}">
                                                        <div class="card-image-crop">
                                                            <img src="https://pbs.twimg.com/media/Gl6dPUXbEAE1HCr?format=jpg&name=medium"
                                                                alt="エルフ" style="object-position: 5% 20px;" />
                                                            <div class="card-image-name">エルフ</div>
                                                        </div>
                                                    </a>
                                                </div>

                                                <div class="col-6 col-md-4 col-lg-3 col-xl-2">
                                                    <a href="{{ route('posts.decksimulator', ['class' => 'ロイヤル']) }}">
                                                        <div class="card-image-crop">
                                                            <img src="https://pbs.twimg.com/media/Gl6dUvba4AEGHUE?format=jpg&name=medium"
                                                                alt="ロイヤル" style="object-position: 10% 20px;" />
                                                            <div class="card-image-name">ロイヤル</div>
                                                        </div>
                                                    </a>
                                                </div>

                                                <div class="col-6 col-md-4 col-lg-3 col-xl-2">
                                                    <a href="{{ route('posts.decksimulator', ['class' => 'ウィッチ']) }}">
                                                        <div class="card-image-crop">
                                                            <img src="https://pbs.twimg.com/media/Gl6dZoIbYAIp8Cb?format=jpg&name=medium"
                                                                alt="ウィッチ" style="object-position: 10% 20px;" />
                                                            <div class="card-image-name">ウィッチ</div>
                                                        </div>
                                                    </a>
                                                </div>

                                                <div class="col-6 col-md-4 col-lg-3 col-xl-2">
                                                    <a href="{{ route('posts.decksimulator', ['class' => 'ドラゴン']) }}">
                                                        <div class="card-image-crop">
                                                            <img src="https://pbs.twimg.com/media/Gl6dekbbYAMuH1A?format=jpg&name=medium"
                                                                alt="ドラゴン" style="object-position: 10% 20px;" />
                                                            <div class="card-image-name">ドラゴン</div>
                                                        </div>
                                                    </a>
                                                </div>

                                                <div class="col-6 col-md-4 col-lg-3 col-xl-2">
                                                    <a href="{{ route('posts.decksimulator', ['class' => 'ナイトメア']) }}">
                                                        <div class="card-image-crop">
                                                            <img src="https://pbs.twimg.com/media/Gl6doo_bEAAlacW?format=jpg&name=medium"
                                                                alt="ナイトメア" style="object-position: 45% 10px;" />
                                                            <div class="card-image-name">ナイトメア</div>
                                                        </div>
                                                    </a>
                                                </div>

                                                <div class="col-6 col-md-4 col-lg-3 col-xl-2">
                                                    <a href="{{ route('posts.decksimulator', ['class' => 'ビショップ']) }}">
                                                        <div class="card-image-crop">
                                                            <img src="https://pbs.twimg.com/media/Gl6dyWyawAAyuAi?format=jpg&name=medium"
                                                                alt="ビショップ" style="object-position: 10% 20px;" />
                                                            <div class="card-image-name">ビショップ</div>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>





                            <div class="card-list-modal"></div>
                            <!--なんだこれ-->
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
    </main>
@endsection
