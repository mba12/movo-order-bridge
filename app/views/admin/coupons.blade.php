@extends('admin.main')
@section('page-id')coupons @stop
@section('page-css')
    {{ HTML::style('css/vendor/jquery/jquery.datetimepicker.css') }}
@stop
@section('content')

    <div id="coupon-list">
        <div class="inner">
            <h2>Coupons</h2>
        </div>
        @foreach($coupons as $coupon)
            <div class="coupon">
                <div class="inner">
                    {{Form::model($coupon, [
                       "route"=>["update-coupon",$coupon->id],
                       "method"=>"PUT",
                    ])}}
                    <div class="fields">
                        <div class="field">
                            {{Form::label('name', 'Name');}}
                            {{Form::text("name")}}
                        </div>
                        <div class="field">
                            {{Form::label('code', 'Code');}}
                            {{Form::text("code")}}
                        </div>
                        <div class="field">
                            {{Form::label('amount', 'Discount');}}
                            {{Form::text("amount", null, ["class"=>"amount"])}}
                            {{Form::select('method', array('%' => '%', '$' => '$'))}}
                        </div>
                        <div class="field">
                            {{Form::label('limit', '# Allowed');}}
                            {{Form::text("limit", null, ["class"=>"limit"])}}
                        </div>
                        <div class="field">
                            {{Form::label('min-units', 'Min. Units');}}
                            {{Form::text("min_units", null, ["class"=>"min-units"])}}
                        </div>
                        <div class="field">
                            {{Form::label('constrained-by-time', 'Timed');}}
                            {{Form::checkbox("time_constraint")}}
                        </div>
                        <div id="time-fields">
                            <div class="field">
                                {{Form::label('start-time', 'Start Time');}}
                                {{Form::text("start_time",null,["class"=>"datetimepicker date"])}}
                            </div>
                            <div class="field">
                                {{Form::label('end-time', 'End Time');}}
                                {{Form::text("end_time",null,["class"=>"datetimepicker date"])}}
                            </div>
                        </div>
                         <div class="field">
                            {{Form::label('active', 'Active');}}
                            {{Form::checkbox("active")}}
                        </div>
                    </div>
                    <div class="buttons">
                        <div class="update-button">
                            <div>
                                {{Form::submit("Update",["class"=>"button"])}}
                            </div>
                        {{Form::close()}}
                        </div>
                        <div class="delete-button">
                            {{Form::open([
                             "route"=>["delete-coupon",$coupon->id],
                             "method"=>"DELETE",
                            ])}}
                            {{Form::submit("Delete",["class"=>"button"])}}
                            {{Form::close()}}
                        </div>

                    </div>
                 </div>
            </div>
        @endforeach
    </div>

    <div id="add" class="inner">
        <h2>Create New Coupon</h2>
        {{Form::open([
              "route"=>["add-coupon"],
              "method"=>"create",
        ])}}
        <div class="errors">
            @if (Session::has("add-coupon-message"))
                {{Session::get("add-coupon-message")}}
            @endif
        </div>
        <span>{{Form::text("name", null,["placeholder"=>"Coupon name"])}}</span>
        <span>{{Form::submit("Create",["class"=>"button"])}}</span>
        {{Form::close()}}
    </div>

@stop

@section('inline-scripts')
    <script src="/js/admin/coupons.js"></script>
@stop


