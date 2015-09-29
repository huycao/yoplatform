<div class="admin-pagination">
	{{$lists->links()}}
	<div class="clearfix"></div>
</div>
<table class="table table-responsive table-striped table-hover table-condensed table-bordered tableList">
	
    <thead>
		<tr class="bg-primary">
			<th>Flight</th>
			<th>Campaign</th>
			<th>Website</th>
			<th>Total Inventory</th>
			<th>Days</th>
			<th>Cost Type</th>
			<th><a href="javascript:;">Action</a></th>
		</tr>
    </thead>

	<tbody>
		<?php if( count($lists) ){ ?>
			<?php foreach( $lists as $item ){ ?>
			<tr>
				<td>[{{$item->id}}] {{$item->name}}</td>
				<td>{{$item->campaign->name}}</td>
				<td>{{$item->publisher->company or "-"}}</td>
				<td>{{$item->publisherSite->name or "-" }}</td>
				<td>{{$item->publisher_ad_zone->name or "-"}}</td>
				<td>{{$item->total_inventory}}</td>
				<td>{{$item->day}}</td>
				<td>{{strtoupper($item->cost_type)}}</td>
				<td>
					<a href="{{ URL::Route($moduleRoutePrefix.'ShowUpdate',$item['id']) }}" class="btn btn-default btn-sm">
						<span class="glyphicon glyphicon-pencil"></span> Edit
					</a>
					<a href="{{ URL::Route($moduleRoutePrefix.'ShowView',$item['id']) }}" class="btn btn-default btn-sm">
						<span class="fa fa-eye"></span> View
					</a>
				</td>				
			</tr>
			<?php } ?>
		<?php }else{ ?>
			<tr>
				<td class="no-data" >{{trans("text.no_data")}}</td>
			</tr>
		<?php } ?>
	</tbody>

</table>
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


