<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item nav-profile">
            <div class="nav-link">
                <div class="d-flex justify-content-center">
                    <h2>後台管理</h2>
                    <span class="online-status online"></span>
                </div>
                <div class="profile-name">
                    <p class="name">
                        {{ Auth::user()->name }}
                    </p>
                </div>
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.ads.index') }}">
                <i class="fas fa-ad menu-icon"></i>
                <span class="menu-title">首頁主廣告維護</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.home-ads.index') }}">
                <i class="fas fa-ad menu-icon"></i>
                <span class="menu-title">小幅廣告維護</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.posts.index') }}">
                <i class="fas fa-newspaper menu-icon"></i>
                <span class="menu-title">關於我們維護</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.activities.index') }}">
                <i class="fas fa-calendar-alt menu-icon"></i>
                <span class="menu-title">活動訊息維護</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#product-management" aria-expanded="false">
                <i class="fas fa-box menu-icon"></i>
                <span class="menu-title">商品維護</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="product-management">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.categories.index') }}">分類管理</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.products.index') }}">商品管理</a>
                    </li>
                </ul>
            </div>
        </li>

        {{-- <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.members.index') }}">
                <i class="fas fa-users menu-icon"></i>
                <span class="menu-title">會員管理</span>
            </a>
        </li> --}}

        {{-- <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#faq-management" aria-expanded="false">
                <i class="fas fa-question-circle menu-icon"></i>
                <span class="menu-title">常見問題維護</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="faq-management">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.faq-categories.index') }}">分類管理</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.faqs.index') }}">問題管理</a>
                    </li>
                </ul>
            </div>
        </li> --}}

        {{-- <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.orders.index') }}">
                <i class="fas fa-shopping-cart menu-icon"></i>
                <span class="menu-title">訂單管理</span>
            </a>
        </li> --}}


        {{-- <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.email-settings.index') }}">
                <i class="fas fa-envelope menu-icon"></i>
                <span class="menu-title">郵件設定</span>
            </a>
        </li> --}}

        {{-- <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.settings.index') }}">
                <i class="fas fa-cog menu-icon"></i>
                <span class="menu-title">運費設定</span>
            </a>
        </li> --}}

        {{-- <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.free-shippings.index') }}">
                <i class="fas fa-truck menu-icon"></i>
                <span class="menu-title">免運設定</span>
            </a>
        </li> --}}

        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.admins.index') }}">
                <i class="fas fa-users menu-icon"></i>
                <span class="menu-title">帳號管理</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.site-settings.index') }}">
                <i class="fas fa-cog menu-icon"></i>
                <span class="menu-title">系統設定</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.logout') }}"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="icon-support menu-icon"></i>
                <span class="menu-title">登出</span>
            </a>
            <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </li>
    </ul>
</nav>
