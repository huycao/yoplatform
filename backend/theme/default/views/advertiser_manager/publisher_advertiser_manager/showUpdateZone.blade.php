<div class="part">
{{ HTML::script("{$assetURL}js/dual-list-box.js") }}
{{ Form::open(array('role'=>'form','files'=>true,'class'=>"form-horizontal")) }}
@include("partials.show_messages") 
<div class="row">
<div class="col-md-12">
    <div class="form-group form-group-sm">
        <label for="inputPassword3" class="col-sm-3">Ad format: </label>
        <div class="col-sm-9">
            <select name="ad_format_id" class="adformat form-control">
                <option value="" selected="selected"> -- Select Ad Format -- </option>
                <?php
                $adFormatId = isset( $item->ad_format_id ) ? $item->ad_format_id : Input::get('ad_format_id');
                foreach ($listadformat as $adformat) {
                    if ($adFormatId == $adformat->id) {
                        echo '<option value="' . $adformat->id . '" selected="selected">' . $adformat->name . '</option>';
                    } else {
                        echo '<option value="' . $adformat->id . '">' . $adformat->name . '</option>';
                    }
                }
                ?>
            </select>
        </div>
    </div>    
    <div class="form-group form-group-sm">
        <label for="name" class="col-sm-3">Name: </label>
        <div class="col-sm-9">
            <input type="text" class="form-control" id="name" value="{{{ $item->name or Input::get('name') }}}" name="name" placeholder="Nhập tiêu đề">
        </div>
    </div>

    <div class="form-group form-group-sm">
        <label for="name" class="col-sm-3">Element Id: </label>
        <div class="col-sm-9">
            <input type="text" class="form-control" id="element_id" value="{{{ $item->element_id or Input::get('element_id') }}}" name="element_id">
        </div>
    </div>

    <div class="form-group form-group-sm">
        <label for="name" class="col-sm-3">Width: </label>
        <div class="col-sm-9">
            <input type="text" class="form-control" id="width" value="{{{ $item->width or Input::get('width') }}}" name="width">
        </div>
    </div>

    <div class="form-group form-group-sm">
        <label for="name" class="col-sm-3">Height: </label>
        <div class="col-sm-9">
            <input type="text" class="form-control" id="height" value="{{{ $item->height or Input::get('height') }}}" name="height">
        </div>
    </div>

    @if(isset($item))

    <div class="form-group form-group-sm"> 
        <div class="col-sm-3">
            <label>Ad Rotator: </label>
            <a href="javascript:;" onclick="modalApp.loadModal(0)" class="btn btn-default btn-sm">{{trans('text.add')}}</a>
        </div>

        <div class="col-sm-9" id="loadList">
            {{ $listAlternateAd }}
        </div>
        <div class="clearfix"></div>
        <div class="col-sm-3">
        </div>
    </div>

    @endif
    
    

</div>
</div>
<div class="row">
    <div class="col-md-12">
        @include("partials.save")
    </div>
</div>
{{ Form::close() }}

</div>

<div class="modal fade bs-contact-modal" id="AlternateAdModal" tabindex="-1" role="dialog" aria-labelledby="contactModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div id="loadModal"></div>
        </div>
    </div>
</div>

<script>

    var modalApp = new function(){

        var loadList    = $('#loadList');
        var loadModal   = $('#loadModal');
        var modalEl     = $('#AlternateAdModal');
        var module      = "publisher";

        this.update = function(id){

            var formData = $('#formModal').serializeArray();

            console.log(formData);

            formData.push({
                name : "id",
                value : id
            });

            formData.push({
                name : "zoneId",
                value : {{$id}}
            });

            var url = root+module+"/updateAlternateAd";

            // console.log(formData);

            $.post(
                url,
                formData,
                function(data){
                    if( data.status == true ){
                        // $('#formModal')[0].reset();
                        loadList.html(data.view);
                        modalEl.modal('hide');
                    }
                },
                'JSON'
            )
        }


        this.delete = function(id){
            if (confirm("You want to delete?")) {
                var url = root+module+"/deleteAlternateAd";
                $.post(
                    url,
                    {
                        id : id,
                        zoneId : {{$id}}
                    },
                    function(data){
                        if( data.status == true ){
                            loadList.html(data.view);
                        }else if( data.message == "access-denied" ){
                            alert("Access Denied");
                        }
                    }
                );
            }
        }    

        this.loadModal = function(id){
            var url = root+module+"/loadModalAlternateAd";
            $.post(
                url,
                {id : id},
                function(data){
                    console.log(1);
                    if( data.status == true ){
                        loadModal.html(data.view);
                        modalEl.modal('show');
                    }
                },
                'JSON'
            );

        } 
           
    }


</script>
