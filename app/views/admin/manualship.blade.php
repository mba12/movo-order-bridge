<section id="shipping-info">
    <h3 class="section-title">Shipping Info</h3>

    <p>
<!--    <input type="text" name="partner_id" placeholder="Partner Id" id="shipping-partner-id"/> -->
        {{ Form::select('partner_id', array('STACK' => 'StackSocial', 'MOVO' => "Movo/AHA", 'RETAIL' => "Retail"), 'STACK', array( 'style' => 'background-color: red; width: 149px;', 'onchange' => "retainToggle(this)")) }}

        <input type="text" name="partner_order_id" placeholder="Partner Order Id" id="shipping-partner-order-id" class="retailFields"/>
    <input type="text" name="ship-to-code" placeholder="Retailer Code" id="shipping-retailer-code" class="retailFields" />
    </p>
    <p>
    <input name="ship-request-date" type="text" id="ship-on-date" placeholder="Ship On Date" class="retailFields" >
    <input name="ship-no-later" type="text" id="ship-no-later" placeholder="Ship No Later" class="retailFields" >
    <input name="dock-date" type="text" id="delivery-date"  placeholder="Delivery Date" class="retailFields" >
    </p>
    <div id="use-billing-address">
        <label for="use-billing-address-checkbox">
            <input type="checkbox" id="use-billing-address-checkbox" onclick="fillShipping(this.form)"  />Use billing address</label>
    </div>
    <div class="fields hide2">
        <div class="row double">
            <div class="field">

                <input type="text" name="shipping-first-name" placeholder="First Name" id="shipping-first-name" data-validate="min:1" data-error-selector=".error-messages .first-name"/> <input type="text" name="shipping-last-name" placeholder="Last Name" id="shipping-last-name" data-validate="min:1" data-error-selector=".error-messages .last-name"/>
            </div>
        </div>

        <div class="row single">
            <div class="field">
                <input style="width: 302px" type="text" name="shipping-address" placeholder="Address" id="shipping-address" data-validate="min:1" data-error-selector=".error-messages .address"/>
            </div>
        </div>
        <div class="row single">
            <div class="field">
                <input style="width: 302px" type="text" name="shipping-address2" placeholder="Address" id="shipping-address2" data-validate="min:1" data-error-selector=".error-messages .address"/>
            </div>
        </div>

        <div class="row triple">
            <div class="field">
                <input type="text" name="shipping-city" placeholder="City" id="shipping-city" data-validate="min:1" data-error-selector=".error-messages .city"/>, &nbsp; <select name="shipping-state" id="shipping-state-select">
                    <option value="">-- State --</option>
                    <option value="AL">Alabama</option>
                    <option value="AK">Alaska</option>
                    <option value="AZ">Arizona</option>
                    <option value="AR">Arkansas</option>
                    <option value="CA">California</option>
                    <option value="CO">Colorado</option>
                    <option value="CT">Connecticut</option>
                    <option value="DE">Delaware</option>
                    <option value="DC">Dist. of Columbia</option>
                    <option value="FL">Florida</option>
                    <option value="GA">Georgia</option>
                    <option value="HI">Hawaii</option>
                    <option value="ID">Idaho</option>
                    <option value="IL">Illinois</option>
                    <option value="IN">Indiana</option>
                    <option value="IA">Iowa</option>
                    <option value="KS">Kansas</option>
                    <option value="KY">Kentucky</option>
                    <option value="LA">Louisiana</option>
                    <option value="ME">Maine</option>
                    <option value="MD">Maryland</option>
                    <option value="MA">Massachusetts</option>
                    <option value="MI">Michigan</option>
                    <option value="MN">Minnesota</option>
                    <option value="MS">Mississippi</option>
                    <option value="MO">Missouri</option>
                    <option value="MT">Montana</option>
                    <option value="NE">Nebraska</option>
                    <option value="NV">Nevada</option>
                    <option value="NH">New Hampshire</option>
                    <option value="NJ">New Jersey</option>
                    <option value="NM">New Mexico</option>
                    <option value="NY">New York</option>
                    <option value="NC">North Carolina</option>
                    <option value="ND">North Dakota</option>
                    <option value="OH">Ohio</option>
                    <option value="OK">Oklahoma</option>
                    <option value="OR">Oregon</option>
                    <option value="PA">Pennsylvania</option>
                    <option value="RI">Rhode Island</option>
                    <option value="SC">South Carolina</option>
                    <option value="SD">South Dakota</option>
                    <option value="TN">Tennessee</option>
                    <option value="TX">Texas</option>
                    <option value="UT">Utah</option>
                    <option value="VT">Vermont</option>
                    <option value="VA">Virginia</option>
                    <option value="WA">Washington</option>
                    <option value="WV">West Virginia</option>
                    <option value="WI">Wisconsin</option>
                    <option value="WY">Wyoming</option>
                </select>                  <input type="text" name="shipping-zip" placeholder="Zip" id="shipping-zip" data-validate="min:1" data-error-selector=".error-messages .zip"/>
                <input type="text" name="shipping-state-input" placeholder="Alt State" id="shipping-state-input"/>
            </div>
            <div>
                <div class="field">
                    <select name="shipping-country" id="shipping-country">
                        {{--<option value="AF">Afghanistan</option>--}}
                        {{--<option value="AX">Åland Islands</option>--}}
                        {{--<option value="AL">Albania</option>--}}
                        {{--<option value="DZ">Algeria</option>--}}
                        {{--<option value="AS">American Samoa</option>--}}
                        {{--<option value="AD">Andorra</option>--}}
                        {{--<option value="AO">Angola</option>--}}
                        {{--<option value="AI">Anguilla</option>--}}
                        {{--<option value="AQ">Antarctica</option>--}}
                        {{--<option value="AG">Antigua and Barbuda</option>--}}
                        {{--<option value="AR">Argentina</option>--}}
                        {{--<option value="AM">Armenia</option>--}}
                        {{--<option value="AW">Aruba</option>--}}
                        {{--<option value="AU">Australia</option>--}}
                        {{--<option value="AT">Austria</option>--}}
                        {{--<option value="AZ">Azerbaijan</option>--}}
                        {{--<option value="BS">Bahamas</option>--}}
                        {{--<option value="BH">Bahrain</option>--}}
                        {{--<option value="BD">Bangladesh</option>--}}
                        {{--<option value="BB">Barbados</option>--}}
                        {{--<option value="BY">Belarus</option>--}}
                        {{--<option value="BE">Belgium</option>--}}
                        {{--<option value="BZ">Belize</option>--}}
                        {{--<option value="BJ">Benin</option>--}}
                        {{--<option value="BM">Bermuda</option>--}}
                        {{--<option value="BT">Bhutan</option>--}}
                        {{--<option value="BO">Bolivia, Plurinational State of</option>--}}
                        {{--<option value="BQ">Bonaire, Sint Eustatius and Saba</option>--}}
                        {{--<option value="BA">Bosnia and Herzegovina</option>--}}
                        {{--<option value="BW">Botswana</option>--}}
                        {{--<option value="BV">Bouvet Island</option>--}}
                        {{--<option value="BR">Brazil</option>--}}
                        {{--<option value="IO">British Indian Ocean Territory</option>--}}
                        {{--<option value="BN">Brunei Darussalam</option>--}}
                        {{--<option value="BG">Bulgaria</option>--}}
                        {{--<option value="BF">Burkina Faso</option>--}}
                        {{--<option value="BI">Burundi</option>--}}
                        {{--<option value="KH">Cambodia</option>--}}
                        {{--<option value="CM">Cameroon</option>--}}
                        {{--<option value="CA">Canada</option>--}}
                        {{--<option value="CV">Cape Verde</option>--}}
                        {{--<option value="KY">Cayman Islands</option>--}}
                        {{--<option value="CF">Central African Republic</option>--}}
                        {{--<option value="TD">Chad</option>--}}
                        {{--<option value="CL">Chile</option>--}}
                        {{--<option value="CN">China</option>--}}
                        {{--<option value="CX">Christmas Island</option>--}}
                        {{--<option value="CC">Cocos (Keeling) Islands</option>--}}
                        {{--<option value="CO">Colombia</option>--}}
                        {{--<option value="KM">Comoros</option>--}}
                        {{--<option value="CG">Congo</option>--}}
                        {{--<option value="CD">Congo, the Democratic Republic of the</option>--}}
                        {{--<option value="CK">Cook Islands</option>--}}
                        {{--<option value="CR">Costa Rica</option>--}}
                        {{--<option value="CI">Côte d'Ivoire</option>--}}
                        {{--<option value="HR">Croatia</option>--}}
                        {{--<option value="CU">Cuba</option>--}}
                        {{--<option value="CW">Curaçao</option>--}}
                        {{--<option value="CY">Cyprus</option>--}}
                        {{--<option value="CZ">Czech Republic</option>--}}
                        {{--<option value="DK">Denmark</option>--}}
                        {{--<option value="DJ">Djibouti</option>--}}
                        {{--<option value="DM">Dominica</option>--}}
                        {{--<option value="DO">Dominican Republic</option>--}}
                        {{--<option value="EC">Ecuador</option>--}}
                        {{--<option value="EG">Egypt</option>--}}
                        {{--<option value="SV">El Salvador</option>--}}
                        {{--<option value="GQ">Equatorial Guinea</option>--}}
                        {{--<option value="ER">Eritrea</option>--}}
                        {{--<option value="EE">Estonia</option>--}}
                        {{--<option value="ET">Ethiopia</option>--}}
                        {{--<option value="FK">Falkland Islands (Malvinas)</option>--}}
                        {{--<option value="FO">Faroe Islands</option>--}}
                        {{--<option value="FJ">Fiji</option>--}}
                        {{--<option value="FI">Finland</option>--}}
                        {{--<option value="FR">France</option>--}}
                        {{--<option value="GF">French Guiana</option>--}}
                        {{--<option value="PF">French Polynesia</option>--}}
                        {{--<option value="TF">French Southern Territories</option>--}}
                        {{--<option value="GA">Gabon</option>--}}
                        {{--<option value="GM">Gambia</option>--}}
                        {{--<option value="GE">Georgia</option>--}}
                        {{--<option value="DE">Germany</option>--}}
                        {{--<option value="GH">Ghana</option>--}}
                        {{--<option value="GI">Gibraltar</option>--}}
                        {{--<option value="GR">Greece</option>--}}
                        {{--<option value="GL">Greenland</option>--}}
                        {{--<option value="GD">Grenada</option>--}}
                        {{--<option value="GP">Guadeloupe</option>--}}
                        {{--<option value="GU">Guam</option>--}}
                        {{--<option value="GT">Guatemala</option>--}}
                        {{--<option value="GG">Guernsey</option>--}}
                        {{--<option value="GN">Guinea</option>--}}
                        {{--<option value="GW">Guinea-Bissau</option>--}}
                        {{--<option value="GY">Guyana</option>--}}
                        {{--<option value="HT">Haiti</option>--}}
                        {{--<option value="HM">Heard Island and McDonald Islands</option>--}}
                        {{--<option value="VA">Holy See (Vatican City State)</option>--}}
                        {{--<option value="HN">Honduras</option>--}}
                        {{--<option value="HK">Hong Kong</option>--}}
                        {{--<option value="HU">Hungary</option>--}}
                        {{--<option value="IS">Iceland</option>--}}
                        {{--<option value="IN">India</option>--}}
                        {{--<option value="ID">Indonesia</option>--}}
                        {{--<option value="IR">Iran, Islamic Republic of</option>--}}
                        {{--<option value="IQ">Iraq</option>--}}
                        {{--<option value="IE">Ireland</option>--}}
                        {{--<option value="IM">Isle of Man</option>--}}
                        {{--<option value="IL">Israel</option>--}}
                        {{--<option value="IT">Italy</option>--}}
                        {{--<option value="JM">Jamaica</option>--}}
                        {{--<option value="JP">Japan</option>--}}
                        {{--<option value="JE">Jersey</option>--}}
                        {{--<option value="JO">Jordan</option>--}}
                        {{--<option value="KZ">Kazakhstan</option>--}}
                        {{--<option value="KE">Kenya</option>--}}
                        {{--<option value="KI">Kiribati</option>--}}
                        {{--<option value="KP">Korea, Democratic People's Republic of</option>--}}
                        {{--<option value="KR">Korea, Republic of</option>--}}
                        {{--<option value="KW">Kuwait</option>--}}
                        {{--<option value="KG">Kyrgyzstan</option>--}}
                        {{--<option value="LA">Lao People's Democratic Republic</option>--}}
                        {{--<option value="LV">Latvia</option>--}}
                        {{--<option value="LB">Lebanon</option>--}}
                        {{--<option value="LS">Lesotho</option>--}}
                        {{--<option value="LR">Liberia</option>--}}
                        {{--<option value="LY">Libya</option>--}}
                        {{--<option value="LI">Liechtenstein</option>--}}
                        {{--<option value="LT">Lithuania</option>--}}
                        {{--<option value="LU">Luxembourg</option>--}}
                        {{--<option value="MO">Macao</option>--}}
                        {{--<option value="MK">Macedonia, the former Yugoslav Republic of</option>--}}
                        {{--<option value="MG">Madagascar</option>--}}
                        {{--<option value="MW">Malawi</option>--}}
                        {{--<option value="MY">Malaysia</option>--}}
                        {{--<option value="MV">Maldives</option>--}}
                        {{--<option value="ML">Mali</option>--}}
                        {{--<option value="MT">Malta</option>--}}
                        {{--<option value="MH">Marshall Islands</option>--}}
                        {{--<option value="MQ">Martinique</option>--}}
                        {{--<option value="MR">Mauritania</option>--}}
                        {{--<option value="MU">Mauritius</option>--}}
                        {{--<option value="YT">Mayotte</option>--}}
                        {{--<option value="MX">Mexico</option>--}}
                        {{--<option value="FM">Micronesia, Federated States of</option>--}}
                        {{--<option value="MD">Moldova, Republic of</option>--}}
                        {{--<option value="MC">Monaco</option>--}}
                        {{--<option value="MN">Mongolia</option>--}}
                        {{--<option value="ME">Montenegro</option>--}}
                        {{--<option value="MS">Montserrat</option>--}}
                        {{--<option value="MA">Morocco</option>--}}
                        {{--<option value="MZ">Mozambique</option>--}}
                        {{--<option value="MM">Myanmar</option>--}}
                        {{--<option value="NA">Namibia</option>--}}
                        {{--<option value="NR">Nauru</option>--}}
                        {{--<option value="NP">Nepal</option>--}}
                        {{--<option value="NL">Netherlands</option>--}}
                        {{--<option value="NC">New Caledonia</option>--}}
                        {{--<option value="NZ">New Zealand</option>--}}
                        {{--<option value="NI">Nicaragua</option>--}}
                        {{--<option value="NE">Niger</option>--}}
                        {{--<option value="NG">Nigeria</option>--}}
                        {{--<option value="NU">Niue</option>--}}
                        {{--<option value="NF">Norfolk Island</option>--}}
                        {{--<option value="MP">Northern Mariana Islands</option>--}}
                        {{--<option value="NO">Norway</option>--}}
                        {{--<option value="OM">Oman</option>--}}
                        {{--<option value="PK">Pakistan</option>--}}
                        {{--<option value="PW">Palau</option>--}}
                        {{--<option value="PS">Palestinian Territory, Occupied</option>--}}
                        {{--<option value="PA">Panama</option>--}}
                        {{--<option value="PG">Papua New Guinea</option>--}}
                        {{--<option value="PY">Paraguay</option>--}}
                        {{--<option value="PE">Peru</option>--}}
                        {{--<option value="PH">Philippines</option>--}}
                        {{--<option value="PN">Pitcairn</option>--}}
                        {{--<option value="PL">Poland</option>--}}
                        {{--<option value="PT">Portugal</option>--}}
                        {{--<option value="PR">Puerto Rico</option>--}}
                        {{--<option value="QA">Qatar</option>--}}
                        {{--<option value="RE">Réunion</option>--}}
                        {{--<option value="RO">Romania</option>--}}
                        {{--<option value="RU">Russian Federation</option>--}}
                        {{--<option value="RW">Rwanda</option>--}}
                        {{--<option value="BL">Saint Barthélemy</option>--}}
                        {{--<option value="SH">Saint Helena, Ascension and Tristan da Cunha</option>--}}
                        {{--<option value="KN">Saint Kitts and Nevis</option>--}}
                        {{--<option value="LC">Saint Lucia</option>--}}
                        {{--<option value="MF">Saint Martin (French part)</option>--}}
                        {{--<option value="PM">Saint Pierre and Miquelon</option>--}}
                        {{--<option value="VC">Saint Vincent and the Grenadines</option>--}}
                        {{--<option value="WS">Samoa</option>--}}
                        {{--<option value="SM">San Marino</option>--}}
                        {{--<option value="ST">Sao Tome and Principe</option>--}}
                        {{--<option value="SA">Saudi Arabia</option>--}}
                        {{--<option value="SN">Senegal</option>--}}
                        {{--<option value="RS">Serbia</option>--}}
                        {{--<option value="SC">Seychelles</option>--}}
                        {{--<option value="SL">Sierra Leone</option>--}}
                        {{--<option value="SG">Singapore</option>--}}
                        {{--<option value="SX">Sint Maarten (Dutch part)</option>--}}
                        {{--<option value="SK">Slovakia</option>--}}
                        {{--<option value="SI">Slovenia</option>--}}
                        {{--<option value="SB">Solomon Islands</option>--}}
                        {{--<option value="SO">Somalia</option>--}}
                        {{--<option value="ZA">South Africa</option>--}}
                        {{--<option value="GS">South Georgia and the South Sandwich Islands</option>--}}
                        {{--<option value="SS">South Sudan</option>--}}
                        {{--<option value="ES">Spain</option>--}}
                        {{--<option value="LK">Sri Lanka</option>--}}
                        {{--<option value="SD">Sudan</option>--}}
                        {{--<option value="SR">Suriname</option>--}}
                        {{--<option value="SJ">Svalbard and Jan Mayen</option>--}}
                        {{--<option value="SZ">Swaziland</option>--}}
                        {{--<option value="SE">Sweden</option>--}}
                        {{--<option value="CH">Switzerland</option>--}}
                        {{--<option value="SY">Syrian Arab Republic</option>--}}
                        {{--<option value="TW">Taiwan, Province of China</option>--}}
                        {{--<option value="TJ">Tajikistan</option>--}}
                        {{--<option value="TZ">Tanzania, United Republic of</option>--}}
                        {{--<option value="TH">Thailand</option>--}}
                        {{--<option value="TL">Timor-Leste</option>--}}
                        {{--<option value="TG">Togo</option>--}}
                        {{--<option value="TK">Tokelau</option>--}}
                        {{--<option value="TO">Tonga</option>--}}
                        {{--<option value="TT">Trinidad and Tobago</option>--}}
                        {{--<option value="TN">Tunisia</option>--}}
                        {{--<option value="TR">Turkey</option>--}}
                        {{--<option value="TM">Turkmenistan</option>--}}
                        {{--<option value="TC">Turks and Caicos Islands</option>--}}
                        {{--<option value="TV">Tuvalu</option>--}}
                        {{--<option value="UG">Uganda</option>--}}
                        {{--<option value="UA">Ukraine</option>--}}
                        {{--<option value="AE">United Arab Emirates</option>--}}
                        {{--<option value="GB">United Kingdom</option>--}}
                        <option value="US">United States</option>
                        {{--<option value="UM">United States Minor Outlying Islands</option>--}}
                        {{--<option value="UY">Uruguay</option>--}}
                        {{--<option value="UZ">Uzbekistan</option>--}}
                        {{--<option value="VU">Vanuatu</option>--}}
                        {{--<option value="VE">Venezuela, Bolivarian Republic of</option>--}}
                        {{--<option value="VN">Viet Nam</option>--}}
                        {{--<option value="VG">Virgin Islands, British</option>--}}
                        {{--<option value="VI">Virgin Islands, U.S.</option>--}}
                        {{--<option value="WF">Wallis and Futuna</option>--}}
                        {{--<option value="EH">Western Sahara</option>--}}
                        {{--<option value="YE">Yemen</option>--}}
                        {{--<option value="ZM">Zambia</option>--}}
                        {{--<option value="ZW">Zimbabwe</option>--}}
                    </select>
                </div>


            </div>
        </div>
    </div>


    <div class="row double">
            <div class="field">
                <input type="text" name="shipping-phone" placeholder="Phone" id="shipping-phone" data-validate="min:1" data-error-selector=".error-messages .phone"/>
            </div>
    </div>
    <div class="row single">
        <div class="field">
            <select id="shipType" name="shipping-type" data-validate="min:1" data-error-selector=".error-messages .size">
                    <option value="" data-price="0">-- Ship Type --</option>
                    @foreach($shippingDropdownData as $shipping)
                        <option value="{{$shipping->id}}" data-price="{{$shipping->rate}}" >
                            {{$shipping->type}}
                        </option>
                    @endforeach
                </select>
        </div>
    </div>



</section>