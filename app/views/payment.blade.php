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
                <input type="text" name="credit-card-number" placeholder="Credit Card Number" id="credit-card-number" maxlength="16" data-validate="min:16|max:16|number" data-error-selector=".error-messages .credit-card"/>
            </div>
        </div>
        <div class="row triple">
            <div class="field">
                <label for="cc-month">Country</label>
                <select id="cc-month" data-validate="min:1" data-error-selector=".error-messages .month">
                    <option value="">-- month --</option>
                    <option value="01">01 - January</option>
                    <option value="02">02 - February</option>
                    <option value="03">03 - March</option>
                    <option value="04">04 - April</option>
                    <option value="05">05 - May</option>
                    <option value="06">06 - June</option>
                    <option value="07">07 - July</option>
                    <option value="08">08 - August</option>
                    <option value="09">09 - September</option>
                    <option value="10">10 - October</option>
                    <option value="11">11 - November</option>
                    <option value="12">12 - December</option>
                </select>
            </div>
            <div class="field">
                <label for="cc-year">Country</label>
                <select id="cc-year" data-validate="min:1" data-error-selector=".error-messages .year">
                    <option value="">-- year --</option>
                    <option value="01">2014</option>
                    <option value="02">2015</option>
                    <option value="03">2016</option>
                    <option value="04">2017</option>
                    <option value="05">2018</option>
                    <option value="06">2019</option>
                    <option value="07">2020</option>
                </select>
            </div>
            <div class="field">
                <label for="cvc">CVC</label>
                <input type="text" name="cvc" placeholder="CVC" id="cvc" maxlength="4" data-validate="number|min:3|max:4" data-error-selector=".error-messages .cvc"/>
            </div>
        </div>
    </div>
    <ul class="error-messages">
        <li class="credit-card">Please enter a credit card number!</li>
        <li class="month">Please enter an expiration month!</li>
        <li class="year">Please enter an expiration year!</li>
        <li class="cvc">Please enter the CVC!</li>
    </ul>
    <div class="prev-next">
        <div class="button next" id="submit-order">Submit Order</div>
        <div class="button prev">Previous</div>
    </div>

</section>