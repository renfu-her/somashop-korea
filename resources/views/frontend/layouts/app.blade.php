<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="format-detection" content="telephone=no">
    <meta name="keywords" content="印章店,刻印章,印章 刻印,臍帶章,臍帶印章,肚臍印章,臍帶章推薦,印章開運,手工印章,客製化印章,剃胎毛">
    <meta name="description" content="各式印鑑.肚臍章,手工刻、印章、開運章、臍帶章、胎毛章,髮財章終生保固~七天鑑賞期不滿意全額微笑退費~古井鏡面刻工.">
    <meta name="author" content="">

    <title>Babyin 寶貝印 印鑑工坊</title>

    <link href="{{ asset('frontend/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- AOS animation CSS -->
    <link href="{{ asset('frontend/css/aos.css') }}" rel="stylesheet">

    <!-- Hover CSS -->
    <link href="{{ asset('frontend/css/hover-min.css') }}" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="{{ asset('frontend/css/babyin_styles.css') }}" rel="stylesheet">

    <!-- fontawesome -->
    <link href="{{ asset('frontend/vendor/fontawesome/css/all.min.css') }}" rel="stylesheet">

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
        @yield('content')
    </div>

    @stack('app-content')

    <footer class="bg-footer d-flex align-items-center">
        <div class="container">
            <div class="row flex-row align-items-center">
                <div class="col-auto mb-3">
                    <div class="row my-md-0 my-2">
                        <div class="col-md-12 col-12">
                            <img src="{{ asset('frontend/img/brand_logo_bg-red.png') }}">
                        </div>
                        <div class="col-md-12 col-12">
                            <div class="row">
                                <div class="col-auto">
                                    <p class="m-0 text-dark"><i class="fas fa-phone-volume"></i> (02)2302-5558</p>
                                </div>
                                <div class="col-auto pl-md-0">
                                    <p class="m-0 text-dark"><img
                                            src="https://img.icons8.com/pastel-glyph/18/000000/place-marker.png">
                                        台北市萬華區莒光路302號</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <p class="m-0 text-dark">&copy; 2019 All Rights Reversed. babyin Co., Ltd. All rights reserved.</p>
                </div>
                <div
                    class="col-auto social-link d-flex justify-content-between align-items-center ml-auto text-center px-md-3 px-4">
                    <a href="tel:(02)2302-5558" target="_blank" class="px-md-3 px-2 hvr-bob"><img
                            src="{{ asset('frontend/img/ic_small_phone.png') }}" class="img-fluid px-md-0 px-3">
                        <p class="pt-2">點我連結</p>
                    </a>
                    <a href="https://www.facebook.com/babyin1688/" target="_blank" class="px-md-3 px-2 hvr-bob"><img
                            src="{{ asset('frontend/img/ic_small_fb.png') }}" class="img-fluid px-md-0 px-3">
                        <p class="pt-2">點我連結</p>
                    </a>
                    <a href="https://line.me/ti/p/@zfa7556c" target="_blank" class="px-md-3 px-0 hvr-bob"><img
                            src="{{ asset('frontend/img/ic_small_line.png') }}" class="img-fluid px-md-0 px-3">
                        <p class="pt-2">點我連結</p>
                    </a>
                    <a href="https://www.instagram.com/a0908512899/" target="_blank" class="px-md-3 px-0 hvr-bob"><img
                            src="{{ asset('frontend/img/ic_small_ig.png') }}" class="img-fluid px-md-0 px-3">
                        <p class="pt-2">點我連結</p>
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


        function checkform() {
            $('#loading').fadeIn(300, function() {
                $.ajax({
                    type: "POST",
                    url: 'proc.php?proc=contact',
                    data: 'uname=' + $('input[name="name"]').val() +
                        '&tel=' + $('input[name="tel"]').val() +
                        '&email=' + $('input[name="email"]').val() +
                        '&info=' + $('textarea').val() +
                        '&captcha=' + $('input[name="captcha"]').val(),
                    error: function(xhr) {
                        $('#loading').fadeOut();
                        alert('網路錯誤');
                    },
                    success: function(data, status, xhr) {
                        $('#loading').fadeOut();
                        if (data == 'succ') {
                            alert('感謝您的來信 ,我們已收到信件將會處理確認');
                            // $('input').val('');
                            // $('textarea').val('');
                        } else if (data == 'captcha') {
                            alert('驗證碼錯誤!');
                        } else {
                            // top.location.href = "./";
                        }

                    }
                });
            });
            return false;
        }


        $(function() {
            $('.btn-refresh').click(function() {
                $('#loading').fadeIn(300, function() {
                    $.ajax({
                        type: "POST",
                        url: 'proc.php?proc=captcha',
                        data: '',
                        error: function(xhr) {
                            $('#loading').fadeOut();
                            alert('網路錯誤');
                        },
                        success: function(data, status, xhr) {
                            $('#loading').fadeOut();
                            $('.captchaImg').attr('src', 'uploads/captcha/' + data);

                        }
                    });
                });
            });


            $('.map-container').html(
                '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3615.08330759507!2d121.49602831562903!3d25.031246744554526!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3442a9b1e1c611f5%3A0xb7f7029aa88763fc!2zMTA45Y-w5YyX5biC6JCs6I-v5Y2A6I6S5YWJ6LevMzAy6Jmf!5e0!3m2!1szh-TW!2stw!4v1561976370651!5m2!1szh-TW!2stw" width="100%" height="320" frameborder="0" style="border:0" allowfullscreen></iframe>'
            );

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

</body>

</html>
