<h5>Flight Detail</h5>
<table class="table table-responsive table-condensed">
	<tr>
		<td class="bg-default" width="25%">Campaign</td>
		<td>({{ $data->campaign->id }})</td>
		<td>{{ $data->campaign->name }}</td>
	</tr>
	<tr>
		<td class="bg-default">Publisher</td>
		<td>({{ $data->publisher->id or '-' }})</td>
		<td>{{ $data->publisher->company or '-' }}</td>
	</tr>
	<tr>
		<td class="bg-default">Section</td>
		<td>({{ $data->publisherSite->id or '-' }})</td>
		<td>{{ $data->publisherSite->name or '-' }}</td>
	</tr>
	<tr>
		<td class="bg-default">Zone</td>
		<td>({{ $data->publisher_ad_zone->id or '-' }})</td>
		<td>{{ $data->publisher_ad_zone->name or '-' }}</td>
	</tr>
	<tr>
		<td class="bg-default">Remarks</td>
		<td colspan="2">{{ $data->remark }}</td>
	</tr>
	<tr>
		<td class="bg-default">Total Inventory</td>
		<td colspan="2">{{ $data->total_inventory }}</td>
	</tr>
	<tr>
		<td class="bg-default">Days</td>
		<td colspan="2">{{ $data->day }}</td>
	</tr>
	<tr>
		<td class="bg-default">Date</td>
		<td colspan="2">{{ $data->campaign->dateRange }}</td>
	</tr>
	<tr>
		<td colspan="3" class="bg-default text-center">Costing</td>
	</tr>
	<tr>
		<td class="bg-default">Media Cost</td>
		<td colspan="2">{{ number_format($data->media_cost, 2)}}</td>
	</tr>	
	<tr>
		<td class="bg-default">Discount</td>
		<td colspan="2">{{ number_format($data->discount, 2)}}%</td>
	</tr>	
	<tr>
		<td class="bg-default">Cost After Discount</td>
		<td colspan="2">{{ number_format($data->cost_after_discount, 2)}}%</td>
	</tr>	
	<tr>
		<td class="bg-default">Total Cost After Discount</td>
		<td colspan="2">{{ number_format($data->total_cost_after_discount, 2)}}</td>
	</tr>	
	<tr>
		<td class="bg-default">Agency Commission</td>
		<td colspan="2">{{ number_format($data->agency_commission, 2)}}%</td>
	</tr>	
	<tr>
		<td class="bg-default">Cost After Agency Commission</td>
		<td colspan="2">{{ number_format($data->cost_after_agency_commission, 2)}}</td>
	</tr>	
	<tr>
		<td class="bg-default">Commission</td>
		<td colspan="2">{{ number_format($data->advalue_commission, 2)}}%</td>
	</tr>	
	<tr>
		<td class="bg-default">Publisher Cost</td>
		<td colspan="2">{{ number_format($data->publisher_cost, 2)}}</td>
	</tr>	
</table>

<table class="table table-responsive table-condensed table-bordered table-hover tableList">
	<thead>
		<tr class="bg-primary">
			<th>Action</th>
			<th>ID</th>
			<th>Ad</th>
			<th>Zone</th>
			<th>Ad Type</th>
		</tr>
    </thead>
	


	<tbody>
		@if( $data->ad->count() )
			@foreach( $data->ad as $ad )
			<tr>
				<td>
					<a href="{{ URL::Route('AdFlightAdvertiserManagerShowView',$ad->pivot->id) }}" class="btn btn-default btn-sm">
						<span class="fa fa-eye"></span> View
					</a>
				</td>
				<td>{{$ad->pivot->id}}</td>
				<td>{{$ad->name}}</td>
				<td>{{$data->publisherSite->name or '-'}}</td>
				<td>{{$ad->type}}</td>
			</tr>
			@endforeach
		@endif
	</tbody>
	

</table>