@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">新增印章知識分類</div>

                    <div class="card-body">
                        <form action="{{ route('admin.seal-knowledge-category.store') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="name" class="form-label">分類名稱</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name" value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="sort" class="form-label">排序</label>
                                <input type="number" class="form-control @error('sort') is-invalid @enderror"
                                    id="sort" name="sort" value="{{ old('sort', 0) }}">
                                @error('sort')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3 d-flex align-items-center">
                                <input type="checkbox" class="form-check-input p-1" id="status" 
                                       name="status" value="1" {{ old('status') ? 'checked' : '' }}>
                                <label class="form-check-label p-1" for="status">啟用</label>
                            </div>


                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">
                                    創建分類
                                </button>
                                <a href="{{ route('admin.seal-knowledge-category.index') }}"
                                    class="btn btn-outline-secondary">
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
