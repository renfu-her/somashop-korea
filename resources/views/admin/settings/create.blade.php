@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">新增設定</div>

                    <div class="card-body">
                        <form action="{{ route('admin.settings.store') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="key" class="form-label required">設定名稱</label>
                                <input type="text" class="form-control @error('key') is-invalid @enderror"
                                    id="key" name="key" value="{{ old('key') }}" required>
                                <small class="form-text text-muted">只能包含字母、數字和底線，且必須以字母開頭</small>
                                @error('key')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="value" class="form-label required">設定值</label>
                                <input type="text" class="form-control @error('value') is-invalid @enderror"
                                    id="value" name="value" value="{{ old('value') }}" required>
                                @error('value')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">說明</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" 
                                    id="description" name="description" rows="3">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">儲存</button>
                                <a href="{{ route('admin.settings.index') }}"
                                    class="btn btn-outline-secondary">返回列表</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection 