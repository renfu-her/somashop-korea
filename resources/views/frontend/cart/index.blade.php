@extends('frontend.layouts.app')

@push('app-content')
    <header>
        <div class="container">
            <div class="row">
                <div class="col-12 px-md-0">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb bg-transparent justify-content-md-end">
                            <li class="breadcrumb-item"><a href="./">홈</a></li>
                            <li class="breadcrumb-item active" aria-current="page">장바구니</li>
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
                <h2 class="text-black text-center font-weight-bold mb-0" data-aos="zoom-in-up">장바구니</h2>
                <h4 class="text-center text-gold mb-4" data-aos="zoom-in-up" data-aos-delay="150">Shopping Cart</h4>
            </div>

            <section class="mx-md-5 my-md-2 m-sm-1" data-aos="fade-up" data-aos-delay="450">
                <div class="shopping-cart">
                    <div class="table-responsive">
                        <table class="table text-center cart-items">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col" style="width: 5%"></th>
                                    <th scope="col" style="width: 15%">이미지</th>
                                    <th scope="col" style="width: 20%">상품명</th>
                                    <th scope="col" style="width: 15%">할인가</th>
                                    <th scope="col" style="width: 15%">수량</th>
                                    <th scope="col" style="width: 15%">소계</th>
                                    <th scope="col" style="width: 10%">삭제</th>
                                    <th scope="col" style="width: 5%"></th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($cart as $key => $item)
                                    <tr class="cart-item" data-cart-key="{{ $key }}">
                                        <td scope="row"></td>
                                        <td class="thumb-img align-middle">
                                            <img class="item-img" src="{{ $item['primary_image'] }}" width="106px">
                                        </td>
                                        <td class="align-middle border-sm-top">
                                            <span class="cart-tag d-block d-sm-none text-muted" disable>규격</span>
                                            <div class="product-details text-md-left text-sm-center">
                                                <p class="mb-0">{{ $item['product_name'] }}</p>
                                                <p class="mb-0">규격：{{ $item['spec_name'] }}</p>
                                            </div>
                                        </td>
                                        <td class="align-middle border-sm-top">
                                            <span class="cart-tag d-block d-sm-none text-muted" disable>단가</span>
                                            <p class="mb-0">NT${{ number_format($item['price']) }}</p>
                                        </td>
                                        <td class="quantity align-middle border-sm-top">
                                            <span class="cart-tag d-block d-sm-none text-muted" disable>수량</span>
                                            <div class="input-group num-row">
                                                <button class="btn btn-minus btn-light border btn-sm"
                                                    data-cart-key="{{ $key }}"
                                                    data-product-id="{{ $item['product_id'] }}"
                                                    data-specification-id="{{ $item['spec_id'] }}">
                                                    <i class="fa fa-minus"></i>
                                                </button>
                                                <input type="text" class="form-control bg-white text-center qty_input"
                                                    value="{{ $item['quantity'] }}" data-cart-key="{{ $key }}"
                                                    data-product-id="{{ $item['product_id'] }}"
                                                    data-specification-id="{{ $item['spec_id'] }}">
                                                <button class="btn btn-plus btn-light border btn-sm"
                                                    data-cart-key="{{ $key }}"
                                                    data-product-id="{{ $item['product_id'] }}"
                                                    data-specification-id="{{ $item['spec_id'] }}">
                                                    <i class="fa fa-plus"></i>
                                                </button>
                                            </div>
                                        </td>
                                        <td class="total align-middle border-sm-top">
                                            <span class="cart-tag d-block d-sm-none text-muted" disable>소계</span>
                                            <p class="text-danger mb-0 money">
                                                NT${{ number_format($item['price'] * $item['quantity']) }}</p>
                                        </td>
                                        <td class="align-middle border-sm-top">
                                            <button type="button"
                                                class="btn bg-transparent border-0 hvr-buzz-out remove-item"
                                                data-cart-key="{{ $key }}"
                                                data-product-id="{{ $item['product_id'] }}"
                                                data-specification-id="{{ $item['spec_id'] }}">

                                                <i class="far fa-trash-alt"></i>
                                            </button>
                                        </td>
                                        <td></td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">장바구니가 비어있습니다</td>
                                    </tr>
                                @endforelse

                            </tbody>
                        </table>
                    </div>

                    <div class="col-sm-12 my-3">
                        <div class="row">
                            <div class="col-sm-12 col-xs-6 offset-xs-6" style="text-align: right">
                                <h2 class="text-black mb-0">
                                    총계
                                    <span class="pl-3 priceTotalplusFee">NT${{ number_format($total) }}</span>
                                </h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="row my-3">
                            <div class="col-sm-3 offset-sm-9">
                                <button class="btn btn-danger btn-purchase w-100 rounded-pill mb-3 cartNext" type="button"
                                    onclick="window.location.href='{{ route('checkout.index') }}'">결제하기</button>
                                <button class="btn btn-danger btn-addcart w-100 rounded-pill mb-3"
                                    type="button">쇼핑 계속하기</button>
                                <input type="hidden" id="referrer" value="{{ $cartReferrer }}">
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </article>

@endpush

@push('styles')
    <style>
        /* 添加以下 CSS 樣式 */
        .table-responsive {
            overflow-x: hidden;
            /* 隱藏水平滾動條 */
        }

        @media (max-width: 768px) {
            .table-responsive {
                overflow-x: auto;
                /* 在手機版時才顯示滾動條 */
            }
        }

        .shopping-cart {
            max-width: 100%;
            margin: 0 auto;
        }

        .cart-items {
            width: 100%;
            table-layout: fixed;
            /* 固定表格布局 */
        }

        /* 確保圖片不會超出容器 */
        .thumb-img img {
            max-width: 100%;
            height: auto;
        }
    </style>
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {
            // Update quantity
            $('.btn-plus, .btn-minus').click(function() {
                const cartKey = $(this).data('cart-key');
                const productId = $(this).data('product-id');
                const specificationId = $(this).data('specification-id');
                let input = $(this).closest('.num-row').find('.qty_input');
                let quantity = parseInt(input.val());

                if ($(this).hasClass('btn-plus')) {
                    quantity++;
                } else {
                    quantity = quantity > 1 ? quantity - 1 : 1;
                }

                updateCartQuantity(cartKey, productId, specificationId, quantity);
            });

            // Remove product
            $('.remove-item').on('click', function() {
                const cartKey = $(this).data('cart-key');
                const productId = $(this).data('product-id');
                const specificationId = $(this).data('specification-id');
                if (confirm('이 상품을 제거하시겠습니까?')) {
                    removeFromCart(cartKey, productId, specificationId);
                }
            });
            // Continue shopping button
            $('.btn-addcart').click(function() {
                const referrer = $('#referrer').val();


                window.location.href = '{{ route('products.show', $cartReferrer) }}';

            });

            // Checkout button
            $('.cartNext').click(function() {
                window.location.href = '{{ route('checkout.index') }}';
            });
        });

        function updateCartQuantity(cartKey, productId, specificationId, quantity) {
            $.ajax({
                url: '{{ route('cart.update-quantity') }}',
                method: 'POST',
                data: {
                    cart_key: cartKey,
                    product_id: productId,
                    spec_id: specificationId,
                    quantity: quantity,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    location.reload();
                },
                error: function(xhr) {
                    alert('수량 업데이트 실패, 잠시 후 다시 시도해주세요');
                }
            });
        }

        function removeFromCart(cartKey, productId, specificationId) {
            $.ajax({
                url: '{{ route('cart.remove') }}',
                method: 'POST',
                data: {
                    cart_key: cartKey,
                    product_id: productId,
                    spec_id: specificationId,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        // Remove corresponding TR element
                        const $item = $(`tr[data-cart-key="${cartKey}"]`);
                        $item.fadeOut(300, function() {
                            $(this).remove();

                            // Check if cart is empty
                            if ($('.cart-item').length === 0) {
                                $('.cart-items tbody').html(
                                    '<tr><td colspan="8" class="text-center">장바구니가 비어있습니다</td></tr>'
                                );
                            }

                            // Recalculate total amount
                            updateTotalPrice();
                        });
                    }
                },
                error: function(xhr) {
                    alert('상품 제거 실패, 잠시 후 다시 시도해주세요');
                }
            });
        }

        // Add function to calculate total amount
        function updateTotalPrice() {
            let total = 0;
            $('.cart-item').each(function() {
                const price = $(this).find('.money').text().replace('NT$', '').replace(',', '') * 1;
                total += price;
            });
            $('.priceTotalplusFee').text('NT$' + total.toLocaleString());
        }
    </script>
@endpush

@push('styles')
    <style>
        /* 添加以下 CSS 樣式 */
        .table-responsive {
            overflow-x: hidden;
            /* 隱藏水平滾動條 */
        }

        @media (max-width: 768px) {
            .table-responsive {
                overflow-x: auto;
                /* 在手機版時才顯示滾動條 */
            }
        }

        .shopping-cart {
            max-width: 100%;
            margin: 0 auto;
        }

        .cart-items {
            width: 100%;
            table-layout: fixed;
            /* 固定表格布局 */
        }

        /* 確保圖片不會超出容器 */
        .thumb-img img {
            max-width: 100%;
            height: auto;
        }
    </style>
@endpush
