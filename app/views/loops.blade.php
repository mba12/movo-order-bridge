<section id="loops">
    <h3 class="section-title">Loops</h3>

    @for($i=0; $i<sizeof($loops); $i++)
        <div class="item">
            <div class="left">
                <a href="/img/loop{{$i+1}}-large.jpg" target="_blank">
                    <img src="/img/loop{{$i+1}}-thumb.jpg"/>
                </a>
            </div>
            <div class="right">
                <h3 class="product-title">{{$loops[$i]->name}} - ${{$loops[$i]->price}}</h3>
                <div class="qty">
                    <input id="loop{{$i+1}}" class="loop-input" type="number" value="0" pattern="\d*"
                           data-validate="minValue:0|number"
                           data-error-selector=".error-messages .quantity"
                           data-sku="{{$loops[$i]->sku}}"
                           data-name="{{$loops[$i]->name}}"
                           data-price="{{$loops[$i]->price}}"/>
                </div>
            </div>
        </div>
    @endfor

    <ul class="error-messages">
        <li class="quantity">Please enter a valid quantity!</li>
    </ul>
    <div class="prev-next">
        <div class="button next">Next</div>
        <div class="button prev">Previous</div>
    </div>
</section>