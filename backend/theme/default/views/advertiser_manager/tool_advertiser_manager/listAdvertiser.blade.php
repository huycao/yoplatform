<table class="table table-responsive table-striped table-hover table-condensed table-bordered tableList">
    <thead>
		<tr class="bg-primary">
			<th>Name</th>
			<th>Type</th>
			<th>Country</th>
		</tr>
    </thead>
	
	<tbody>
		
		@if( !$listAdvertiser->isEmpty() )
			@foreach( $listAdvertiser as $advertiser )
			<tr>
				<td><a href="javascript:;" onclick="Select.chooseData('{{$advertiser->id}}','{{$advertiser->name}}')">({{$advertiser->id}}) {{$advertiser->name}}</a></td>
				<td>{{$advertiser->type}}</td>
				<td>{{$advertiser->country->country_name}}</td>
			</tr>
			@endforeach
		@else
			<tr><td colspan="4">No data</td>
		@endif
	</tbody>
</table>