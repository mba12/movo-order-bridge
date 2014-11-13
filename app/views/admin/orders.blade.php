@extends('admin.main')
@section('content')
    <div class="container">
      <ul class="orders">
        @foreach($orders as $order)
             <li>
                Order: {{$order->id}} -- Last name: {{ $order->billing_last_name}}
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


