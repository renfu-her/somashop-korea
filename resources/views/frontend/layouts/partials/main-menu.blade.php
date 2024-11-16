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

            <ul class="dropdown-menu" aria-labelledby="aboutUsDropdown">
                @foreach ($navData['about'] as $item)
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('post.show', $item->id) }}">{{ $item->title }}</a>
                    </li>
                @endforeach
            </ul>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('activity.index') }}">活動訊息</a>
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
                                    <a class="nav-link"
                                        href="{{ route('product.index', $child->id) }}">{{ $child->name }}</a>
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
                @auth('member')
                    <li class="nav-item">
                        <a class="nav-link" href="#">個人資料修改</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">訂單查詢</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                   document.getElementById('logout-form').submit();">
                            登出
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">登入</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('join') }}">加入會員</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('forget') }}">忘記密碼</a>
                    </li>
                @endauth
            </ul>
        </li>

        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="infomationDropdown" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                認識印章 <i class="fas fa-angle-down"></i>
            </a>
            <ul class="dropdown-menu" aria-labelledby="infomationDropdown">
                @foreach ($navData['sealKnowledgeCategories'] as $item)
                    <li class="nav-item">
                        <a class="nav-link"
                            href="{{ route('seal-knowledge.category', $item->id) }}">{{ $item->name }}</a>
                    </li>
                @endforeach
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
                        <a class="nav-link" href="{{ route('faqs.index', $item->id) }}">{{ $item->title }}</a>
                    </li>
                @endforeach

            </ul>
        </li>
    </ul>
</div>
