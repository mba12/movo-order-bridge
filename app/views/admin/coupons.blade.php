@extends('admin.main')
@section('page-id')coupons @stop
@section('page-css')
    {{ HTML::style('css/vendor/jquery/jquery.datetimepicker.css') }}
@stop
@section('content')
    <div class="container">
        <h4>Coupons</h4>
        <div class="coupon">

            <div class="coupon-row">
                <span>Name</span> <span>Code</span> <span>Amount</span> <span>Method</span> <span>Total Allowed</span>
                <span>Minimum Units</span> <span>Start Time</span> <span>End Time</span>
                <span>Constrained by time</span> <span>Active</span> <span> </span>
            </div>
            @foreach($coupons as $coupon)
                {{Form::model($coupon, [
                   "route"=>["update-coupon",$coupon->id],
                   "method"=>"PUT",
                ])}}

                <div class="coupon-row">
                    <span>{{Form::text("name")}}</span> <span>{{Form::text("code")}}</span>
                    <span>{{Form::text("amount")}}</span>
                    <span>{{Form::select('method', array('%' => 'percentage', '$' => 'dollar amount'))}}</span>
                    <span>{{Form::text("limit")}}</span> <span> {{Form::text("min_units")}}</span>
                    <span>{{Form::text("start_time",null,["class"=>"datetimepicker"])}}</span>
                    <span>{{Form::text("end_time",null,["class"=>"datetimepicker"])}}</span>
                    <span>{{Form::checkbox("time_constraint")}}</span> <span> {{Form::checkbox("active")}}</span>
                    <span>{{Form::submit("Update coupon",["class"=>"button"])}}</span>
                </div>
                {{Form::close()}}
                {{Form::open([
                     "route"=>["delete-coupon",$coupon->id],
                     "method"=>"DELETE",
                ])}}
                <div class="coupon-row">
                    <span>{{Form::submit("Delete coupon",["class"=>"button"])}}</span>
                </div>
                {{Form::close()}}
            @endforeach
        </div>
        <div class="coupon-row">
            {{Form::open([
                  "route"=>["add-coupon"],
                  "method"=>"create",
            ])}}
            <div class="coupon-row">
                @if (Session::has("add-coupon-message"))
                    {{Session::get("add-coupon-message")}}
                @endif
                <span>{{Form::text("name", null,["placeholder"=>"Enter a name for your coupon"])}}</span>
                <span>{{Form::submit("Add a new coupon",["class"=>"button"])}}</span>
            </div>
            {{Form::close()}}
        </div>
    </div>
@stop

@section('inline-scripts')
    <script src="/js/vendor/pusher/pusher.js" type="text/javascript"></script>
    <script src="/js/vendor/jquery/jquery.js"></script>
    <script src="/js/vendor/jquery/jquery.datetimepicker.js"></script>
    <script src="js/admin/admin.js"></script>
    <script type="text/javascript">
        $('.datetimepicker').datetimepicker();
    </script>
@stop


