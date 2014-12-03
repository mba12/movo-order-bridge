<header id="header">
    <div class="bar"></div>
    <div class="inner">
        <a href="/admin">
           <div class="logo"></div>
        </a>
        <ul id="nav-links">
            @if(Auth::check())
            @endif
                <li><a href="/admin/logout" class="">logout</a></li>
            <li><a href="/admin/coupons" class="">coupons</a></li>
            <li><a href="/admin/orders" class="">orders</a></li>
            <li><a href="/admin" class="active">stats</a></li>
        </ul>
    </div>
</header>