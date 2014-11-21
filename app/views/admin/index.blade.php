@extends('admin.main')
@section('page-css')
      {{ HTML::style('css/vendor/jquery/jquery.datetimepicker.css') }}
@stop
@section('content')
     <div class="container">
        <h4>Realtime stats</h4>
        <div class="order-count"><span class="category">Total orders: </span><span class="count"></span></div>
        <div class="error-count"><span class="category">Orders with error flag: </span><span class="count"></span></div>
     </div>
@stop
@section('inline-scripts')
   <script src="/js/vendor/pusher/pusher.js" type="text/javascript"></script>
   <script src="/js/vendor/jquery/jquery.js"></script>
   <script src="/js/vendor/jquery/jquery.datetimepicker.js"></script>
   <script src="js/admin.js"></script>
   <script src="js/stats.js"></script>
@stop


