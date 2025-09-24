@extends('frontend.layouts.app')

@push('app-content')
    <header>
        <div class="container">
            <div class="row">
                <div class="col-12 px-md-0">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb bg-transparent justify-content-md-end">
                            <li class="breadcrumb-item"><a href="./">홈</a></li>
                            <li class="breadcrumb-item active" aria-current="page">회원 로그인</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </header>

    <article class="page-wrapper my-3">
        <div class="container">
            <div class="page-title">
                <h2 class="text-black text-center font-weight-bold mb-0 aos-init aos-animate" data-aos="zoom-in-up"
                    data-aos-delay="450">회원 로그인</h2>
                <h4 class="text-center text-gold mb-4 aos-init aos-animate" data-aos="zoom-in-up" data-aos-delay="600">
                    Member Login</h4>
                <hr class="page_line aos-init aos-animate" data-aos="flip-right" data-aos-delay="0"
                    data-aos-duration="3000">
            </div>

            <section data-aos="fade-zoom-in" data-aos-easing="ease-in-back" data-aos-delay="750" data-aos-offset="0"
                class="aos-init aos-animate">
                <div class="row justify-content-center py-3">
                    <div class="col-md-7 col-sm-12 my-3">
                        <form method="post" action="{{ route('login.process') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group row mb-3">
                                <label for="inputEmail" class="col-sm-3 col-form-label text-md-right text-sm-left">
                                    <span class="text-danger">*</span>이메일
                                </label>
                                <div class="col-sm-7">
                                    <input type="email" 
                                           class="form-control @error('email') is-invalid @enderror" 
                                           id="inputEmail" 
                                           name="email" 
                                           value="{{ old('email') }}" 
                                           required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="form-group row mb-3">
                                <label for="inputPassword" class="col-sm-3 col-form-label text-md-right text-sm-left">
                                    <span class="text-danger">*</span>비밀번호
                                </label>
                                <div class="col-sm-7">
                                    <input type="password" 
                                           class="form-control @error('password') is-invalid @enderror" 
                                           id="inputPassword" 
                                           name="password" 
                                           required>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-3">
                                <div class="col-sm-7 offset-sm-3 py-3">
                                    <button class="btn btn-lg btn-danger btn-purchase btn-block rounded-pill"
                                        type="submit">확인 전송</button>
                                </div>
                            </div>

                            <div class="form-group row mb-3">
                                <div class="col-sm-7 offset-sm-3 text-center">
                                    <div class="row">
                                        <div class="col-md-6 col-6 py-3">
                                            <a href="{{ route('join') }}"
                                                class="btn btn-default btn-lg btn-block text-white bg-search rounded p-t14 hvr-bounce-in">회원가입</a>
                                        </div>
                                        <div class="col-md-6 col-6 py-3">
                                            <a href="{{ route('forget') }}"
                                                class="btn btn-default btn-lg btn-block text-white bg-search rounded p-t14 hvr-bounce-in">비밀번호 찾기</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </section>

        </div>
    </article>
@endpush
