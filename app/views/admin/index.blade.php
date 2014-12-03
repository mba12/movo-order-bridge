@extends('admin.main')
@section('page-css')
      {{ HTML::style('css/vendor/jquery/jquery.datetimepicker.css') }}
@stop
@section('content')
     <section id="orders" class="gray">
        <div class="inner">
             <div class="container">
                <h2>Orders</h2>
                <ul>
                    <li class="hour">
                        <a href="/admin/orders">
                            <div class="circle">
                                <div class="number">{{$lastHour}}</div>
                            </div>
                            <div class="period">last hour</div>
                        </a>
                    </li>
                    <li class="day">
                        <a href="/admin/orders">
                            <div class="circle">
                                <div class="number">{{$lastDay}}</div>
                            </div>
                            <div class="period">last day</div>
                        </a>
                    </li>
                    <li class="week">
                        <a href="/admin/orders">
                            <div class="circle">
                                <div class="number">{{$lastWeek}}</div>
                            </div>
                            <div class="period">last week</div>
                        </a>
                    </li>
                    <li class="month">
                        <a href="/admin/orders">
                            <div class="circle">
                                <div class="number">{{$lastMonth}}</div>
                            </div>
                            <div class="period">last month</div>
                        </a>
                    </li>
                    <li class="errors">
                        <a href="/admin/orders">
                            <div class="circle">
                                <div class="number">{{$errors}}</div>
                            </div>
                            <div class="period">errors</div>
                        </a>
                    </li>
                </ul>

             </div>
        </div>
     </section>
     <section id="coupons">
        <div class="inner">
            <h2>Coupons</h2>
            <ul>
                @foreach($coupons as $coupon)
                    @if($coupon->limit>0)
                      <li>
                           <div class="circle">
                                <div class="percent" data-used="{{$coupon->usedCoupons()->count()}}" data-left="{{$coupon->limit-$coupon->usedCoupons()->count()}}"><span class="used">{{$coupon->usedCoupons()->count()/$coupon->limit*100}}</span><sup>%</sup></div>
                                    <canvas class="doughnut" width="135" height="135"></canvas>
                                </div>
                           <div class="bottom">
                                <div class="coupon">{{$coupon->name}}</div>
                           </div>
                      </li>
                    @else
                       <li>
                           <div class="circle">
                                <div class="percent" data-used="{{$coupon->usedCoupons()->count()}}" data-left="{{$coupon->usedCoupons()->count()}}"><span class="used">{{$coupon->usedCoupons()->count()}}</span><sup></sup></div>
                                    <canvas class="doughnut" width="135" height="135"></canvas>
                                </div>
                           <div class="bottom">
                                <div class="coupon">{{$coupon->name}}</div>
                           </div>
                      </li>
                    @endif
                @endforeach

            </ul>
        </div>
     </section>
@stop
@section('inline-scripts')
   <script src="/js/vendor/pusher/pusher.js" type="text/javascript"></script>
   <script src="/js/vendor/jquery/jquery.js"></script>
   <script src="/js/vendor/jquery/jquery.datetimepicker.js"></script>
   <script src="/js/vendor/textfit/textFit.min.js"></script>
   <script src="/js/vendor/chartjs/Chart.min.js"></script>
   <script src="/js/vendor/greensock/TweenMax.min.js"></script>
   <script src="js/admin/admin.js"></script>
   <script src="js/admin/stats.js"></script>
@stop


