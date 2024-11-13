@extends('frontend.layouts.app')

@section('content')
@endsection

@push('home-content')
    <div class="container py-4">
        <h2 class="text-center font-weight-bold mb-0 pt-5 aos-init aos-animate" data-aos="zoom-in-up" data-aos-delay="300"
            data-aos-offset="0" data-aos-once="true">
            <span class="bg-white px-5 py-2">與我聯絡</span>
        </h2>
        <h4 class="text-center text-gold aos-init aos-animate" data-aos="zoom-in-up" data-aos-delay="450" data-aos-offset="0"
            data-aos-once="true">
            <span class="bg-white px-5">Contact Us</span>
        </h4>
        <hr class="w-100 my-0 mt-n4">

        <div class="row pt-5 aos-init aos-animate" data-aos="zoom-in-up" data-aos-delay="500" data-aos-offset="0"
            data-aos-once="true">
            <div class="col-md-8 col-12 mx-auto">
                <h1
                    class="large-address font-weight-bold rounded-pill text-center text-white bg-red t-40 px-md-0 px-2 py-4">
                    台北市萬華區莒光路302號</h1>
            </div>
            <div class="col-md-7 col-12 mx-auto py-5">
                <div class="row justify-content-center align-items-center">
                    <div class="col-md-3 col-6 px-md-0 px-4">
                        <a href="tel:(02)2302-5558" class="text-center hvr-bob">
                            <img src="{{ asset('frontend/img/ic_large_phone.png') }}" class="img-fluid px-md-0 px-3">
                            <p class="t-22 font-weight-bold text-nowrap pt-2">點我連結</p>
                        </a>
                    </div>
                    <div class="col-md-3 col-6 px-md-0 px-4">
                        <a href="https://www.facebook.com/babyin1688/" class="text-center hvr-bob" target="_blank">
                            <img src="{{ asset('frontend/img/ic_large_fb.png') }}" class="img-fluid px-md-0 px-3">
                            <p class="t-22 font-weight-bold text-nowrap pt-2">點我連結</p>
                        </a>
                    </div>
                    <div class="col-md-3 col-6 px-md-0 px-4">
                        <a href="https://line.me/ti/p/@zfa7556c" class="text-center hvr-bob" target="_blank">
                            <img src="{{ asset('frontend/img/ic_large_line.png') }}" class="img-fluid px-md-0 px-3">
                            <p class="t-22 font-weight-bold text-nowrap pt-2">點我連結</p>
                        </a>
                    </div>
                    <div class="col-md-3 col-6 px-md-0 px-4">
                        <a href="https://www.instagram.com/a0908512899/" class="text-center hvr-bob" target="_blank">
                            <img src="{{ asset('frontend/img/ic_large_ig.png') }}" class="img-fluid px-md-0 px-3">
                            <p class="t-22 font-weight-bold text-nowrap pt-2">點我連結</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Page Features -->
        <div class="row my-4" style="overflow-x: hidden; overflow-y: hidden;">
            <div class="col-md-4 offset-md-1 col-12 mb-md-0 mb-4 aos-init aos-animate" data-aos="zoom-in-right"
                data-aos-delay="450" data-aos-anchor-placement="top-bottom" data-aos-offset="0" data-aos-once="true">
                <img src="{{ asset('frontend/img/fea_01.png') }}" class="img-fluid align-self-center" alt="...">
            </div>
            <div class="col-md-7 col-12 align-self-center aos-init aos-animate" data-aos="zoom-in-left" data-aos-delay="450"
                data-aos-anchor-placement="top-bottom" data-aos-offset="0" data-aos-once="true">
                <h3 class="font-weight-bold mt-0">獨一無二客製化商品</h3>
                <h5 class="text-gold mt-0">純手工，精緻胎毛藝術工藝，藝術無價，精緻鑲工，把幸福一直延續下去</h5>
                <p class="mb-0">從事印章業界十幾餘年，不忍其中國文化傳承5000多餘年之歷史，漸行漸遠逐漸沒落，故大膽創立印章界之潮品牌「babyin」寶貝印
                    印鑑工坊進而推廣實行精緻刻印之精神及其專業服務態度.望能持續推廣中國文化之美與傳承</p>
            </div>
        </div>
    </div>

    <div class="container mb-5">
        <h2 class="text-center font-weight-bold mb-0 aos-init aos-animate" data-aos="zoom-in-up" data-aos-delay="300"
            data-aos-anchor-placement="top-bottom" data-aos-offset="0" data-aos-once="true">活動訊息</h2>
        <h4 class="text-center text-gold mb-4 aos-init aos-animate" data-aos="zoom-in-up" data-aos-delay="350"
            data-aos-anchor-placement="top-bottom" data-aos-offset="0" data-aos-once="true">Activity Message</h4>
        <div class="row mx-auto my-auto">
            <div id="MessageCarousel" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner row w-100 mx-auto" role="listbox">

                    @foreach ($actives as $active)
                        <div class="carousel-item col-12 col-sm-6 col-md-4 col-lg-4 active">
                            <a href="act_center.php?p=69">
                                <div class="card border-0">
                                    <img class="card-img-top img-fluid"
                                        src="{{ asset('storage/activities/' . $active->id . '/' . $active->image) }}"
                                        alt="">
                                    <div class="card-body px-0">
                                        <p class="card-text mb-1"><small
                                                class="text-gold">{{ $active->created_at->format('Y-m-d') }}</small></p>
                                        <h4 class="card-title">{{ $active->title }}</h4>
                                        <p class="card-text">{{ $active->subtitle }}</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach

                </div>

                <a class="carousel-control-prev text-black-50 w-auto" href="#MessageCarousel" role="button"
                    data-slide="prev">
                    <i class="fas fa-chevron-left"></i>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next text-black-50 w-auto" href="#MessageCarousel" role="button"
                    data-slide="next">
                    <i class="fas fa-chevron-right"></i>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>
    </div>

    <section class="parrallax py-5">
        <div class="container my-md-4 my-0">
            <div class="row mx-auto my-auto" style="overflow-x: hidden; overflow-y: hidden;">

                <div class="d-md-flex flex-md-equal w-100 pl-md-3 mb-5 aos-init aos-animate" data-aos="fade-down-left"
                    data-aos-delay="100" data-aos-anchor-placement="top-bottom" data-aos-once="true">
                    <div class="col-md-6 offset-md-6 col-12 mr-md-3 px-3 px-md-5 text-center overflow-hidden">
                        <div class="mx-auto">
                            <img src="{{ asset('assets/images/6551c1d1b17797fade62dc420cc5adc3.png') }}"
                                class="img-fluid">
                        </div>
                        <div class="p-3">
                            <h3 class="text-black display-5">傳承 永恆 對寶貝的期望</h3>
                            <p class="mb-0">將您對寶貝的祝福語＆期望交給我們</p>
                        </div>

                    </div>
                </div>

                <div class="d-md-flex flex-md-equal w-100 mt-n8 mt-sm-0 pl-md-3 mb-5 aos-init aos-animate"
                    data-aos="fade-down-right" data-aos-delay="450" data-aos-anchor-placement="top-bottom"
                    data-aos-once="true">
                    <div class="col-md-6 col-12 ml-md-3 px-3 px-md-5 text-center overflow-hidden">
                        <div class="mx-auto">
                            <img src="{{ asset('assets/images/4d140b0ae20490ae88f00a00083b5174.png') }}"
                                class="img-fluid">
                        </div>
                        <div class="p-3">
                            <h3 class="text-black display-5">飽滿的布局不漏財</h3>
                            <p class="mb-0">爸爸媽媽給予寶貝的見面禮、彌月禮</p>
                        </div>
                    </div>
                </div>

                <div class="d-md-flex flex-md-equal w-100 mt-n8 mt-sm-0 pl-md-3 aos-init aos-animate"
                    data-aos="fade-up-left" data-aos-delay="800" data-aos-anchor-placement="top-bottom"
                    data-aos-once="true">
                    <div class="col-md-6 offset-md-6 col-12 mr-md-3 px-3 px-md-5 text-center overflow-hidden">
                        <div class="mx-auto">
                            <img src="{{ asset('assets/images/8c5b9fdbffb5d6c1e3c189216cb3ced0.png') }}"
                                class="img-fluid">
                        </div>
                        <div class="py-3">
                            <h3 class="text-black display-5">新手媽咪首選</h3>
                            <p class="mb-0">爸爸媽媽給予寶貝的見面禮、彌月禮</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <div class="container my-3">

        <div class="row mx-auto my-5" style="overflow-x: hidden; overflow-y: hidden;">
            <div class="col-md-12 col-sm-12 py-2 aos-init aos-animate" data-aos="zoom-in-right" data-aos-offset="0"
                data-aos-once="true">
                <h2 class="text-dark font-weight-bold"><img src="{{ asset('frontend/img/logo_red.png') }}"></h2>
                <p class="text-justify mb-1">您好 歡迎來店挑選，我們將會有專人為您服務<span class="px-3">|</span> 營業時間 :
                    上午09:00~晚上21:00(全年無休)</p>
                <div class="card no-border p0 map-container"><iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3615.08330759507!2d121.49602831562903!3d25.031246744554526!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3442a9b1e1c611f5%3A0xb7f7029aa88763fc!2zMTA45Y-w5YyX5biC6JCs6I-v5Y2A6I6S5YWJ6LevMzAy6Jmf!5e0!3m2!1szh-TW!2stw!4v1561976370651!5m2!1szh-TW!2stw"
                        width="100%" height="320" frameborder="0" style="border:0" allowfullscreen=""></iframe>
                </div>
            </div>
        </div>
    </div>
@endpush
