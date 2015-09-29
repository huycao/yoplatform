{{ HTML::style("{$assetURL}css/checkbox.css") }}
<div class="modal fade bs-website-modal" id="websiteModal" tabindex="-1" role="dialog" aria-labelledby="websiteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">{{trans('text.close')}}</span></button>
                <h4 class="modal-title" id="websiteModalLabel">
                    @if( !empty($data) )
                        {{trans('text.edit_website')}}
                    @else
                        {{trans('text.add_website')}}
                    @endif
                </h4>
            </div>
            <div class="modal-body">
                <form id="formUpdateWebsite" class="form-horizontal form-cms" role="form">

				    <div class="row">
				        <div class="col-md-12">

		                    <div id="formUpdateWebsiteMessage" class="col-xs-10 col-xs-offset-2"></div>
							
			                <input type="hidden" name="flightId" value="{{{ $flightId }}}">
			                <input type="hidden" name="id" value="{{{ $id }}}">

		                    <div class="form-group">
		                        <label class="col-xs-2 control-label">{{trans('text.name')}}</label>
		                        <div class="col-xs-10">
			                    <input type="hidden" name="websiteId" value="{{{ $websiteId }}}">
			                    <input type="text" class="form-control input-sm" value="{{{ $websiteName }}}" readonly>
		                        </div>
		                    </div>			

		                    <div class="form-group">
		                        <label class="col-xs-2 control-label">{{trans('text.total_inventory')}}</label>
		                        <div class="col-xs-10">
			                    <input type="text" class="form-control input-sm" name="total_inventory" value="{{{ $data->total_inventory or 0 }}}">
		                        </div>
		                    </div>			
		                    
		                    <div class="form-group">
		                        <label class="col-xs-2 control-label">{{trans('text.value_added')}}</label>
		                        <div class="col-xs-8">
		                        <?php 
		                            $disabled = '';
		                            if (isset($data->value_added)) {
		                                $value_added = $data->value_added;
		                                if ($value_added < 0) {
		                                    $value_added = 0;
		                                    $disabled = 'disabled';
		                                }
		                            }
		                        ?>
			                    <input type="text" id="value-added" class="form-control input-sm {{$disabled}}" {{$disabled}} name="value_added" value="{{{ $value_added or 0 }}}">
		                        </div>
		                        <div class="col-xs-2 checkbox checkbox-info checkbox-inline">
    			                    {{ Form::checkbox('not_apply', '1', '' != $disabled, array('id'=>"not-apply"))}}
                        			<label class="mgr20" for="not-apply"> Not Apply </label>
		                        </div>
		                    </div>			

		                    <div class="form-group">
		                        <label class="col-xs-2 control-label">{{trans('text.cost')}}</label>
		                        <div class="col-xs-10">
			                    <input type="text" class="form-control input-sm" name="publisher_base_cost" value="{{{ $data->publisher_base_cost or 0 }}}">
		                        </div>
		                    </div>			

				            <div class="form-group form-group-sm">
				                <label class="col-xs-2 control-label">{{trans('text.status')}}</label>
				                <div class="col-xs-10">
				                    <select class="form-control" id="status" name="status">
				                        <option value="1" <?php if( isset($data->status) &&  $data->status == 1 ){ echo "selected='selected'"; }?> >{{trans('text.active')}}</option>
				                        <option value="0" <?php if( isset($data->status) &&  $data->status == 0 ){ echo "selected='selected'"; }?>>{{trans('text.unactive')}}</option>
				                    </select>
				                </div>
				            </div>

						</div>
					</div>

                </form>                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">{{trans('text.close')}}</button>
                <button type="button" class="btn btn-primary btn-sm" onclick="Flight.update()" id="btnUpdateWebsite">
                    @if( !empty($data) )
                        {{trans('text.edit')}}
                    @else
                        {{trans('text.add')}}
                    @endif
                </button>
            </div>

        </div>
    </div>
</div>
<script type="text/javascript">
    $('#not-apply').click(function() {
        if(this.checked) { // check select status
        	$('#value-added').attr('disabled', true);
        	$('#value-added').addClass('disabled');
        	$('#value-added').val(0);
        }else{
        	$('#value-added').attr('disabled', false);     
        	$('#value-added').removeClass('disabled');    
        }
    });
</script>