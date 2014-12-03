@extends('admin.main')

@section('content')

    <div class="container">
      <h4>Search results</h4>
      <ul class="orders">
        @foreach($orders as $order)
            @include('admin.order-link')
        @endforeach
      </ul>
    {{ $orders->appends(array('search' => Input::get("search"), 'criteria'=>Input::get("criteria")))->links()}}
     </div>
@stop
@section('inline-scripts')
   <script src="js/vendor/pusher/pusher.js" type="text/javascript"></script>
   <script src="js/vendor/jquery/jquery.js"></script>
   <script src="js/admin/admin.js"></script>
@stop


