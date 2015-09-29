<table class="table table-responsive table-striped table-hover table-condensed table-bordered tableList">
    <thead>
		<tr class="bg-primary">
			<th>Name</th>
		</tr>
    </thead>
	
	<tbody>
		
		@if( !$listFlight->isEmpty() )
			@foreach( $listFlight as $Flight )
			<tr>
				<td><a href="javascript:;" onclick="Select.chooseData('{{$Flight->id}}','{{{addslashes($Flight->name)}}}')">({{$Flight->id}}) {{$Flight->name}}</a></td>
			</tr>
			@endforeach
		@else
			<tr><td colspan="2">No data</td>
		@endif
	</tbody>
</table>