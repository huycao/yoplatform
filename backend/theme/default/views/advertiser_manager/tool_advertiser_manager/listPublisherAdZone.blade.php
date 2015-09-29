<table class="table table-responsive table-striped table-hover table-condensed table-bordered tableList">
    <thead>
		<tr class="bg-primary">
			<th>Name</th>
		</tr>
    </thead>
	
	<tbody>
		
		@if( !$listPublisherAdZone->isEmpty() )
			@foreach( $listPublisherAdZone as $publisherAdZone )
			<tr>
				<td><a href="javascript:;" onclick="Select.chooseData('{{$publisherAdZone->id}}','{{$publisherAdZone->name}}')">({{$publisherAdZone->id}}) {{$publisherAdZone->name}}</a></td>
			</tr>
			@endforeach
		@else
			<tr><td colspan="2">No data</td>
		@endif
	</tbody>
</table>