@extends('admin.main')

@section('content')

    <div class="container">
      @if ($orders->count()==0)
             <h4>There are no results for this search</h4>
      @else
      <h4>Search results</h4>
          <ul class="orders">
            @foreach($orders as $order)
                @include('admin.order-link')
            @endforeach
          </ul>
          {{ $orders->appends(array('search' => Input::get("search"), 'criteria'=>Input::get("criteria")))->links()}}
     @endif
     </div>
@stop
@section('inline-scripts')
   <script src="js/vendor/pusher/pusher.js" type="text/javascript"></script>
   <script src="js/vendor/jquery/jquery.js"></script>
   <script src="js/admin/admin.js"></script>
@stop


