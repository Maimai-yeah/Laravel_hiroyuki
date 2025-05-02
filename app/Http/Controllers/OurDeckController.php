<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OurDeckController extends Controller
{
    public function index()
{
    /*
    $publicDecks = Deck::with(['user', 'cards'])
        ->where('is_public', true)
        ->latest()
        ->paginate(12);
        */

        return view('posts.ourdeck');
}
}
