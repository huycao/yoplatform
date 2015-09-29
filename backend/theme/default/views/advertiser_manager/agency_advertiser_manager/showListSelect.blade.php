<table class="table table-responsive table-condensed tableList">
    <thead>
		<tr>
			<th>#</th>
			<th>Name</th>
			<th>Country</th>
		</tr>
    </thead>
	
	<tbody>
		
		@if( !empty($listAgency) )
			<?php $stt = 0; ?>
			@foreach( $listAgency as $agency )
			<?php $stt++; ?>
			<tr>
				<td>{{$stt}}</td>
				<td><a href="javasctip:;" onclick="Select.chooseData('{{$agency->id}}','{{$agency->name}}')">{{$agency->name}}</a></td>
				<td>{{$agency->country->country_name}}</td>
			</tr>
			@endforeach
		@else
			<tr><td colspan="3">No data</td>
		@endif
	</tbody>
</table>