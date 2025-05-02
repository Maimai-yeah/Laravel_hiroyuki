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

//あなたのデッキのルーティング
Route::middleware('auth')->group(function () {
    Route::get('/yourdeck', [YourDeckController::class, 'yourdeck'])->name('posts.yourdeck');
    Route::get('/yourdeck/{id}', [YourDeckController::class, 'show'])->name('yourdeck.show');
    Route::delete('/yourdeck/{id}', [YourDeckController::class, 'destroy'])->name('yourdeck.destroy');
    Route::post('/yourdeck/{id}/share', [YourDeckController::class, 'shareDeck'])->name('yourdeck.share');
});

//皆のデッキのルーティング
Route::get('/ourdecks', [OurDeckController::class, 'index'])->name('posts.ourdeck');
Route::get('/ourdeck/{id}', [OurDeckController::class, 'show'])->name('ourdeck.show');
// routes/web.php
// 共有を取り消す
Route::post('/yourdeck/{id}/unshare', [YourDeckController::class, 'unshareDeck'])->name('yourdeck.unshare');


