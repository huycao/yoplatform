{{ HTML::script("{$assetURL}js/dual-list-box.js") }}
<?php
if (!isset($item)) {
    $item = new stdClass();
    $item->ad_format_id = 0;
    $item->alternateadtype = 1;
    $item->platform = 1;
    $item->adplacement = 0;
}
?>
{{ Form::open(array('role'=>'form','files'=>true,'class'=>"form-horizontal")) }}
<div class="part">
    <!-- form start -->
    <div class="form-group">
        <label for="name" class="col-sm-3">Name: </label>
        <div class="col-sm-9">
            <input type="text" class="form-control" id="name" value="{{{ $item->name or Input::get('name') }}}" name="name" placeholder="Nhập tiêu đề">
            @if( isset($validate) && $validate->has('name')  )
            <span class="text-warning">{{ $validate->first('name') }}</span>
            @endif
        </div>
    </div>

    <div class="form-group">
        <label for="inputPassword3" class="col-sm-3">Ad format: </label>
        <div class="col-sm-9">
            <select name="ad_format_id" class="ad_format_id form-control">
                <option value="" selected="selected"> -- Select Ad Format -- </option>

                <?php
                foreach (AdFormatBaseModel::all() as $ad_format_id) {

                    if ($item->ad_format_id == $ad_format_id->id) {
                        echo '<option value="' . $ad_format_id->id . '" selected="selected">' . $ad_format_id->name . '</option>';
                    } else {
                        echo '<option value="' . $ad_format_id->id . '">' . $ad_format_id->name . '</option>';
                    }
                }
                ?>
            </select>
            @if( isset($validate) && $validate->has('ad_format_id')  )
            <span class="text-warning">{{ $validate->first('ad_format_id') }}</span>
            @endif
        </div>
    </div>

    <div class="form-group" id="type2">
        <label for="inputPassword3" class="col-sm-3">URL: </label>
        <div class="col-sm-9">
            <input type="text" class="form-control" id="url" value="{{{ $item->url or Input::get('url') }}}" name="url" placeholder="Nhập tiêu đề">
            @if( isset($validate) && $validate->has('url')  )
            <span class="text-warning">{{ $validate->first('url') }}</span>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            @include("partials.save")
        </div>
    </div>
</div>
{{ Form::close() }}
