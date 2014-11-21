<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="publishable-key" content="{{{Config::get("services.stripe.publishable")}}}"/>
        <title>Movo - Order Form</title>
        <link href='https://fonts.googleapis.com/css?family=Open+Sans:300,600,400,700' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="css/main.css"/>


    </head>
<body>
       @if($coupon)
         <script type="text/javascript">
            var COUPON={
                code: '{{$coupon->code}}',
                name: '{{$coupon->name}}',
                amount: {{$coupon->amount}},
                method: '{{$coupon->method}}',
                min_units: {{$coupon->min_units}},
                limit: {{$coupon->limit}}
            };
       @endif

           <div id="form-content-box">
               @include('nav')
               <div id="close"></div>

               {{Form::open([
                           'class' => 'order-form',
                           'id' => 'order-form',
                           'route'=>'buy',
                           'autocomplete'=>'on',
                           'data-product-prices'=>$unitPrice,
                           'data-shipping-types'=>$shippingDropdownData['shippingTypes'],
                           'data-shipping-ids'=>$shippingDropdownData['shippingIds'],
                           'data-shipping-rates'=>$shippingDropdownData['shippingRates']
                           ])
                      }}
                       @include('fixed-right-module')
                       @include('products')
                       @include('billing')
                       @include('shipping')
                       @include('payment')
                       @include('summary')
               {{Form::close()}}
           </div>

       <script src="js/vendor/jquery/jquery.js"></script>
       <script src="js/vendor/Stepper/jquery.fs.stepper.js"></script>
       <script src="js/vendor/greensock/TweenMax.min.js"></script>
       <script src="js/vendor/placeholder/jquery.placeholder.js"></script>
       <script src="js/vendor/js-signals/signals.js"></script>
       <script src="https://js.stripe.com/v2/"></script>
       <script src="/js/order-form.js"></script>
</body>
</html>