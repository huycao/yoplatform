<table class="table table-responsive table-striped table-hover table-condensed table-bordered tableList">
    <thead>
		<tr class="bg-primary">
			<th>Name</th>
			<th>Url</th>
			<th>Action</th>
		</tr>
    </thead>
	
	<tbody>
		
		@if( $item->publisherSite  )
			@foreach( $item->publisherSite as $website )
			<tr>
				<td>{{$website->name}}</td>
				<td>{{$website->url}}</td>
				<td>
					<a href="{{ URL::Route($moduleRoutePrefix.'ShowUpdateSite', [$item['id'], $website->id ] ) }}" class="btn btn-default btn-sm">
						<span class="fa fa-pencil"></span> Edit
					</a>					
				</td>
			</tr>
			@endforeach
		@else
			<tr><td colspan="4">No data</td>
		@endif
	</tbody>
</table>