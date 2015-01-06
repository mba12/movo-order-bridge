<section id="products">
    <h3 class="section-title">Waves</h3>
    <div class="products"></div>
    <a href="img/product-sizing-guide.jpg" target="_blank" id="product-sizing-btn">
        Product sizing guide
    </a>
    <div id="too-many-units">
        <p>Want to order more than 8 Waves?</p>
        <p>Email <a href="mailto:sales@getmovo.com">sales@getmovo.com</a></p>
    </div>
    <ul class="error-messages">
        <li class="size">Please select a size!</li>
    </ul>
    <div class="prev-next">
        <div class="button next">Next</div>
    </div>
</section>

<script type="text/template" id="product-select-tpl">
    <div class="select-group">
        <h5>Unit #unitNum Size</h5>
        <label for="#unitID"></label>
        <select name="#unitID" id="#unitID" data-validate="min:1" data-error-selector=".error-messages .size">
            <option value="">-- Please Select--</option>
            @foreach($waves as $wave)
                <option value="{{$wave->sku}}" data-price="{{$wave->price}}}">
                    {{$wave->name}}
                </option>
            @endforeach
        </select>
    </div>
</script>