@extends('frontend.layouts.app')

@push('app-content')
    <header>
        <div class="container">
            <div class="row">
                <div class="col-12 px-md-0">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb bg-transparent justify-content-md-end">
                            <li class="breadcrumb-item"><a href="./">首頁</a></li>
                            <li class="breadcrumb-item active" aria-current="page">個人資料修改</li>
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
                <h2 class="text-black text-center font-weight-bold mb-0" data-aos="zoom-in-up" data-aos-delay="450">個人資料修改
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
                                    class="col-sm-3 col-form-label text-md-right text-sm-left align-self-center">電子郵件
                                </label>
                                <div class="col-sm-7 align-self-center">
                                    <input type="text" readonly class="form-control-plaintext" id="email"
                                        name="email" value="{{ $member->email }}">
                                </div>
                            </div>

                            <div class="form-group row mb-3">
                                <label for="password"
                                    class="col-sm-3 col-form-label text-md-right text-sm-left align-self-center"><span
                                        class="text-danger">*</span>密碼</label>
                                <div class="col-sm-7 align-self-center">
                                    <input type="password" class="form-control" id="password"
                                        placeholder="6~15字元，至少搭配 1 個英文字母" required name="pwd">
                                </div>
                            </div>

                            <div class="form-group row mb-3">
                                <label for="password_confirm"
                                    class="col-sm-3 col-form-label text-md-right text-sm-left align-self-center"><span
                                        class="text-danger">*</span>再次輸入密碼 </label>
                                <div class="col-sm-7 align-self-center">
                                    <input type="password" class="form-control" id="password_confirm" placeholder="請再輸入一次密碼"
                                        required name="repwd">
                                </div>
                            </div>

                            <div class="form-group row mb-3">
                                <label class="col-sm-3 col-form-label text-md-right text-sm-left align-self-center"
                                    for="phone"><span class="text-danger">*</span>手機</label>
                                <div class="col-sm-7 align-self-center">
                                    <input type="text" class="form-control" id="phone" placeholder="請輸入電話" required
                                        name="phone" value="{{ $member->phone }}">
                                </div>
                            </div>

                            <div class="form-group row mb-3">
                                <label class="col-sm-3 col-form-label text-md-right text-sm-left"><span
                                        class="text-danger">*</span>地址</label>
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
                                                placeholder="請輸入詳細地址" value="{{ $member->address }}">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row mb-3">
                                <div class="col-sm-7 offset-sm-3 py-2">
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
