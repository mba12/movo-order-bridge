<html>
<head>
<title>Getmovo Order</title>
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
  text-rendering: optimizeLegibility; }

p {
  line-height: 1.4em;
  margin: 18px 0; }

a {
  color: #f6303e;
  text-decoration: underline; }

.bold {
  font-weight: 700; }

.red {
  color: #f6303e; }

#top-bar {
  background-color: #f6303e;
  height: 11px; }

#logo {
  width: 327px;
  height: 62px;
  background-image: url('http://orders.getmovo.com/img/logo.png');
  background-size: 327px 62px;
  background-repeat: no-repeat;
  margin: 60px auto; }
  @media (-webkit-min-device-pixel-ratio: 2), (min-resolution: 144dppx) {
    #logo {
      background-image: url('http://orders.getmovo.com/img/logo@2x.png');
      background-size: 327px 62px; } }

#content-wrap {
  background-color: #efeeee;
  border-top: 1px solid #cecece;
  border-bottom: 1px solid #cecece;
  margin-bottom: 30px; }
  #content-wrap .inner {
    max-width: 700px;
    margin: 0 auto;
    padding: 40px 0;
    width: 80%; }
    #content-wrap .inner .product {
      font-size: 1.125em; }

#website {
  color: #f6303e;
  font-size: 1.25em;
  font-weight: 700;
  text-align: center;
  margin-bottom: 50px; }
  #website a {
    text-decoration: none !important; }

</style>
{{--<link rel="stylesheet" href="/css/email-receipt.css"/>--}}
</head>

<body>
    <div id="top-bar"></div>
    <div id="logo"></div>
    <div id="content-wrap">
        <div class="inner">
            <p>This email is to confirm your order on <span class="bold">{{date('m-d-Y')}}</span></p>
            <p><span class="bold product">1 x Movo Wave (M)</span></p>
            <p><span class="bold">Shipping Address:</span><br>
                Ryan Hovland<br>
                1651 Ash St.<br>
                Lake Oswego, OR 97034
                    {{--{{$data['shippingAddress']}}--}}
            </p>

           {{-- @foreach($data['items'] as $item)
                <p><span class="quantity">{{$item->quantity}} </span><span class="title">{{$item->title}}: </span> <span class="price">{{$item->price}}</span></p>
            @endforeach--}}

            <div class="total"><span class="bold">Order Total: <span class="red">{{$data['total']}}</span></span></div>

            <p>Thank you for your order! If you have any questions, please get in touch: <a href="mailto:info@getmovo.com">info@getmovo.com</a></p>
            <p>Enjoy your Wave!</p>
            <p>-Team Movo</p>
        </div>
    </div>
    <div id="website"><a href="http://www.getmovo.com">getmovo.com</a></div>

</body>
</html>