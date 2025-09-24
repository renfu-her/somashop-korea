@inject('navigation', 'App\Http\Controllers\Frontend\NavigationController')
@php
    $navData = $navigation->getNavigationData();
@endphp

<div class="collapse navbar-collapse" id="navbarResponsive">
    <ul class="navbar-nav main-menu mr-auto">
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="aboutUsDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                회사 소개 <i class="fas fa-angle-down"></i>
            </a>

            <ul class="dropdown-menu" aria-labelledby="aboutUsDropdown">
                @foreach ($navData['about'] as $item)
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('post.show', $item->id) }}">{{ $item->title }}</a>
                    </li>
                @endforeach
            </ul>
        </li>

        {{-- <li class="nav-item">
            <a class="nav-link" href="{{ route('activity.index') }}">활동 소식</a>
        </li> --}}

        <li class="nav-item product-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                상품 전용 <i class="fas fa-angle-down"></i>
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
                회원 전용 <i class="fas fa-angle-down"></i>
            </a>
            <ul class="dropdown-menu" aria-labelledby="memberDropdown">
                @auth('member')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('profile.index') }}">개인정보 수정</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('orders.list') }}">주문 조회</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                   document.getElementById('logout-form').submit();">
                            로그아웃
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">로그인</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('join') }}">회원가입</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('forget') }}">비밀번호 찾기</a>
                    </li>
                @endauth
            </ul>
        </li>
        
        {{-- <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="faqDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                자주 묻는 질문 <i class="fas fa-angle-down"></i>
            </a>
            <ul class="dropdown-menu" aria-labelledby="faqDropdown">
                @foreach ($navData['faqCategories'] as $item)
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('faqs.index', $item->id) }}">{{ $item->title }}</a>
                    </li>
                @endforeach

            </ul>
        </li> --}}
{{-- 
        <li class="nav-item">
            <a class="nav-link" href="{{ route('feedback.index') }}">問題回饋</a>
        </li> --}}
    </ul>
</div>
