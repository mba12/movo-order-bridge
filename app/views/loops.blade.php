<section id="loops">
    <h3 class="section-title">Loops</h3>

    {{--<div class="products"></div>--}}


    <ul class="error-messages">
        {{--<li class="size">Please select a size!</li>--}}
    </ul>
    <div class="prev-next">
        <div class="button next">Next</div>
        <div class="button prev">Previous</div>
    </div>
</section>

{{--
<script type="text/template" id="product-select-tpl">
    <div class="select-group">
        <h5>Unit #unitNum Size</h5>
        <label for="#unitID"></label>
        <select name="#unitID" id="#unitID" data-validate="min:1" data-error-selector=".error-messages .size">
            <option value="">-- Please Select--</option>
            @foreach($sizeInfo as $size)
                <option value="{{$size->sku}}">
                    {{$size->name}}
                </option>
            @endforeach
        </select>
    </div>
</script>--}}
