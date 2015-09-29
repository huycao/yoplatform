<table class="table table-responsive table-striped table-hover table-condensed table-bordered tableList">
    <thead>
		<tr class="bg-primary">
			<th>Name</th>
		</tr>
    </thead>
	
	<tbody>
		
		@if( !$listAd->isEmpty() )
			@foreach( $listAd as $ad )
			<tr>
				<td><a href="javascript:;" onclick="Select.chooseData('{{$ad->id}}','{{{addslashes($ad->name)}}}')">{{$ad->name}}</a></td>
			</tr>
			@endforeach
		@else
			<tr><td colspan="2">No data</td>
		@endif
	</tbody>
</table>