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
                    {{ucwords(strtolower($order->billing_first_name))}} {{ucwords(strtolower($order->billing_last_name))}}
                    <br>
                    {{ucwords(strtolower($order->billing_address))}}<br>
                    {{ucwords(strtolower($order->billing_city))}}, {{$order->billing_state}} {{$order->billing_zip}}<br>
                    {{$order->billing_country}}<br>
                    {{\Movo\Helpers\Format::FormatPhoneNumber($order->billing_phone)}}
                </div>
                <div class="row">
                    <h3>Shipping:</h3>
                    {{ucwords(strtolower($order->shipping_first_name))}} {{ucwords(strtolower($order->shipping_last_name))}}
                    <br>
                    {{ucwords(strtolower($order->shipping_address))}} <br>
                    {{ucwords(strtolower($order->shipping_city))}}, {{$order->shipping_state}} {{$order->billing_zip}}
                    <br>
                    {{$order->shipping_country}}<br>
                    {{\Movo\Helpers\Format::FormatPhoneNumber($order->shipping_phone)}}
                </div>
                <div class="row">
                    <h3>Items:</h3>
                    <ul class="items">
                        @foreach($combinedItems as $item)
                            <li>
                                {{$item['quantity']}} x {{$item['description']}}
                            </li>
                        @endforeach
                    </ul>
                </div>
                @if($order->donations->count()>0)
                    <div class="row">
                        <h3>Donations:</h3>
                        <ul class="items">

                            @foreach($order->donations as $donation)
                                <li>
                                    {{\Movo\Helpers\Format::FormatStripeMoney($donation['amount'])}}
                                    for: {{Product::where("sku", "=",$donation['item_sku'])->first()->name}}
                                </li>
                            @endforeach

                        </ul>
                    </div>
                @endif
                <div class="row">
                    <h3>Shipping:</h3>
                    {{$shipping->type}} ({{$shipping->scac_code}})
                    {{ HTML::link($trackLink, $order->tracking_code)}}
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
                    @if (!is_null($order->stripe_charge_id))
                        {{$order->stripe_charge_id}}
                    @else
                        {{"This order was not charged"}}
                    @endif

                </div>
                <div class="row {{$order->error_flag ? 'error' : ''}}">
                    <h3>Error:</h3>
                    {{$order->error_flag ? 'true' : 'false'}}
                </div>
            </div>
        </div>

    </section>
@stop
@section('inline-scripts')

@stop


