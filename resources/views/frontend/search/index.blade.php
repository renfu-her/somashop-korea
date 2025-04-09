@extends('frontend.layouts.app')

@push('app-content')
    <header>
        <div class="container">
            <div class="row">
                <div class="col-12 px-md-0">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb bg-transparent justify-content-md-end">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">首頁</a></li>
                            <li class="breadcrumb-item active" aria-current="page">搜尋</li>
                            @if (request('search'))
                                <li class="breadcrumb-item active" aria-current="page">{{ request('search') }}</li>
                            @endif
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </header>

    <!-- Page Content Start -->
    <article class="page-wrapper my-3">
        <div class="container">
            <section class="page-content">
                <div class="row">
                    @forelse($products as $product)
                        <div class="col-lg-3 col-md-4 col-6 my-md-3 my-2 px-md-3 pl-2 pr-1" data-aos="zoom-in"
                            data-aos-delay="0" data-aos-anchor-placement="center-bottom">
                            <a href="{{ route('products.show', $product->id) }}">
                                <div class="card product-card border-0">
                                    <div class="card-top">
                                        <img src="{{ $product->primaryImageUrl }}" class="card-img-top img-fluid"
                                            alt="{{ $product->name }}">
                                    </div>
                                    <div class="card-body px-0">
                                        <h5 class="card-title">{{ $product->name }}</h5>
                                        <p class="card-text">{{ $product->sub_title }}</p>
                                        <div class="original-price mb-1">原價 NT$ {{ number_format($product->price) }}</div>
                                        <h5 class="card-text text-danger">優惠價 NT$ {{ number_format($product->spec_price) }}</h5>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @empty
                        <div class="col-12 text-center py-5">
                            <h4>未找到相關商品</h4>
                            <p class="text-muted">請嘗試其他關鍵字</p>
                        </div>
                    @endforelse
                </div>

                @if ($products->count() > 0)
                    <div class="my-5">
                        {{ $products->appends(request()->query())->links() }}
                    </div>
                @endif
            </section>
        </div>
    </article>
@endpush

@push('styles')
    <style>
        .card-top {
            overflow: hidden;
            position: relative;
            padding-top: 100%;
        }

        .card-top img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .product-card {
            transition: transform 0.2s;
        }

        .product-card:hover {
            transform: translateY(-5px);
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
