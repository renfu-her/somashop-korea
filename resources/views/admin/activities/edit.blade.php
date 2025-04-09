@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">編輯活動</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.activities.update', $activity) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="title" class="form-label">標題</label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror"
                                    id="title" name="title" value="{{ old('title', $activity->title) }}" required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="subtitle" class="form-label">副標題</label>
                                <input type="text" class="form-control @error('subtitle') is-invalid @enderror"
                                    id="subtitle" name="subtitle" value="{{ old('subtitle', $activity->subtitle) }}"
                                    required>
                                @error('subtitle')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="image" class="form-label">圖片  (<span class="text-danger">寬度 800px，高度不限</span>)</label>
                                @if ($activity->image)
                                    <div class="mb-2">
                                        <img src="{{ asset('storage/activities/' . $activity->id . '/' . $activity->image) }}"
                                            width="200">
                                    </div>
                                @endif
                                <input type="file" class="form-control @error('image') is-invalid @enderror"
                                    id="image" name="image">
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="date" class="form-label">日期</label>
                                <input type="text" class="form-control flatpickr @error('date') is-invalid @enderror"
                                    id="date" name="date" value="{{ old('date', $activity->date) }}" required>
                                @error('date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="content" class="form-label">內容</label>
                                <textarea class="form-control ckeditor @error('content') is-invalid @enderror" id="content" name="content" rows="10">{{ old('content', $activity->content) }}</textarea>
                                @error('content')
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
                                    value="1" {{ old('is_active', $activity->is_active) == 1 ? 'checked' : '' }}>
                                <label class="form-check-label p-1" for="is_active">啟用廣告</label>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">
                                    更新活動
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

@include('admin.partials.ckeditor')

@push('scripts')
    <script>
        $(document).ready(function() {
            $('form').on('submit', function(e) {
                const content = editor.getData();
                if (!content.trim()) {
                    e.preventDefault();
                    alert('請填寫活動內容');
                    return false;
                }
                $('#content').val(content);
            });

            $('#date').datepicker({
                language: 'zh-TW',
                autoclose: true,
                todayHighlight: true
            });
        });
    </script>
@endpush
