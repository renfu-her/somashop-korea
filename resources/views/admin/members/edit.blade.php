@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">編輯會員</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.members.update', $member) }}">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="name" class="form-label">姓名</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name" value="{{ old('name', $member->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    id="email" name="email" value="{{ old('email', $member->email) }}" required
                                    readonly style="background-color: #e9ecef; opacity: 1;">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">密碼 <span class="text-danger">（如不修改請留空，規則：至少8個字元，包含大小寫英文、數字）</span></label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    id="password" name="password">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">確認密碼</label>
                                <input type="password" class="form-control" id="password_confirmation"
                                    name="password_confirmation">
                            </div>

                            <div class="mb-3">
                                <label for="phone" class="form-label">電話</label>
                                <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                    id="phone" name="phone" value="{{ old('phone', $member->phone) }}">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="address" class="form-label">地址</label>
                                <div class="row">
                                    <div id="twzipcode" class="col-12">
                                        <div class="row">
                                            <div class="col-12 col-md-6 mb-2">
                                                <select data-role="county"
                                                    class="form-control @error('county') is-invalid @enderror"
                                                    name="county">
                                                </select>
                                                @error('county')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-12 col-md-6 mb-2">
                                                <select data-role="district"
                                                    class="form-control @error('district') is-invalid @enderror"
                                                    name="district">
                                                </select>
                                                @error('district')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <input type="hidden" data-role="zipcode" name="zipcode" value="{{ old('zipcode', $member->zipcode ?? '') }}" />
                                    </div>
                                    <div class="col-12">
                                        <input type="text" class="form-control @error('address') is-invalid @enderror"
                                            id="address" name="address"
                                            value="{{ old('address', $member->address ?? '') }}" placeholder="請輸入詳細地址">
                                        @error('address')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3 d-flex align-items-center">
                                <input type="checkbox" class="form-check-input p-1" id="is_active" name="is_active"
                                    value="1" {{ old('is_active', $member->is_active) == 1 ? 'checked' : '' }}>
                                <label class="form-check-label p-1" for="is_active">啟用帳號</label>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">
                                    更新會員資料
                                </button>
                                <a href="{{ route('admin.members.index') }}" class="btn btn-outline-secondary">
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

@push('scripts')
    <script src="{{ asset('frontend/js/jquery.twzipcode.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#twzipcode').twzipcode({
                'zipcodeSel': '{{ old('zipcode', $member->zipcode ?? '') }}'
            });
        });
    </script>
@endpush

@push('styles')
<style>
    input[readonly] {
        background-color: #e9ecef !important;
        opacity: 1 !important;
    }
</style>
@endpush
