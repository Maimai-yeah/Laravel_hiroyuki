@extends('layout')

@section('content')
    <h2>新規投稿</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form id="postForm" action="{{ route('posts.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="title" class="form-label">タイトル</label>
            <input type="text" name="title" class="form-control" required value="{{ old('title') }}">
        </div>

        <div class="mb-3">
            <label for="class" class="form-label">クラス</label>
            <select name="class" class="form-control" required>
                <option value="">選択してください</option>
                @foreach (['ネメシス', 'エルフ', 'ロイヤル', 'ウィッチ', 'ドラゴン', 'ナイトメア', 'ビショップ'] as $class)
                    <option value="{{ $class }}" {{ old('class') === $class ? 'selected' : '' }}>{{ $class }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- テキストエリアで入力を受け付ける -->
        <div class="mb-3">
            <label for="content" class="form-label">内容</label>
            <div id="editor"></div>
            <input type="hidden" name="content" id="content" value="{{ old('content') }}">
        </div>

        <button type="submit" class="btn btn-success">投稿</button>
    </form>
@endsection

@push('scripts')
    <script>
        // Quillエディタの初期化
        var quill = new Quill('#editor', {
            theme: 'snow',
            modules: {
                toolbar: [
                    [{
                        'header': [1, 2, 3, 4, 5, 6, false]
                    }],
                    [{
                        'font': []
                    }],
                    [{
                        'size': ['small', false, 'large', 'huge']
                    }], // ← これを追加！
                    ['bold', 'italic', 'underline'],
                    [{
                        'list': 'ordered'
                    }, {
                        'list': 'bullet'
                    }],
                    ['link', 'image'],
                    [{
                        'align': []
                    }],
                    [{
                        'color': []
                    }, {
                        'background': []
                    }],
                    ['clean']
                ]

            }
        });

        // 画像挿入処理
        const toolbar = quill.getModule('toolbar');
        toolbar.addHandler('image', () => {
            const input = document.createElement('input');
            input.setAttribute('type', 'file');
            input.setAttribute('accept', 'image/*');
            input.click();

            input.addEventListener('change', () => {
                const file = input.files[0];
                if (!file) return;

                const formData = new FormData();
                formData.append('image', file);

                axios.post('{{ route('posts.uploadImage') }}', formData)
                    .then(response => {
                        const imageUrl = response.data.image_url;
                        const range = quill.getSelection();
                        quill.insertEmbed(range.index, 'image', imageUrl);
                    })
                    .catch(error => {
                        console.error('Image upload failed:', error);
                    });
            });
        });

        // フォーム送信時にエディタのHTMLをhidden inputにセット
        document.getElementById('postForm').addEventListener('submit', function() {
            document.getElementById('content').value = quill.root.innerHTML;
        });

        // MutationObserver（任意）
        const observer = new MutationObserver(() => {
            // DOM変更時に必要な処理があればここに書く
        });
        const targetNode = document.getElementById('editor');
        const config = {
            childList: true,
            subtree: true
        };
        observer.observe(targetNode, config);
    </script>
@endpush
