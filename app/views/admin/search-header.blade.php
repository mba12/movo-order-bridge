<h2>Orders</h2>
<div id="search">
                    {{Form::open([ "route"=>"order-search" ])}}
                    {{Form::text("search", "",[ "placeholder"=>"Search term" ])}}
                    {{Form::select("criteria",[
                        "billing_last_name"=>"Billing Last Name",
                        "billing_first_name"=>"Billing First Name",
                        "billing_address"=>"Billing Address",
                        "shipping_last_name"=>"Shipping Last Name",
                        "shipping_first_name"=>"Shipping First Name",
                        "shipping_address"=>"Shipping Address",
                        "stripe_charge_id"=>"Stripe Charge ID",
                        "email"=>"Email Address",
                        "billing_phone"=>"Phone Number",
                        "error_flag"=>"Error Flag"
                    ])}}
                    {{Form::submit("Search",[
                        "class"=>"button"
                    ])}}
                    {{Form::close()}}
</div>