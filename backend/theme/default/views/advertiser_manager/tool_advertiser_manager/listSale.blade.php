<table class="table table-responsive table-striped table-hover table-condensed table-bordered tableList">
    <thead>
		<tr class="bg-primary">
			<th>Name</th>
		</tr>
    </thead>
	
	<tbody>
		
		@if( !$listSale->isEmpty() )
			@foreach( $listSale as $sale )
			<tr>
				<td><a href="javascript:;" onclick="Select.chooseData('{{$sale->id}}','{{$sale->username}}')">({{$sale->id}}) {{$sale->username}}</a></td>
			</tr>
			@endforeach
		@else
		<tr><td colspan="2">No data</td></tr>
		@endif
	</tbody>
</table>