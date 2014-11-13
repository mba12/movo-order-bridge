@extends('admin.main')
@section('content')
    <div class="container">
     <h2>Coupons</h2>
     @foreach($coupons as $coupon)
                {{Form::model($coupon)}}
                {{Form::text("")}}
                {{Form::close()}}
     @endforeach
     </div>

@stop
@section('inline-scripts')
   <script src="/js/vendor/pusher/pusher.js" type="text/javascript"></script>
   <script src="/js/vendor/jquery/jquery.js"></script>
   <script src="/js/admin.js"></script>
   <script src="/js/stats.js"></script>
@stop


