@extends('frontend.layouts.app')

@section('title', '회원가입')

@push('app-content')
    <header>
        <div class="container">
            <div class="row">
                <div class="col-12 px-md-0">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb bg-transparent justify-content-md-end">
                            <li class="breadcrumb-item"><a href="./">홈</a></li>
                            <li class="breadcrumb-item active" aria-current="page">회원가입</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </header>

    <!-- Page Content Start -->
    <article class="page-wrapper my-3">
        <div class="container">
            <div class="page-title">
                <h2 class="text-black text-center font-weight-bold mb-0" data-aos="zoom-in-up" data-aos-delay="450">회원가입
                </h2>
                <h4 class="text-center text-gold mb-4" data-aos="zoom-in-up" data-aos-delay="600">Join Member</h4>
                <hr class="page_line" data-aos="flip-right" data-aos-delay="0" data-aos-duration="3000">
            </div>

            <section data-aos="fade-zoom-in" data-aos-easing="ease-in-back" data-aos-delay="750" data-aos-offset="0">
                <div class="row justify-content-center py-3">
                    <div class="col-md-7 col-sm-12 my-3">
                        <form method="post" action="{{ route('join.process') }}" enctype="multipart/form-data"
                            onsubmit="return checkform();">
                            @csrf
                            <div class="form-group row mb-3">
                                <label for="inputEmail"
                                    class="col-sm-3 col-form-label text-md-right text-sm-left align-self-center"><span
                                        class="text-danger">*</span>이메일 </label>
                                <div class="col-sm-7 align-self-center">
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        id="inputEmail" name="email" value="{{ old('email') }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-3">
                                <label for="password"
                                    class="col-sm-3 col-form-label text-md-right text-sm-left align-self-center"><span
                                        class="text-danger">*</span>비밀번호 </label>
                                <div class="col-sm-7 align-self-center">
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                        id="password" name="password" required>
                                    <span class="text-danger">(최소 8자 이상, 대소문자 영문, 숫자 포함)</span>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-3">
                                <label for="password_confirmation"
                                    class="col-sm-3 col-form-label text-md-right text-sm-left align-self-center"><span
                                        class="text-danger">*</span>비밀번호 확인 </label>
                                <div class="col-sm-7 align-self-center">
                                    <input type="password" class="form-control" id="password_confirmation"
                                        placeholder="비밀번호를 다시 입력해주세요" required name="password_confirmation">
                                </div>
                            </div>

                            <div class="form-group row mb-3">
                                <label for="name"
                                    class="col-sm-3 col-form-label text-md-right text-sm-left align-self-center"><span
                                        class="text-danger">*</span>성명</label>
                                <div class="col-sm-7 align-self-center">
                                    <input type="text" class="form-control" id="name" placeholder="실제 성명을 입력해주세요" required
                                        name="name" value="">
                                </div>
                            </div>

                            <div class="form-group row mb-3">
                                <label
                                    class="col-sm-3 col-form-label text-md-right text-sm-left align-self-center">성별</label>
                                <div class="col-sm-7 align-self-center">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="gender" id="male"
                                            value="1" checked>
                                        <label class="form-check-label" for="male">남성</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="gender" id="female"
                                            value="2">
                                        <label class="form-check-label" for="female">여성</label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row mb-3">
                                <label
                                    class="col-sm-3 col-form-label text-md-right text-sm-left align-self-center">생년월일</label>
                                <div class="col-sm-7 align-self-center">
                                    <div class="row">
                                        <div class="col-md-4 col-sm-12 py-2">
                                            <select name="year" class="form-control">
                                                <option value="0" selected="" disabled="">년</option>
                                                @for ($i = date('Y'); $i >= 1900; $i--)
                                                    <option value="{{ $i }}">{{ $i }}</option>
                                                @endfor
                                            </select>
                                        </div>
                                        <div class="col-md-4 col-sm-12 py-2">
                                            <select name="month" class="form-control">
                                                <option value="0" selected="" disabled="">월</option>
                                                @for ($i = 1; $i <= 12; $i++)
                                                    <option value="{{ $i }}">{{ $i }}月</option>
                                                @endfor
                                            </select>
                                        </div>
                                        <div class="col-md-4 col-sm-12 py-2">
                                            <select name="day" class="form-control">
                                                <option value="0" selected="" disabled="">일</option>
                                                @for ($i = 1; $i <= 31; $i++)
                                                    <option value="{{ $i }}">{{ $i }}日</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row mb-3">
                                <label class="col-sm-3 col-form-label text-md-right text-sm-left align-self-center"
                                    for="phone"><span class="text-danger">*</span>휴대폰</label>
                                <div class="col-sm-7 align-self-center">
                                    <input type="phone" class="form-control" id="phone" placeholder="전화번호를 입력해주세요"
                                        required name="phone" value="">
                                </div>
                            </div>


                            <div class="form-group row mb-3">
                                <label class="col-sm-3 col-form-label text-md-right text-sm-left"><span
                                        class="text-danger">*</span>주소</label>
                                <div class="col-sm-7">
                                    <div class="row">
                                        <div id="twzipcode" class="col-12">
                                            <div class="row">
                                                <div class="col-12 col-md-6 mb-2">
                                                    <select data-role="county" class="form-control"
                                                        name="county"></select>
                                                </div>
                                                <div class="col-12 col-md-6 mb-2">
                                                    <select data-role="district" class="form-control"
                                                        name="district"></select>
                                                </div>
                                            </div>
                                            <input type="hidden" data-role="zipcode" name="zipcode" />
                                        </div>
                                        <div class="col-12">
                                            <input type="text" class="form-control" id="address" placeholder=""
                                                required name="address" value="">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row mb-3">
                                <label class="col-sm-3 col-form-label text-md-right pr-0 align-self-center"><span
                                        class="text-danger">*</span>우측 인증번호 입력</label>
                                <div class="col-sm-7  align-self-center">
                                    <div class="input-group">
                                        <input type="text" class="form-control align-self-center" id="verify"
                                            placeholder="" required name="captcha" style="text-transform: uppercase"
                                            oninput="this.value = this.value.toUpperCase()">
                                        <div class="d-flex pl-2 align-self-center">
                                            <img src="{{ route('captcha.generate') }}" width="120" height="60"
                                                class="captchaImg" />
                                        </div>
                                        <div class="input-group-append">
                                            <label class="refresh mn-0">
                                                <a class="btn btn-refresh hvr-icon-spin">변경 <i
                                                        class="fas fa-sync-alt hvr-icon px-1"></i>
                                                </a>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row mb-3">
                                <div class="col-sm-7 offset-sm-3">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="agree" value="1"
                                                {{ old('agree') ? 'checked' : '' }}
                                                class="@error('agree') is-invalid @enderror" required>
                                            <a href="{{ route('member.agreement') }}" target="_blank"
                                                class="text-danger px-1">회원약관</a>을 읽고 동의합니다
                                        </label>
                                        @error('agree')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row mb-3">
                                <div class="col-sm-7 offset-sm-3 py-2">
                                    <input type="hidden" name="fb_id" value="">
                                    <button class="btn btn-lg btn-danger btn-purchase btn-block rounded-pill mb-3 hvr-grow"
                                        type="submit">확인 전송</button>
                                    <button class="btn btn-lg bg-secondary text-white btn-block rounded-pill mb-3 hvr-grow"
                                        type="reset">취소 후 다시 작성</button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </section>

        </div>
    </article>
@endpush

@push('scripts')
    <script src="{{ asset('frontend/js/jquery.twzipcode.min.js') }}"></script>
    <script>
        function checkform() {
            // Password validation
            const password = $('#password').val();
            const passwordConfirm = $('#password_confirmation').val();

            if (password !== passwordConfirm) {
                alert('입력한 비밀번호가 일치하지 않습니다');
                return false;
            }

            if (!/^(?=.*[A-Za-z])(?=.*\d).{6,15}$/.test(password)) {
                alert('비밀번호는 6~15자이며, 최소 하나의 영문자와 숫자를 포함해야 합니다');
                return false;
            }

            // Phone number validation
            const phone = $('#phone').val();
            if (!/^09\d{8}$/.test(phone)) {
                alert('유효한 휴대폰 번호를 입력해주세요');
                return false;
            }

            // Address validation
            const county = $('select[name="county"]').val();
            const district = $('select[name="district"]').val();
            const address = $('#address').val();

            if (!county || !district || !address) {
                alert('완전한 주소 정보를 입력해주세요');
                return false;
            }

            // Captcha validation
            const captcha = $('#verify').val();
            if (!captcha || captcha.length !== 5) {
                alert('5자리 인증번호를 입력해주세요');
                return false;
            }

            // Membership agreement consent
            if (!$('input[name="agree"]:checked').length) {
                errorMessage += '회원약관에 동의해주세요\n';
                $('input[name="agree"]').addClass('is-invalid');
                hasError = true;
            }

            return true;
        }

        // Real-time password validation
        $('#password_confirmation').on('input', function() {
            const password = $('#password').val();
            const confirmPassword = $(this).val();

            if (password !== confirmPassword) {
                $(this).addClass('is-invalid');
            } else {
                $(this).removeClass('is-invalid');
            }
        });

        // Real-time phone number validation
        $('#phone').on('input', function() {
            const phone = $(this).val();
            if (!/^09\d{8}$/.test(phone)) {
                $(this).addClass('is-invalid');
            } else {
                $(this).removeClass('is-invalid');
            }
        });

        $(document).ready(function() {
            $('#twzipcode').twzipcode();
        });
    </script>
@endpush
