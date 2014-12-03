@extends('admin.main')
@section('content')
    <section id="login" class="gray">
        <div class="inner">
            <h3>Log in to the admin section</h3>
            @if(Session::has("global"))
                <p class="errors">{{ Session::get("global") }}</p>
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
@section('inline-scripts')
   <script src="js/vendor/pusher/pusher.js" type="text/javascript"></script>
   <script src="js/vendor/jquery/jquery.js"></script>
   <script src="js/admin.js"></script>
@stop