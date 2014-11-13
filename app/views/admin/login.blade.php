@extends('admin.main')
@section('content')
  <h1>Log in to the admin section</h1>
      <div class="row">
       <div class="small-3 large-3 columns">
        @if(Session::has("global"))
         <p>{{ Session::get("global") }}</p>
         @endif
         {{Form::open(array('route' => array('post-admin-login')))}}
         <div>
             {{Form::label("name")}}
             {{ Form::text("name")}}
         </div>
         <div>
             {{Form::label("password")}}
             {{ Form::password("password")}}
         </div>

         <div>
             {{Form::submit("Login",["class"=>"button"]) }}
         </div>
         {{Form::close()}}
       </div>
        <div class="small-9 large-9 columns"></div>

      </div>
@stop
@section('inline-scripts')
   <script src="js/vendor/pusher/pusher.js" type="text/javascript"></script>
   <script src="js/vendor/jquery/jquery.js"></script>
   <script src="js/admin.js"></script>
@stop

