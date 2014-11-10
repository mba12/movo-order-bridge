<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="publishable-key" content="{{{Config::get("services.stripe.publishable")}}}"/>
        <title>Movo - Order Form</title>
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:300,600,400,700' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="css/main.css"/>
    </head>
<body>
        <?php

        $shippingTypes="";
        $shippingIds="";
        $shippingRates="";
        $i=0;
        foreach($shippingInfo as $info){
            if($i>0){
               $shippingTypes.='|';
               $shippingIds.='|';
               $shippingRates.='|';
            }
            $shippingTypes.=$info->type;
            $shippingIds.=$info->id;
            $shippingRates.=\Movo\Helpers\Format::FormatDecimals($info->rate);
            $i++;
        }
           //dd( $shippingTypes);
        ?>

       {{Form::open([
            'class' => 'order-form',
            'id' => 'order-form',
            'route'=>'buy',
            'autocomplete'=>'on',
            'data-product-prices'=>$unitPrice,
            'data-shipping-types'=>$shippingTypes,
            'data-shipping-ids'=>$shippingIds,
            'data-shipping-rates'=>$shippingRates
            ])
       }}

       {{Form::selectMonth(null, null, ['data-stripe'=>"exp-month"])}}
       {{Form::selectYear(null, date('Y'), date('Y')+10,date('Y')+1, ['data-stripe'=>'exp-year'])}}
       {{Form::submit("Buy Now")}}-->
       <div id="form-modal">
           <div id="form-content-box">
               @include('nav')
               @include('fixed-right-module')
               @include('products')
               @include('billing')
               @include('shipping')
               @include('payment')
               @include('summary')
           </div>
       </div>


       <div class="payment-errors"></div>
       {{Form::close()}}
       <script src="js/vendor/jquery/jquery.js"></script>
       <script src="js/vendor/Stepper/jquery.fs.stepper.js"></script>
       <script src="js/vendor/placeholder/jquery.placeholder.js"></script>
       <script src="https://js.stripe.com/v2/"></script>
       <script src="/js/order-form.js"></script>
</body>
</html>