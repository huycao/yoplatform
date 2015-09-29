<table class="table table-responsive table-striped table-hover table-condensed table-bordered tableList">
    <thead>
		<tr class="bg-primary">
			<th>Name</th>
			<th>Country</th>
		</tr>
    </thead>
	
	<tbody>
		
		@if( !$listAgency->isEmpty() )
			@foreach( $listAgency as $agency )
			<tr>
				<td><a href="javascript:;" onclick="Select.chooseData('{{$agency->id}}','{{$agency->name}}')">({{$agency->id}}) {{$agency->name}}</a></td>
				<td>{{$agency->country->country_name}}</td>
			</tr>
			@endforeach
		@else
			<tr><td colspan="3">No data</td>
		@endif
	</tbody>
</table>