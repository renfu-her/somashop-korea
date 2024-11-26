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
                <h2 class="text-black text-center font-weight-bold mb-0" data-aos="zoom-in-up" data-aos-delay="450">訂購完成
                </h2>
                <h4 class="text-center text-gold mb-4" data-aos="zoom-in-up" data-aos-delay="600">Order Completed</h4>
                <hr class="page_line" data-aos="flip-right" data-aos-delay="0" data-aos-duration="3000">
            </div>

            <section class="mx-md-5" data-aos="fade-up" data-aos-delay="750">

                <div class="shopping3">
                    <div class="col-12 my-3">
                        <div class="page-title">
                            <h2 class="text-black text-center font-weight-bold ">訂單明細</h2>
                        </div>
                    </div>

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
                                        <th scope="col"></th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($orderItems as $item)
                                        <tr>
                                            <td scope="row"></td>
                                            <td class="thumb-img align-middle">
                                                <img class="item-img"
                                                    src="{{ asset('storage/products/' . $item->product->id . '/' . $item->productImage->image_path) }}"
                                                    width="106px">
                                            </td>
                                            <td class="align-middle border-sm-top">
                                                <span class="cart-tag d-block d-sm-none text-muted" disable>規格</span>
                                                <div class="product-details text-md-left text-sm-center">
                                                    <p class="mb-0">{{ $item->product->name }}</p>
                                                    @if ($item->spec)
                                                        <p class="mb-0">規格: {{ $item->spec->value }}</p>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="align-middle border-sm-top">
                                                <span class="cart-tag d-block d-sm-none text-muted" disable>優惠價</span>
                                                <p class="mb-0">NT${{ number_format($item->price) }}</p>
                                            </td>
                                            <td class="quantity align-middle border-sm-top">
                                                <span class="cart-tag d-block d-sm-none text-muted" disable>數量</span>
                                                <p class="mb-0">{{ $item->quantity }}</p>
                                            </td>
                                            <td class="total align-middle border-sm-top">
                                                <span class="cart-tag d-block d-sm-none text-muted" disable>小計</span>
                                                <p class="text-danger mb-0">
                                                    NT${{ number_format($item->price * $item->quantity) }}</p>
                                            </td>
                                            <td></td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td class="text-center">運費</td>
                                        <td class="text-danger mb-0">
                                            NT${{ number_format($shippingFee) }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <hr class="dot-line">

                    <div class="col-sm-12 my-3">
                        <div class="row">
                            <div class="col-lg-4 offset-lg-8 col-md-6 offset-md-6 col-12">
                                <h2 class="text-black mb-0">
                                    <b>
                                        總計
                                        <span class="pl-3">NT${{ number_format($totalAmount + $shippingFee) }}</span>
                                    </b>
                                </h2>
                            </div>
                        </div>
                    </div>

                    <form class="w-100">

                        <div class="col-md-12 mt-5">
                            <div class="row">
                                <div class="col-md-3 col-sm-12 align-self-center">
                                    <h3 class="text-md-right text-sm-left text-danger">付款方式</h3>
                                </div>
                                <div class="col-md-9 col-sm-12 align-self-center">
                                    <div class="row">
                                        <p class="col-md-2 col-sm-12 text-md-right text-sm-left pl-md-0 pr-0 mb-0">
                                            @if ($order->payment_method == 'credit')
                                                刷卡
                                            @elseif ($order->payment_method == 'atm')
                                                網路ATM
                                            @elseif ($order->payment_method == 'transfer')
                                                網路銀行轉帳
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 mt-3">
                            <div class="row">
                                <div class="col-md-3 col-sm-12 pl-md-0">
                                    <h3 class="text-md-right text-sm-left text-danger">收貨人資訊</h3>
                                </div>
                                <div class="col-md-9 col-sm-12">
                                    <div class="form-group row">
                                        <div class="col-md-2 col-5 pl-md-0 pr-0  text-right">
                                            <p class="mb-0">收貨姓名</p>
                                        </div>
                                        <div class="col-md-6 col-7">
                                            <p class="mb-0">{{ $order->recipient_name }}</p>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-2 col-5 pl-md-0 pr-0  text-right">
                                            <p class="mb-0">性別</p>
                                        </div>
                                        <div class="col-md-6 col-7">
                                            <p class="mb-0">{{ $order->recipient_gender == 1 ? '男' : '女' }}</p>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-2 col-5 pl-md-0 pr-0  text-right">
                                            <p class="mb-0">聯絡電話</p>
                                        </div>
                                        <div class="col-md-6 col-7">
                                            <p class="mb-0">{{ $order->recipient_phone }}</p>
                                        </div>
                                    </div>

                                    @if ($order->shipment_method == 'mail_send')
                                        <div class="form-group row">
                                            <div class="col-md-2 col-5 pl-md-0 pr-0  text-right">
                                                <p class="mb-0">寄送方式</p>
                                            </div>
                                            <div class="col-md-6 col-7">
                                                <p class="mb-0">郵寄</p>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-2 col-5 pl-md-0 pr-0  text-right">
                                                <p class="mb-0">寄送地址</p>
                                            </div>
                                            <div class="col-md-6 col-7">
                                                <p class="mb-0">
                                                    {{ $order->recipient_county . $order->recipient_district . $order->recipient_address }}
                                                </p>
                                            </div>
                                        </div>
                                    @endif
                                    @if ($order->shipment_method == '711_b2c')
                                        <div class="form-group row">
                                            <div class="col-md-2 col-5 pl-md-0 pr-0  text-right">
                                                <p class="mb-0">寄送方式</p>
                                            </div>
                                            <div class="col-md-6 col-7">
                                                <p class="mb-0">7-11 門市取貨</p>
                                            </div>
                                        </div>
                                    @endif
                                    @if ($order->shipment_method == 'family_b2c')
                                        <div class="form-group row">
                                            <div class="col-md-2 col-5 pl-md-0 pr-0  text-right">
                                                <p class="mb-0">寄送方式</p>
                                            </div>
                                            <div class="col-md-6 col-7">
                                                <p class="mb-0">全家便利商店取貨</p>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <!-- /.col -->


                        <div class="col-md-12 mt-3" style="display:none;">
                            <div class="row">
                                <div class="col-md-3 col-12 align-self-center">
                                    <h3 class="text-md-right text-sm-left text-danger">開立發票</h3>
                                </div>
                                <div class="col-md-9 col-12 align-self-center">
                                    <div class="row">
                                        <div class="col-md-6 offset-md-2 col-7 align-self-center">
                                            <p class="mb-0">ATM轉帳</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 mt-3" style="display:none;">
                            <div class="row">
                                <div class="col-md-9 offset-md-3 col-12 align-self-center">
                                    <div class="form-group row">
                                        <div class="col-md-2 col-5 pl-md-0 pr-0 text-right">
                                            <p>發票寄送地址</p>
                                        </div>
                                        <div class="col-md-6 col-7">
                                            <p></p>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-2 col-5 pl-md-0 pr-0 text-right">
                                            <p>發票抬頭</p>
                                        </div>
                                        <div class="col-md-6 col-7">
                                            <p></p>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-2 col-5 pl-md-0 pr-0 text-right">
                                            <p>發票統編</p>
                                        </div>
                                        <div class="col-md-6 col-7">
                                            <p></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.col -->
                    </form>
                </div>
            </section>
        </div>
    </article>
@endpush
