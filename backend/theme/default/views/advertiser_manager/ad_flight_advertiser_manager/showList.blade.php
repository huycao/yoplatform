<div class="row">
    <div class="col-xs-12">
		<button type="button" class="btn btn-primary btn-filter btn-sm pull-left" data-toggle="collapse" data-target="#filter">Filter</button>
    </div>
</div>
<hr>
<div id="filter" class="collapse">
	<form class="filter-form form-horizontal" id="filter" role="form">
		<div class="filter-wrapper">
			<div class="row">
				<div class="col-xs-12">
					<table class="table table-responsive table-condensed table-bordered">
						<tr>
							<td class="bg-default" width="15%">{{trans('text.id')}}</td>
							<td width="35%"><input type="text" class="form-control input-sm" id="id" name="id"></td>
							<td class="bg-default" width="15%">{{trans('text.publisher')}}</td>
							<td width="35%">
			                    <input type="hidden" id="publisher_id" value="" name="publisher_id">
			                    <input type="text" class="input-sm w49p" id="publisher" value="">
                    			<a href="javascript:;" onclick="Select.openModal('publisher')" class="btn btn-primary w49p btn-sm">{{trans('text.select_publisher')}}</a>
							</td>
						</tr>
						<tr>
							<td class="bg-default" width="15%">{{trans('text.campaign')}}</td>
							<td width="35%">
			                    <input type="hidden" id="campaign_id" value="" name="campaign_id">
			                    <input type="text" class="input-sm w49p" id="campaign" value="">
                    			<a href="javascript:;" onclick="Select.openModal('campaign')" class="btn btn-primary w49p btn-sm">{{trans('text.select_campaign')}}</a>
							</td>
							<td class="bg-default" width="15%">{{trans('text.section')}}</td>
							<td width="35%">
			                    <input type="hidden" id="publisher_site_id" value="" name="publisher_site_id">
			                    <input type="text" class="input-sm w49p" id="publisher_site" value="">
                    			<a href="javascript:;" onclick="Select.openModal('publisher_site')" class="btn btn-primary w49p btn-sm">{{trans('text.select_section')}}</a>
							</td>
						</tr>
						<tr>
							<td class="bg-default" width="15%">{{trans('text.ad_name')}}</td>
							<td width="35%"><input type="text" class="form-control input-sm" id="ad_name" name="ad_name"></td>
							<td class="bg-default" width="15%">{{trans('text.ad_type')}}</td>
							<td width="35%">
				                {{ 
				                    Form::select(
				                        'ad_type', 
				                        $listAdType,
				                        "", 
				                        array('class'=>'form-control input-sm','id'=>'ad_type')
				                    ) 
				                }}
							</td>

						</tr>
					</table>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-6">
		    		<button type="submit" class="btn btn-sm btn-primary filter-button">Submit</button>
				</div>
		    </div>
		</div>
	</form>
<hr>
</div>
<div id="loadSelectModal">
    @include("partials.select")
</div>

@include('partials.show_list')