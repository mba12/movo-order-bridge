<section id="products">

    <h3 class="section-title">Products</h3>
    <div class="products"></div>
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
            <option value="extra-small">
                Extra Small (14.5 cm - Small Female Wrist)
            </option>
            <option value="small">
                Small (16 cm - Average Female Wrist)
            </option>
            <option value="medium" data-cart-item-option-price="0">
                Medium (17.5 cm - Avg. Male Wrist / Large Female Wrist)
            </option>
            <option value="large">
                Large (19 cm - Large Male Wrist)
            </option>
            <option value="extra-large">
                Extra Large (21.5 cm - Very Large Male Wrist)
            </option>
        </select>
    </div>
</script>