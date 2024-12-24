@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">新增免運設定</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.free-shippings.store') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="start_date" class="form-label">開始日期</label>
                                <input type="text" class="form-control flatpickr @error('start_date') is-invalid @enderror"
                                    id="start_date" name="start_date" value="{{ old('start_date') }}" required>
                                @error('start_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="end_date" class="form-label">結束日期</label>
                                <input type="text" class="form-control flatpickr @error('end_date') is-invalid @enderror"
                                    id="end_date" name="end_date" value="{{ old('end_date') }}">
                                @error('end_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="minimum_amount" class="form-label">最低消費金額</label>
                                <input type="number" step="0.01"
                                    class="form-control @error('minimum_amount') is-invalid @enderror" id="minimum_amount"
                                    name="minimum_amount" value="{{ old('minimum_amount') }}" required>
                                <small class="text-muted">請輸入達到免運費的最低消費金額</small>
                                @error('minimum_amount')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3 d-flex align-items-center">
                                <input type="checkbox" class="form-check-input p-1" id="is_active" name="is_active"
                                    value="1" {{ old('is_active') ? 'checked' : '' }}>
                                <label class="form-check-label p-1" for="is_active">是否啟用</label>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">新增活動</button>
                                <a href="{{ route('admin.free-shippings.index') }}"
                                    class="btn btn-outline-secondary">返回列表</a>
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
            $('.flatpickr').flatpickr({
                locale: 'zh_tw',
                enableTime: true,
                dateFormat: 'Y-m-d H:i',
                time_24hr: true
            });
        });
    </script>
@endpush

