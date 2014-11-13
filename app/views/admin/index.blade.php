@extends('admin.main')
@section('content')
     <div class="container">
        <h2>Total orders</h2>
        <div class="order-count"></div>
        </div>
@stop
@section('inline-scripts')
   <script src="/js/vendor/pusher/pusher.js" type="text/javascript"></script>
   <script src="/js/vendor/jquery/jquery.js"></script>
   <script src="js/admin.js"></script>
   <script src="js/stats.js"></script>
@stop


