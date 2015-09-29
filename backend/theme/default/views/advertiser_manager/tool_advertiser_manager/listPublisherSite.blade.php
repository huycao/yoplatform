<table class="table table-responsive table-striped table-hover table-condensed table-bordered tableList">
    <thead>
		<tr class="bg-primary">
			<th>Name</th>
		</tr>
    </thead>
	
	<tbody>
		
		@if( !$listPublisherSite->isEmpty() )
			@foreach( $listPublisherSite as $publisherSite )
			<tr>
				<td><a href="javascript:;" onclick="Select.chooseData('{{$publisherSite->id}}','{{$publisherSite->name}}')">({{$publisherSite->id}}) {{$publisherSite->name}}</a></td>
			</tr>
			@endforeach
		@else
			<tr><td colspan="2">No data</td>
		@endif
	</tbody>
</table>