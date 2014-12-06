<ul id="orders">
                    @foreach($orders as $order)
                        <li>
                            <a href="{{'/admin/orders/'.$order->id}}">
                                <div class="left">
                                    <div class="date">{{ date("m-d-y", strtotime( $order->created_at)) }}</div>
                                </div>
                                <div class="right">
                                    <div class="name">
                                        {{ ucwords(strtolower($order->billing_first_name))}}
                                        {{ ucwords(strtolower($order->billing_last_name)) }}
                                    </div>
                                </div>
                            </a>
                        </li>
                    @endforeach
</ul>