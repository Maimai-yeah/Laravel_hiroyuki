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
                                                @php
                                                    $leaders = [
                                                        [
                                                            'name' => 'ネメシス',
                                                            'image' => 'nemesis.jpg',
                                                            'position' => '10% 15px',
                                                        ],
                                                        [
                                                            'name' => 'エルフ',
                                                            'image' => 'elf.jpg',
                                                            'position' => '5% 20px',
                                                        ],
                                                        [
                                                            'name' => 'ロイヤル',
                                                            'image' => 'royal.jpg',
                                                            'position' => '10% 20px',
                                                        ],
                                                        [
                                                            'name' => 'ウィッチ',
                                                            'image' => 'witch.jpg',
                                                            'position' => '10% 20px',
                                                        ],
                                                        [
                                                            'name' => 'ドラゴン',
                                                            'image' => 'dragon.jpg',
                                                            'position' => '10% 20px',
                                                        ],
                                                        [
                                                            'name' => 'ナイトメア',
                                                            'image' => 'nightmare.jpg',
                                                            'position' => '45% 10px',
                                                        ],
                                                        [
                                                            'name' => 'ビショップ',
                                                            'image' => 'bishop.jpg',
                                                            'position' => '10% 20px',
                                                        ],
                                                    ];
                                                @endphp

                                                @foreach ($leaders as $leader)
                                                    <div class="col-6 col-md-4 col-lg-3 col-xl-2">
                                                        <a href="{{ route('posts.decksimulator', ['class' => $leader['name']]) }}"
                                                            class="card-image-link">
                                                            <div class="card-image-crop">
                                                                <img src="{{ asset('images/leaders/' . $leader['image']) }}"
                                                                    alt="{{ $leader['name'] }}"
                                                                    style="object-position: {{ $leader['position'] }};" />
                                                                <div class="card-image-name">{{ $leader['name'] }}</div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-list-modal"></div>
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
