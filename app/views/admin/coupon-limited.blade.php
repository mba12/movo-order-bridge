<li>
    <div class="circle">
        <div class="percent" data-used="{{$coupon->usedCoupons()->count()}}" data-left="{{$coupon->limit-$coupon->usedCoupons()->count()}}"><span class="used">{{round($coupon->usedCoupons()->count()/$coupon->limit*100)}}</span><sup>%</sup></div>
        <canvas class="doughnut" width="135" height="135"></canvas>
    </div>
    <div class="bottom">
        <div class="coupon">{{$coupon->code}}</div>
        <div class="detail">{{$coupon->usedCoupons()->count()}} of {{$coupon->usedCoupons()->count() + $coupon->limit-$coupon->usedCoupons()->count()}} used</div>
    </div>
</li>