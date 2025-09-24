@extends('frontend.layouts.app')

@push('app-content')
    <header>
        <div class="container">
            <div class="row">
                <div class="col-12 px-md-0">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb bg-transparent justify-content-md-end">
                            <li class="breadcrumb-item"><a href="./">홈</a></li>
                            <li class="breadcrumb-item active" aria-current="page">주문 조회</li>
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
                <h2 class="text-black text-center font-weight-bold mb-0" data-aos="zoom-in-up">주문 조회</h2>
                <h4 class="text-center text-gold mb-4" data-aos="zoom-in-up" data-aos-delay="150">Order Tracking</h4>
            </div>

            <section data-aos="fade-up" data-aos-delay="450">
                <div class="order-track">
                    <span class="hint hint-touch1"><i class="fas fa-hand-point-left"></i>왼쪽으로 스와이프하세요</span>
                    <div class="touch_table1">
                        <table class="table text-center table-responsive">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">주문일</th>
                                    <th scope="col">주문번호</th>
                                    <th scope="col">상품</th>
                                    <th scope="col">결제금액</th>
                                    <th scope="col">배송비</th>
                                    <th scope="col">상태</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($orders as $order)
                                    <tr style="height: 100px;">
                                        <td class="align-middle">{{ $order->created_at->format('Y-m-d H:i') }}</td>
                                        <td class="align-middle">{{ $order->order_number }}</td>
                                        <td class="align-middle text-left">
                                            <table class="table table-borderless product-items">
                                                @foreach ($order->items as $key => $item)
                                                    <tr>
                                                        <td class="mb-0">{{ $item['name'] }}<br>규격：{{ $item['spec'] }}
                                                        </td>
                                                        <td><img src="{{ $item['image_path'] }}" height="100"
                                                                alt=""></td>
                                                    </tr>
                                                    <tr class="separator">
                                                        <td colspan="2"></td>
                                                    </tr>
                                                @endforeach
                                            </table>
                                        </td>
                                        <td class="align-middle">NT${{ $order->total_amount }}</td>
                                        <td class="align-middle">{{ $order->shipping_fee == 0 ? '무료배송' : 'NT$' . number_format($order->shipping_fee) }}</td>
                                        <td class="align-middle" style="white-space: nowrap;">
                                            결제상태：{{ $order->payment_status_text }} <br>
                                            배송상태：{{ $order->shipping_status_text }} <br>
                                            주문상태：{{ $order->status_text }} </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="col-sm-12 dot-line-top">
                        <div class="row pt-4 p-t14">
                            <div class="col-md-1 col-2 pr-0 text-md-right text-sm-left">참고 :</div>
                            <div class="col-md-11 col-10 pl-0 pb-3">
                                <ol class="pl-md-4 pl-0">
                                    <li>위 자료는 6개월간만 보관됩니다</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <nav class="my-5" aria-label="Page navigation">
                <ul class="pagination justify-content-center" style="display:none;">
                    <li class="page-item">
                        <div class="dropdown">
                            <button class="btn btn-light btn-page border dropdown-toggle" type="button"
                                id="dropdownMenuButton" data-toggle="dropdown">
                                1
                            </button>
                            <div class="page-menu dropdown-menu" aria-labelledby="dropdownMenuButton">

                                <a class="dropdown-item" href="order_search.php?p=1">1</a>

                            </div>
                        </div>
                    </li>

                </ul>
            </nav>
        </div>
    </article>
@endpush

@push('styles')
    <style>
        .product-items .separator td {
            position: relative;
            padding: 0;
        }

        .product-items .separator td::after {
            content: '';
            position: absolute;
            left: 0;
            right: 0;
            height: 1px;
            background-color: #e0e0e0;
            opacity: 0.8;
            margin: 3px 3px;
        }
    </style>
@endpush
