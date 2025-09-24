<nav class="navbar navbar-expand-lg navbar-light navbar-white bg-white">
    <div class="container px-0">
        {{-- Logo --}}
        <span class="fake-row mx-auto"></span>
        <a class="navbar-brand mx-auto" href="{{ route('home') }}">
            <img src="{{ asset('frontend/img/logo.png') }}" style="max-width: 100%; max-height: 50px; object-fit: contain;">
        </a>

        {{-- 햄버거 메뉴 버튼 --}}
        <button class="navbar-toggler navbar-toggler-right collapsed" type="button" data-toggle="collapse" data-target="#navbarResponsive">
            <span></span>
            <span></span>
            <span></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarResponsive">
            {{-- 메인 메뉴 --}}
            @include('frontend.layouts.partials.main-menu')

            {{-- 검색창 --}}
            @include('frontend.layouts.partials.search')

            {{-- 장바구니 및 로그인 영역 --}}
            @include('frontend.layouts.partials.cart-login')
        </div>
    </div>
</nav> 