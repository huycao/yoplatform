<div class="admin-pagination">
	{{$lists->links()}}
	<div class="clearfix"></div>
</div>
<table id="tableList" class="table table-responsive table-condensed">
	
    <thead>
		<tr>
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
				<?php 
					if( !empty($showField) ){ 
						foreach( $showField as $field =>	$info ){
							$value = ( isset($info['alias']) ) ? $item->{$info['alias']} : $item->{$field};
							echo AdminGetTypeContent::make($info['type'], $field, $item->id, $value);
						} 
					} 
				?>
				<td>
					<a href="{{ URL::Route($moduleRoutePrefix.'ShowUpdate',$item['id']) }}" class="btn btn-default">
						<span class="glyphicon glyphicon-pencil"></span> Edit
					</a>
					<a href="javascript:;" onclick="deleteItem({{{$item->id}}})" class="btn btn-default">
						<span class="fa fa-trash-o"></span> Del
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
		var colspan = $("#tableList th").length;
		$(".no-data").attr("colspan", colspan);
	} 

</script>


