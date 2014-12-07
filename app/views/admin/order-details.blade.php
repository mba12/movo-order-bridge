@extends('admin.main')
@section('page-css')
      {{ HTML::style('css/vendor/jquery/jquery.datetimepicker.css') }}
@stop
@section('page-id')orders order-details @stop
@section('content')
    <section class="gray">
        <div class="inner">
            <h2>Order Details</h2>
            <div class="details">
                <div class="row">
                    <h3>Order ID:</h3>
                   {{$order->id}}
                </div>
                <div class="row">
                    <h3>Created:</h3>
                   {{$order->created_at}}
                </div>
                <div class="row">
                    <h3>Email:</h3>
                     {{$order->email}}
                </div>
                <div class="row">
                    <h3>Billing:</h3>
                    {{$order->billing_first_name}} {{$order->billing_last_name}}<br>
                    {{$order->billing_address}}<br>
                    {{$order->billing_city}}, {{$order->billing_state}} {{$order->billing_zip}}<br>
                    {{$order->billing_country}}<br>
                    {{\Movo\Helpers\Format::FormatPhoneNumber($order->billing_phone)}}
                </div>
                <div class="row">
                    <h3>Shipping:</h3>
                   {{$order->shipping_first_name}} {{$order->shipping_last_name}}<br>
                   {{$order->shipping_address}} <br>
                   {{$order->shipping_city}}, {{$order->shipping_state}} {{$order->billing_zip}}<br>
                   {{$order->shipping_country}}<br>
                   {{\Movo\Helpers\Format::FormatPhoneNumber($order->shipping_phone)}}
                </div>
                <div class="row">
                    <h3>Items:</h3>
                    <ul class="items">
                        @foreach($order->items as $item)
                            <li>
                                1 x {{$item->description}}
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="row">
                    <h3>Shipping:</h3>
                    <div class="row">
                        {{$shipping->type}} ({{$shipping->scac_code}})
                    </div>
                </div>
                <div class="row">
                    <h3>Coupon:</h3>
                     {{$order->coupon == '' ? '(none)' : $order->coupon}}
                </div>
                <div class="row">
                    <h3>Total:</h3>
                     {{\Movo\Helpers\Format::FormatStripeMoney($order->amount)}}
                </div>
                <div class="row">
                    <h3>Stripe Token:</h3>
                     {{$order->stripe_charge_id}}
                </div>
            </div>
        </div>

    </section>
@stop
@section('inline-scripts')

@stop


