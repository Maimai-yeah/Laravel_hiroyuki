<?php
// app/Http/Controllers/ContactController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function show()
    {
        return view('contact.form');
    }

    public function submit(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'message' => 'required|string',
        ]);
    
        // メール送信
        Mail::raw(
            "お名前: {$validated['name']}\nメールアドレス: {$validated['email']}\n\nお問い合わせ内容:\n{$validated['message']}",
            function ($message) use ($validated) {
                $message->to('ryo.fith@gmail.com') // 管理者宛てメールアドレスに変更
                        ->subject('【お問い合わせ】シャドバ（仮）からのメッセージ');
            }
        );
    
        return redirect()->route('contact.show')->with('success', 'お問い合わせを送信しました。');
    }
}
