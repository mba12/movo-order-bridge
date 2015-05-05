<html>
<head>
    <title>Movo Email Confirmation</title>

    <style type="text/css">
        @import url(http://fonts.googleapis.com/css?family=Roboto:400,700);
        body {
            color: #333333;
            font-family: 'Open Sans', sans-serif;
            background-color: white;
            margin: 0;
            padding: 0;
            font-family: 'Roboto', sans-serif;
            font-weight: 400;
            font-size: 16px;
            -webkit-font-smoothing: antialiased;
            text-rendering: optimizeLegibility;
        }
    </style>

</head>

<body>
<div id="top-bar" style="background-color: #f6303e;height: 11px;color:#f6303e;overflow: hidden;">.</div>
<div id="logo" style="width: 65%; max-width: 327px; margin: 5% auto;">
    <img src="http://orders.getmovo.com/img/logo.png" style="width: 100%;"/>
</div>
<div id="content-wrap" style="background-color: #efeeee;border-top: 1px solid #cecece;border-bottom: 1px solid #cecece;margin-bottom: 3%;color:#333333;">
    <div class="inner" style="max-width: 700px;margin: 0 auto;padding: 40px 0;width: 80%;">

        <p style="line-height: 1.4em;margin: 18px 0;">Your account is confirmed. Thank you for verifying your email and setting up your account with Movo.</p>
        <p>
            @if(isset($data['fullName']) && strlen($data['fullName']) > 0)
                {{{  $data['fullName'] }}}<br/>
            @endif
            @if(isset($data['email'])  && strlen($data['email']) > 0)
                {{{ $data['email'] }}}<br/>
            @endif

        </p>
        <p style="line-height: 1.4em;margin: 18px 0;">Please check our {{ HTML::link('http://www.getmovo.com/faq/', 'FAQ')}} page for instruction and if you have any questions, please get in touch: <a href="mailto:info@getmovo.com" style="color: #f6303e;text-decoration: underline;">info@getmovo.com</a></p>
        <p style="line-height: 1.4em;margin: 18px 0;">Enjoy your Wave!</p>
        <p style="line-height: 1.4em;margin: 18px 0;">-Team Movo</p>
    </div>
</div>
<div id="website" style="color: #f6303e;font-size: 1.25em;font-weight: 700;text-align: center;margin-bottom: 4%;"><a href="http://www.getmovo.com" style="color: #f6303e;text-decoration: none !important;">getmovo.com</a></div>

</body>
</html>