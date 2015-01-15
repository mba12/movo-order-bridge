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
    <div class="charity-donations">
        <h3 class="section-title">Charity Donation</h3>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aut autem consectetur ducimus eius esse excepturi
            incidunt molestiae molestias nam numquam odio quia, repellendus repudiandae sequi sit ut veniam vitae
            voluptatibus?</p>
        <select name="charity" id="charity" data-validate="min:1" data-error-selector=".error-messages .charity">
            <option value="">-- Select Charity --</option>
            @foreach($charities as $charity)
                <option value="{{$charity->id}}"">
                    {{$charity->name}}
                </option>
            @endforeach
        </select>
    </div>
    <ul class="error-messages">
        <li class="size">Please select a size!</li>
        <li class="charity">Please select a charity!</li>
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
            <option value="">-- Select Size --</option>
            @foreach($waves as $wave)
                <option value="{{$wave->sku}}" data-price="{{$wave->price}}}">
                    {{$wave->name}}
                </option>
            @endforeach
        </select>
    </div>
</script>