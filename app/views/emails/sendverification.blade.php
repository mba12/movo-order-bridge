<html>
<head>
<title>Getmovo Email Verification</title>

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
            <p>
                @if(isset($data['full_name']) && strlen($data['full_name']) > 0)
                    {{{  $data['full_name'] }}}<br/>
                @endif
                @if(isset($data['email'])  && strlen($data['email']) > 0)
                    {{{ $data['email'] }}}<br/>
                @endif

            </p>

            <p style="line-height: 1.4em;margin: 18px 0;">Your journey ahead starts with this first step. Get ready to count what counts and to see where your steps will take you along the way.</p>

            <p style="line-height: 1.4em;margin: 18px 0;">Verify your email now to get started: {{ HTML::link($data['link'], 'link')}}.</p>
            <p>If the link above does not work for your email client you can copy and paste the full link below into your browser:<br/>
                {{{ $data['link'] }}}
            </p>
            <p style="line-height: 1.4em;margin: 18px 0;">If you have any questions, give us a shout on {{HTML::link('http://www.facebook.com/getmovo', 'Facebook')}},
                {{HTML::link('http://www.twitter.com/getmovo', 'Twitter')}} or via <a href="mailto:info@getmovo.com" style="color: #f6303e;text-decoration: underline;">info@getmovo.com</a>, and we'll help you find your way.</p>

            <p style="line-height: 1.4em;margin: 18px 0;">In the meantime, get stepping!</p>

            <p style="line-height: 1.4em;margin: 18px 0;">Thank you for your signing up with Movo! Enjoy your Wave!</p>
            <p style="line-height: 1.4em;margin: 18px 0;">-Team Movo</p>
        </div>
    </div>
    <div id="website" style="color: #f6303e;font-size: 1.25em;font-weight: 700;text-align: center;margin-bottom: 4%;"><a href="http://www.getmovo.com" style="color: #f6303e;text-decoration: none !important;">getmovo.com</a></div>

</body>
</html>