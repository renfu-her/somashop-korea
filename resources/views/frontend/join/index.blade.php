@extends('frontend.layouts.app')

@push('app-content')
    <header>
        <div class="container">
            <div class="row">
                <div class="col-12 px-md-0">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb bg-transparent justify-content-md-end">
                            <li class="breadcrumb-item"><a href="./">首頁</a></li>
                            <li class="breadcrumb-item active" aria-current="page">加入會員</li>
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
                <h2 class="text-black text-center font-weight-bold mb-0" data-aos="zoom-in-up" data-aos-delay="450">加入會員
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
                                        class="text-danger">*</span>電子郵件 </label>
                                <div class="col-sm-7 align-self-center">
                                    <input type="text" class="form-control" id="inputEmail" placeholder="此為日後登入帳號"
                                        required name="email" value="">
                                </div>
                            </div>

                            <div class="form-group row mb-3">
                                <label for="inputPassword"
                                    class="col-sm-3 col-form-label text-md-right text-sm-left align-self-center"><span
                                        class="text-danger">*</span>密碼</label>
                                <div class="col-sm-7 align-self-center">
                                    <input type="password" class="form-control" id="inputPassword"
                                        placeholder="6~15字元，至少搭配 1 個英文字母" required name="password">
                                </div>
                            </div>

                            <div class="form-group row mb-3">
                                <label for="inputPasswordAgain"
                                    class="col-sm-3 col-form-label text-md-right text-sm-left align-self-center"><span
                                        class="text-danger">*</span>再次輸入密碼 </label>
                                <div class="col-sm-7 align-self-center">
                                    <input type="password" class="form-control" id="inputPasswordAgain"
                                        placeholder="請再輸入一次密碼" required name="password_confirmation">
                                </div>
                            </div>

                            <div class="form-group row mb-3">
                                <label for="inputUsername"
                                    class="col-sm-3 col-form-label text-md-right text-sm-left align-self-center"><span
                                        class="text-danger">*</span>姓名</label>
                                <div class="col-sm-7 align-self-center">
                                    <input type="text" class="form-control" id="inputUsername" placeholder="請填真實姓名"
                                        required name="name" value="">
                                </div>
                            </div>

                            <div class="form-group row mb-3">
                                <label
                                    class="col-sm-3 col-form-label text-md-right text-sm-left align-self-center">性別</label>
                                <div class="col-sm-7 align-self-center">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="gender" id="male"
                                            value="1" checked>
                                        <label class="form-check-label" for="male">男</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="gender" id="female"
                                            value="2">
                                        <label class="form-check-label" for="female">女</label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row mb-3">
                                <label
                                    class="col-sm-3 col-form-label text-md-right text-sm-left align-self-center">生日</label>
                                <div class="col-sm-7 align-self-center">
                                    <div class="row">
                                        <div class="col-md-4 col-sm-12 py-2">
                                            <select name="year" class="form-control">
                                                <option value="0" selected="" disabled="">年</option>
                                                @for ($i = date('Y'); $i >= 1900; $i--)
                                                    <option value="{{ $i }}">{{ $i }}</option>
                                                @endfor
                                            </select>
                                        </div>
                                        <div class="col-md-4 col-sm-12 py-2">
                                            <select name="month" class="form-control">
                                                <option value="0" selected="" disabled="">月</option>
                                                @for ($i = 1; $i <= 12; $i++)
                                                    <option value="{{ $i }}">{{ $i }}月</option>
                                                @endfor
                                            </select>
                                        </div>
                                        <div class="col-md-4 col-sm-12 py-2">
                                            <select name="day" class="form-control">
                                                <option value="0" selected="" disabled="">日</option>
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
                                    for="inputPhone"><span class="text-danger">*</span>手機</label>
                                <div class="col-sm-7 align-self-center">
                                    <input type="phone" class="form-control" id="inputPhone" placeholder="請輸入電話"
                                        required name="phone" value="">
                                </div>
                            </div>

                            <div class="form-group row mb-3">
                                <label class="col-sm-3 col-form-label text-md-right text-sm-left"><span
                                        class="text-danger">*</span>地址</label>
                                <div class="col-sm-7">
                                    <div class="row">
                                        <div class="form-group col-md-6 col-sm-12">
                                            <select id="city" class="form-control" name="city" data-width="fit">
                                                <option value="" selected="" disabled="">縣市</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6 col-sm-12">
                                            <select id="city" class="form-control" name="district"
                                                data-width="fit">
                                                <option value="" selected="" disabled="">鄉鎮市區</option>
                                            </select>
                                        </div>
                                        <div class="col-md-12 col-sm-12">
                                            <input type="text" class="form-control" id="address" placeholder=""
                                                required name="address" value="">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row mb-3">
                                <label class="col-sm-3 col-form-label text-md-right pr-0 align-self-center"><span
                                        class="text-danger">*</span>輸入右方驗證碼</label>
                                <div class="col-sm-7  align-self-center">
                                    <div class="input-group">
                                        <input type="text" class="form-control align-self-center" id="verify"
                                            placeholder="" required name="captcha">
                                        <div class="d-flex pl-2 align-self-center">
                                            <img src="{{ route('captcha.generate') }}" width="68px" height="24px"
                                                class="img-fluid captchaImg" />
                                        </div>
                                        <div class="input-group-append">
                                            <label class="refresh mn-0">
                                                <a class="btn btn-refresh hvr-icon-spin">更換 <i
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
                                            <input type="checkbox" value="" name="agree" required>
                                            我已閱讀<a href="#" class="text-danger px-1"
                                                target="_blank">會員條款</a>並同意接受條款內容
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row mb-3">
                                <div class="col-sm-7 offset-sm-3 py-2">
                                    <input type="hidden" name="fb_id" value="">
                                    <button class="btn btn-lg btn-danger btn-purchase btn-block rounded-pill mb-3 hvr-grow"
                                        type="submit">確認送出</button>
                                    <button class="btn btn-lg bg-secondary text-white btn-block rounded-pill mb-3 hvr-grow"
                                        type="reset">取消重填</button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </section>

        </div>
    </article>
@endpush
