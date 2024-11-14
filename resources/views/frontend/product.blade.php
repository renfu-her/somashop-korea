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
                            @if($currentCategory)
                                @if($currentCategory->parent_id > 0)
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
                                <div class="col-md-4 col-6 my-md-3 my-2 px-md-3 pl-2 pr-1" data-aos="zoom-in"
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
                                                @if($product->sub_title)
                                                    <h6 class="card-subtitle mb-2 text-muted">{{ $product->sub_title }}</h6>
                                                @endif
                                                <h6 class="card-text">原價 NT$ {{ number_format($product->price) }}</h6>
                                                <h5 class="card-text text-danger">現金價 NT$
                                                    {{ number_format($product->cash_price) }}</h5>
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
