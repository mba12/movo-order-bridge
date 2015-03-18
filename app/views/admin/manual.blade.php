@extends('admin.main')
@section('page-id')coupons @stop
@section('page-css')
    {{ HTML::style('css/vendor/jquery/jquery.datetimepicker.css') }}
@stop
@section('content')

    <div id="manual-list">
        <div class="inner">
            <h2>Manual Orders</h2>
        </div>
            <div class="manual">
                <div class="inner">
                    {{Form::model($manual, [
                       "route"=>"manualorderentry",
                       "method"=>"PUT",
                    ])}}
                    @include('products')
                    @include('loops')
                    @include('billing')
                    @include('shipping')
                        <div class="buttons">
                        <div class="update-button">
                            <div>
                                {{Form::submit("Update",["class"=>"button"])}}
                            </div>
                            {{Form::close()}}
                        </div>

                </div>
            </div>
    </div>


@stop

@section('inline-scripts')
    // Note: Need to create manual js with a typescript file
    <script src="/js/admin/manual.js"></script>
@stop


