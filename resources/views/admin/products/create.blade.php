{{-- resources/views/admin/products/create.blade.php --}}
@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">新增產品</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-3">
                                <label for="category_id" class="form-label">分類</label>
                                <select class="form-control @error('category_id') is-invalid @enderror" id="category_id"
                                    name="category_id" required>
                                    <option value="">請選擇分類</option>
                                    @foreach ($categories as $category)
                                        {{-- 父分類只作為標題顯示，不能選擇 --}}
                                        <option value="" disabled
                                            style="background-color: #f8f9fa; font-weight: bold;">
                                            {{ $category->name }}
                                        </option>
                                        {{-- 只顯示子分類供選擇 --}}
                                        @foreach ($category->children as $child)
                                            <option value="{{ $child->id }}"
                                                {{ old('category_id') == $child->id ? 'selected' : '' }}>
                                                ├─ {{ $child->name }}
                                            </option>
                                        @endforeach
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="name" class="form-label">產品名稱</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name" value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="sub_title" class="form-label">副標題</label>
                                <input type="text" class="form-control @error('sub_title') is-invalid @enderror"
                                    id="sub_title" name="sub_title" value="{{ old('sub_title') }}">
                                @error('sub_title')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">描述</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                                    cols="30" rows="10">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="price" class="form-label">原價</label>
                                <input type="number" class="form-control @error('price') is-invalid @enderror"
                                    id="price" name="price" value="{{ old('price') }}" required>
                                @error('price')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="cash_price" class="form-label">現金價</label>
                                <input type="number" class="form-control @error('cash_price') is-invalid @enderror"
                                    id="cash_price" name="cash_price" value="{{ old('cash_price') }}">
                                @error('cash_price')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="stock" class="form-label">庫存</label>
                                <input type="number" class="form-control @error('stock') is-invalid @enderror"
                                    id="stock" name="stock" value="{{ old('stock') }}" required>
                                @error('stock')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="images" class="form-label">新增圖片</label>
                                <input type="file" class="form-control @error('images.*') is-invalid @enderror"
                                    id="images" name="images[]" multiple accept="image/*">
                                <small class="text-muted">可以選擇多張圖片，第一張圖片將作為主圖</small>
                                @error('images.*')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <div id="imagePreview" class="row g-2"></div>
                            </div>

                            <div class="mb-3 d-flex align-items-center gap-4">
                                <div>
                                    <input type="checkbox" class="form-check-input p-1" id="is_active" name="is_active"
                                        value="1" {{ old('is_active') ? 'checked' : '' }}>
                                    <label class="form-check-label p-1" for="is_active">是否啟用</label>
                                </div>
                                <div>
                                    <input type="checkbox" class="form-check-input p-1" id="is_new" name="is_new"
                                        value="1" {{ old('is_new') ? 'checked' : '' }}>
                                    <label class="form-check-label p-1" for="is_new">新品標籤</label>
                                </div>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">
                                    創建產品
                                </button>
                                <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">
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
        /* 讓編輯器內容可以滾動 */
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
            let editor;

            ClassicEditor
                .create(document.querySelector('#description'), {
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
                            'bold', 'italic', 'underline', 'link', '|',
                            'bulletedList', 'numberedList', '|',
                            'imageUpload', 'blockQuote', 'insertTable', 'mediaEmbed', '|',
                            'undo', 'redo'
                        ]
                    },
                    image: {
                        toolbar: [
                            'imageTextAlternative', 'imageStyle:full', 'imageStyle:side'
                        ]
                    }
                })
                .then(newEditor => {
                    editor = newEditor;
                })
                .catch(error => {
                    console.error('編輯器初始化失敗', error);
                    alert('編輯器初始化失敗：' + error.message);
                });

            // 表單提交前驗證
            $('form').on('submit', function(e) {
                const description = editor.getData();

                if (!description.trim()) {
                    e.preventDefault();
                    alert('請填寫商品描述');
                    return false;
                }

                // 更新隱藏的 textarea 值
                $('#description').val(description);
            });

            // 圖片預覽代碼保持不變
            $('#images').on('change', function(e) {
                const $preview = $('#imagePreview');
                $preview.empty();

                $.each(e.target.files, function(index, file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        $preview.append(`
                    <div class="col-md-3 mb-2">
                        <div class="card">
                            <img src="${e.target.result}" class="card-img-top" alt="Preview">
                            <div class="card-body p-2">
                                <small class="text-muted">圖片 ${index + 1}</small>
                            </div>
                        </div>
                    </div>
                `);
                    }
                    reader.readAsDataURL(file);
                });
            });
        });
    </script>
@endpush
