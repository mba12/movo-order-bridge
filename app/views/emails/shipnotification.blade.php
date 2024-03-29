<html>
<head>
<title>Getmovo Shipping Notification</title>

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
            <p style="line-height: 1.4em;margin: 18px 0;">This email is a shipping notification for your order placed on  <span class="bold" style="font-weight: 700;">{{{ $data['order_date'] }}}</span></p>
             @foreach($data['items']['line-item'] as $item)
                 <p style="line-height: 1.4em;margin: 18px 0;"><span class="bold product" style="font-weight: 700;font-size: 1.125em;">{{intval($item['ship-quantity'])}} x {{$item['name']}} ({{$item['item-code']}})</span></p>
             @endforeach
            <p style="line-height: 1.4em;margin: 18px 0;"><span class="bold" style="font-weight: 700;">Shipping Address:</span><br>
                {{$data['name']}}<br>

                @if(isset($data['address1']) && strlen($data['address1']) > 0)
                    {{{  $data['address1'] }}}<br/>
                @endif
                @if(isset($data['address2'])  && strlen($data['address2']) > 0)
                    {{{ $data['address2'] }}}<br/>
                @endif
                @if(isset($data['address3'])  && strlen($data['address3']) > 0)
                    {{{ $data['address3'] }}}<br/>
                @endif
                @if(isset($data['address4'])  && strlen($data['address4']) > 0)
                    {{{ $data['address4'] }}}<br/>
                @endif
                @if(isset($data['ship_country_code'])  && strlen($data['ship_country_code']) > 0)
                    {{{ $data['ship_country_code'] }}}<br/>
                @endif

            </p>
            <div class="total"><span class="bold" style="font-weight: 700;">Shipping Company: <span class="red" style="color: #1729f6;">Fed Ex</span></span></div>
            <div class="total"><span class="bold" style="font-weight: 700;">Tracking Code: <span class="red" style="color: #1729f6;">{{$data['tracking_code']}}</span><span class="red" style="color: #1729f6;">&nbsp;({{ HTML::link($data['link'], 'Track')}})</span></span></div>
            <p style="line-height: 1.4em;margin: 18px 0;">Thank you for your order! If you have any questions, please get in touch: <a href="mailto:info@getmovo.com" style="color: #f6303e;text-decoration: underline;">info@getmovo.com</a></p>
            <p style="line-height: 1.4em;margin: 18px 0;">Enjoy your Wave!</p>
            <p style="line-height: 1.4em;margin: 18px 0;">-Team Movo</p>
        </div>
    </div>
    <div id="website" style="color: #f6303e;font-size: 1.25em;font-weight: 700;text-align: center;margin-bottom: 4%;"><a href="http://www.getmovo.com" style="color: #f6303e;text-decoration: none !important;">getmovo.com</a></div>

</body>
</html>