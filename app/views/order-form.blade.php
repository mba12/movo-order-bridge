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

       {{Form::open([
            'class' => 'order-form',
            'id' => 'order-form',
            'route'=>'buy',
            'autocomplete'=>'on',
            'data-product-prices'=>'29.99',
            'data-shipping-types'=>'7-10 Day Ground|3-5 Day Ground|2 Day|Priority Overnight|International',
            'data-shipping-ids'=>'1|2|3|4|5',
            'data-shipping-rates'=>'5.75|8.50|12.00|18.00|17.00'
            ])
       }}

       <!-- <div class="form-row">
            <label for="">
                <span>Card Number: </span>
                <input type="number" data-stripe="number" value="4242424242424242" min="1" max="2000"/>
            </label>
        </div>

       <div class="form-row">
             <label for="">
                   <span>CVC: </span>
                   <input type="text" data-stripe="cvc" value="123"/>
             </label>
       </div>

        <div class="form-row">
              <label for="">
                    <span>Expiration: </span>
                    {{Form::selectMonth(null, null, ['data-stripe'=>"exp-month"])}}
                    {{Form::selectYear(null, date('Y'), date('Y')+10,date('Y')+1, ['data-stripe'=>'exp-year'])}}
              </label>
        </div>
       {{Form::submit("Buy Now")}}-->


       <div id="form-modal">
           <div id="form-content-box">
               @include('nav')
               @include('fixed-right-module')
               @include('products')
               @include('billing')
               @include('shipping')
               @include('payment')
           </div>
       </div>


       <div class="payment-errors"></div>
       {{Form::close()}}
       <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
       <script src="js/vendor/jquery/jquery.fs.stepper.js"></script>
       <script src="js/vendor/jquery/jquery.placeholder.js"></script>
       <script src="https://js.stripe.com/v2/"></script>
       <script src="/js/order-form.js"></script>
</body>
</html>