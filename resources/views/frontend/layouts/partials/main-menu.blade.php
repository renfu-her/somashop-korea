@inject('navigation', 'App\Http\Controllers\Frontend\NavigationController')
@php
    $navData = $navigation->getNavigationData();
@endphp

<div class="collapse navbar-collapse" id="navbarResponsive">
    <ul class="navbar-nav main-menu mr-auto">
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="aboutUsDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                關於我們 <i class="fas fa-angle-down"></i>
            </a>
            @foreach ($navData['about'] as $item)
                <ul class="dropdown-menu" aria-labelledby="aboutUsDropdown">
                    <li class="nav-item">
                        <a class="nav-link" href="#">{{ $item->title }}</a>
                    </li>
                </ul>
            @endforeach
        </li>

        <li class="nav-item">
            <a class="nav-link" href="act_list.php">活動訊息</a>
        </li>

        <li class="nav-item product-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                商品專區 <i class="fas fa-angle-down"></i>
            </a>


            <ul class="dropdown-menu sub-menu" aria-labelledby="navbarDropdown">
                @foreach ($navData['categories'] as $item)
                    <li class="nav-item dropdown no-arrow">
                        <a class="nav-link dropdown-toggle active" href="#" id="navbarDropdown" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ $item->name }} <i class="fas fa-angle-down"></i>
                        </a>

                        <ul class="dropdown-menu sub-sub-menu" aria-labelledby="navbarDropdown">
                            @foreach ($item->children as $child)
                                <li class="nav-item">
                                    <a class="nav-link" href="product_list.php?c=28">{{ $child->name }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                @endforeach
            </ul>
        </li>

        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="memberDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                會員專區 <i class="fas fa-angle-down"></i>
            </a>
            <ul class="dropdown-menu" aria-labelledby="memberDropdown">
                <li class="nav-item">
                    <a class="nav-link" href="login.php">登入</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="join.php">加入會員</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="forget.php">忘記密碼</a>
                </li>
            </ul>
        </li>

        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="infomationDropdown" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                認識印章 <i class="fas fa-angle-down"></i>
            </a>
            <ul class="dropdown-menu" aria-labelledby="infomationDropdown">
                <li class="nav-item">
                    <a class="nav-link" href="article-list.php?c=7">印章的秘密</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="article-list.php?c=6">印章材質介紹</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="article-list.php?c=5">印章保養方法</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="article-list.php?c=10">印章字體介紹</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="article-list.php?c=9">剃胎毛/胎毛筆</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="article-list.php?c=8">產品介紹</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="article-list.php?c=2">服務介紹</a>
                </li>
            </ul>
        </li>

        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="faqDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                常見問答 <i class="fas fa-angle-down"></i>
            </a>
            <ul class="dropdown-menu" aria-labelledby="faqDropdown">
                @foreach ($navData['faqCategories'] as $item)
                    <li class="nav-item">
                        <a class="nav-link" href="#">{{ $item->title }}</a>
                    </li>
                @endforeach

            </ul>
        </li>
    </ul>
</div>
