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
        <label for="name" class="col-sm-3">Site: </label>
        <div class="col-sm-9">
            <?php if (!isset($item->publisher_site_id)) { ?>

                <select name="publisher_site_id" class="form-control">
                    <option value="" selected="selected"> -- Select Site -- </option>
                    <?php
                    foreach ($listzone as $zone) {
                        echo '<option value="' . $zone->id . '">' . $zone->name . '</option>';
                    }
                    ?>
                </select>

                <?php
            } else {
                echo $item->site->name;
                echo '<input type="hidden" class="form-control" id="title" value="' . $item->publisher_site_id . '" name="publisher_site_id" placeholder="Nhập tiêu đề">';
            }
            ?>
            @if( isset($validate) && $validate->has('publisher_site_id')  )
            <span class="text-warning">{{ $validate->first('publisher_site_id') }}</span>
            @endif
        </div>
    </div>
    <div class="form-group">
        <label for="inputPassword3" class="col-sm-3">Ad format: </label>
        <div class="col-sm-9">
            <select name="ad_format_id" class="adformat form-control">
                <option value="" selected="selected"> -- Select Ad Format -- </option>

                <?php
                foreach ($listadformat as $adformat) {
                    
                    if ($item->ad_format_id == $adformat->id) {
                        echo '<option value="' . $adformat->id . '" selected="selected">' . $adformat->name . '</option>';
                    } else {
                        echo '<option value="' . $adformat->id . '">' . $adformat->name . '</option>';
                    }
                }
                ?>
            </select>
            @if( isset($validate) && $validate->has('ad_format_id')  )
            <span class="text-warning">{{ $validate->first('ad_format_id') }}</span>
            @endif
        </div>
    </div>    
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
        <label for="inputPassword3" class="col-sm-3">Target Platform: </label>
        <div class="col-sm-9">

            <?php
            ($item->platform == 1) ? $check = true : $check = false;
            echo Form::checkbox('platform', 1, $check, ['class' => 'field', 'data-off-class' => "btn-primary", "data-on-class" => "btn-primary", "data-style" => "btn-group-justified", "data-off-label" => "Mobile", "data-on-label" => "Web"]);
            ?>

        </div>
    </div>
    <div class="form-group">
        <label for="inputPassword3" class="col-sm-3">Target Platform: </label>
        <div class="col-sm-9">

            <?php
            ($item->adplacement == 1) ? $check = true : $check = false;
            echo Form::checkbox('adplacement', 1, $check, ['class' => 'field', 'data-off-class' => "btn-primary", "data-on-class" => "btn-primary", "data-style" => "btn-group-justified", "data-off-label" => "Above the fold", "data-on-label" => "Bellow the fold"]);
            ?>

        </div>
    </div>

    <div class="form-group" id="type2">
        <label for="inputPassword3" class="col-sm-3">Alternate Ad: </label>
        <div class="col-sm-9 data-alternate">            
            <select class="form-control" name="alternatead" data-name="alternatead[]" id="alternatead" multiple="true">
                <?php
                if (count($listaltenatead) > 0) {
                    $listalt = json_decode($item->alternatead); 
                    if( !empty($listalt) ){
                        foreach ($listaltenatead as $alt) {
                            if (array_search($alt->id, $listalt) !== false) {
                                echo '<option value="' . $alt->id . '" selected="selected">' . $alt->name . '</option>';
                            } else {
                                echo '<option value="' . $alt->id . '">' . $alt->name . '</option>';
                            }
                        }
                    }
                }
                ?>
            </select>
            <div class="col-md-12">
                @if( isset($validate) && $validate->has('selected_alternatead')  )
                <span class="text-warning">{{ $validate->first('selected_alternatead') }}</span>
                @endif
            </div>
        </div>
    </div>

    <div class="form-group">
        <label for="name" class="col-sm-3">Element Id: </label>
        <div class="col-sm-9">
            <input type="text" class="form-control" id="element_id" value="{{{ $item->element_id or Input::get('element_id') }}}" name="element_id">
        </div>
    </div>

    <div class="form-group">
        <label for="name" class="col-sm-3">Width: </label>
        <div class="col-sm-9">
            <input type="text" class="form-control" id="width" value="{{{ $item->width or Input::get('width') }}}" name="width">
        </div>
    </div>

    <div class="form-group">
        <label for="name" class="col-sm-3">Height: </label>
        <div class="col-sm-9">
            <input type="text" class="form-control" id="height" value="{{{ $item->height or Input::get('height') }}}" name="height">
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            @include("partials.save")
        </div>
    </div>
</div>
{{ Form::close() }}

<script>
    $(function () {
        $(':checkbox').checkboxpicker();
        $('#alternatead').DualListBox();
        $('.adformat').change(function () {
             jsonObj = [];
             $("#selected_alternatead option").each(function ()
            {
                jsonObj.push($(this).val());
            });
           $data = JSON.stringify(jsonObj);
            $.ajax({
                type: "POST",
                url: '{{ URL::Route($moduleRoutePrefix."AltnateAd") }}',
                data: {id: $(this).val(), data: $data}
            })
                    .done(function (data) {
                        $('.unselected').html(data);
                    });
        }); 
    });

</script>