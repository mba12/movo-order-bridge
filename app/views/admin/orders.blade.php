@extends('admin.main')
@section('content')

    <div class="container">
        <h4>Order lookup</h4>
        <div class="search">
            {{Form::open([
                "route"=>"order-search",

            ])}}
            {{Form::text("search", "",[
                "placeholder"=>"Search term"
            ])}}
            {{Form::select("criteria",[
                "shipping_first_name"=>"Shipping First Name",
                "shipping_last_name"=>"Shipping Last Name",
                "shipping_address"=>"Shipping Address",
                "billing_first_name"=>"Billing First Name",
                "billing_last_name"=>"Billing Last Name",
                "billing_address"=>"Billing Address",
                "stripe_charge_id"=>"Stripe Charge ID",

            ])}}
            {{Form::submit("Search",[
                "class"=>"button"
            ])}}
            {{Form::close()}}
        </div>
    </div>

    <div class="container">
      <h4>Latest orders</h4>
      <ul class="orders">
        @foreach($orders as $order)
               @include('admin.order-link')
          @endforeach
      </ul>
    {{ $orders->links()}}
     </div>
@stop
@section('inline-scripts')
   <script src="js/vendor/pusher/pusher.js" type="text/javascript"></script>
   <script src="js/vendor/jquery/jquery.js"></script>
   <script src="js/admin/admin.js"></script>
@stop


