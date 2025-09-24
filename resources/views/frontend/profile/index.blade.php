@extends('frontend.layouts.app')

@push('app-content')
    <header>
        <div class="container">
            <div class="row">
                <div class="col-12 px-md-0">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb bg-transparent justify-content-md-end">
                            <li class="breadcrumb-item"><a href="./">홈</a></li>
                            <li class="breadcrumb-item active" aria-current="page">개인정보 수정</li>
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
                <h2 class="text-black text-center font-weight-bold mb-0" data-aos="zoom-in-up" data-aos-delay="450">개인정보 수정
                </h2>
                <h4 class="text-center text-gold mb-4" data-aos="zoom-in-up" data-aos-delay="600">Personal Data Modification
                </h4>
                <hr class="page_line" data-aos="flip-right" data-aos-delay="0" data-aos-duration="3000">
            </div>

            <section data-aos="fade-zoom-in" data-aos-easing="ease-in-back" data-aos-delay="750" data-aos-offset="0">
                <div class="row justify-content-center py-3">
                    <div class="col-md-7 col-sm-12 my-3">
                        <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group row mb-3">
                                <label for="staticEmail"
                                    class="col-sm-3 col-form-label text-md-right text-sm-left align-self-center">이메일
                                </label>
                                <div class="col-sm-7 align-self-center">
                                    <input type="text" readonly class="form-control-plaintext" id="email"
                                        name="email" value="{{ $member->email }}">
                                </div>
                            </div>

                            <div class="form-group row mb-3">
                                <label for="password"
                                    class="col-sm-3 col-form-label text-md-right text-sm-left align-self-center"><span
                                        class="text-danger">*</span>비밀번호</label>
                                <div class="col-sm-7 align-self-center">
                                    <input type="password" class="form-control" id="password"
                                        placeholder="6~15자, 최소 1개의 영문자 포함" required name="password">
                                </div>
                            </div>

                            <div class="form-group row mb-3">
                                <label for="password_confirm"
                                    class="col-sm-3 col-form-label text-md-right text-sm-left align-self-center"><span
                                        class="text-danger">*</span>비밀번호 확인 </label>
                                <div class="col-sm-7 align-self-center">
                                    <input type="password" class="form-control" id="password_confirm" placeholder="비밀번호를 다시 입력해주세요"
                                        required name="password_confirm">
                                </div>
                            </div>

                            <div class="form-group row mb-3">
                                <label class="col-sm-3 col-form-label text-md-right text-sm-left align-self-center"
                                    for="phone"><span class="text-danger">*</span>휴대폰</label>
                                <div class="col-sm-7 align-self-center">
                                    <input type="text" class="form-control" id="phone" placeholder="전화번호를 입력해주세요" required
                                        name="phone" value="{{ $member->phone }}">
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
                                                    <select data-role="county" class="form-control" name="county"></select>
                                                </div>
                                                <div class="col-12 col-md-6 mb-2">
                                                    <select data-role="district" class="form-control"
                                                        name="district"></select>
                                                </div>
                                            </div>
                                            <input type="hidden" data-role="zipcode" />
                                        </div>
                                        <div class="col-12">
                                            <input type="text" class="form-control" id="address" name="address"
                                                placeholder="상세 주소를 입력해주세요" value="{{ $member->address }}">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row mb-3">
                                <div class="col-sm-7 offset-sm-3 py-2">
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
        $(document).ready(function() {
            $('#twzipcode').twzipcode({
                "zipcodeSel": "{{ Auth::guard('member')->user()->zipcode }}",
            });
        });
    </script>
@endpush
