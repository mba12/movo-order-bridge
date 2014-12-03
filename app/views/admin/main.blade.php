<!DOCTYPE html>
<html lang="en">
<head>
    <title>Movo Admin Page</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"/>
    <meta name="pusher-key" content="{{{Config::get("services.pusher.public")}}}"/>
    {{--{{ HTML::style('//cdnjs.cloudflare.com/ajax/libs/foundation/5.4.7/css/foundation.css') }}--}}
    <link href='http://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700' rel='stylesheet' type='text/css'>
    {{ HTML::style('css/admin/admin.css') }}
    @yield('page-css')
</head>

<body>

<div id="page-wrap">
    @include ('admin.header')
    @yield('content')
    @include ('admin.footer')
</div>

@yield('inline-scripts')
</body>
</html>