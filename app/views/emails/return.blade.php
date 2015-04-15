<html>
<head>
<title>Order Exception or Return</title>

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
            <p style="line-height: 1.4em;margin: 18px 0;">Warning: There was Fed Ex Exception or Return on <span class="bold" style="font-weight: 700;">{{date('m-d-Y')}}</span></p>
             @foreach($data['items'] as $item)
                <p style="line-height: 1.4em;margin: 18px 0;"><span class="bold product" style="font-weight: 700;font-size: 1.125em;">{{intval($item['ship-quantity'])}} x {{$item['name']}} ({{$item['item-code']}})</span></p>
             @endforeach
            <p style="line-height: 1.4em;margin: 18px 0;"><span class="bold" style="font-weight: 700;">New Shipping Address:</span><br>

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
                <br/>
                @if(isset($data['order_date']) && strlen($data['order_date']) > 0)
                    Order Date: {{{  $data['order_date'] }}}<br/>
                @endif
                @if(isset($data['brightpoint-order-number']) && strlen($data['brightpoint-order-number']) > 0)
                    Brightpoint Order ID: {{{  $data['brightpoint-order-number'] }}}<br/>
                @endif
                @if(isset($data['ship-to-code']) && strlen($data['ship-to-code']) > 0)
                    Ship To Code: {{{  $data['ship-to-code'] }}}<br/>
                @endif

            </p>
            <div class="total"><span class="bold" style="font-weight: 700;">Order Total: <span class="red" style="color: #f6303e;">{{$data['order_total_net']}}</span></span></div>
            <p style="line-height: 1.4em;margin: 18px 0;">Use the Brightpoint Order Id and original order date above to determine the original Movo order id.</p>
        </div>
    </div>
    <div id="website" style="color: #f6303e;font-size: 1.25em;font-weight: 700;text-align: center;margin-bottom: 4%;"><a href="http://www.getmovo.com" style="color: #f6303e;text-decoration: none !important;">getmovo.com</a></div>

</body>
</html>