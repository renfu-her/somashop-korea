@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3>新增印章知識</h3>
                <a href="{{ route('admin.seal-knowledge.index') }}" class="btn btn-secondary">返回列表</a>
            </div>

            <div class="card-body">
                <form action="{{ route('admin.seal-knowledge.store') }}" method="POST">
                    @csrf

                    <div class="row">
                        <!-- 主要內容 -->
                        <div class="col-12 mb-4">
                            <div class="mb-3">
                                <label for="title" class="form-label required">標題</label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror"
                                    id="title" name="title" value="{{ old('title') }}" required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="content" class="form-label required">內容</label>
                                <textarea class="form-control @error('content') is-invalid @enderror" id="content" name="content" rows="10"
                                    required>{{ old('content') }}</textarea>
                                @error('content')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- 發布設定 -->
                        <div class="col-12 mb-4">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0">發布設定</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="category_id" class="form-label required">分類</label>
                                                <select class="form-control @error('category_id') is-invalid @enderror"
                                                    id="category_id" name="category_id" required>
                                                    <option value="">請選擇分類</option>
                                                    @foreach ($categories as $category)
                                                        <option value="{{ $category->id }}"
                                                            {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                            {{ $category->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('category_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="sort" class="form-label">排序</label>
                                                <input type="number" class="form-control @error('sort') is-invalid @enderror"
                                                    id="sort" name="sort" value="{{ old('sort', 0) }}">
                                                @error('sort')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label d-block">狀態</label>
                                                <div class="form-check form-switch">
                                                    <input type="checkbox" class="form-check-input" id="status" name="status"
                                                        value="1" {{ old('status', 1) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="status">啟用</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- SEO 設定 -->
                        <div class="col-12 mb-4">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0">SEO 設定</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="meta_title" class="form-label">Meta 標題</label>
                                                <input type="text" class="form-control" id="meta_title" name="meta_title"
                                                    value="{{ old('meta_title') }}">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="meta_description" class="form-label">Meta 描述</label>
                                                <textarea class="form-control" id="meta_description" name="meta_description" rows="3">{{ old('meta_description') }}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="meta_keywords" class="form-label">Meta 關鍵字</label>
                                                <input type="text" class="form-control" id="meta_keywords" name="meta_keywords"
                                                    value="{{ old('meta_keywords') }}">
                                                <small class="form-text text-muted">多個關鍵字請用逗號分隔</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">儲存</button>
                            <a href="{{ route('admin.seal-knowledge.index') }}" class="btn btn-secondary">取消</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function() {
                // 使用 CKEditor
                ClassicEditor
                    .create(document.querySelector('#content'))
                    .catch(error => {
                        console.error(error);
                    });
            });
        </script>
    @endpush
@endsection
