@extends('frontend.layouts.app')

@section('meta_title', trim($product->meta_title) ? trim($product->meta_title) : $product->name . ' - 德善堂')
@section('meta_description', trim($product->meta_description))
@section('meta_keywords', trim($product->meta_keywords))

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
                            @if ($currentCategory->parent)
                                <li class="breadcrumb-item">
                                    <a href="{{ route('products.category', $currentCategory->parent->id) }}">
                                        {{ $currentCategory->parent->name }}
                                    </a>
                                </li>
                            @endif
                            <li class="breadcrumb-item">
                                <a href="{{ route('products.category', $currentCategory->id) }}">
                                    {{ $currentCategory->name }}
                                </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </header>

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

                <div class="col-lg-9 col-md-12 col-12">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="product-gallery">
                                <div class="main-image mb-3">
                                    <img src="{{ asset('storage/products/' . $product->id . '/' . $product->primaryImage->image_path) }}"
                                        class="img-fluid" alt="{{ $product->name }}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="product-info">
                                <h1 class="product-title">{{ $product->name }}</h1>
                                @if ($product->sub_title)
                                    <h5 class="text-muted">{{ $product->sub_title }}</h5>
                                @endif
                                <div class="product-price mt-4">
                                    <p class="mb-2">原價：NT$ {{ number_format($product->price) }}</p>
                                    <h3 class="text-danger">現金價：NT$ {{ number_format($product->cash_price) }}</h3>
                                </div>

                                <form action="{{ Auth::guard('member')->check() ? route('cart.add') : route('login') }}"
                                    @if (Auth::guard('member')->check()) method="POST"
                                    @else
                                        method="GET" @endif>
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="checkout_direct" id="checkout_direct" value="0">

                                    <div class="form-group row my-4">
                                        <label class="col-sm-2 col-form-label">規格</label>
                                        <div class="col-10 col-md-10">
                                            <select class="form-control" name="specification_id">
                                                <option value="">請選擇</option>
                                                @foreach ($product->specs as $spec)
                                                    <option value="{{ $spec->id }}">{{ $spec->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row my-4">
                                        <label class="col-sm-2 col-form-label">數量</label>
                                        <div class="col-sm-4">
                                            <div class="input-group">
                                                <button type="button"
                                                    class="btn btn-minus btn-light border btn-sm">-</button>
                                                <input type="text" class="form-control text-center" name="quantity"
                                                    value="1">
                                                <button type="button"
                                                    class="btn btn-plus btn-light border btn-sm">+</button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        @if (Auth::guard('member')->check())
                                            <div class="col-6">
                                                <button type="submit"
                                                    class="btn btn-danger w-100 rounded-pill checkout-btn">
                                                    立即訂購
                                                </button>
                                            </div>
                                            <div class="col-6">
                                                <button type="submit"
                                                    class="btn btn-outline-danger w-100 rounded-pill cart-btn">加入購物車</button>
                                            </div>
                                        @else
                                            <div class="col-12">
                                                <a href="{{ route('login') }}" class="btn btn-danger w-100 rounded-pill">
                                                    登入後購買
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                </form>
                            </div>

                        </div>
                        <div class="product-description mt-4">
                            {!! $product->description !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </article>
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {
            $('.checkout-btn, .cart-btn').click(function(e) {
                e.preventDefault();

                // 检查规格是否已选择
                const specificationId = $('select[name="specification_id"]').val();
                if (!specificationId) {
                    // 创建并显示 toast 消息
                    showToast('請選擇商品規格', 'error');
                    return;
                }

                // 继续提交表单
                $('#checkout_direct').val($(this).hasClass('checkout-btn') ? '1' : '0');
                $(this).closest('form').submit();
            });
        });
    </script>
@endpush
