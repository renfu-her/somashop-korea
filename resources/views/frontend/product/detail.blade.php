@extends('frontend.layouts.app')

@section('meta_title', trim($product->meta_title) ? trim($product->meta_title) : $product->name . ' - EzHive 易群佶選')
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
                                <a href="{{ route('home') }}">홈</a>
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
                                    @if ($product->is_new)
                                        <span class="badge">新品</span>
                                    @endif
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
                                    <p class="mb-2 original-price">原價：NT$ <span
                                            id="original-price">{{ number_format($product->price) }}</span></p>
                                    <h3 class="text-danger">優惠價：NT$ <span
                                            id="cash-price">{{ number_format($product->spec_price) }}</span></h3>
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
                                            <select class="form-control" name="spec_id" id="spec-select">
                                                <option value="">請選擇</option>
                                                @foreach ($product->specs as $spec)
                                                    @if ($spec->is_active)
                                                        <option value="{{ $spec->id }}"
                                                            data-price="{{ $spec->price }}">
                                                            {{ $spec->name }}
                                                        </option>
                                                    @endif
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
                                                <button type="submit" class="btn btn-danger w-100 rounded-pill cart-btn">
                                                    立即訂購
                                                </button>
                                            </div>
                                            <div class="col-6">
                                                <button type="submit"
                                                    class="btn btn-outline-danger w-100 rounded-pill checkout-btn">加入購物車</button>
                                            </div>
                                        @else
                                            <div class="col-12">
                                                <a href="{{ route('login') }}" class="btn btn-danger w-100 rounded-pill">
                                                    登入後購買
                                                </a>
                                            </div>
                                        @endif
                                    </div>

                                    @if ($freeShippings)
                                        <div class="col-12 text-danger">
                                            @if ($freeShippings->start_date && $freeShippings->end_date)
                                                <p class="text-danger">{{ $freeShippings->start_date->format('Y/m/d') }} ~
                                                    {{ $freeShippings->end_date->format('Y/m/d') }}
                                                    期間 <br>
                                                    購買商品滿 ${{ number_format($freeShippings->minimum_amount) }} 免運費</p>
                                            @else
                                                <p class="text-danger">購買商品滿 ${{ number_format($freeShippings->minimum_amount) }} 免運費</p>
                                            @endif
                                        </div>
                                    @endif
                                </form>
                            </div>

                        </div>
                        <div class="product-description mt-4">
                            {!! $product->content !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </article>
@endpush

@push('styles')
    <style>
        .product-description {
            margin: 15px;
        }

        .product-price .original-price {
            text-decoration: line-through;
            color: #6c757d;
        }

        .product-description img {
            max-width: 100%;
            height: auto;
        }

        .product-gallery {
            position: relative;
        }

        .product-gallery .badge {
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
    </style>
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {
            $('.checkout-btn').click(function(e) {
                e.preventDefault();

                // 檢查規格是否已選擇
                const specId = $('select[name="spec_id"]').val();
                if (!specId) {
                    showToast('請選擇商品規格', 'error');
                    return;
                }
                $.ajax({
                    url: '{{ route('cart.add', ['redirect' => false]) }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        product_id: '{{ $product->id }}',
                        spec_id: specId,
                        quantity: $('input[name="quantity"]').val(),
                    },
                    success: function(response) {
                        showToast('加入購物車成功', 'success');
                    },
                    error: function(xhr, status, error) {
                        showToast('加入購物車失敗', 'error');
                    }
                });
            });

            $('.cart-btn').click(function(e) {
                e.preventDefault();
                const specId = $('select[name="spec_id"]').val();
                if (!specId) {
                    showToast('請選擇商品規格', 'error');
                    return;
                }
                $(this).closest('form').submit();
            });

            $('#spec-select').change(function() {
                const selectedOption = $(this).find('option:selected');
                if (selectedOption.val()) {
                    const specPrice = parseInt(selectedOption.data('price'));
                    $('#cash-price').text(numberFormat(specPrice));
                } else {
                    $('#cash-price').text('{{ number_format($product->cash_price) }}');
                }
            });

            function numberFormat(number) {
                return new Intl.NumberFormat('zh-TW').format(number);
            }

            // 添加數量增減功能
            $('.btn-minus').click(function() {
                const input = $(this).siblings('input[name="quantity"]');
                const currentValue = parseInt(input.val());
                if (currentValue > 1) {
                    input.val(currentValue - 1);
                }
            });

            $('.btn-plus').click(function() {
                const input = $(this).siblings('input[name="quantity"]');
                const currentValue = parseInt(input.val());
                input.val(currentValue + 1);
            });

            // 防止手動輸入非數字或負數
            $('input[name="quantity"]').on('input', function() {
                let value = $(this).val();
                // 移除非數字字符
                value = value.replace(/[^\d]/g, '');
                // 確保至少為 1
                value = value === '' ? 1 : Math.max(1, parseInt(value));
                $(this).val(value);
            });
        });
    </script>
@endpush
