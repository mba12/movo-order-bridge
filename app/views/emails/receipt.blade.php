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


<ul class="items">
       @foreach($data['items'] as $item)
             <li>
                  <span class="title">{{$item->title}}: </span><span class="quantity">{{$item->quantity}}</span> <span class="price">{{$item->price}}</span>
             </li>
       @endforeach
</ul>

<div class="total">Total: {{$data['total']}}</div>

<p align="center">Thanks for your order</p>


</body>
</html>