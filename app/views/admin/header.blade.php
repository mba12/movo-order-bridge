<header id="header">
    <div class="bar"></div>
    <div class="inner">
        <a href="/admin">
           <div class="logo"></div>
        </a>
        <ul id="nav-links">
            @if(Session::get('admin'))
                <li><a href="/admin/logout" class="">logout</a></li>
            @endif
            <li><a href="/admin/coupons" class="coupons">coupons</a></li>
            <li><a href="/admin/orders" class="orders">orders</a></li>
            <li><a href="/admin" class="stats">stats</a></li>
        </ul>
    </div>
</header>