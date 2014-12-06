@extends('admin.main')
@section('page-id')orders @stop
@section('content')
    <section class="gray">
        <div class="inner">
            <div id="search-header">
                @include('admin.search-header')
            </div>
            <div class="results">
                @include('admin.order-results')
                {{ $orders->links()}}
            </div>
        </div>
    </section>
@stop
@section('inline-scripts')
   <script src="/js/admin/orders.js"></script>
@stop