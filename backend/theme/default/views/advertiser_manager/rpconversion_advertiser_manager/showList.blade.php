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
                                <input type="hidden" id="campaign_id" value="{{preg_match('/^[0-9]+$/', $campaignID) ? $campaignID : ''}}" name="campaign_id">
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

<div class="row">
    <div class="col-xs-12">
			<div class="wrap-table">
				
			</div>
    </div>
</div>
<script type="text/javascript">
	$().ready(function(){
		pagination.property.searchData =  $('.filter-form').serializeArray();
		pagination.init({
			url : "{{{ $defaultURL }}}get-list",
			defaultField : "{{{ $defaultField }}}",
			defaultOrder : "{{{ $defaultOrder }}}"
		});
	});
</script>
