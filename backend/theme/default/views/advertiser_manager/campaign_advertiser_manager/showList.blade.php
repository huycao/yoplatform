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
									<span class="lbl">{{trans('text.date')}}</span>
									<div>
										<input type="text" class="form-control input-sm" id="created_at" name="created_at">
									</div>
								</td>
							</tr>

							<tr>
								<td width="50%">
									<span class="lbl">{{trans('text.campaign')}}</span>
									<div>
										<input type="text" class="form-control input-sm" id="name" name="name">
									</div>
								</td>
								<td width="50%">
									<span class="lbl">{{trans('text.category')}}</span>
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
							</tr>
							<tr>
								<td colspan="2">
									<span class="lbl">{{trans('text.campaign_status')}}</span>
									<div>
										<div class="pull-left">
											<select name="sale_status['wilcard']" class="input-sm">
												<option value="=">=</option>
												<option value="!=">!=</option>
											</select>
										</div>
										<div class="pull-left">
											&nbsp;
							                {{ 
							                    Form::select(
							                        "sale_status['status']", 
							                        $listSaleStatus,
							                        "", 
							                        array('class'=>'input-sm','id'=>'sale_status')
							                    ) 
							                }}
										</div>
										<div class="clearfix"></div>									
									</div>
								</td>
							</tr>
							<tr>
								<td width="50%">
									<span class="lbl">{{trans('text.advertiser')}}</span>
									<div>
					                    <input type="hidden" id="advertiser_id" value="" name="advertiser_id">
					                    <input type="text" class="form-control input-sm w90p display-in-bl" id="advertiser" value="" onclick="Select.openModal('advertiser')" placeholder="Click here to select advertiser">
		                    			<!-- <a href="javascript:;" onclick="Select.openModal('advertiser')" class="btn btn-default w49p btn-sm">{{trans('text.select_advertiser')}}</a> -->
		                    			<a href="javascript:;" onclick="resetAdvertiser()" class="btn btn-default w49p btn-sm"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>
									</div>
								</td>
								<td width="50%">
									<span class="lbl">{{trans('text.campaign_manager')}}</span>
									<div>
					                    <input type="hidden" class="form-control" id="campaign_manager_id" name="campaign_manager_id">
					                    <input type="text" class="form-control input-sm w90p display-in-bl" id="campaign_manager" onclick="Select.openModal('campaign_manager')" placeholder="Click here to select campaign manager">
		                    			<!-- <a href="javascript:;" onclick="Select.openModal('campaign_manager')" class="btn btn-default w49p btn-sm">{{trans('text.select_campaign_manager')}}</a> -->
		                    			<a href="javascript:;" onclick="resetCampaignManager()" class="btn btn-default w49p btn-sm"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>
									</div>
								</td>															
							</tr>
							<tr>
								<td width="50%">
									<span class="lbl">{{trans('text.sale_person')}}</span>
									<div>
					                    <input type="hidden" class="form-control" id="sale_id" value="" name="sale_id">
					                    <input type="text" class="form-control input-sm w90p display-in-bl" id="sale" value="" onclick="Select.openModal('sale')" placeholder="Click here to select sale">
		                    			<!-- <a href="javascript:;" onclick="Select.openModal('sale')" class="btn btn-default w49p btn-sm">{{trans('text.select_sale')}}</a> -->
		                    			<a href="javascript:;" onclick="resetSale()" class="btn btn-default w49p btn-sm"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>
									</div>
								</td>
								<td width="50%">
									<span class="lbl">{{trans('text.agency')}}</span>
									<div>
				                    <input type="hidden" class="form-control" id="agency_id" value="" name="agency_id">
				                    <input type="text" class="form-control input-sm w90p display-in-bl" id="agency" value="" onclick="Select.openModal('agency')" placeholder="Click here to select agency">
	                    			<!-- <a href="javascript:;" onclick="Select.openModal('agency')" class="btn btn-default w49p btn-sm">{{trans('text.select_agency')}}</a> -->
	                    			<a href="javascript:;" onclick="resetAgency()" class="btn btn-default w49p btn-sm"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>
									</div>
								</td>
							</tr>
							<tr>
								<td width="50%">

                                    <span class="lbl">{{trans('text.start_start_date')}}</span>
                                    <div>
                                        <input type="text" class="form-control input-sm" id="start_start_date" name="start_start_date">
                                    </div>
                                    <span class="lbl">{{trans('text.end_start_date')}}</span>
                                    <div>
                                        <input type="text" class="form-control input-sm" id="end_start_date" name="end_start_date">
                                    </div>
								</td>
								<td width="50%">
									<span class="lbl">{{trans('text.start_end_date')}}</span>
									<div>
										<input type="text" class="form-control input-sm" id="start_end_date" name="start_end_date">
									</div>
                                    <span class="lbl">{{trans('text.end_end_date')}}</span>
                                    <div>
                                        <input type="text" class="form-control input-sm" id="end_end_date" name="end_end_date">
                                    </div>
								</td>
							</tr>
						</table>
					</div>
			
				</div>
				<div class="row">
					<div class="col-xs-6">
			    		<button type="submit" class="btn btn-default btn-sm filter-button">{{trans('text.search')}}</button>
					</div>
			    </div>
			</div>
		</form>
		<script type="text/javascript">
			$().ready(function(){
				$("#created_at").datepicker({
			        format: 'dd-mm-yyyy'
			    });
				$("#start_start_date").datepicker({
			        format: 'dd-mm-yyyy'
			    });
                $("#end_start_date").datepicker({
                    format: 'dd-mm-yyyy'
                });
				$("#end_end_date").datepicker({
                    format: 'dd-mm-yyyy'
                });
                $("#start_end_date").datepicker({
                    format: 'dd-mm-yyyy'
                });
			});
            
            function resetAdvertiser(){
                $("#advertiser_id").val("");
                $("#advertiser").val("");
            }
            
            function resetCampaignManager(){
                $("#campaign_manager_id").val("");
                $("#campaign_manager").val("");
            }

            function resetSale(){
                $("#sale_id").val("");
                $("#sale").val("");
            }

            function resetAgency(){
                $("#agency_id").val("");
                $("#agency").val("");
            }
		</script>
	</div>

</div>

<div id="loadSelectModal">
    @include("partials.select")
</div>

@include('partials.show_list')
@include("partials.preview")