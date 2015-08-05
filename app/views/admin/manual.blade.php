@extends('admin.main')
@section('page-id')manual @stop
@section('page-css')
    {{ HTML::style('css/vendor/jquery/jquery.datetimepicker.css') }}
@stop
@section('content')

    <div id="manual-list">
        <div class="inner">
            <h2>Manual Orders</h2>
        </div>
            <div class="manual">
                <div class="inner">
                    {{Form::model($manual, [
                       "route"=>"manualorderentry",
                       "method"=>"PUT",
                    ])}}


                    <br/><br/>
                    SKU Qty Default Price<br/>
                    @for ($i = 1; $i <= 10; $i++)
                        <select id="select{{ $i }}" name="unitID[]" data-validate="min:1" data-error-selector=".error-messages .size" onchange="updatePriceField(this.selectedIndex, 'select{{ $i }}')">
                            <option value="" data-price="0">-- Select Item --</option>
                            @foreach($waves as $wave)
                                <option value="{{$wave->sku}}" data-price="{{$wave->price}}" >
                                    {{$wave->name}}
                                </option>
                            @endforeach
                        </select>

                        {{ Form::text('quantities[]', '0', array('class' => 'qtyField', 'style' => 'text-align: right; width: 60px')) }}
                        {{ Form::text('price[]', '', array('class' => 'priceField', 'style' => 'text-align: right; width: 100px', 'id' => 'price' . $i)) }}
                        <br/>
                    @endfor

                    @include('admin.manualbill')
                    @include('admin.manualship')

                        <div class="buttons">
                        <div class="update-button">
                            <div>
                                {{Form::submit("Submit",["class"=>"button"])}}
                            </div>
                            {{Form::close()}}
                        </div>
                </div>
            </div>
    </div>


@stop

@section('inline-scripts')

    <script src="/js/admin/manual.js"></script>
    <script>

        var formElements = {
            'shipping-first-name':'billing-first-name',
            'shipping-last-name':'billing-last-name',
            'shipping-address':'billing-address',
            'shipping-address2':'billing-address2',
            'shipping-city':'billing-city',
            'shipping-state-select':'billing-state-select',
            'shipping-zip':'billing-zip',
            'shipping-country':'billing-country',
            'shipping-phone':'billing-phone',
            'shipping-state-input':'billing-state-input'
        };

        function updatePriceField(index, id) {
            console.log("Index: " + index + " ID: " + id);

            var e = document.getElementById(id);
            var price = e.options[e.selectedIndex].getAttribute('data-price');
            var newId = 'price' + id.substring(6);
            console.log("Price: " + price + " newId: " + newId);
            var p = document.getElementById(newId);
            p.value = price;
        }

        function retainToggle(t) {
            console.log("RetainToggle called");
            /*
            if(t.options[t.selectedIndex].value != 'RETAIL' ) {
                $('.retailFields').prop('disabled', true);
            } else {
                $('.retailFields').prop('disabled', false);
            }
            */
        }

        function pageLoaded() {

            $("#ship-on-date").datepicker( {
                firstDay: 0,
                maxDate: '+6m +0w +0d',
                minDate: '+0m +0w +0d',
                onSelect: function(dateText, obj) {
                    console.log("DateText: " + dateText);
                    // console.log("Date selected: " + moment(Date.parse(dateText)).format('YYYY-MM-DD'));
                }
            });

            $("#ship-no-later").datepicker( {
                firstDay: 0,
                maxDate: '+6m +0w +0d',
                minDate: '+0m +0w +0d',
                onSelect: function(dateText, obj) {
                    console.log("DateText: " + dateText);
                    // console.log("Date selected: " + moment(Date.parse(dateText)).format('YYYY-MM-DD'));
                }
            });

            $("#delivery-date").datepicker( {
                firstDay: 0,
                maxDate: '+6m +0w +0d',
                minDate: '+0m +0w +0d',
                onSelect: function(dateText, obj) {
                    console.log("DateText: " + dateText);
                    // console.log("Date selected: " + moment(Date.parse(dateText)).format('YYYY-MM-DD'));
                }
            });

            // $('.retailFields').prop('disabled', true);
        }

        function fillShipping(f) {

            console.log("FillShipping called");
            if( document.getElementById('use-billing-address-checkbox').checked === true) {
                console.log("Box is checked");
                for (var key in formElements) {
                    console.log(key + " :: " + formElements[key]);
                    document.getElementById(key).value = document.getElementById(formElements[key]).value;
                }
            } else if(document.getElementById('use-billing-address-checkbox').checked === false) {
                console.log("Box is NOT checked");
                for (var key in formElements) {
                    console.log(formElements[key]);
                    document.getElementById(key).value = "";
                }
            }

                /*
                if(f.use-billing-address-checkbox.checked == true) {

                    f.shipping-first-name.value = f.billing-first-name.value;
                    f.shipping-last-name.value = f.billing-last-name.value;
                    f.shipping-address.value = f.billing-address.value;
                    f.shipping-address2.value = f.billing-address2.value;
                    f.shipping-city.value = f.billing-city.value;
                    f.shipping-state.value = f.billing-state.value;
                    f.shipping-zip.value = f.billing-zip.value;
                    f.shipping-country.value = f.billing-country.value;
                    f.shipping-phone.value = f.billing-phone.value;
                    f.shipping-state-alt.value = f.billing-state-alt.value;

                    // f.billingname.value = f.shippingname.value;
                    // f.billingcity.value = f.shippingcity.value;
                }
                if(f.use-billing-address-checkbox.checked == false) {
                    // f.billingname.value = '';
                    // f.billingcity.value = '';
                    f.shipping-first-name.value = "";
                    f.shipping-last-name.value = "";
                    f.shipping-address.value = "";

                }
                */
        }

        pageLoaded();

    </script>
@stop


