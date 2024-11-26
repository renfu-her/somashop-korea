@extends('frontend.layouts.app')

@push('app-content')
    <header>
        <div class="container">
            <div class="row">
                <div class="col-12 px-md-0">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb bg-transparent justify-content-md-end">
                            <li class="breadcrumb-item"><a href="./">首頁</a></li>
                            <li class="breadcrumb-item active" aria-current="page">購物車</li>
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
                <h2 class="text-black text-center font-weight-bold mb-0" data-aos="zoom-in-up">購物車</h2>
                <h4 class="text-center text-gold mb-4" data-aos="zoom-in-up" data-aos-delay="150">Shopping Cart</h4>
            </div>

            <section class="mx-md-5 my-md-2 m-sm-1" data-aos="fade-up" data-aos-delay="450">
                <div class="shopping-cart">
                    <div class="table-responsive">
                        <table class="table text-center cart-items">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col"></th>
                                    <th scope="col">商品</th>
                                    <th scope="col">規格</th>
                                    <th scope="col">優惠價</th>
                                    <th scope="col">數量</th>
                                    <th scope="col">小計</th>
                                    <th scope="col">刪除</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($cart as $key => $item)
                                    <tr class="cart-item">
                                        <td scope="row"></td>
                                        <td class="thumb-img align-middle">
                                            <img class="item-img" src="{{ $item['primary_image'] }}" width="106px">
                                        </td>
                                        <td class="align-middle border-sm-top">
                                            <span class="cart-tag d-block d-sm-none text-muted" disable>規格</span>
                                            <div class="product-details text-md-left text-sm-center">
                                                <p class="mb-0">{{ $item['product_name'] }}</p>
                                                <p class="mb-0">{{ $item['spec_name'] }}</p>
                                            </div>
                                        </td>
                                        <td class="align-middle border-sm-top">
                                            <span class="cart-tag d-block d-sm-none text-muted" disable>單價</span>
                                            <p class="mb-0">NT${{ number_format($item['price']) }}</p>
                                        </td>
                                        <td class="quantity align-middle border-sm-top">
                                            <span class="cart-tag d-block d-sm-none text-muted" disable>數量</span>
                                            <div class="input-group num-row">
                                                <button class="btn btn-minus btn-light border btn-sm"
                                                    data-product-id="{{ $item['product_id'] }}"
                                                    data-specification-id="{{ $item['spec_id'] }}">
                                                    <i class="fa fa-minus"></i>
                                                </button>
                                                <input type="text" class="form-control bg-white text-center qty_input"
                                                    value="{{ $item['quantity'] }}"
                                                    data-product-id="{{ $item['product_id'] }}"
                                                    data-specification-id="{{ $item['spec_id'] }}">
                                                <button class="btn btn-plus btn-light border btn-sm"
                                                    data-product-id="{{ $item['product_id'] }}"
                                                    data-specification-id="{{ $item['spec_id'] }}">
                                                    <i class="fa fa-plus"></i>
                                                </button>
                                            </div>
                                        </td>
                                        <td class="total align-middle border-sm-top">
                                            <span class="cart-tag d-block d-sm-none text-muted" disable>小計</span>
                                            <p class="text-danger mb-0 money">
                                                NT${{ number_format($item['price'] * $item['quantity']) }}</p>
                                        </td>
                                        <td class="align-middle border-sm-top">
                                            <button type="button"
                                                class="btn bg-transparent border-0 hvr-buzz-out remove-item"
                                                data-product-id="{{ $item['product_id'] }}"
                                                data-specification-id="{{ $item['spec_id'] }}">

                                                <i class="far fa-trash-alt"></i>
                                            </button>
                                        </td>
                                        <td></td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">購物車是空的</td>
                                    </tr>
                                @endforelse

                            </tbody>
                        </table>
                    </div>

                    <div class="col-sm-12 my-3">
                        <div class="row">
                            <div class="col-sm-3 offset-sm-9 col-xs-6 offset-xs-6">
                                <h2 class="text-black mb-0">
                                    總計
                                    <span class="pl-3 priceTotalplusFee">NT${{ number_format($total) }}</span>
                                </h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="row my-3">
                            <div class="col-sm-3 offset-sm-9">
                                <button class="btn btn-danger btn-purchase w-100 rounded-pill mb-3 cartNext" type="button"
                                    onclick="window.location.href='{{ route('checkout.index') }}'">我要結帳</button>
                                <button class="btn btn-danger btn-addcart w-100 rounded-pill mb-3" type="button"
                                    onclick="#">繼續購物</button>
                            </div>
                        </div>
                    </div>
                </div>
            </section>


        </div>
    </article>
@endpush

@push('script')
    <script>
        $(document).ready(function() {
            // 更新數量
            $('.btn-plus, .btn-minus').click(function() {
                const productId = $(this).data('product-id');
                const specificationId = $(this).data('specification-id');
                let input = $(this).closest('.num-row').find('.qty_input');
                let quantity = parseInt(input.val());

                if ($(this).hasClass('btn-plus')) {
                    quantity++;
                } else {
                    quantity = quantity > 1 ? quantity - 1 : 1;
                }

                updateCartQuantity(productId, specificationId, quantity);
            });

            // 移除商品
            $('.remove-item').on('click', function() {
                const productId = $(this).data('product-id');
                const specificationId = $(this).data('specification-id');
                console.log(productId, specificationId);
                // if (confirm('確定要移除此商品嗎？')) {
                //     removeFromCart(productId, specificationId);
                // }
            });

            function updateCartQuantity(productId, specificationId, quantity) {
                $.ajax({
                    url: '{{ route('cart.update-quantity') }}',
                    method: 'POST',
                    data: {
                        product_id: productId,
                        spec_id: specificationId,
                        quantity: quantity,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        location.reload();
                    },
                    error: function(xhr) {
                        alert('更新數量失敗，請稍後再試');
                    }
                });
            }

            function removeFromCart(productId, specificationId) {
                $.ajax({
                    url: '{{ route('cart.remove') }}',
                    method: 'POST',
                    data: {
                        product_id: productId,
                        spec_id: specificationId,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            // 移除对应的 TR 元素
                            const $item = $(
                                `button[data-product-id="${productId}"][data-specification-id="${specificationId}"]`
                            ).closest('tr');
                            $item.fadeOut(300, function() {
                                $(this).remove();

                                // 检查购物车是否为空
                                if ($('.cart-item').length === 0) {
                                    $('.cart-items tbody').html(
                                        '<tr><td colspan="8" class="text-center">購物車是空的</td></tr>'
                                    );
                                }

                                // 重新计算总金额
                                updateTotalPrice();
                            });
                        }
                    },
                    error: function(xhr) {
                        alert('移除商品失敗，請稍後再試');
                    }
                });
            }

            // 添加计算总金额的函数
            function updateTotalPrice() {
                let total = 0;
                $('.cart-item').each(function() {
                    const price = $(this).find('.money').text().replace('NT$', '').replace(',', '') * 1;
                    total += price;
                });
                $('.priceTotalplusFee').text('NT$' + total.toLocaleString());
            }

            // 繼續購物按鈕
            $('.btn-addcart').click(function() {
                window.location.href = '{{ route('products.index') }}';
            });

            // 結帳按鈕
            $('.cartNext').click(function() {
                window.location.href = '{{ route('checkout.payment') }}';
            });
        });
    </script>
@endpush
