<div class="admin-pagination mb12">
	{{$lists->links()}}
	<div class="clearfix"></div>
</div>
<div class="box mb12">
	<table class="table table-striped table-hover table-condensed">
	    <colgroup>
    		<col width="10%">
    		<col width="75%">
    		<col width="15%">
    	</colgroup>
	    <thead>
			<tr>
				<th>ID</th>
				<th>Param</th>
				<th>Date</th>
			</tr>
	    </thead>

		<tbody>
			@if( count($lists) )
				@foreach( $lists as $item )
    				<tr>
    					<td>{{$item->id}}</td>
    					<td>
    						<?php
    						    $arrParam = json_decode($item->param);
    						?>
    						@if (!empty($arrParam))
    							@foreach ($arrParam as $key=>$value)
    								{{$key}}: {{$value}}<br />
    							@endforeach
    						@endif
    					</td>
    					<td>{{date('H:i:s d/m/Y', strtotime($item->created_at))}}</td>			
    				</tr>
				@endforeach
			@else
				<tr>
					<td class="no-data" >{{trans("text.no_data")}}</td>
				</tr>
			@endif
		</tbody>

	</table>
</div>

<div class="admin-pagination">
	{{ $lists->links() }}
	<div class="clearfix"></div>
</div>
<script type="text/javascript">
	if( $(".no-data").length > 0 ){
		var colspan = $(".tableList th").length;
		$(".no-data").attr("colspan", colspan);
	} 
</script>
