<header id="header">
    <div class="bar"></div>
    <div class="inner">
        <a href="/admin">
           <div class="logo"></div>
        </a>
        <ul id="nav-links">
            <li><a href="/admin" class="stats">stats</a></li>
            <li><a href="/admin/orders" class="orders">orders</a></li>
            <li><a href="/admin/coupons" class="coupons">coupons</a></li>
            <li><a href="/admin/manual" class="coupons">manual</a></li>
            <li><a href="/admin/upload" class="coupons">upload</a></li>

        @if(Session::get('admin'))
                <li><a href="/admin/logout" class="">logout</a></li>
            @endif
        </ul>
    </div>
</header>