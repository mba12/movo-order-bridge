@extends('admin.main')
@section('content')
     <div class="container">
        <h4>Realtime stats</h4>
        <div class="order-count"><span class="category">Total orders: </span><span class="count"></span></div>
        <div class="error-count"><span class="category">Orders with error flag: </span><span class="count"></span></div>
     </div>
     <div class="container">
         <h4>Coupons</h4>
         <div class="coupon">


           <div class="coupon-row">
                      <span>Name</span>
                      <span>Code</span>
                      <span>Amount</span>
                      <span>Method</span>
                      <span>Total Allowed</span>
                      <span>Minimum Units</span>
                      <span> </span>
                   </div>
         @foreach($coupons as $coupon)
         {{Form::model($coupon, [
            "route"=>["update-coupon",$coupon->id],
            "method"=>"PUT",
         ])}}
             <div class="coupon-row">

                  <span>{{Form::text("name")}}</span>
                  <span>{{Form::text("code")}}</span>
                  <span> {{Form::text("amount")}}</span>
                  <span>{{Form::select('method', array('%' => 'percentage', '$' => 'dollar amount'))}}</span>
                  <span> {{Form::text("limit")}}</span>
                  <span> {{Form::text("min_units")}}</span>
                  <span>{{Form::submit("Update coupon",["class"=>"button"])}}</span>

             </div>
             {{Form::close()}}
         @endforeach
           </div>
     </div>
@stop
@section('inline-scripts')
   <script src="/js/vendor/pusher/pusher.js" type="text/javascript"></script>
   <script src="/js/vendor/jquery/jquery.js"></script>
   <script src="js/admin.js"></script>
   <script src="js/stats.js"></script>
@stop


