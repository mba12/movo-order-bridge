@extends('admin.main')
@section('page-id')orders @stop
@section('content')
    <section class="gray">
        <div class="inner">
            <div id="search-header">
                @include('admin.search-header')
            </div>
            <div class="results">
                @if ($orders->count()==0)
                    <h4>There are no results for this search</h4>
                @else
                    <h3 id="search-results-title">Search Results ({{$orders->count()}})</h3>
                    @include('admin.order-results')
                @endif
                {{ $orders->appends(array('search' => Input::get("search"), 'criteria'=>Input::get("criteria")))->links()}}
            </div>
        </div>
    </section>
@stop
@section('inline-scripts')
   <script src="/js/admin/orders.js"></script>
@stop


