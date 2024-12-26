@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        編輯商品
                        <a href="{{ route('admin.products.specs.index', $product->id) }}"
                            class="btn btn-info btn-sm float-end">
                            管理商品規格
                        </a>
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.products.update', $product) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

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
                                <label for="sub_title" class="form-label">副標題</label>
                                <input type="text" class="form-control @error('sub_title') is-invalid @enderror"
                                    id="sub_title" name="sub_title" value="{{ old('sub_title', $product->sub_title) }}">
                                @error('sub_title')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="content" class="form-label">描述</label>
                                <textarea class="form-control @error('content') is-invalid @enderror" id="content" name="content" required>{{ old('content', $product->content) }}</textarea>
                                @error('content')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="price" class="form-label">售價</label>
                                <input type="number" class="form-control @error('price') is-invalid @enderror"
                                    id="price" name="price" value="{{ old('price', $product->price) }}" required>
                                @error('price')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="cash_price" class="form-label">優惠價</label>
                                <input type="number" class="form-control @error('cash_price') is-invalid @enderror"
                                    id="cash_price" name="cash_price"
                                    value="{{ old('cash_price', $product->cash_price) }}">
                                @error('cash_price')
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
                                @if ($product->primaryImage)
                                    <div class="mb-3">
                                        <label class="form-label">目前圖片</label>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="card h-100">
                                                    <div class="card-img-wrapper">
                                                        <img src="{{ $product->primaryImage->image_url }}"
                                                            class="card-img-top" alt="{{ $product->name }}">
                                                    </div>
                                                    <div class="card-footer p-2 text-center">
                                                        <button type="button"
                                                            class="btn btn-sm btn-outline-danger delete-image"
                                                            data-image-id="{{ $product->primaryImage->id }}">
                                                            刪除圖片
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <label for="image" class="form-label">
                                    {{ $product->primaryImage ? '更換圖片' : '上傳圖片' }}
                                    (<span class="text-danger">寬度 800px，高度不限</span>)
                                </label>
                                <input type="file" class="form-control @error('image') is-invalid @enderror"
                                    id="image" name="image" accept="image/*"
                                    {{ !$product->primaryImage ? 'required' : '' }}>
                                <small class="text-muted">
                                    {{ $product->primaryImage ? '上傳新圖片將會替換現有圖片' : '請上傳商品圖片' }}
                                </small>
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <div id="imagePreview" class="row g-2"></div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">產品規格 <small class="text-muted">(管理產品規格按鈕進行設定)</small></label>
                                <div class="border p-3 rounded">
                                    <div class="row">
                                        @foreach ($product->specs->chunk(4) as $specChunk)
                                            @foreach ($specChunk as $spec)
                                                <div class="col-md-3 mb-2">
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            style="margin-left: 3px;" id="spec_{{ $spec->id }}"
                                                            name="specs[]" value="{{ $spec->id }}"
                                                            {{ $spec->is_active == 1 ? 'checked' : '' }}
                                                            onclick="return false;">
                                                        <label class="form-check-label" for="spec_{{ $spec->id }}">
                                                            {{ $spec->name }}
                                                        </label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3 d-flex align-items-center gap-4">
                                <div>
                                    <input type="checkbox" class="form-check-input p-1" id="is_active" name="is_active"
                                        value="1" {{ old('is_active', $product->is_active) == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label p-1" for="is_active">是否啟用</label>
                                </div>
                                <div>
                                    <input type="checkbox" class="form-check-input p-1" id="is_new" name="is_new"
                                        value="1" {{ old('is_new', $product->is_new) == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label p-1" for="is_new">新品標籤</label>
                                </div>
                                <div>
                                    <input type="checkbox" class="form-check-input p-1" id="is_hot" name="is_hot"
                                        value="1" {{ old('is_hot', $product->is_hot) == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label p-1" for="is_hot">熱銷標籤</label>
                                </div>
                            </div>

                            <div class="card mt-4">
                                <div class="card-header">
                                    SEO 設定
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="meta_title" class="form-label">SEO 標題</label>
                                        <input type="text"
                                            class="form-control @error('meta_title') is-invalid @enderror" id="meta_title"
                                            name="meta_title" value="{{ old('meta_title', $product->meta_title) }}"
                                            maxlength="60">
                                        <small class="text-muted">建議長度：60 字元以內</small>
                                    </div>

                                    <div class="mb-3">
                                        <label for="meta_description" class="form-label">SEO 描述</label>
                                        <textarea class="form-control @error('meta_description') is-invalid @enderror" id="meta_description"
                                            name="meta_description" rows="3" maxlength="160">{{ old('meta_description', $product->meta_description) }}</textarea>
                                        <small class="text-muted">建議長度：160 字元以內</small>
                                    </div>

                                    <div class="mb-3">
                                        <label for="meta_keywords" class="form-label">SEO 關鍵字</label>
                                        <input type="text"
                                            class="form-control @error('meta_keywords') is-invalid @enderror"
                                            id="meta_keywords" name="meta_keywords"
                                            value="{{ old('meta_keywords', $product->meta_keywords) }}">
                                        <small class="text-muted">多個關鍵字請用逗號分隔</small>
                                    </div>
                                </div>
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
    </style>
@endpush

@include('admin.partials.ckeditor')

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>

    <script>
        $(document).ready(function() {
            // 表單提交前驗證
            $('form').on('submit', function(e) {
                const content = editor.getData();

                if (!content.trim()) {
                    e.preventDefault();
                    alert('請填寫商品描述');
                    return false;
                }

                // 更新隱藏的 textarea 值
                $('#content').val(content);
            });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // 定義產品ID供 AJAX 使��
            const productId = {{ $product->id }};

            // 圖片預覽
            $('#image').on('change', function(e) {
                const $preview = $('#imagePreview');
                $preview.empty();

                if (e.target.files && e.target.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        $preview.html(`
                            <div class="col-md-3">
                                <div class="card">
                                    <img src="${e.target.result}" class="card-img-top" alt="Preview">
                                    <div class="card-body p-2">
                                        <small class="text-muted">新圖片預覽</small>
                                    </div>
                                </div>
                            </div>
                        `);
                    }
                    reader.readAsDataURL(e.target.files[0]);
                }
            });

            // 刪除圖片
            $('.delete-image').on('click', function() {
                if (confirm('確定要刪除此圖片嗎？')) {
                    $.ajax({
                        url: `/admin/products/${productId}/image`,
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function() {
                            $('.card-img-wrapper').parent().parent().parent().remove();
                            $('#image').prop('required', true);
                        }
                    });
                }
            });
        });
    </script>
@endpush
