<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CardlistController;
use App\Http\Controllers\DecksimulatorController;
use App\Http\Controllers\YourDeckController;
use App\Http\Controllers\OurDeckController;
use App\Http\Controllers\OsusumeDeckController;
use App\Http\Controllers\DeckCommentController;
use App\Http\Controllers\ContactController;
use App\Models\Like;

Route::get('/', [PostController::class, 'index'])->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('posts',PostController::class);
//コメントを投稿するルーティング
Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');
//いいねを投稿するルーティング
Route::post('/comments/{comment}/toggle-like', [LikeController::class, 'toggleLike'])->name('comments.like')->middleware('auth');
require __DIR__.'/auth.php';

//カードリストのルーティング
Route::get('/cardlist', [CardlistController::class, 'cardlist'])->name('posts.cardlist');
//カードリスト検索機能のルーティング
Route::get('/card-info/{id}', [CardlistController::class, 'getCardInfo']);

//デッキシミュレーターのルーティング
Route::get('/leaderselect', [DecksimulatorController::class, 'leaderselect'])->name('posts.leaderselect');
Route::get('/decksimulator', [DecksimulatorController::class, 'decksimulator'])->name('posts.decksimulator');


Route::middleware('auth')->post('/save-deck', [DecksimulatorController::class, 'saveDeck'])->name('deck.save');

Route::middleware('auth')->group(function () {
    Route::get('/yourdeck', [YourDeckController::class, 'yourdeck'])->name('posts.yourdeck');
    Route::get('/yourdeck/{id}', [YourDeckController::class, 'show'])->name('yourdeck.show');
    Route::put('/yourdeck/{id}/description', [YourDeckController::class, 'updateDescription'])->name('yourdeck.updateDescription');
    Route::delete('/yourdeck/{id}', [YourDeckController::class, 'destroy'])->name('yourdeck.destroy');
    Route::post('/yourdeck/{id}/share', [YourDeckController::class, 'shareDeck'])->name('yourdeck.share');
});



//皆のデッキのルーティング
Route::get('/ourdecks', [OurDeckController::class, 'index'])->name('posts.ourdeck');
Route::get('/ourdeck/{id}', [OurDeckController::class, 'show'])->name('ourdeck.show');

// routes/web.php
// 共有を取り消す
Route::post('/yourdeck/{id}/unshare', [YourDeckController::class, 'unshareDeck'])->name('yourdeck.unshare');
Route::middleware('auth')->group(function () {
    // デッキ詳細ページで「いいね」をトグル（ルート名を変更）
    Route::post('/deck/{id}/like', [OurDeckController::class, 'toggleLike'])->name('ourdeck.like');
});


Route::middleware('auth')->group(function () {
    // おすすめデッキ一覧
    Route::get('/osusumedeck', [OsusumeDeckController::class, 'index'])->name('posts.osusumedeck');

    // おすすめデッキ詳細
    Route::get('/osusumedeck/{deck}', [OsusumeDeckController::class, 'show'])->name('posts.osusumedeck.show');
});


//footer このサイトについて
Route::get('/konosite', function () {
    return view('posts.footer.konosite');
})->name('konosite');
Route::get('/terms', function () {
    return view('posts.footer.terms');
})->name('terms');
Route::get('/privacy', function () {
    return view('posts.footer.privacy');
})->name('privacy');

/* Route::middleware('auth')->group(function () {
    // コメントの作成
    Route::post('/decks/{deck}/comments', [DeckCommentController::class, 'store'])->name('comments.store');

    // コメントの削除
    Route::delete('/comments/{comment}', [DeckCommentController::class, 'destroy'])->name('comments.destroy');
}); */

//お問い合わせフォーム
Route::get('/contact', [ContactController::class, 'show'])->name('contact.show');
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');

//quillの画像挿入
Route::post('/posts/upload-image', [PostController::class, 'uploadImage'])->name('posts.uploadImage');

