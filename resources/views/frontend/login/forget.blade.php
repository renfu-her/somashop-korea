@extends('frontend.layouts.app')

@push('app-content')
    <header>
        <div class="container">
            <div class="row">
                <div class="col-12 px-md-0">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb bg-transparent justify-content-md-end">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">홈</a></li>
                            <li class="breadcrumb-item active" aria-current="page">비밀번호 찾기</li>
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
                <h2 class="text-black text-center font-weight-bold mb-0" data-aos="zoom-in-up" data-aos-delay="450">비밀번호 찾기
                </h2>
                <h4 class="text-center text-gold mb-4" data-aos="zoom-in-up" data-aos-delay="600">Forget Password</h4>
                <hr class="page_line" data-aos="flip-right" data-aos-delay="0" data-aos-duration="3000">
                <p class="p-t14 text-center" data-aos="zoom-in-up" data-aos-delay="700">등록하신 이메일 주소를 입력해주세요. 비밀번호가 이메일로 전송됩니다.
                </p>
            </div>

            <section data-aos="fade-zoom-in" data-aos-easing="ease-in-back" data-aos-delay="900" data-aos-offset="0">
                <div class="row justify-content-center">
                    <div class="col-md-7 col-sm-12 my-3">
                        <form method="post" action="{{ route('forget.process') }}" enctype="multipart/form-data"
                            onsubmit="return checkform();">
                            @csrf
                            <div class="form-group row mb-3">
                                <label for="email" class="col-sm-3 col-form-label text-md-right text-sm-left pr-0">
                                    <span class="text-danger">*</span>이메일
                                </label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" id="email" placeholder="" required
                                        name="email">
                                </div>
                            </div>

                            <div class="form-group row mb-3">
                                <label class="col-sm-3 col-form-label text-md-right pr-0 align-self-center"><span
                                        class="text-danger">*</span>우측 인증번호 입력</label>
                                <div class="col-sm-7 align-self-center">
                                    <div class="input-group">
                                        <input type="text" class="form-control align-self-center" id="captcha"
                                            placeholder="" required name="captcha" style="text-transform: uppercase"
                                            oninput="this.value = this.value.toUpperCase()">
                                        <div class="d-flex pl-2 align-self-center">
                                            <img src="{{ route('captcha.generate') }}" width="120" height="60"
                                                class="captchaImg" />
                                        </div>
                                        <div class="input-group-append">
                                            <label class="refresh mn-0">
                                                <button class="btn btn-refresh hvr-icon-spin" type="submit">변경 <i
                                                        class="fas fa-sync-alt hvr-icon px-1"></i>
                                                </button>
                                            </label>
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
