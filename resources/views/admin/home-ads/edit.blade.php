@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">編輯小幅廣告</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.home-ads.update', $homeAd) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="title" class="form-label">標題</label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror"
                                    id="title" name="title" value="{{ old('title', $homeAd->title) }}" required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">當前圖片</label>
                                <div class="card" style="width: 200px;">
                                    <img src="{{ asset('storage/home_ads/' . $homeAd->image) }}" class="card-img-top"
                                        alt="{{ $homeAd->title }}">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="image" class="form-label">更換圖片 (<span class="text-danger">寬度
                                        1920px</span>)</label>
                                <input type="file" class="form-control @error('image') is-invalid @enderror"
                                    id="image" name="image" accept="image/*">
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div id="imagePreview" class="mt-2"></div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">當前縮小圖</label>
                                <div class="card" style="width: 200px;">
                                    <img src="{{ asset('storage/home_ads/' . $homeAd->image_thumb) }}" class="card-img-top"
                                        alt="{{ $homeAd->title }}">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="image_thumb" class="form-label">更換縮小圖 (<span class="text-danger">寬度
                                        800px</span>)</label>
                                <input type="file" class="form-control @error('image_thumb') is-invalid @enderror"
                                    id="image_thumb" name="image_thumb" accept="image/*">
                                @error('image_thumb')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="link" class="form-label">連結網址</label>
                                <input type="url" class="form-control @error('link') is-invalid @enderror"
                                    id="link" name="link" value="{{ old('link', $homeAd->link) }}"
                                    placeholder="https://">
                                @error('link')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="sort_order" class="form-label">排序（數字越小越前面）</label>
                                <input type="number" class="form-control @error('sort_order') is-invalid @enderror"
                                    id="sort_order" name="sort_order" value="{{ old('sort_order', $homeAd->sort_order) }}"
                                    min="0">
                                <small class="text-muted">請輸入數字，數字越小排序越前面</small>
                                @error('sort_order')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3 d-flex align-items-center">
                                <input type="checkbox" class="form-check-input p-1" id="is_active" name="is_active"
                                    value="1" {{ old('is_active', $homeAd->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label p-1" for="is_active">是否啟用</label>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">更新</button>
                                <a href="{{ route('admin.home-ads.index') }}" class="btn btn-outline-secondary">返回列表</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // 圖片預覽
            $('#image').on('change', function(e) {
                const $preview = $('#imagePreview');
                $preview.empty();

                if (this.files && this.files[0]) {
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        $preview.html(`
                        <div class="card" style="width: 200px;">
                            <img src="${e.target.result}" class="card-img-top" alt="預覽圖">
                        </div>
                    `);
                    }

                    reader.readAsDataURL(this.files[0]);
                }
            });
        });
    </script>
@endpush
