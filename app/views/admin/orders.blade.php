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
                "shipping_last_name"=>"Shipping Last name",
                "stripe_charge_id"=>"Stripe Charge ID",
                "billing_last_name"=>"Billing Last name",
                "shipping_address"=>"Shipping Address",
                "billing_address"=>"Billing Address",
            ])}}
            {{Form::submit("Search",[
                "class"=>"button"
            ])}}
            {{Form::close()}}
        </div>
    </div>

    @if(isset($searchResults))
           <h4>Search results</h4>
           <ul class="orders">
           @foreach($searchResults as $result)
                <li>
                     Order ID: {{$result->id}} -- Last name: {{ $result->billing_last_name}} -- Stripe Charge ID:  {{ $result->stripe_charge_id}}
                </li>
           @endforeach
           </ul>
    @endif
    <div class="container">
      <h4>Latest orders</h4>
      <ul class="orders">
        @foreach($orders as $order)
             <li>
                Order ID: {{$order->id}} -- Last name: {{ $order->billing_last_name}}
             </li>
          @endforeach
      </ul>
    {{ $orders->links()}}
     </div>
@stop
@section('inline-scripts')
   <script src="js/vendor/pusher/pusher.js" type="text/javascript"></script>
   <script src="js/vendor/jquery/jquery.js"></script>
   <script src="js/admin.js"></script>
@stop


