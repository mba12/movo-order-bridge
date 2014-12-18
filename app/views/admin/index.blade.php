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
            <ul></ul>
        </div>
    </section>
@stop
@section('inline-scripts')
    <script type="text/template" id="coupon-limited-tpl">
        @include("admin.coupon-limited")
    </script>
    <script type="text/template" id="coupon-unlimited-tpl">
        @include("admin.coupon-unlimited")
    </script>
    <script src="/js/admin/stats.js"></script>
@stop
