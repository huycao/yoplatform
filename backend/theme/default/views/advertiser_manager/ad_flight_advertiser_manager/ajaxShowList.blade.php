<div class="admin-pagination">
	{{$lists->links()}}
	<div class="clearfix"></div>
</div>
<table class="table table-responsive table-striped table-hover table-condensed table-bordered tableList">
    <thead>
		<tr class="bg-primary">
			<th>#</th>
			@include('partials.show_field')
			<th><a href="javascript:;">Action</a></th>
		</tr>
    </thead>

	<tbody>
		<?php if( count($lists) ){ 
			$stt = ($lists->getCurrentPage()-1) * $lists->getPerPage() ; 
		?>
			<?php foreach( $lists as $item ){ $stt++; ?>
			<tr>
				<td>{{$stt}}</td>
				<td>{{$item->ad->name}}</td>
				<td>{{$item->ad->campaign->name}}</td>
				<td>{{$item->flight->name or '-' }}</td>
				<td>{{$item->flight->publisherSite->name or '-'}}</td>
				<td>{{$item->ad->type}}</td>
				<td>
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


