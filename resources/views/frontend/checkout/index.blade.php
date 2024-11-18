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
                <h2 class="text-black text-center font-weight-bold mb-0" data-aos="zoom-in-up">我要結帳</h2>
                <h4 class="text-center text-gold mb-4" data-aos="zoom-in-up" data-aos-delay="150">Checkout</h4>
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
                                                <p class="mb-0">{{ $item['specification_name'] }}</p>
                                            </div>
                                        </td>
                                        <td class="align-middle border-sm-top">
                                            <span class="cart-tag d-block d-sm-none text-muted" disable>單價</span>
                                            <p class="mb-0">NT${{ number_format($item['price']) }}</p>
                                        </td>
                                        <td class="quantity align-middle border-sm-top">
                                            <span class="cart-tag d-block d-sm-none text-muted" disable>數量</span>
                                            <p class="mb-0">{{ $item['quantity'] }}</p>
                                        </td>
                                        <td class="total align-middle border-sm-top">
                                            <span class="cart-tag d-block d-sm-none text-muted" disable>小計</span>
                                            <p class="text-danger mb-0 money">
                                                NT${{ number_format($item['price'] * $item['quantity']) }}</p>
                                        </td>
                                        <td></td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">購物車是空的</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="col-sm-12 dot-line">
                        <div class="row">
                            <div class="col-sm-3 offset-sm-9 pb-3">
                                <h5 class="text-danger">全館周年慶商品免運</h5>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12 my-3">
                        <div class="row">
                            <div class="col-md-4 offset-md-8 col-sm-6 offset-sm-6">
                                <h2 class="text-black mb-0">
                                    總計
                                    <span class="pl-3">NT${{ number_format($total) }}</span>
                                </h2>
                            </div>
                        </div>
                    </div>

                    <form class="w-100" method="post" action="#" enctype="multipart/form-data">
                        <div class="col-sm-12 border rounded mt-3">
                            <div class="form-group row m-3">
                                <legend
                                    class="col-form-label col-sm-3 text-md-right text-sm-left text-danger align-self-center">
                                    <h3 class="mb-0">付款方式</h3>
                                </legend>
                                <div class="col-sm-9 align-self-center">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="payment" id="inlineRadio1"
                                            value="1" checked>
                                        <label class="form-check-label" for="inlineRadio1">線上刷卡</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="payment" id="inlineRadio2"
                                            value="2">
                                        <label class="form-check-label" for="inlineRadio2">ATM轉帳</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12 border rounded mt-3">

                            <div class="form-group row m-3">
                                <div class="col-md-3 col-sm-12 align-self-center">
                                    <h3 class="text-md-right text-sm-left text-danger mb-0">收貨人資訊</h3>
                                </div>
                                <div class="col-md-9 col-sm-12 align-self-center">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="gridCheck1" name="sameAsMember">
                                        <label class="form-check-label" for="gridCheck1">同訂購人資料</label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row m-3">
                                <div class="col-md-9 offset-md-3 col-sm-12">
                                    <div class="form-group row">
                                        <label
                                            class="col-sm-2 col-form-label pr-0 text-md-right text-sm-left align-self-center"
                                            for="name">
                                            <span class="text-danger">*</span>收貨姓名
                                        </label>
                                        <div class="col-sm-6 align-self-center">
                                            <input ref="test" type="text" class="form-control" id="name"
                                                placeholder="請填真實姓名" required name="username">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label
                                            class="col-sm-2 col-form-label pr-0 text-md-right text-sm-left align-self-center"><span
                                                class="text-danger">*</span>性別</label>
                                        <div class="col-sm-6 align-self-center">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="gender"
                                                    id="male" value="1" checked ref="1">
                                                <label class="form-check-label" for="male">男</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="gender"
                                                    id="female" value="2" ref="1">
                                                <label class="form-check-label" for="female">女</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label
                                            class="col-sm-2 col-form-label pr-0 text-md-right text-sm-left align-self-center"
                                            for="phone"><span class="text-danger">*</span>聯絡電話</label>
                                        <div class="col-sm-6 align-self-center">
                                            <input type="text" class="form-control" id="phone" placeholder=""
                                                required name="phone" ref="0922013171">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label
                                            class="col-sm-2 col-form-label pr-0 text-md-right text-sm-left align-self-center"
                                            for="shippment">
                                            <span class="text-danger">*</span>寄送方式
                                        </label>
                                        <div class="col-sm-6 align-self-center">
                                            <select id="shippment" class="form-control" name="shippment"
                                                data-width="fit">
                                                <option value="">請選擇</option>
                                                <option value="mail_send">郵寄</option>
                                                <option value="711_b2c">7-11 店到店</option>
                                                <option value="family_b2c">全家 店到店</option>
                                            </select>
                                            <button type="button" class="btn btn-primary mt-2 map-btn"
                                                style="display: none;">
                                                <i class="fas fa-map-marker-alt"></i> 選擇門市
                                            </button>
                                        </div>
                                    </div>

                                    <div class="form-group row addr" style="display:none;">
                                        <label class="col-sm-2 col-form-label pr-0 text-md-right text-sm-left"><span
                                                class="text-danger">*</span>寄送地址</label>
                                        <div class="col-sm-6">
                                            <div class="row">
                                                <div id="twzipcode" class="col-12">
                                                    <div class="row">
                                                        <div class="col-12 col-md-6 mb-2">
                                                            <select data-role="county" class="form-control"
                                                                name="county"></select>
                                                        </div>
                                                        <div class="col-12 col-md-6 mb-2">
                                                            <select data-role="district" class="form-control"
                                                                name="district"></select>
                                                        </div>
                                                    </div>
                                                    <input type="hidden" data-role="zipcode" />
                                                </div>
                                                <div class="col-12">
                                                    <input type="text" class="form-control" id="address"
                                                        placeholder="" required name="address" value="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label pr-0 text-md-right text-sm-left"
                                            for="note">訂購備註</label>
                                        <div class="col-sm-6">
                                            <textarea class="form-control" rows="5" id="note" name="info"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.col -->


                        <div class="col-sm-12 border rounded mt-3">

                            <div class="form-group row m-3">
                                <legend
                                    class="col-form-label col-sm-3 text-md-right text-sm-left text-danger align-self-center">
                                    <h3 class="mb-0">開立發票</h3>
                                </legend>
                                <div class="col-sm-9 align-self-center">
                                    <div class="form-check form-check-inline mx-1">
                                        <input class="form-check-input" type="radio" name="receipt" id="receipt2"
                                            checked value="2">
                                        <label class="form-check-label" for="receipt2">二聯式</label>
                                    </div>
                                    <div class="form-check form-check-inline mr-0">
                                        <input class="form-check-input" type="radio" name="receipt" id="receipt3"
                                            value="3">
                                        <label class="form-check-label" for="receipt3">三聯式</label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row m-3 invoiceArea" style="display:none;">
                                <div class="col-md-9 offset-md-3 col-sm-12">
                                    <div class="form-group row">
                                        <label
                                            class="col-sm-2 col-form-label text-md-right text-sm-left align-self-center pr-0"
                                            for="note">發票寄送地址</label>
                                        <div class="col-sm-6 align-self-center">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="idCheck1"
                                                    name="invoiceSameAsMember">
                                                <label class="form-check-label" for="idCheck1">同訂購人資料</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-2"></label>
                                        <div class="col-sm-6">
                                            <div class="row">
                                                <div id="twzipcode" class="col-12">
                                                    <div class="row">
                                                        <div class="col-12 col-md-6 mb-2">
                                                            <select data-role="county" class="form-control"
                                                                name="county"></select>
                                                        </div>
                                                        <div class="col-12 col-md-6 mb-2">
                                                            <select data-role="district" class="form-control"
                                                                name="district"></select>
                                                        </div>
                                                    </div>
                                                    <input type="hidden" data-role="zipcode" />
                                                </div>
                                                <div class="col-12">
                                                    <input type="text" class="form-control" id="address"
                                                        placeholder="" required name="address" value="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row invoiceTitleArea">
                                        <label
                                            class="col-sm-2 col-form-label pr-0 text-md-right text-sm-left align-self-center"
                                            for="billtitle">發票抬頭</label>
                                        <div class="col-sm-6 align-self-center">
                                            <input type="text" class="form-control" id="billtitle" placeholder="發票抬頭"
                                                name="invoiceTitle">
                                        </div>
                                    </div>

                                    <div class="form-group row invoiceTitleArea">
                                        <label
                                            class="col-sm-2 col-form-label pr-0 text-md-right text-sm-left align-self-center"
                                            for="taxid">發票統編</label>
                                        <div class="col-sm-6 align-self-center">
                                            <input type="text" class="form-control" id="taxid" placeholder="發票統編"
                                                name="invoiceTaxid">
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12 sum-row">
                            <div class="form-group row mt-4">
                                <div class="col-md-9 offset-md-3 col-sm-12">
                                    <div class="form-group row mb-3">
                                        <label class="col-sm-2 col-form-label text-md-right px-0 align-self-center">
                                            <span class="text-danger">*</span>輸入右方驗證碼
                                        </label>
                                        <div class="col-sm-6 align-self-center">
                                            <div class="input-group">
                                                <input type="text" class="form-control align-self-center"
                                                    id="verify" placeholder="" required name="captcha">
                                                <div class="d-flex pl-2 align-self-center">
                                                    <img src="{{ route('captcha.generate') }}" width="68px"
                                                        height="24px" class="img-fluid captchaImg" />
                                                </div>
                                                <div class="input-group-append">
                                                    <label class="refresh mn-0">
                                                        <a class="btn btn-refresh hvr-icon-spin"
                                                            style="cursor: pointer;">更換 <i
                                                                class="fas fa-sync-alt hvr-icon px-1"></i>
                                                        </a>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-sm-6 offset-sm-2">
                                            <button type="submit"
                                                class="btn btn-danger btn-purchase w-100 rounded-pill mb-3 px-5 py-3 shoppingFinish">訂購完成</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>


                </div>
            </section>


        </div>
    </article>
@endpush

@push('scripts')
    <script src="{{ asset('frontend/js/jquery.twzipcode.min.js') }}"></script>
    <script>
        $(document).ready(function() {

            $('#twzipcode').twzipcode({
                "zipcodeSel": "{{ Auth::guard('member')->user()->zipcode }}",
            });

            // 監聽"同訂購人資料"複選框的變化
            $('input[name="sameAsMember"]').change(function() {
                if ($(this).is(':checked')) {
                    // 如果勾選，填入會員資料
                    $('input[name="username"]').val('{{ Auth::guard('member')->user()->name }}');
                    $('input[name="phone"]').val('{{ Auth::guard('member')->user()->phone }}');

                    // 設置性別
                    if ('{{ Auth::guard('member')->user()->gender }}' === '1') {
                        $('#male').prop('checked', true);
                    } else {
                        $('#female').prop('checked', true);
                    }

                    // 如果地址區塊是顯示的，則填入地址資料
                    if ($('.addr').is(':visible')) {
                        // 修正地址欄位的選擇器，使用 twzipcode 的方法
                        $('select[data-role="county"]').val('{{ Auth::guard('member')->user()->county }}')
                            .trigger('change');
                        $('select[data-role="district"]').val(
                            '{{ Auth::guard('member')->user()->district }}');
                        $('input[name="address"]').val('{{ Auth::guard('member')->user()->address }}');
                    }
                } else {
                    // 如果取消勾選，清空所有欄位
                    $('input[name="username"]').val('');
                    $('input[name="phone"]').val('');
                    $('select[data-role="county"]').val('');
                    $('select[data-role="district"]').val('');
                    $('input[name="address"]').val('');
                }
            });

            // 監聽寄送方式的變化
            $('#shippment').change(function() {
                const selectedValue = $(this).val();
                const addrArea = $('.addr');
                const mapBtn = $('.map-btn');

                // 根據選擇顯示不同內容
                switch (selectedValue) {
                    case 'mail_send':
                        addrArea.show();
                        mapBtn.hide();
                        break;
                    case '711_b2c':
                    case 'family_b2c':
                        addrArea.hide();
                        mapBtn.show();
                        break;
                    default:
                        addrArea.hide();
                        mapBtn.hide();
                        break;
                }
            });

            // 門市地圖按鈕點擊事件
            $('.map-btn').click(function() {
                const shippmentType = $('#shippment').val();
                // 根據不同超商打開對應地圖
                if (shippmentType === '711_b2c') {
                    openSevenMap();
                } else if (shippmentType === 'family_b2c') {
                    openFamilyMap();
                }
            });
        });

        // 開啟 7-11 地圖
        function openSevenMap() {
            // 這裡添加開啟 7-11 電子地圖的邏輯
            alert('開啟 7-11 門市地圖');
        }

        // 開啟全家地圖
        function openFamilyMap() {
            // 這裡添加開啟全家電子地圖的邏輯
            alert('開啟全家門市地圖');
        }
    </script>
@endpush
