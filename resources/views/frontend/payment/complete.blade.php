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
                <div class="row px-2 mb-5">
                    <div class="col-lg-6 offset-lg-3 col-md-8 offset-md-2 col-12">
                        <p class="p-t14 mb-3">親愛的顧客您好，感謝您的訂購。 請於<span class="text-danger">三天內</span>匯款完成，我們將盡速安排出貨。</p>

                        <div class="row mb-3 p3">
                            <div class="col-12">
                                <div class="row bg-lightgray rounded py-4">
                                    <div class="col-md-4 col-sm-4 col-12 align-self-center mb-md-0 mb-3">
                                        <h3 class="text-sm-left text-md-right text-danger mb-0">匯款資料</h3>
                                    </div>
                                    <div class="col-md-8 col-sm-8 col-12 p-t14 align-self-center">
                                        <div class="row">
                                            <div class="col-12 pr-0">銀行代碼：700</div>
                                            <div class="col-12 pr-0">匯款銀行：莒光路(郵局)</div>
                                            <div class="col-12 pr-0">匯款帳號：000-1358-089-7632 </div>
                                            <div class="col-12 pr-0">戶&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp名：李品樂</div>
                                            <div class="col-12 pr-0">匯款金額：NT$360</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <p class="p-t14">注意事項：</p>
                        <ul class="p-t14">
                            <li>我們將於確認您的付款後，1-3工作天內聯繫您確認商品細項。</li>
                            <li>如做胎毛和肚臍章擇會再收到胎毛和肚臍後開始正式製作。</li>
                            <li>如做公司和個人印鑑會再確認匯款後開始製作，因遵循老師傅古法手工鏡面古井刻工工作天為45~60天。</li>
                            <li>匯款完成後，可至「會員專區-訂單查詢」確認您目前訂單狀況。</li>
                            <li>若三天內未收到您的轉帳付款，系統將取消您的訂單，請見諒!</li>
                        </ul>
                    </div>
                </div>

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
                                        <th scope="col">現金價</th>
                                        <th scope="col">數量</th>
                                        <th scope="col">小計</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr>
                                        <td scope="row"></td>
                                        <td class="thumb-img align-middle">
                                            <img class="item-img" src="./uploads/d7a00ab1f419d86a6c20f3da91d81c3d.jpg"
                                                width="106px">
                                        </td>
                                        <td class="align-middle border-sm-top">
                                            <span class="cart-tag d-block d-sm-none text-muted" disable>規格</span>
                                            <div class="product-details text-md-left text-sm-center">
                                                <p class="mb-0">紅木外攜外出盒 不含印章</p>
                                                <p class="mb-0">款式請下單後「備註」留言</p>
                                            </div>
                                        </td>
                                        <td class="align-middle border-sm-top">
                                            <span class="cart-tag d-block d-sm-none text-muted" disable>現金價</span>
                                            <p class="mb-0">NT$360</p>
                                        </td>
                                        <td class="quantity align-middle border-sm-top">
                                            <span class="cart-tag d-block d-sm-none text-muted" disable>數量</span>
                                            <p class="mb-0">1</p>
                                        </td>
                                        <td class="total align-middle border-sm-top">
                                            <span class="cart-tag d-block d-sm-none text-muted" disable>小計</span>
                                            <p class="text-danger mb-0">NT$360</p>
                                        </td>
                                        <td></td>
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
                                        <span class="pl-3">NT360</span>
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
                                        <p class="col-md-2 col-sm-12 text-md-right text-sm-left pl-md-0 pr-0 mb-0">ATM轉帳</p>
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
                                            <p class="mb-0">測試</p>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-2 col-5 pl-md-0 pr-0  text-right">
                                            <p class="mb-0">性別</p>
                                        </div>
                                        <div class="col-md-6 col-7">
                                            <p class="mb-0">男</p>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-2 col-5 pl-md-0 pr-0  text-right">
                                            <p class="mb-0">聯絡電話</p>
                                        </div>
                                        <div class="col-md-6 col-7">
                                            <p class="mb-0">0922013171</p>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-2 col-5 pl-md-0 pr-0  text-right">
                                            <p class="mb-0">寄送方式</p>
                                        </div>
                                        <div class="col-md-6 col-7">
                                            <p class="mb-0">到店自取</p>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-2 col-5 pl-md-0 pr-0  text-right">
                                            <p class="mb-0">寄送地址</p>
                                        </div>
                                        <div class="col-md-6 col-7">
                                            <p class="mb-0">花蓮縣花蓮市test</p>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-2 col-5 pl-md-0 pr-0  text-right">
                                            <p class="mb-0">匯款帳號後五碼</p>
                                        </div>
                                        <div class="col-md-6 col-7">
                                            <p class="mb-0">12345</p>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-2 col-5 pl-md-0 pr-0  text-right">
                                            <p class="mb-0">訂購備註</p>
                                        </div>
                                        <div class="col-md-6 col-7">
                                            <p class="mb-0">系統測試，請勿理會</p>
                                        </div>
                                    </div>
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
