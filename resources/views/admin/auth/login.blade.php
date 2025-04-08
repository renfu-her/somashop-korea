@extends('admin.layouts.auth')

@section('title', '管理員登入')

@section('content')
    <div class="login-container">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-5">
                    <div class="d-flex justify-content-center mb-3">
                        <img src="{{ asset('frontend/img/logo.png') }}" alt="logo" style="height: 100px;">
                    </div>
                    <div class="card shadow">
                        <div class="card-header bg-primary text-white text-center py-3"
                            style="background-color: #4eadd7 !important;">

                            <h4 class="mb-0">管理後台登入</h4>
                        </div>
                        <div class="card-body p-4">
                            @if (session('error'))
                                <div class="alert alert-danger">
                                    {{ session('error') }}
                                </div>
                            @endif

                            <form method="POST" action="{{ route('admin.login') }}">
                                @csrf

                                <div class="mb-3">
                                    <label for="email" class="form-label">電子郵件</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        id="email" name="email" value="{{ old('email') }}" required autofocus>
                                    @error('email')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="password" class="form-label">密碼</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                        id="password" name="password" required>
                                    @error('password')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">驗證碼</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control @error('captcha') is-invalid @enderror"
                                            id="verify" name="captcha" required style="text-transform: uppercase"
                                            oninput="this.value = this.value.toUpperCase()">
                                        <div class="d-flex pl-2 align-self-center">
                                            <img src="{{ route('captcha.generate') }}" width="120" height="60"
                                                class="captchaImg" />
                                        </div>
                                        <div class="input-group-append">
                                            <label class="refresh mn-0">
                                                <a class="btn btn-refresh hvr-icon-spin">
                                                    更換 <i class="fas fa-sync-alt hvr-icon px-1"></i>
                                                </a>
                                            </label>
                                        </div>
                                        @error('captcha')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary">
                                        登入
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .btn-refresh {
            color: #666;
            padding: 0.375rem 0.75rem;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            cursor: pointer;
        }

        .btn-refresh:hover {
            color: #333;
        }

        .hvr-icon-spin {
            display: inline-block;
            vertical-align: middle;
            -webkit-transform: perspective(1px) translateZ(0);
            transform: perspective(1px) translateZ(0);
            position: relative;
        }

        .hvr-icon {
            -webkit-transform: translateZ(0);
            transform: translateZ(0);
            -webkit-transition-duration: 1s;
            transition-duration: 1s;
            -webkit-transition-property: transform;
            transition-property: transform;
            -webkit-transition-timing-function: ease-in-out;
            transition-timing-function: ease-in-out;
        }

        .hvr-icon-spin:hover .hvr-icon,
        .hvr-icon-spin:focus .hvr-icon,
        .hvr-icon-spin:active .hvr-icon {
            -webkit-transform: rotate(360deg);
            transform: rotate(360deg);
        }
    </style>
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {
            $('.btn-refresh').on('click', function() {
                $('#loading').fadeIn();
                $('.captchaImg').attr('src', '{{ route('captcha.generate') }}?' + new Date().getTime());
                $('#loading').fadeOut();
            });
        });
    </script>
@endpush
