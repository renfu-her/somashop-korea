@extends('frontend.layouts.app')

@push('app-content')
    <header>
        <div class="container">
            <div class="row">
                <div class="col-12 px-md-0">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb bg-transparent justify-content-md-end">
                            <li class="breadcrumb-item"><a href="./">首頁</a></li>
                            <li class="breadcrumb-item active" aria-current="page">會員登入</li>
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
                    data-aos-delay="450">會員登入</h2>
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
                            <div class="form-group row mb-3">
                                <label for="inputEmail" class="col-sm-3 col-form-label text-md-right text-sm-left"><span
                                        class="text-danger">*</span>電子郵件 </label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" id="inputEmail" placeholder="" required=""
                                        name="email">
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <label for="inputPassword" class="col-sm-3 col-form-label text-md-right text-sm-left"><span
                                        class="text-danger">*</span>密碼</label>
                                <div class="col-sm-7">
                                    <input type="password" class="form-control" id="inputPassword" placeholder=""
                                        required="" name="password">
                                </div>
                            </div>

                            <div class="form-group row mb-3">
                                <div class="col-sm-7 offset-sm-3 py-3">
                                    <button class="btn btn-lg btn-danger btn-purchase btn-block rounded-pill"
                                        type="submit">確認送出</button>
                                </div>
                            </div>

                            <div class="form-group row mb-3">
                                <div class="col-sm-7 offset-sm-3 text-center">
                                    <div class="row">
                                        <div class="col-md-6 col-6 py-3">
                                            <a href="{{ route('join') }}"
                                                class="btn btn-default btn-lg btn-block text-white bg-search rounded p-t14 hvr-bounce-in">加入會員</a>
                                        </div>
                                        <div class="col-md-6 col-6 py-3">
                                            <a href="forget.php"
                                                class="btn btn-default btn-lg btn-block text-white bg-search rounded p-t14 hvr-bounce-in">忘記密碼</a>
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
