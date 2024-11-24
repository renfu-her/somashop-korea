@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">新增活動</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.activities.store') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-3">
                                <label for="title" class="form-label">標題</label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror"
                                    id="title" name="title" value="{{ old('title') }}" required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="subtitle" class="form-label">副標題</label>
                                <input type="text" class="form-control @error('subtitle') is-invalid @enderror"
                                    id="subtitle" name="subtitle" value="{{ old('subtitle') }}" required>
                                @error('subtitle')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="content" class="form-label">內容</label>
                                <textarea class="form-control @error('content') is-invalid @enderror" id="content" name="content" rows="10">{{ old('content') }}</textarea>
                                @error('content')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="image" class="form-label">圖片</label>
                                <input type="file" class="form-control @error('image') is-invalid @enderror"
                                    id="image" name="image">
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="date" class="form-label">日期</label>
                                <input type="text" class="form-control flatpickr @error('date') is-invalid @enderror"
                                    id="date" name="date" value="{{ old('date') }}" required>
                                @error('date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="sort_order" class="form-label">排序</label>
                                <input type="number" class="form-control @error('sort_order') is-invalid @enderror"
                                    id="sort_order" name="sort_order"
                                    value="{{ old('sort_order', $activity->sort_order ?? '') }}">
                                <small class="form-text text-muted">數字越小排序越前面，留空則自動排到最後</small>
                                @error('sort_order')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3 d-flex align-items-center">
                                <input type="checkbox" class="form-check-input p-1" id="is_active" name="is_active"
                                    value="1" {{ old('is_active') ? 'checked' : '' }}>
                                <label class="form-check-label p-1" for="is_active">啟用廣告</label>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">
                                    創建活動
                                </button>
                                <a href="{{ route('admin.activities.index') }}" class="btn btn-outline-secondary">
                                    返回列表
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

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
                            'alignment', '|', // 添加對齊功能
                            'bulletedList', 'numberedList', '|',
                            'outdent', 'indent', '|',
                            'link', 'imageUpload', 'mediaEmbed', '|',
                            'blockQuote', 'insertTable', '|',
                            'undo', 'redo'
                        ]
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

            // Flatpickr 初始化
            $('.flatpickr').flatpickr({
                locale: 'zh_tw'
            });
        });
    </script>
@endpush
