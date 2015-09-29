<div class="row mb12">
	<div class="col-md-12">
		<div class="box">
			<div class="head">Flight Detail</div>
			<table class="table table-striped table-hover table-condensed ">
				<tr>
					<td width="25%">Campaign</td>
					<td>({{ $data->campaign->id }}) {{ $data->campaign->name }}</td>
				</tr>
				<tr>
					<td>Publisher</td>
					<td>({{ $data->publisher->id or '-' }}) {{ $data->publisher->company or '-' }}</td>
				</tr>
				<tr>
					<td>Website</td>
					<td>({{ $data->publisherSite->id or '-' }}) {{ $data->publisherSite->name or '-' }}</td>
				</tr>
				<tr>
					<td>Zone</td>
					<td>({{ $data->publisher_ad_zone->id or '-' }}) {{ $data->publisher_ad_zone->name or '-' }}</td>
				</tr>
				<tr>
					<td>Remarks</td>
					<td>{{ $data->remark }}</td>
				</tr>
				<tr>
					<td>Total Inventory</td>
					<td>{{ $data->total_inventory }}</td>
				</tr>
				<tr>
					<td>Days</td>
					<td>{{ $data->day }}</td>
				</tr>
				<tr>
					<td>Date</td>
					<td>{{ $data->campaign->dateRange }}</td>
				</tr>
				<tr>
					<td colspan="2" class="text-center">Costing</td>
				</tr>
				<tr>
					<td>Media Cost</td>
					<td>{{ number_format($data->media_cost, 2)}}</td>
				</tr>	
				<tr>
					<td>Discount</td>
					<td>{{ number_format($data->discount, 2)}}%</td>
				</tr>	
				<tr>
					<td>Cost After Discount</td>
					<td>{{ number_format($data->cost_after_discount, 2)}}%</td>
				</tr>	
				<tr>
					<td>Total Cost After Discount</td>
					<td>{{ number_format($data->total_cost_after_discount, 2)}}</td>
				</tr>	
				<tr>
					<td>Agency Commission</td>
					<td>{{ number_format($data->agency_commission, 2)}}%</td>
				</tr>	
				<tr>
					<td>Cost After Agency Commission</td>
					<td>{{ number_format($data->cost_after_agency_commission, 2)}}</td>
				</tr>	
				<tr>
					<td>Commission</td>
					<td>{{ number_format($data->advalue_commission, 2)}}%</td>
				</tr>	
				<tr>
					<td>Publisher Cost</td>
					<td>{{ number_format($data->publisher_cost, 2)}}</td>
				</tr>	
			</table>
		</div>		
	</div>
</div>


<div class="row mb12">
	<div class="col-md-12">
		<div class="box">
			<div class="head">List Ad Of Flight</div>
			<div class="ad-message"></div>
			<table class="table table-striped table-hover table-condensed ">

				<thead>
					<tr>
						<th>Action</th>
						<th>Ad</th>
						<th>Zone</th>
						<th>Ad Type</th>
					</tr>
			    </thead>


				<tbody>
					@if( $data->ad )
						<tr>
							<td>
								<a href="{{ URL::Route('AdAdvertiserManagerShowView',$data->ad->id) }}" class="btn btn-default btn-sm">
									<span class="fa fa-eye"></span> View
								</a>
								<a href="{{ URL::Route('AdAdvertiserManagerShowUpdate',$data->ad->id) }}" class="btn btn-default btn-sm">
									<span class="fa fa-pencil-square-o"></span> Edit
								</a>
								<a href="{{ URL::Route('AdAdvertiserManagerRenewCache',$data->ad->id) }}" class="btn btn-default btn-sm renewCache">
									<span class="fa fa-refresh"></span> Refresh Cache
								</a>
							</td>
							<td>({{$data->ad->id}}) {{$data->ad->name}}</td>
							<td>{{$data->publisherSite->name or '-'}}</td>
							<td>{{$data->ad->type}}</td>
						</tr>
					@endif
				</tbody>
	
			</table>
		</div>		
	</div>
</div>
<script type="text/javascript">
	$(function () {
	  //renew cache
	  $('.renewCache').click(function(e){
	  	 e.preventDefault();
	  	 $.post(
	  	 	$(this).prop('href'),
	  	 	{},
	  	 	function(rs){
	  	 		if(rs == 'success'){
	  	 			renewCacheSuccess();
	  	 		}
	  	 		else{
	  	 			renewCacheFailed();
	  	 		}
	  	 	}
	  	 )
	  })
	});

	function renewCacheSuccess(){
		$('.ad-message').prepend(
			'<div class="alert alert-success alert-dismissible fade in renewCacheSuccess" role="alert">'+
	  			'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="fa fa-times-circle-o"></i></button>'+
	  			'<h4>Renew Cache Success!</h4>'+
			'</div>');
	}

	function renewCacheFailed(){
		$('.ad-message').prepend(
			'<div class="alert alert-danger alert-dismissible fade in renewCacheSuccess" role="alert">'+
	  			'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="fa fa-times-circle-o"></i></button>'+
	  			'<h4>Renew Cache Failed, please try again later!</h4>'+
			'</div>');
	}
</script>
