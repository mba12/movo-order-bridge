@extends('admin.main')
@section('page-id')login @stop
@section('content')
    <section id="login" class="gray">
        <div class="inner">
            <h3>Log in to the admin section</h3>
            @if(Session::has("global"))
                <div class="errors">{{ Session::get("global") }}</div>
            @endif
            {{Form::open(array('route' => array('post-admin-login'), 'autocomplete'=>'off'))}}
            <div>
                {{Form::label("")}}
                {{Form::text("name", null, array('placeholder'=>'Username'))}}
            </div>
            <div>
                {{Form::label("")}}
                {{ Form::password('password', array('placeholder' => 'Password')) }}
            </div>
            <div>
                {{Form::submit("Login",["class"=>"button"]) }}
            </div>
            {{Form::close()}}
        </div>
    </section>
@stop