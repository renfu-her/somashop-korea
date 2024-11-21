@extends('frontend.layouts.app')

@push('app-content')
    @if ($ads->count() > 0)
        <div class="container px-0">
            <header id="babyinCarousel" class="carousel slide">
                <ol class="carousel-indicators">
                    @foreach ($ads as $ad)
                        <li data-target="#babyinCarousel" data-slide-to="{{ $loop->index }}"
                            class="{{ $loop->first ? 'active' : '' }}"></li>
                    @endforeach
                </ol>
                <div class="carousel-inner">
                    @foreach ($ads as $ad)
                        <a class="carousel-item {{ $loop->first ? 'active' : '' }}"
                            @if (!empty($ad->url)) href="{{ $ad->url }}" @endif target="_blank">
                            <img src="{{ asset('storage/ads/' . $ad->image) }}" class="d-block w-100" alt="">
                        </a>
                    @endforeach
                </div>
                <a class="carousel-control-prev text-black-50 w-auto" href="#babyinCarousel" role="button"
                    data-slide="prev">
                    <i class="fas fa-chevron-left"></i>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next text-black-50 w-auto" href="#babyinCarousel" role="button"
                    data-slide="next">
                    <i class="fas fa-chevron-right"></i>
                    <span class="sr-only">Next</span>
                </a>
            </header>
        </div>
    @endif

    {{-- TODO: 移除與我聯絡 --}}
    {{-- <div class="container py-4">
        <h2 class="text-center font-weight-bold mb-0 pt-5 aos-init aos-animate" data-aos="zoom-in-up" data-aos-delay="300"
            data-aos-offset="0" data-aos-once="true">
            <span class="bg-white px-5 py-2">與我聯絡</span>
        </h2>
        <h4 class="text-center text-gold aos-init aos-animate" data-aos="zoom-in-up" data-aos-delay="450"
            data-aos-offset="0" data-aos-once="true">
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
    </div> --}}

    <div class="container mb-5 mt-5">
        <h2 class="text-center font-weight-bold mb-0 aos-init aos-animate" data-aos="zoom-in-up" data-aos-delay="300"
            data-aos-anchor-placement="top-bottom" data-aos-offset="0" data-aos-once="true">活動訊息</h2>
        <h4 class="text-center text-gold mb-4 aos-init aos-animate" data-aos="zoom-in-up" data-aos-delay="350"
            data-aos-anchor-placement="top-bottom" data-aos-offset="0" data-aos-once="true">Activity Message</h4>
        <div class="row mx-auto my-auto">
            <div id="MessageCarousel" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner row w-100 mx-auto" role="listbox">

                    @foreach ($actives as $active)
                        <div class="carousel-item col-12 col-sm-6 col-md-4 col-lg-4 active">
                            <a href="{{ route('activity.detail', $active->id) }}">
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

    {{-- 中間廣告區塊 --}}
    @if ($homeAds->count() > 0)
        <div class="container px-0">
            <header id="homeAdsCarousel" class="carousel slide">
                <ol class="carousel-indicators">
                    @foreach ($homeAds as $ad)
                        <li data-target="#homeAdsCarousel" data-slide-to="{{ $loop->index }}"
                            class="{{ $loop->first ? 'active' : '' }}"></li>
                    @endforeach
                </ol>
                <div class="carousel-inner">
                    @foreach ($homeAds as $ad)
                        <a class="carousel-item {{ $loop->first ? 'active' : '' }}"
                            @if ($ad->link) href="{{ $ad->link }}" @endif target="_blank">
                            <img src="{{ asset('storage/home_ads/' . $ad->image) }}" class="d-block w-100"
                                alt="{{ $ad->title }}">
                        </a>
                    @endforeach
                </div>
                <a class="carousel-control-prev text-black-50 w-auto" href="#homeAdsCarousel" role="button"
                    data-slide="prev">
                    <i class="fas fa-chevron-left"></i>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next text-black-50 w-auto" href="#homeAdsCarousel" role="button"
                    data-slide="next">
                    <i class="fas fa-chevron-right"></i>
                    <span class="sr-only">Next</span>
                </a>
            </header>
        </div>
    @endif

    <div class="container mb-5 pt-5">
        <h2 class="text-center font-weight-bold mb-0 border-frame aos-init aos-animate" data-aos="zoom-in-up"
            data-aos-delay="300" data-aos-anchor-placement="top-bottom" data-aos-offset="0" data-aos-once="true">
            熱賣商品
        </h2>
        <h4 class="text-center text-gold mb-4 aos-init aos-animate" data-aos="zoom-in-up" data-aos-delay="350"
            data-aos-anchor-placement="top-bottom" data-aos-offset="0" data-aos-once="true">
            Hot items
            <div style="border-top: 1px solid #cbc8c8; margin: 20px 0; width: 100%"></div>
        </h4>
        <div class="page-content">
            <div class="row">
                @foreach ($hotProducts as $product)
                    <div class="col-md-4 col-6 my-md-3 my-2 px-md-3 pl-2 pr-1 aos-init aos-animate" data-aos="zoom-in"
                        data-aos-delay="0" data-aos-anchor-placement="center-bottom">
                        <a href="{{ route('products.show', $product->id) }}">
                            <div class="card product-card border-0">
                                <div class="card-top">
                                    <img src="{{ asset('storage/products/' . $product->id . '/' . $product->primaryImage->image_path) }}"
                                        class="card-img-top img-fluid" alt="{{ $product->name }}">
                                    <b class="float-tag text-white bg-danger">新品</b>
                                </div>
                                <div class="card-body px-0">
                                    <h5 class="card-title">{{ $product->name }}</h5>
                                    <p class="card-text">{{ $product->sub_title }}</p>
                                    @if ($product->original_price)
                                        <h6 class="card-text text-muted"
                                            style="text-decoration: line-through; color: black">
                                            原價 NT$ {{ number_format($product->original_price) }}
                                        </h6>
                                    @endif
                                    <h5 class="card-text text-danger">現金價 NT$ {{ number_format($product->price) }}</h5>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

@endpush

@push('styles')
    <style>
        #babyinCarousel .carousel-item img,
        #homeAdsCarousel .carousel-item img {
            width: 100%;
            height: 400px;
            object-fit: cover;
        }
    </style>
@endpush
