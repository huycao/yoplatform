@include("partials.show_messages")
{{ Form::open(array('role'=>'form','class'=>'form-horizontal form-cms')) }}
    <div class="row">
        <div class="col-md-12">
            <!-- NAME -->
            <div class="form-group form-group-sm">
                <label class="col-md-2">{{trans('text.name')}}</label>
                <div class="col-md-4">
                    <input type="text" class="form-control" id="name" value="{{{ $item->name or Input::get('name') }}}" name="name">
                </div>
            </div>                        
            <!-- WIDTH -->
            <div class="form-group form-group-sm">
                <label class="col-md-2">{{trans('text.width')}}</label>
                <div class="col-md-4">
                    <input type="text" class="form-control" id="width" value="{{{ $item->width or Input::get('width') }}}" name="width">
                </div>
            </div>                        
            <!-- HEIGHT -->
            <div class="form-group form-group-sm">
                <label class="col-md-2">{{trans('text.height')}}</label>
                <div class="col-md-4">
                    <input type="text" class="form-control" id="height" value="{{{ $item->height or Input::get('height') }}}" name="height">
                </div>
            </div>
            <!-- TYPE -->
            <div class="form-group form-group-sm">
                <label class="col-md-2">{{trans('text.type')}}</label>
                <div class="col-md-4">
					<?php
                    $type = (isset($item->type)) ? $item->type : Input::get('type');
                    ?>
                    {{
                        Form::select(
                            'type',
                            $listAdFormatType,
                            $type,
                            array('class'=>'form-control input-sm','id'=>'type')
                        )
                    }}                   

                </div>
            </div>  
            <!-- AD VIEW -->
            <div class="form-group form-group-sm">
                <label class="col-md-2">{{trans('text.ad_view')}}</label>
                <div class="col-md-4">
                    <input type="text" class="form-control" id="ad_view" value="{{{ $item->ad_view or Input::get('ad_view') }}}" name="ad_view">
                </div>
            </div>                       
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            @include("partials.save")
        </div>
    </div>
{{ Form::close() }}

<div id="loadSelectModal">
    @include("partials.select")
</div>



