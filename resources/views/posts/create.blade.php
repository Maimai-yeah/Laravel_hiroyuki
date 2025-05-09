@extends('layout')

@section('content')
    <h2>新規投稿</h2>
    <form action="{{ route('posts.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="title" class="form-label">タイトル</label>
            <input type="text" name="title" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="class" class="form-label">クラス</label>
            <select name="class" class="form-control" required>
                <option value="">選択してください</option>
                <option value="ネメシス">ネメシス</option>
                <option value="エルフ">エルフ</option>
                <option value="ロイヤル">ロイヤル</option>
                <option value="ウィッチ">ウィッチ</option>
                <option value="ドラゴン">ドラゴン</option>
                <option value="ナイトメア">ナイトメア</option>
                <option value="ビショップ">ビショップ</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="editor" class="form-label">内容</label>
            <div id="editor" style="height: 300px; background-color: #fff;"></div>
            <input type="hidden" name="content" id="content">
        </div>

        <button type="submit" class="btn btn-success">投稿</button>
    </form>
@endsection

@push('scripts')
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

    <script>
        const quill = new Quill('#editor', {
            theme: 'snow',
            placeholder: 'ここに本文を入力...',
            modules: {
                toolbar: [
                    [{
                        'header': [1, 2, 3, false]
                    }],
                    ['bold', 'italic', 'underline'],
                    ['link', 'image'],
                    [{
                        'list': 'ordered'
                    }, {
                        'list': 'bullet'
                    }],
                    ['clean']
                ]
            }
        });

        document.querySelector('form').addEventListener('submit', function() {
            document.querySelector('#content').value = quill.root.innerHTML;
        });
    </script>
@endpush
