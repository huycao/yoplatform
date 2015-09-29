<h5>Flight Detail</h5>
<table class="table table-responsive table-condensed">
	<tr>
		<td class="bg-primary">Campaign</td>
		<td>({{ $data->campaign->id }})</td>
		<td>{{ $data->campaign->name }}</td>
	</tr>
	<tr>
		<td class="bg-primary">Publisher</td>
		<td>({{ $data->publisher->id or '-' }})</td>
		<td>{{ $data->publisher->company or '-' }}</td>
	</tr>
	<tr>
		<td class="bg-primary">Section</td>
		<td>({{ $data->publisherSite->id or '-' }})</td>
		<td>{{ $data->publisherSite->name or '-' }}</td>
	</tr>
	<tr>
		<td class="bg-primary">Zone</td>
		<td>({{ $data->publisher_ad_zone->id or '-' }})</td>
		<td>{{ $data->publisher_ad_zone->name or '-' }}</td>
	</tr>
	<tr>
		<td class="bg-primary">Remarks</td>
		<td colspan="2">{{ $data->remark }}</td>
	</tr>
	<tr>
		<td class="bg-primary">Total Inventory</td>
		<td colspan="2">{{ $data->total_inventory }}</td>
	</tr>
	<tr>
		<td class="bg-primary">Days</td>
		<td colspan="2">{{ $data->day }}</td>
	</tr>
	<tr>
		<td class="bg-primary">Date</td>
		<td colspan="2">{{ $data->campaign->dateRange }}</td>
	</tr>
	<tr>
		<td colspan="3" class="danger text-center">Costing</td>
	</tr>
	<tr>
		<td class="bg-primary">Media Cost</td>
		<td colspan="2">{{ number_format($data->media_cost, 2)}}</td>
	</tr>	
	<tr>
		<td class="bg-primary">Discount</td>
		<td colspan="2">{{ number_format($data->discount, 2)}}%</td>
	</tr>	
	<tr>
		<td class="bg-primary">Cost After Discount</td>
		<td colspan="2">{{ number_format($data->cost_after_discount, 2)}}%</td>
	</tr>	
	<tr>
		<td class="bg-primary">Total Cost After Discount</td>
		<td colspan="2">{{ number_format($data->total_cost_after_discount, 2)}}</td>
	</tr>	
	<tr>
		<td class="bg-primary">Agency Commission</td>
		<td colspan="2">{{ number_format($data->agency_commission, 2)}}%</td>
	</tr>	
	<tr>
		<td class="bg-primary">Cost After Agency Commission</td>
		<td colspan="2">{{ number_format($data->cost_after_agency_commission, 2)}}</td>
	</tr>	
	<tr>
		<td class="bg-primary">Commission</td>
		<td colspan="2">{{ number_format($data->advalue_commission, 2)}}%</td>
	</tr>	
	<tr>
		<td class="bg-primary">Publisher Cost</td>
		<td colspan="2">{{ number_format($data->publisher_cost, 2)}}</td>
	</tr>	
</table>