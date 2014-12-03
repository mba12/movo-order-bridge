@extends('admin.main')
@section('page-css')
      {{ HTML::style('css/vendor/jquery/jquery.datetimepicker.css') }}
@stop
@section('content')
     <div class="container">
         <h2>Order Details</h2>
         <h3>Created</h3>
         <div class="text-row">
               {{date("m-d-Y", strtotime($order->created_at))}}
         </div>
         <h3>Billing to</h3>
         <div class="text-row">
               {{$order->billing_first_name}} {{$order->billing_last_name}}
         </div>
         <div class="text-row">
               {{$order->billing_address}} {{$order->billing_city}}, {{$order->billing_state}} {{$order->billing_zip}}
         </div>
         <h3>Shipping to</h3>
         <div class="text-row">
           {{$order->shipping_first_name}} {{$order->shipping_last_name}}
         </div>
         <div class="text-row">
           {{$order->shipping_address}} {{$order->shipping_city}}, {{$order->shipping_state}} {{$order->billing_zip}}
         </div>
         <h3>Total</h3>
         <div class="text-row">
             {{\Movo\Helpers\Format::FormatStripeMoney($order->amount)}}
          </div>
          <h3>Items</h3>
          @foreach($items as $item)
               <div class="text-row">
                   1 x {{$item}}
               </div>
          @endforeach
           <h3>Shipping</h3>
           <div class="text-row">
                 {{$shipping->type}} ({{$shipping->scac_code}})
            </div>
     </div>
@stop
@section('inline-scripts')
   <script src="/js/vendor/pusher/pusher.js" type="text/javascript"></script>
   <script src="/js/vendor/jquery/jquery.js"></script>
   <script src="/js/vendor/jquery/jquery.datetimepicker.js"></script>
   <script src="js/admin/admin.js"></script>
   <script type="text/javascript">
   $('.datetimepicker').datetimepicker();
   </script>
@stop


