<html>
<head>

<title>Getmovo.com</title>

<style type="text/css">

body {
  color: #000;
  background-color: #FFF;
  background-image: url("");

}

</style>

</head>

<body>

 <p>This email is to confirm your order on {{date('m-d-Y')}}:</p>
 <p>Shipping Address: {{$data['shippingAddress']}}</p>

@foreach($data['items'] as $item)
    <p><span class="quantity">{{$item->quantity}} </span><span class="title">{{$item->title}}: </span> <span class="price">{{$item->price}}</span></p>
@endforeach


<div class="total">Order Total: {{$data['total']}}</div>

<p>Thank you for your order! If you need to manage your order, click here: <a href="mailto:info@getmovo.com">info@getmovo.com</a></p>
<p>Enjoy your Wave!</p>
<p>-Team Movo</p>


</body>
</html>