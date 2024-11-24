@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">編輯印章知識</div>

                    <div class="card-body">
                        <form action="{{ route('admin.seal-knowledge.update', $sealKnowledge) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="category_id" class="form-label required">分類</label>
                                <select class="form-control @error('category_id') is-invalid @enderror" id="category_id"
                                    name="category_id" required>
                                    <option value="">請選擇分類</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ old('category_id', $sealKnowledge->category_id) == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="title" class="form-label required">標題</label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror"
                                    id="title" name="title" value="{{ old('title', $sealKnowledge->title) }}"
                                    required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="content" class="form-label required">內容</label>
                                <textarea class="form-control @error('content') is-invalid @enderror" id="content" name="content" rows="10"
                                    required>{{ old('content', $sealKnowledge->content) }}</textarea>
                                @error('content')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="sort" class="form-label">排序</label>
                                <input type="number" class="form-control @error('sort') is-invalid @enderror"
                                    id="sort" name="sort" value="{{ old('sort', $sealKnowledge->sort) }}">
                                @error('sort')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3 d-flex align-items-center">
                                <input type="checkbox" class="form-check-input p-1" id="status" name="status"
                                    value="1" {{ old('status', $sealKnowledge->status) ? 'checked' : '' }}>
                                <label class="form-check-label p-1" for="status">是否啟用</label>
                            </div>

                            <!-- SEO 設定 -->
                            <div class="card mt-4">
                                <div class="card-header">
                                    <h5 class="mb-0">SEO 設定</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="meta_title" class="form-label">Meta 標題</label>
                                                <input type="text" class="form-control" id="meta_title" name="meta_title"
                                                    value="{{ old('meta_title', $sealKnowledge->meta_title) }}">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="meta_description" class="form-label">Meta 描述</label>
                                                <textarea class="form-control" id="meta_description" name="meta_description" rows="3">{{ old('meta_description', $sealKnowledge->meta_description) }}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="meta_keywords" class="form-label">Meta 關鍵字</label>
                                                <input type="text" class="form-control" id="meta_keywords"
                                                    name="meta_keywords"
                                                    value="{{ old('meta_keywords', $sealKnowledge->meta_keywords) }}">
                                                <small class="form-text text-muted">多個關鍵字請用逗號分隔</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-grid gap-2 mt-4">
                                <button type="submit" class="btn btn-primary">更新</button>
                                <a href="{{ route('admin.seal-knowledge.index') }}"
                                    class="btn btn-outline-secondary">返回列表</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
        <link rel="stylesheet" href="{{ asset('ckeditor5/ckeditor5.css') }}">
        <style>
            .ck-editor__editable {
                height: 500px;
            }
        </style>
    @endpush

    @push('scripts')
        <script src="{{ asset('ckeditor5/ckeditor.js') }}"></script>
        <script src="{{ asset('ckeditor5/zh.min.js') }}"></script>
        <script>
            $(document).ready(function() {
                // CKEditor 初始化
                let editor;
                ClassicEditor
                    .create(document.querySelector('#content'), {
                        language: 'zh',
                        ckfinder: {
                            uploadUrl: '{{ route('admin.upload.image') }}',
                            upload: {
                                types: ['jpeg', 'png', 'gif', 'jpg', 'webp']
                            }
                        },
                        toolbar: {
                            items: [
                                'heading', '|',
                                'fontSize', 'fontFamily', '|',
                                'fontColor', 'fontBackgroundColor', '|',
                                'bold', 'italic', 'underline', 'strikethrough', '|',
                                'alignment:left', 'alignment:center', 'alignment:right', 'alignment:justify',
                                '|',
                                'bulletedList', 'numberedList', '|',
                                'outdent', 'indent', '|',
                                'link', 'imageUpload', 'mediaEmbed', '|',
                                'blockQuote', 'insertTable', '|',
                                'undo', 'redo'
                            ]
                        },
                        alignment: {
                            options: ['left', 'center', 'right', 'justify']
                        },
                        heading: {
                            options: [{
                                    model: 'paragraph',
                                    title: '段落',
                                    class: 'ck-heading_paragraph'
                                },
                                {
                                    model: 'heading1',
                                    view: 'h1',
                                    title: '標題 1',
                                    class: 'ck-heading_heading1'
                                },
                                {
                                    model: 'heading2',
                                    view: 'h2',
                                    title: '標題 2',
                                    class: 'ck-heading_heading2'
                                },
                                {
                                    model: 'heading3',
                                    view: 'h3',
                                    title: '標題 3',
                                    class: 'ck-heading_heading3'
                                }
                            ]
                        },
                        fontSize: {
                            options: [
                                'tiny',
                                'small',
                                'default',
                                'big',
                                'huge'
                            ]
                        },
                        fontFamily: {
                            options: [
                                'default',
                                '微軟正黑體',
                                '新細明體',
                                '標楷體',
                                'Arial',
                                'Times New Roman'
                            ]
                        },
                        image: {
                            toolbar: [
                                'imageTextAlternative', '|',
                                'imageStyle:alignLeft',
                                'imageStyle:alignCenter',
                                'imageStyle:alignRight', '|',
                                'imageStyle:full',
                                'imageStyle:side'
                            ],
                            styles: [
                                'full',
                                'side',
                                'alignLeft',
                                'alignCenter',
                                'alignRight'
                            ]
                        },
                        table: {
                            contentToolbar: [
                                'tableColumn',
                                'tableRow',
                                'mergeTableCells',
                                'tableCellProperties',
                                'tableProperties'
                            ]
                        },
                        mediaEmbed: {
                            previewsInData: true
                        }
                    })
                    .then(newEditor => {
                        editor = newEditor;
                    })
                    .catch(error => {
                        console.error('編輯器初始化失敗', error);
                        alert('編輯器初始化失敗：' + error.message);
                    });

            });
        </script>
    @endpush
@endsection
