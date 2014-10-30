<html>
    <head>
        <meta charset="UTF-8">
        <meta name="publishable-key" content="{{{Config::get("services.stripe.publishable")}}}"/>
        <title>Order Form</title>
    </head>
<body>
       <h1>Buy Now</h1>
       {{Form::open([
            'class' => 'order-form',
            'id' => 'order-form',
            'route'=>'buy'
            ])
       }}

        <div class="form-row">
            <label for="">
                <span>Card Number: </span>
                <input type="text" data-stripe="number"/>
            </label>
        </div>

       <div class="form-row">
             <label for="">
                   <span>CVC: </span>
                   <input type="text" data-stripe="cvc"/>
             </label>
       </div>

        <div class="form-row">
              <label for="">
                    <span>Expiration: </span>
                    {{Form::selectMonth(null, null, ['data-stripe'=>"exp-month"])}}
                    {{Form::selectYear(null, date('Y'), date('Y')+10,null, ['data-stripe'=>'exp-year'])}}
              </label>
        </div>
       {{Form::submit("Buy Now")}}

       <div class="payment-errors"></div>
       {{Form::close()}}
       <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
       <script src="https://js.stripe.com/v2/"></script>
       <script src="/js/billing.js"></script>
</body>
</html>