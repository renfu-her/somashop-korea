@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">編輯產品</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.products.update', $product) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="name" class="form-label">產品名稱</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name" value="{{ old('name', $product->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">描述</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" required>{{ old('description', $product->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="price" class="form-label">價格</label>
                                <input type="number" class="form-control @error('price') is-invalid @enderror"
                                    id="price" name="price" value="{{ old('price', $product->price) }}" required>
                                @error('price')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="stock" class="form-label">庫存</label>
                                <input type="number" class="form-control @error('stock') is-invalid @enderror"
                                    id="stock" name="stock" value="{{ old('stock', $product->stock) }}" required>
                                @error('stock')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="category_id" class="form-label">分類</label>
                                <select class="form-control @error('category_id') is-invalid @enderror" 
                                        id="category_id"
                                        name="category_id" 
                                        required>
                                    <option value="">請選擇分類</option>
                                    @foreach ($categories as $category)
                                        {{-- 父分類只作為標題顯示，不能選擇 --}}
                                        <option value="" disabled style="background-color: #f8f9fa; font-weight: bold;">
                                            {{ $category->name }}
                                        </option>
                                        {{-- 只顯示子分類供選擇 --}}
                                        @foreach ($category->children as $child)
                                            <option value="{{ $child->id }}" 
                                                {{ old('category_id', $product->category_id) == $child->id ? 'selected' : '' }}>
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
                                <label for="images" class="form-label">新增圖片</label>
                                <input type="file" class="form-control @error('images.*') is-invalid @enderror"
                                    id="images" name="images[]" multiple accept="image/*">
                                <small class="text-muted">可以選擇多張圖片上傳</small>
                                @error('images.*')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <div id="imagePreview" class="row g-2"></div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">現有圖片</label>
                                <div id="existingImages" class="row g-3">
                                    @foreach ($product->images as $image)
                                        <div class="col-md-3 product-image-card" data-image-id="{{ $image->id }}">
                                            <div class="card h-100">
                                                <div class="card-img-wrapper">
                                                    <img src="{{ $image->image_url }}" class="card-img-top"
                                                        alt="{{ $product->name }}">
                                                </div>
                                                <div class="card-footer p-2">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div class="form-check">
                                                            <input type="radio" class="form-check-input primary-image"
                                                                name="primary_image" value="{{ $image->id }}"
                                                                {{ $image->is_primary ? 'checked' : '' }}>
                                                            <label class="form-check-label small">主圖</label>
                                                        </div>
                                                        <button type="button"
                                                            class="btn btn-sm btn-outline-danger delete-image"
                                                            data-image-id="{{ $image->id }}">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="mb-3 d-flex align-items-center">
                                <input type="checkbox" class="form-check-input p-1" id="is_active" name="is_active"
                                    value="1" {{ old('is_active', $product->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label p-1" for="is_active">是否啟用</label>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">
                                    更新產品
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
        .product-image-card {
            position: relative;
            margin-bottom: 1rem;
        }

        .product-image-card .card {
            height: 100%;
            border: 1px solid rgba(0, 0, 0, .125);
        }

        .product-image-card .card-img-wrapper {
            position: relative;
            height: 200px;
            overflow: hidden;
            background-color: #f8f9fa;
        }

        .product-image-card .card-img-top {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .product-image-card .card-footer {
            background-color: #fff;
            border-top: 1px solid rgba(0, 0, 0, .125);
            padding: 0.5rem;
        }

        .product-image-card .form-check {
            margin: 0;
            padding-left: 1.5rem;
        }

        .product-image-card .form-check-input {
            margin-top: 0.25rem;
        }

        .product-image-card .form-check-label {
            font-size: 0.875rem;
            color: #6c757d;
        }

        .product-image-card .btn-outline-danger {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
            line-height: 1;
        }

        /* 拖曳時的視覺效果 */
        .sortable-ghost {
            opacity: 0.5;
        }

        .sortable-chosen {
            background-color: #f8f9fa;
        }

        /* 新增圖片預覽的樣式 */
        #imagePreview .product-image-card .card-footer {
            text-align: center;
            color: #6c757d;
        }

        /* 讓編輯器內容可以滾動 */
        .ck-editor__editable {
            height: 500px;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    <script src="{{ asset('ckeditor5/ckeditor.js') }}"></script>
    <script src="{{ asset('ckeditor5/zh.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            // CKEditor 初始化
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

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            
            // 定義產品ID供 AJAX 使用
            const productId = {{ $product->id }};

            // 圖片預覽
            $('#images').on('change', function(e) {
                const $preview = $('#imagePreview');
                $preview.empty();

                $.each(e.target.files, function(index, file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        $preview.append(`
                            <div class="col-md-3 product-image-card">
                                <div class="card h-100">
                                    <div class="card-img-wrapper">
                                        <img src="${e.target.result}" class="card-img-top" alt="Preview">
                                    </div>
                                    <div class="card-body">
                                        <small class="text-muted">新圖片 ${index + 1}</small>
                                    </div>
                                </div>
                            </div>
                        `);
                    }
                    reader.readAsDataURL(file);
                });
            });

            // 圖片排序
            new Sortable($('#existingImages')[0], {
                animation: 150,
                ghostClass: 'sortable-ghost',
                chosenClass: 'sortable-chosen',
                dragClass: 'sortable-drag',
                handle: '.card', // 整張卡片都可以拖曳
                onEnd: function() {
                    const images = $('#existingImages > div').map(function(index) {
                        return {
                            id: $(this).data('image-id'),
                            sort_order: index
                        };
                    }).get();

                    // 更新排序
                    $.ajax({
                        url: `/admin/products/${productId}/images/order`,
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: JSON.stringify({
                            images
                        }),
                        contentType: 'application/json'
                    });
                }
            });

            // 設置主圖
            $('.primary-image').on('change', function() {
                $.ajax({
                    url: `/admin/products/${productId}/images/${$(this).val()}/primary`,
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
            });

            // 刪除圖片
            $('.delete-image').on('click', function() {
                const $button = $(this);
                const imageId = $button.data('image-id');

                if (confirm('確定要刪除此圖片嗎？')) {
                    $.ajax({
                        url: `/admin/products/${productId}/images/${imageId}`,
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function() {
                            $button.closest('.col-md-3').remove();
                        }
                    });
                }
            });
        });
    </script>
@endpush
