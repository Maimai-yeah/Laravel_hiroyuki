@extends('layout')

@section('content')
    <div class="container">
        <h2>お問い合わせフォーム</h2>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('contact.submit') }}">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">お名前</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}">
                @error('name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">メールアドレス</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                @error('email')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="message" class="form-label">お問い合わせ内容</label>
                <textarea name="message" class="form-control" rows="5">{{ old('message') }}</textarea>
                @error('message')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">送信</button>
        </form>

        <div class="mt-4">
            <a href="{{ route('posts.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> トップページへ戻る</a>
        </div>
    </div>
@endsection
