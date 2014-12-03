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
                                <div class="number">10</div>
                            </div>
                            <div class="period">last hour</div>
                        </a>
                    </li>
                    <li class="day">
                        <a href="/admin/orders">
                            <div class="circle">
                                <div class="number">122</div>
                            </div>
                            <div class="period">last day</div>
                        </a>
                    </li>
                    <li class="week">
                        <a href="/admin/orders">
                            <div class="circle">
                                <div class="number">877</div>
                            </div>
                            <div class="period">last week</div>
                        </a>
                    </li>
                    <li class="month">
                        <a href="/admin/orders">
                            <div class="circle">
                                <div class="number">3,987</div>
                            </div>
                            <div class="period">last month</div>
                        </a>
                    </li>
                    <li class="errors">
                        <a href="/admin/orders">
                            <div class="circle">
                                <div class="number">0</div>
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
                <li>
                    <div class="circle">
                        <div class="percent" data-used="15" data-left="85"><span class="used">15</span><sup>%</sup></div>
                        <canvas class="doughnut" width="135" height="135"></canvas>
                    </div>
                    <div class="bottom">
                        <div class="coupon">friends20</div>
                    </div>
                </li>
                <li>
                    <div class="circle">
                        <div class="percent" data-used="66" data-left="44"><span class="used">66</span><sup>%</sup></div>
                        <canvas class="doughnut" width="135" height="135"></canvas>
                    </div>
                    <div class="bottom">
                        <div class="coupon">take10</div>
                    </div>
                </li>
                <li>
                    <div class="circle">
                        <div class="percent" data-used="90" data-left="10"><span class="used">90</span><sup>%</sup></div>
                        <canvas class="doughnut" width="135" height="135"></canvas>
                    </div>
                    <div class="bottom">
                        <div class="coupon">thanksgiving</div>
                    </div>
                </li>
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
   <script src="js/admin.js"></script>
   <script src="js/stats.js"></script>
@stop


