<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="format-detection" content="telephone=no">

    {{-- SEO Meta Tags --}}
    <title>@yield('meta_title', \App\Models\SiteSetting::getMetaData('site_name', 'SOMA SHOP'))</title>
    <meta name="keywords" content="@yield('meta_keywords', \App\Models\SiteSetting::getMetaData('meta_keywords', 'EzHive 易群佶選'))">
    <meta name="description" content="@yield('meta_description', \App\Models\SiteSetting::getMetaData('site_description', 'EzHive 易群佶選'))">

    {{-- Open Graph Tags --}}
    <meta property="og:title" content="@yield('meta_title', \App\Models\SiteSetting::getMetaData('site_name', 'EzHive 易群佶選'))">
    <meta property="og:description" content="@yield('meta_description', \App\Models\SiteSetting::getMetaData('site_description', 'EzHive 易群佶選'))">
    <meta property="og:image" content="@yield('og_image', asset('frontend/img/brand_logo_bg-red.png'))">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">

    <link rel="icon" href="{{ asset('frontend/img/favicon.svg') }}" type="image/x-icon">

    <link href="{{ asset('frontend/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- AOS animation CSS -->
    <link href="{{ asset('frontend/css/aos.css') }}" rel="stylesheet">

    <!-- Hover CSS -->
    <link href="{{ asset('frontend/css/hover-min.css') }}" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="{{ asset('frontend/css/babyin_styles_20241127.css') }}" rel="stylesheet">

    <!-- fontawesome -->
    <link href="{{ asset('frontend/vendor/fontawesome/css/all.min.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('frontend/css/custom.css?t=' . time()) }}">

    @stack('styles')

    <!-- Google Tag Manager -->
    <script>
        (function(w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                'gtm.start': new Date().getTime(),
                event: 'gtm.js'
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s),
                dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src =
                'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-KLLW9NT');
    </script>
    <!-- End Google Tag Manager -->
</head>

<body>

    <!-- Navigation -->
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KLLW9NT" height="0" width="0"
            style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

    @include('frontend.layouts.partials.nav')

    <div class="container">
        @include('frontend.layouts.partials.toast-messages')

        @yield('content')

        @stack('app-content')
    </div>



    <footer class="bg-footer d-flex align-items-center">
        <div class="container">
            <div class="row flex-row align-items-center">
                <div class="img-logo">
                    <img src="{{ asset('frontend/img/logo.png') }}"
                        style="max-width: 100%; max-height: 50px; object-fit: contain" />
                </div>
                <div class="col-auto mb-3 address">
                    <div class="row my-md-0 my-2">
                        <div class="col-md-12 col-12">
                            <div class="row">
                                <div class="col-auto pl-md-0 text-dark text-dark1">
                                    <p class="m-0">
                                        {{-- <img src="https://img.icons8.com/pastel-glyph/18/000000/place-marker.png" /> --}}
                                        상호명 : (주)소마슬립 <br>
                                        대표이사 : 김지훈 <br>
                                        개인정보책임자 : 박서연 <br>
                                        통신판매업신고번호 : 제 2024-서울마포-01234 호 <br>
                                        본사 : 서울특별시 마포구 양화로 120, 5층 (동교동, 소마타워)
                                    </p>
                                </div>
                            </div>

                        </div>
                    </div>
                    {{-- <p class="m-0 text-dark text-dark2">
                        &copy; 2025 All Rights Reversed. Ezhive Co., Ltd. All rights reserved.
                    </p> --}}
                </div>
                <div
                    class="col-auto social-link d-flex justify-content-between align-items-center ml-auto text-center px-md-3 px-4">
                    <a href="https://line.me/R/ti/p/@924osxbs" target="_blank" class="px-md-3 px-0 hvr-bob">
                        <img src="{{ asset('frontend/img/KakaoTalk_logo.png') }}" class="img-fluid px-md-0 px-3" style="width: 100px; height: 100px;" />
                    </a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'UA-174267163-1');
    </script>

    <!-- Go top Button -->
    <a id="back-to-top" href="#" class="btn btn-lg back-to-top" role="button" title=""
        data-toggle="tooltip" data-placement="left">
        <p>TOP</p>
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Bootstrap core JavaScript -->
    <script src="{{ asset('frontend/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('frontend/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- AOS JavaScript -->
    <script src="{{ asset('frontend/js/aos.js') }}"></script>

    <!-- Custom JavaScript -->
    <script src="{{ asset('frontend/js/babyin.js') }}"></script>

    <script src="{{ asset('frontend/js/custom.js?v=' . time()) }}"></script>

    @stack('scripts')

    <script>
        // Example starter JavaScript for disabling form submissions if there are invalid fields
        (function() {
            'use strict';
            window.addEventListener('load', function() {
                // Fetch all the forms we want to apply custom Bootstrap validation styles to
                var forms = document.getElementsByClassName('needs-validation');
                // Loop over them and prevent submission
                var validation = Array.prototype.filter.call(forms, function(form) {
                    form.addEventListener('submit', function(event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();


        $(function() {
            $('.btn-refresh').click(function() {
                $('#loading').fadeIn(300, function() {
                    $.ajax({
                        type: "GET",
                        url: '{{ route('captcha.generate') }}',
                        error: function(xhr) {
                            $('#loading').fadeOut();
                            alert('網路錯誤');
                        },
                        success: function(data, status, xhr) {
                            $('#loading').fadeOut();
                            $('.captchaImg').attr('src',
                                '{{ route('captcha.generate') }}?' + new Date()
                                .getTime());
                        }
                    });
                });
            });
        });
    </script>

    <div style="display: none;" id="loading">
        <div class="image">
            <img src="{{ asset('frontend/img/loading.svg') }}">
        </div>
    </div>
    <style>
        #loading {
            background-color: #000000;
            display: none;
            height: 100%;
            left: 0;
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 10000;
            opacity: 0.8;
        }

        #loading .image {
            left: 50%;
            margin: -60px 0 0 -60px;
            position: absolute;
            top: 50%;
        }
    </style>

    <script>
        // 全域函數：更新購物車數量
        window.updateCartCount = function() {
            $.ajax({
                url: '{{ route('cart.count') }}',
                method: 'GET',
                success: function(response) {
                    const count = response.count;
                    const badges = $('.badge-danger');

                    badges.each(function() {
                        if (count > 0) {
                            $(this).text(count).show();
                        } else {
                            $(this).hide();
                        }
                    });
                }
            });
        };

        // 定期檢查購物車數量（可選）
        setInterval(window.updateCartCount, 2000); // 每30秒更新一次
    </script>

</body>

</html>
