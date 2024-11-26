@extends('frontend.layouts.app')

@push('app-content')
    @if ($ads->count() > 0)
        <div class="container px-0 mb-5">
            <header id="babyinCarousel" class="carousel slide" data-ride="carousel" data-interval="4000">
                <ol class="carousel-indicators">
                    @foreach ($ads as $ad)
                        <li data-target="#babyinCarousel" data-slide-to="{{ $loop->index }}"
                            class="{{ $loop->first ? 'active' : '' }}"></li>
                    @endforeach
                </ol>
                <div class="carousel-inner">
                    @foreach ($ads as $ad)
                        <a class="carousel-item {{ $loop->first ? 'active' : '' }}"
                            @if (!empty($ad->url)) href="{{ $ad->url }}" @endif>
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

    @if ($actives->count() > 0)
        <div class="container mb-5 mt-5">
            <h2 class="text-center font-weight-bold mb-0" data-aos="zoom-in-up" data-aos-delay="300"
                data-aos-anchor-placement="top-bottom" data-aos-offset="0" data-aos-once="true">活動訊息</h2>
            <h4 class="text-center text-gold mb-4" data-aos="zoom-in-up" data-aos-delay="350"
                data-aos-anchor-placement="top-bottom" data-aos-offset="0" data-aos-once="true">Activity Message</h4>

            <div id="MessageCarousel" class="carousel slide" data-interval="false">
                <div class="carousel-inner">
                    @foreach ($actives->chunk(3) as $key => $chunk)
                        <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                            <div class="row">
                                @foreach ($chunk as $active)
                                    <div class="col-md-4">
                                        <a href="{{ route('activity.detail', $active->id) }}" class="activity-card">
                                            <div class="card border-0">
                                                <div class="card-img-wrapper">
                                                    <img src="{{ asset('storage/activities/' . $active->id . '/' . $active->image) }}"
                                                        alt="{{ $active->title }}">
                                                </div>
                                                <div class="card-body px-0">
                                                    <p class="card-text mb-1">
                                                        <small
                                                            class="text-gold">{{ $active->created_at->format('Y-m-d') }}</small>
                                                    </p>
                                                    <h4 class="card-title">{{ $active->title }}</h4>
                                                    <p class="card-text">{{ $active->subtitle }}</p>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
                <a class="carousel-control-prev" href="#MessageCarousel" role="button" data-slide="prev">
                    <i class="fas fa-chevron-left"></i>
                </a>
                <a class="carousel-control-next" href="#MessageCarousel" role="button" data-slide="next">
                    <i class="fas fa-chevron-right"></i>
                </a>
            </div>
        </div>
    @endif

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
                            @if ($ad->link) href="{{ $ad->link }}" @endif>
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

    @if ($hotProducts->count() > 0)
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
                                        @if ($product->is_new)
                                            <b class="float-tag text-white bg-danger">新品</b>
                                        @endif
                                    </div>
                                    <div class="card-body px-0">
                                        <h5 class="card-title">{{ $product->name }}</h5>
                                        <p class="card-text">{{ $product->sub_title }}</p>
                                        @if ($product->price)
                                            <div class="original-price mb-1">原價 NT$ {{ number_format($product->price) }}
                                            </div>
                                        @endif
                                        <h5 class="card-text text-danger">優惠價 NT$
                                            {{ number_format($product->cash_price) }}</h5>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
@endpush

@push('styles')
    <style>
        /* 輪播圖響應式設計 */
        #babyinCarousel .carousel-item img,
        #homeAdsCarousel .carousel-item img {
            width: 100%;
            height: auto;
            max-height: 400px;
            object-fit: cover;
        }

        @media (max-width: 768px) {

            #babyinCarousel .carousel-item img,
            #homeAdsCarousel .carousel-item img {
                height: 250px;
            }
        }

        @media (max-width: 576px) {

            #babyinCarousel .carousel-item img,
            #homeAdsCarousel .carousel-item img {
                height: 200px;
            }
        }

        /* 活動訊息卡片樣式 */
        .activity-card {
            display: block;
            text-decoration: none;
            color: inherit;
        }

        .activity-card:hover {
            text-decoration: none;
            color: inherit;
        }

        .activity-card .card-img-wrapper {
            position: relative;
            width: 100%;
            padding-top: 75%;
            /* 4:3 比例 */
            overflow: hidden;
        }

        .activity-card .card-img-wrapper img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* 輪播控制樣式 */
        #MessageCarousel .carousel-control-prev,
        #MessageCarousel .carousel-control-next {
            width: 40px;
            height: 40px;
            background: rgba(0, 0, 0, 0.2);
            border-radius: 50%;
            top: 30%;
            transform: translateY(-50%);
            opacity: 1;
        }

        #MessageCarousel .carousel-control-prev {
            left: -50px;
        }

        #MessageCarousel .carousel-control-next {
            right: -50px;
        }

        #MessageCarousel .carousel-control-prev:hover,
        #MessageCarousel .carousel-control-next:hover {
            background: rgba(0, 0, 0, 0.4);
        }

        #MessageCarousel .carousel-item {
            display: none !important;
        }

        #MessageCarousel .carousel-item.active {
            display: block !important;
        }


        #MessageCarousel .fas {
            color: #fff;
            font-size: 20px;
        }

        /* 輪播動畫 */
        #MessageCarousel .carousel-item {
            transition: transform .6s ease-in-out;
        }

        .original-price {
            position: relative;
            color: #6c757d;
            display: inline-block;
            font-size: 0.9rem;
        }

        .original-price::after {
            content: '';
            position: absolute;
            left: 0;
            top: 55%;
            width: 100%;
            height: 1px;
            background-color: #6c757d;
            opacity: 0.8;
        }
    </style>
@endpush
