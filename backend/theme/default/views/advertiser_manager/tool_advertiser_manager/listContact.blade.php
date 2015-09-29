<table class="table table-responsive table-striped table-hover table-condensed table-bordered tableList">
    <thead>
		<tr class="bg-primary">
			<th>Name</th>
		</tr>
    </thead>
	
	<tbody>
		
		@if( count($listContact) )
			@foreach( $listContact as $contact )
			<tr>
				<td><a href="javascript:;" onclick="Select.chooseData('{{$contact->id}}','{{$contact->name}}')">({{$contact->id}}) {{$contact->name}}</a></td>
			</tr>
			@endforeach
		@else
			<tr><td colspan="3">No data</td>
		@endif
	</tbody>
</table>