<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="publishable-key" content="{{{Config::get("services.stripe.publishable")}}}"/>
        <title>Movo - Order Form</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"/>
        <link href='https://fonts.googleapis.com/css?family=Open+Sans:300,600,400,700' rel='stylesheet' type='text/css'>
        {{Assets::css()}}
    </head>
<body class="{{ $after3pm ? 'after3pm' : '' }}">
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



            <script src="https://js.stripe.com/v2/"></script>
            {{Assets::js()}}

       <script type="text/javascript">

                //GA
              (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
              (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
              m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
              })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

              ga('create', 'UA-53056117-1', 'auto');  // Replace with your property ID.
              ga('send', 'pageview');
              ga('require', 'ecommerce');

               //Facebook
              (function () {
                  var _fbq = window._fbq || (window._fbq = []);
                  if (!_fbq.loaded) {
                      var fbds = document.createElement('script');
                      fbds.async = true;
                      fbds.src = '//connect.facebook.net/en_US/fbds.js';
                      var s = document.getElementsByTagName('script')[0];
                      s.parentNode.insertBefore(fbds, s);
                      _fbq.loaded = true;
                  }
              })();
              window._fbq = window._fbq || [];
       </script>
</body>
</html>