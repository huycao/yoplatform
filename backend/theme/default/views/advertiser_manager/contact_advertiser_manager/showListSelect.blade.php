<table class="table table-responsive table-condensed tableList">
    <thead>
		<tr>
			<th>#</th>
			<th>Name</th>
			<th>Advertiser</th>
		</tr>
    </thead>
	
	<tbody>
		
		@if( !empty($listContact) )
			<?php $stt = 0; ?>
			@foreach( $listContact as $contact )
			<?php $stt++; ?>
			<tr>
				<td>{{$stt}}</td>
				<td><a href="javasctip:;" onclick="Select.chooseData('{{$contact->id}}','{{$contact->name}}')">{{$contact->name}}</a></td>
				<td>{{$contact->advertiser->first()->name}}</td>
			</tr>
			@endforeach
		@else
			<tr><td colspan="3">No data</td>
		@endif
	</tbody>
</table>