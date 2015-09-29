{{ HTML::style("{$assetURL}css/checkbox.css") }}
<div class="part">
@include("partials.show_messages")

{{ Form::open(array('role'=>'form','class'=>'form-horizontal form-cms')) }}
    <div class="row">
        <div class="col-md-12">
        	<!-- CAMPAIGN -->
            <div class="form-group">
                <label class="col-md-2">{{trans('text.campaign')}}</label>
                <div class="col-md-4">
                    <input type="hidden" id="campaign_id" value="{{{ $campaign->id or Input::get('campaign_id') }}}" name="campaign_id">
                    @if(!empty($campaign))
                    	({{$campaign->id}}) {{$campaign->name}}
                	@endif
                </div>
            </div>
        	<!-- STATUS -->
            <div class="form-group form-group-sm">
                <label class="col-md-2">{{trans('text.status')}}</label>
                <div class="col-md-5">
                    <select class="form-control" id="status" name="status">
                        <option value="1" <?php if( isset($data->status) &&  $data->status == 1 ){ echo "selected='selected'"; }?> >{{trans('text.active')}}</option>
                        <option value="0" <?php if( isset($data->status) &&  $data->status == 0 ){ echo "selected='selected'"; }?>>{{trans('text.unactive')}}</option>
                    </select>
                </div>
            </div>                   
            <!-- NAME -->
            <div class="form-group form-group-sm">
                <label class="col-md-2">{{trans('text.name')}}</label>
                <div class="col-md-5">
                    <input type="text" class="form-control" id="name" value="{{{ $data->name or Input::get('name') }}}" name="name">
                </div>
            </div>
            <!-- PARAM -->
            <div class="form-group form-group-sm">
                <label class="col-md-2">{{trans('text.param')}}</label>
                <?php 
                    $arrParam = !empty($data->param) ? json_decode($data->param) : Input::get('param');
                ?>
                <div id="param-list" class="col-md-9">
                	@if (empty($arrParam))
                    	<div class="param">
                            <div class="form-group form-group-sm col-md-7">
                                <input type="text" class="form-control" value="" name="param[]">
                            </div>
                            <div class="col-md-3 text-select">
                                <a href="javascript:;" class="add-param"><i class="glyphicon glyphicon-plus add-icon"></i></a>
                            </div>
                        </div>
                    @else
                    	<?php $index = 0;?>
                    	@foreach ($arrParam as $param)
                    		<div class="param">
                            	<div class="form-group form-group-sm col-md-7">
                                    <input type="text" class="form-control" value="{{$param}}" name="param[]">
                                </div>
                                @if (0 == $index)
                                	<div class="col-md-3 text-select">
                                        <a href="javascript:;" class="add-param"><i class="glyphicon glyphicon-plus add-icon"></i></a>
                                    </div>
                                @else
                                    <div class="col-md-3 text-select">
                                        <a href="javascript:;" class="remove-param"><i class="glyphicon glyphicon-remove remove-icon"></i></a>
                                    </div>
                                @endif
                            </div>
                            <?php $index++;?>
                        @endforeach
                    @endif
                </div>
            </div>            
            <!-- NAME -->
            <div class="form-group">
                <label class="col-md-2">{{trans('text.source')}}</label>
                <div class="col-md-5">
                	<input type="text" class="form-control" value="{{{$data->source or Input::get('source', '')}}}" name="source">
                </div>
            </div>
            <div class="tool-cms">
            	<button type="submit" name="save" value="save" class="btn btn-default btn-sm">{{trans("text.save")}}</button>
            	<a href="{{ URL::Route($moduleRoutePrefix.'ShowList', $campaign->id) }}"  class="btn btn-default btn-sm">{{trans("text.cancel")}}</a>
            </div>

        </div>
    </div>
{{ Form::close() }}

<script type="text/javascript">
	$(document).on('click', ".add-param",function(){		
        var html = '<div class="param">';
        html += '<div class="form-group form-group-sm col-md-7">';
        html += '<input type="text" class="form-control" value="" name="param[]">';
        html += '</div>';
        html += '<div class="col-md-3 text-select">';
        html += '<a href="javascript:;" class="remove-param"><i class="glyphicon glyphicon-remove remove-icon"></i></a>';
        html += '</div>';
        html += '</div>';
      	$('#param-list').append(html);
   	});

	$(document).on('click', ".remove-param",function(){
      	$(this).parent().parent().remove();
   	});    
</script>
</div>


