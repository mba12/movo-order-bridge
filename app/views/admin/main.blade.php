<!DOCTYPE html>
<html lang="en">
<head>
    <title>Movo Admin Page</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"/>
    <meta name="pusher-key" content="{{{Config::get("services.pusher.public")}}}"/>
    <link href='https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700' rel='stylesheet' type='text/css'>

    {{ HTML::style('css/admin/admin.css') }}
    @yield('page-css')
</head>

<body class="@yield('page-id')">

@include ('admin.header')
@yield('content')
@include ('admin.footer')

<link rel="stylesheet" media="all" type="text/css" href="http:////code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css" />

<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<!-- <script src="/js/vendor/jquery/jquery.js"></script> -->
<script src="/js/vendor/greensock/TweenMax.min.js"></script>
<script src="/js/vendor/pusher/pusher.js" type="text/javascript"></script>
<script src="/js/vendor/textfit/textFit.min.js"></script>
<script src="/js/vendor/chartjs/Chart.min.js"></script>
<script src="/js/vendor/greensock/TweenMax.min.js"></script>
<script src="/js/vendor/jquery/jquery.datetimepicker.js"></script>

<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>



@yield('inline-scripts')

</body>
</html>