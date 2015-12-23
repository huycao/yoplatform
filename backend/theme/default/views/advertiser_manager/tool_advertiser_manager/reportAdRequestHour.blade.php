
<table class="table table-condensed table-bordered">
	<tr>
	    <td width="25%">Website</td>
	    <td>
	        <div class="row">
	            <div class="col-md-12">{{ $website_name }}</div>
	        </div>
	    </td>
	</tr>
	<tr>
	    <td width="25%">Ad Zone</td>
	    <td>
	        <div class="row">
	            <div class="col-md-12">{{ $zone_name }}</div>
	        </div>
	    </td>
	</tr>
</table>
<table class="table table-striped table-hover table-condensed">
	<colgroup>
		<col width="20%">
		<col width="80%">
	</colgroup>
    <thead>
		<tr>
			<th>Hour</th>
			<th>Ad Request</th>
		</tr>
    </thead>

	<tbody>
		@if( !empty($lists) && count($lists) )
			@foreach( $lists as $item )
				<tr>
					<td>{{ $item->hour}}</td>
					<td>{{ number_format($item->total_ad_request) }}</td>	
				</tr>
			@endforeach
		@else
			<tr>
				<td class="no-data" >{{trans("text.no_data")}}</td>
			</tr>
		@endif
	</tbody>

</table>