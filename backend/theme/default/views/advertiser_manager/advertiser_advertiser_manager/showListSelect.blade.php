<table class="table table-responsive table-condensed tableList">
    <thead>
		<tr>
			<th>#</th>
			<th>Name</th>
			<th>Type</th>
			<th>Country</th>
		</tr>
    </thead>
	
	<tbody>
		
		@if( !empty($listAdvertiser) )
			<?php $stt = 0; ?>
			@foreach( $listAdvertiser as $advertiser )
			<?php $stt++; ?>
			<tr>
				<td>{{$stt}}</td>
				<td><a href="javasctip:;" onclick="Select.chooseData('{{$advertiser->id}}','{{$advertiser->name}}')">{{$advertiser->name}}</a></td>
				<td>{{$advertiser->type}}</td>
				<td>{{$advertiser->country->country_name}}</td>
			</tr>
			@endforeach
		@else
			<tr><td colspan="4">No data</td>
		@endif
	</tbody>
</table>