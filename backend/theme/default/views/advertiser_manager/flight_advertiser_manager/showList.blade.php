<div class="box mb12">
	
	<div class="head">
		<a href="javascript:;" class="btn-filter" data-toggle="collapse" data-target="#filter"><i class="fa fa-chevron-circle-down"></i> Filter</a>
	</div>

	<div id="filter" class="collapse content">
		<form class="filter-form form-horizontal" id="filter" role="form">
			<div class="filter-wrapper">
				<div class="row">
					<div class="col-xs-12">
						<table class="table">
							<tr>
								<td width="50%">
									<span class="lbl">{{trans('text.id')}}</span>
									<div>
										<input type="text" class="form-control input-sm" id="id" name="id">
									</div>
								</td>
                                <td width="50%">
                                    <span class="lbl">{{trans('text.name')}}</span>
                                    <div>
                                        <input type="text" class="form-control input-sm" id="name" value="" name="name" placeholder="Name">
                                    </div>
                                </td>
							</tr>
							<tr>
								<td width="50%">
									<span class="lbl">{{trans('text.campaign')}}</span>
									<div>
					                    <input type="hidden" id="campaign_id" value="" name="campaign_id">
					                    <input type="text" class="form-control input-sm w90p display-in-bl" id="campaign"   value="" onclick="Select.openModal('campaign')" placeholder="Click here to select campaign" >
		                    			<!--<a href="javascript:;" onclick="Select.openModal('campaign')" class="btn btn-default w49p btn-sm">{{trans('text.select_campaign')}}</a>-->
		                    			<a href="javascript:;" onclick="resetCampaign()" class="btn btn-default w49p btn-sm"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>
									</div>
								</td>
                                <td width="50%">
                                    <span class="lbl">{{trans('text.website')}}</span>
                                    <div>
                                        <input type="hidden" id="publisher_site_id" value="" name="publisher_site_id">
                                        <input type="text" class="form-control input-sm w90p display-in-bl" id="publisher_site" value="" onclick="Select.openModal('publisher_site')" placeholder="Click here to select website" >
                                        <!-- <a href="javascript:;" onclick="Select.openModal('publisher_site')" class="btn btn-default w49p btn-sm">{{trans('text.select_section')}}</a> -->
                                        <a href="javascript:;" onclick="resetPublisherSite()" class="btn btn-default w49p btn-sm"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>
                                    </div>
                                </td>
							</tr>
							<tr>
								<td width="50%">
									<span class="lbl">{{trans('text.publisher')}}</span>
									<div>
					                    <input type="hidden" id="publisher_id" value="" name="publisher_id">
					                    <input type="text" class="form-control input-sm w90p display-in-bl" id="publisher" value="" onclick="Select.openModal('publisher')" placeholder="Click here to select publisher" >
		                    			<!-- <a href="javascript:;" onclick="Select.openModal('publisher')" class="btn btn-default w49p btn-sm">{{trans('text.select_publisher')}}</a> -->
                                        <a href="javascript:;" onclick="resetPublisher()" class="btn btn-default w49p btn-sm"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>
									</div>
								</td>
								<td width="50%">
									<span class="lbl">{{trans('text.remark')}}</span>
									<div>
										<input type="text" class="form-control input-sm" id="remark" name="remark">
									</div>
								</td>
							</tr>
							<tr>
								<td width="50%">
									<span class="lbl">{{trans('text.channel')}}</span>
									<div>
						                {{ 
						                    Form::select(
						                        'category_id', 
						                        $listCategory,
						                        "", 
						                        array('class'=>'form-control input-sm','id'=>'category_id')
						                    ) 
						                }}
									</div>
								</td>
								<td width="50%">
									<span class="lbl">{{trans('text.model')}}</span>
									<div>
						                {{ 
						                    Form::select(
						                        'cost_type', 
						                        $listModel,
						                        "", 
						                        array('class'=>'form-control input-sm','id'=>'cost_type')
						                    ) 
						                }}
									</div>
								</td>
							</tr>

						</table>
					</div>
			
				</div>
				<div class="row">
					<div class="col-xs-6">
			    		<button type="submit" class="btn btn-sm btn-default filter-button">Search</button>
					</div>
			    </div>
			</div>
		</form>
	</div>

</div>
<script>
    function resetCampaign(){
        $("#campaign_id").val("");
        $("#campaign").val("");
    }
    function resetPublisherSite(){
        $("#publisher_site_id").val("");
        $("#publisher_site").val("");
    }
    function resetPublisher(){
        $("#publisher_id").val("");
        $("#publisher").val("");
    }
</script>
<div id="loadSelectModal">
    @include("partials.select")
</div>

@include('partials.show_list')
@include('partials.preview')
