<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="publishable-key" content="{{{Config::get("services.stripe.publishable")}}}"/>
        <title>Movo - Order Form</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"/>
        <link href='https://fonts.googleapis.com/css?family=Open+Sans:300,600,400,700' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="css/main.css"/>
    </head>
<body>
        <script type="text/javascript">
            var TAX_TABLE=[];
            @foreach($stateTaxMethods as $method)
                TAX_TABLE.push({"state":"{{$method->state}}", "method":{{round($method->rate)}}});
            @endforeach

         </script>
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
         </script>
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
       <script src="js/vendor/cssua/cssua.js"></script>
       <script src="js/vendor/fastclick/fastclick.js"></script>
       <script src="js/vendor/Stepper/jquery.fs.stepper.js"></script>
       <script src="js/vendor/greensock/TweenMax.min.js"></script>
       <script src="js/vendor/placeholder/jquery.placeholder.js"></script>
       <script src="js/vendor/js-signals/signals.js"></script>
       <script src="https://js.stripe.com/v2/"></script>
       <script src="/js/order-form.js"></script>

       <script type="text/javascript">
               var _gaq = _gaq || [];
               _gaq.push(['_setAccount', 'UA-53056117-1']);
               _gaq.push(['_trackPageview']);
               //_gaq.push(['_addTrans', transactionID, affiliation, total, tax, shippingCost, city, state, country]);
               //_gaq.push(['_addItem', transactionID, sku, productName, category, unitPrice, quantity]);
               //_gaq.push(['_trackTrans']);

                   (function () {
                       var ga = document.createElement('script');
                       ga.type = 'text/javascript';
                       ga.async = true;
                       ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
                       var s = document.getElementsByTagName('script')[0];
                       s.parentNode.insertBefore(ga, s);
                   })();
           </script>
</body>
</html>