<table class="table table-responsive table-striped table-hover table-condensed table-bordered tableList">
    <thead>
		<tr class="bg-primary">
			<th>Name</th>
		</tr>
    </thead>
	
	<tbody>
		
		@if( !$listCampaign->isEmpty() )
			@foreach( $listCampaign as $campaign )
			<tr>
				<td><a href="javascript:;" onclick="Select.chooseDataCampaignRetargetingUrl('{{$campaign->id}}','{{$campaign->name}}', '{{$campaign->dateRange}}','{{$campaign->retargeting_url}}',1)">({{$campaign->id}}) {{$campaign->name}}</a></td>
			</tr>
			@endforeach
		@else
			<tr><td colspan="2">No data</td>
		@endif
	</tbody>
</table>