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
                                    <th scope="col">現金價</th>
                                    <th scope="col">數量</th>
                                    <th scope="col">小計</th>
                                    <th scope="col">刪除</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr class="cart-item">
                                    <td scope="row"></td>
                                    <td class="thumb-img align-middle">
                                        <img class="item-img" src="./uploads/d7a00ab1f419d86a6c20f3da91d81c3d.jpg"
                                            width="106px">
                                    </td>
                                    <td class="align-middle border-sm-top">
                                        <span class="cart-tag d-block d-sm-none text-muted" disable>規格</span>
                                        <div class="product-details text-md-left text-sm-center">
                                            <a href="#">
                                                <p class="mb-0">紅木外攜外出盒 不含印章</p>
                                                <p class="mb-0">款式請下單後「備註」留言</p>
                                            </a>
                                        </div>
                                    </td>
                                    <td class="align-middle border-sm-top">
                                        <span class="cart-tag d-block d-sm-none text-muted" disable>單價</span>
                                        <p class="mb-0">NT$360</p>
                                    </td>
                                    <td class="quantity align-middle border-sm-top">
                                        <span class="cart-tag d-block d-sm-none text-muted" disable>數量</span>
                                        <div class="input-group num-row">
                                            <button class="btn btn-minus btn-light border btn-sm"><i
                                                    class="fa fa-minus"></i></button>
                                            <input type="text" class="form-control bg-white text-center qty_input"
                                                ref="360" prod-data="88,31" value="1">
                                            <button class="btn btn-plus btn-light border btn-sm"><i
                                                    class="fa fa-plus"></i></button>
                                        </div>
                                    </td>
                                    <td class="total align-middle border-sm-top">
                                        <span class="cart-tag d-block d-sm-none text-muted" disable>小計</span>
                                        <p class="text-danger mb-0 money">NT$360</p>
                                    </td>
                                    <td class="align-middle border-sm-top">
                                        <button type="button" class="btn bg-transparent border-0 hvr-buzz-out remove-item">
                                            <i class="far fa-trash-alt"></i>
                                        </button>
                                    </td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="col-sm-12 dot-line">
                        <div class="row">
                            <div class="col-sm-3 offset-sm-9 pb-3">
                                <h5 class="shopping-free-tag text-danger">全館周年慶商品免運</h5>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12 my-3">
                        <div class="row">
                            <div class="col-sm-3 offset-sm-9 col-xs-6 offset-xs-6">
                                <h2 class="text-black mb-0">
                                    總計
                                    <span class="pl-3 priceTotalplusFee">NT360</span>
                                </h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="row my-3">
                            <div class="col-sm-3 offset-sm-9">
                                <button class="btn btn-danger btn-purchase w-100 rounded-pill mb-3 cartNext"
                                    type="button">我要結帳</button>
                                <button class="btn btn-danger btn-addcart w-100 rounded-pill mb-3" type="button"
                                    onclick="javascript:location.href='product_list.php'">繼續購物</button>
                            </div>
                        </div>
                    </div>
                </div>
            </section>


        </div>
    </article>
@endpush
