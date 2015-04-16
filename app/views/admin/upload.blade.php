@extends('admin.main')
@section('page-id')upload @stop
@section('content')
    <section class="gray">
        <div class="inner">
            <div id="search-header">
                @include('admin.upload-details')
            </div>
            <div class="results">
            </div>
        </div>
    </section>
@stop
@section('inline-scripts')
    <script src="/js/admin/upload.js"></script>
@stop