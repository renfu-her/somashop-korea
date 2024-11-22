@extends('frontend.layouts.app')

@push('app-content')
    <header>
        <div class="container">
            <div class="row">
                <div class="col-12 px-md-0">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb bg-transparent justify-content-md-end">
                            <li class="breadcrumb-item">
                                <a href="{{ route('home') }}">首頁</a>
                            </li>
                            @if ($currentCategory)
                                @if ($currentCategory->parent_id > 0)
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('products.category', $currentCategory->parent->id) }}">
                                            {{ $currentCategory->parent->name }}
                                        </a>
                                    </li>
                                @endif
                                <li class="breadcrumb-item active" aria-current="page">
                                    <a href="{{ route('products.category', $currentCategory->id) }}">
                                        {{ $currentCategory->name }}
                                    </a>
                                </li>
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
            <div class="row">
                <aside class="sidebar col-md-3 pl-0 pr-5">
                    <div class="accordion" id="accordionLeftMenu">
                        @component('frontend.components.category-menu-item', [
                            'categories' => $categories,
                            'currentCategory' => $currentCategory,
                        ])
                        @endcomponent
                    </div>
                </aside>

                <section class="col-lg-9 col-md-12 col-12">
                    <div class="page-content">
                        <div class="row">
                            @foreach ($products as $product)
                                <div class="col-md-4 col-6 mb-4">
                                    <a href="{{ route('products.show', $product->id) }}">
                                        <div class="card product-card border-0">
                                            <div class="card-img-wrapper">
                                                <img src="{{ asset('storage/products/' . $product->id . '/' . $product->primaryImage->image_path) }}"
                                                    class="card-img-top" alt="{{ $product->name }}">
                                                @if ($product->is_new)
                                                    <span class="badge">新品</span>
                                                @endif
                                            </div>
                                            <div class="card-body px-0">
                                                <h5 class="card-title text-truncate">{{ $product->name }}</h5>
                                                @if ($product->sub_title)
                                                    <h6 class="card-subtitle mb-2 text-muted text-truncate">
                                                        {{ $product->sub_title }}</h6>
                                                @endif
                                                <p class="card-text mb-1">原價 NT$ {{ number_format($product->price) }}</p>
                                                <p class="card-text text-danger h5 mb-0">優惠價 NT$
                                                    {{ number_format($product->cash_price) }}</p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>

                        <div class="d-flex justify-content-center mt-4">
                            {{ $products->links() }}
                        </div>
                    </div>
                </section>


            </div>
        </div>
    </article>
@endpush

@push('styles')
    <style>
        .product-card .card-img-wrapper {
            position: relative;
            padding-top: 100%;
            /* 1:1 寬高比 */
            overflow: hidden;
        }

        .product-card .card-img-wrapper img {
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

        .product-card .badge {
            position: absolute;
            bottom: 0;
            left: 0;
            z-index: 2;
            background-color: #dc3545;
            color: white;
            font-size: 1rem;
            padding: 0.7em 1.4em;
            border-radius: 0;
            margin: 0;
        }

        .product-card .card-body {
            padding: 1rem;
            background-color: #fff;
        }

        .product-card .card-title {
            font-size: 1.1rem;
            margin-bottom: 0.5rem;
            color: #333;
        }

        .product-card .card-text {
            color: #666;
            margin-bottom: 0.25rem;
        }

        .product-card .text-danger {
            color: #dc3545 !important;
            font-weight: bold;
        }
    </style>
@endpush
