<table class="table table-responsive table-striped table-hover table-condensed table-bordered tableList">
    <thead>
		<tr class="bg-primary">
			<th>Name</th>
		</tr>
    </thead>
	
	<tbody>
		
		@if( !$listPublisher->isEmpty() )
			@foreach( $listPublisher as $publisher )
			<tr>
				<td><a href="javascript:;" onclick="Select.chooseData('{{$publisher->id}}','{{{addslashes($publisher->company)}}}')">({{$publisher->id}}) {{$publisher->company}}</a></td>
			</tr>
			@endforeach
		@else
			<tr><td colspan="2">No data</td>
		@endif
	</tbody>
</table>