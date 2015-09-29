<div class="admin-pagination">
	{{$lists->links()}}
	<div class="clearfix"></div>
</div>
<table class="table table-responsive table-striped table-hover table-condensed table-bordered tableList">
    <thead>
		<tr class="bg-primary">
			@include('partials.show_field')
			<th><a href="javascript:;">Action</a></th>
		</tr>
    </thead>

	<tbody>
		<?php if( count($lists) ){ ?>
			<?php foreach( $lists as $item ){ ?>
			<tr>
				<td>{{$item->name}}</td>
				<td>
					<a href="{{ URL::Route($moduleRoutePrefix.'ShowUpdate',$item['id']) }}" class="btn btn-default btn-sm">
						<span class="glyphicon glyphicon-pencil"></span> Edit
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


