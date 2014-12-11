<section id="payment">
    <h3 class="section-title">Payment</h3>
    <div class="credit-cards"></div>
    <div id="secure">
        <div id="lock-icon"></div>
        <h5>SSL Secured</h5>
    </div>
    <div class="fields">
        <div class="row single">
            <div class="field">
                <label for="credit-card-number">Credit Card Number</label>
                <input type="text" @if(App::environment()=='local'){{'value="4242424242424242"'}}  @endif data-stripe="number" placeholder="Credit Card Number" id="credit-card-number" maxlength="16" data-validate="min:15|max:16|number" data-error-selector=".error-messages .credit-card"/>
            </div>
        </div>
        <div class="row triple">
            <div class="field">
                <label for="cc-month">Month</label>
                <select id="cc-month" data-stripe="exp-month" data-validate="min:1" data-error-selector=".error-messages .month">
                    <option value="">-- month --</option>
                    <option value="1">01 - January</option>
                    <option value="2">02 - February</option>
                    <option value="3">03 - March</option>
                    <option value="4">04 - April</option>
                    <option value="5">05 - May</option>
                    <option value="6">06 - June</option>
                    <option value="7">07 - July</option>
                    <option value="8">08 - August</option>
                    <option value="9">09 - September</option>
                    <option value="10">10 - October</option>
                    <option value="11">11 - November</option>
                    <option value="12">12 - December</option>
                </select>
            </div>
            <div class="field">
                <label for="cc-year">Year</label>
                {{Form::selectYear(null, date('Y'), date('Y')+10,date('Y')+1, [
                    'data-stripe'=>'exp-year',
                    'id'=>'cc-year',
                    'data-validate'=>'min:1',
                    'data-error-selector'=>'.error-messages .year'
                ])}}
            </div>
            <div class="field">
                <label for="cvc">CVC</label>
                <input type="text" data-stripe="cvc" placeholder="CVC" id="cvc" maxlength="4" data-validate="number|min:3|max:4" data-error-selector=".error-messages .cvc"/>
            </div>
        </div>

    </div>
    <div id="coupon-container">
        <input type="text"  placeholder="Enter coupon code" id="coupon-code" value=""/>
        <div class="apply small-gray-button" id="submit-coupon-code">APPLY</div>
        <ul id="coupon-error-messages" class="error-messages">
            <li class="coupon-blank">Please enter a coupon code!</li>
            <li class="coupon-invalid">Coupon code has expired or is invalid!</li>
            <li class="coupon-error"></li>
        </ul>
        <div id="coupon-success" >Coupon applied: <span class="code"></span></div>
    </div>
    <div id="shipping-confirmation">
        <h5>Ship to:</h5>
        <div class="name">Ryan Hovland</div>
        <div class="street">1651 Ash St</div>
        <div class="cityStateZip">Lake Oswego, OR 97034</div>
        <div id="edit-shipping" class="small-gray-button">EDIT</div>
    </div>
    <p id="shipping-message">
    Orders will begin shipping on Monday, December 15. Please note that due to increased holiday shipping demand, we cannot guarantee delivery by December 25th.
    </p>
    <ul class="error-messages">
        <li class="credit-card">Please enter a credit card number!</li>
        <li class="month">Please enter an expiration month!</li>
        <li class="year">Please enter an expiration year!</li>
        <li class="cvc">Please enter the CVC!</li>
        <li class="card-error">There was a problem processing your order. Please try again or contact <a href="mailto:info@getmovo.com">info@getmovo.com</a> for assistance.</li>
        <li class="custom-error"></li>
    </ul>
    <div class="prev-next">
        <div class="button next" id="submit-order">Submit <span class="order"> Order</span></div>
        <div class="spinner">
            <img src="img/spinner.gif" />
        </div>
        <div class="button prev">Previous</div>
    </div>

</section>