<script id="album-template" type="x-tmpl-mustache">
    <div class="row">
    <div class="col-xs-10 col-xs-offset-1"> 
    <select multiple="multiple" class="image-picker" id="album-images">
    @{{#images}}
        <option data-img-src="@{{ link }}" value="@{{ id }}" class="album-image">option</option>
    @{{/images}}
    <select>
    </div>
    </div>
</script>