@extends('admin.main')
@section('page-id')stats @stop

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
                            <div class="circle">
                                <div class="number">{{$lastHour}}</div>
                            </div>
                            <div class="period">last hour</div>
                    </li>
                    <li class="day">
                            <div class="circle">
                                <div class="number">{{$lastDay}}</div>
                            </div>
                            <div class="period">last day</div>
                    </li>
                    <li class="week">
                            <div class="circle">
                                <div class="number">{{$lastWeek}}</div>
                            </div>
                            <div class="period">last week</div>
                    </li>
                    <li class="month">
                            <div class="circle">
                                <div class="number">{{$lastMonth}}</div>
                            </div>
                            <div class="period">last month</div>
                    </li>
                    <li class="errors">
                            <div class="circle">
                                <div class="number">{{$errors}}</div>
                            </div>
                            <div class="period">errors</div>
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
                                <div class="detail">{{$coupon->usedCoupons()->count()}} of {{$coupon->usedCoupons()->count() + $coupon->limit-$coupon->usedCoupons()->count()}} used</div>
                           </div>
                      </li>
                    @else
                       <li>
                           <div class="circle">
                                <div class="percent no-limit" data-used="0" data-left="10">{{$coupon->usedCoupons()->count()}}</div>
                                    <canvas class="doughnut" width="135" height="135"></canvas>
                                </div>
                           <div class="bottom">
                                <div class="coupon">{{$coupon->name}}</div>
                                <div class="detail">no limit</div>
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


