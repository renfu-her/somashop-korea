@inject('navigation', 'App\Http\Controllers\Frontend\NavigationController')
@php
    $navData = $navigation->getNavigationData();
@endphp

<ul class="navbar-nav navbar-navright flex-row ml-md-auto ml-0 pr-md-3 pr-2">
    <li class="nav-item mx-md-3 mx-2">
        <a class="nav-link btn-widget" href="login.php">
            <i class="far fa-user"></i>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link btn-widget" href="{{ route('cart.index') }}">
            <i class="fas fa-shopping-cart"></i>
            @if ($navData['cartCount'] > 0)
                <span class="badge badge-danger">{{ $navData['cartCount'] }}</span>
            @else
                <span class="badge badge-danger" style="display:none;"></span>
            @endif
        </a>
    </li>
</ul>
