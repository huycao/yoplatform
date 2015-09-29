<div class="admin-pagination">
	{{$lists->links()}}
	<div class="clearfix"></div>
</div>
<table id="tableList" class="table table-responsive table-condensed">
	
    <thead>
		<tr>
			<?php if( !empty($showField) ){ ?>
				<th>#</th>
				<th><a href="javascript:;">Action</a></th>
				<?php foreach( $showField as $field =>	$info ){ ?>
						<?php
							$nextOrder = "desc";
							$orderClass = "sorting";
							if( $field == $defaultField ){
								if( $defaultOrder == "desc" ){
									$nextOrder = "asc";
									$orderClass = "sorting_asc";
								}else{
									$orderClass = "sorting_desc";
								}
							}
						?>
						<th class="<?=$orderClass?>"><a href="javascript:;" onclick="pagination.sort('<?=$field?>','<?=$nextOrder?>')"><?=$info['label']?></a></th>
				<?php } ?>
				<th>{{trans("backend::publisher/text.role")}}</th>
			<?php } ?>
			
		</tr>
    </thead>

	<tbody>
		<?php if( count($lists) ){ 
			$stt = ($lists->getCurrentPage()-1) * $lists->getPerPage() ; 
		?>
			<?php foreach( $lists as $item ){ $stt++; ?>
			<tr>
				<td>{{$stt}}</td>
				<td>
					<a href="{{ URL::Route($moduleRoutePrefix.'ShowUpdate',$item['id']) }}" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-edit "></span></a>
					<a href="javascript:;" onclick="deleteItem({{{$item->id}}})" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-trash "></span></a>
				</td>
				<?php 
					if( !empty($showField) ){ 
						foreach( $showField as $field =>	$info ){
							$value = ( isset($info['alias']) ) ? $item->{$info['alias']} : $item->{$field};
							echo AdminGetTypeContent::make($info['type'], $field, $item->id, $value);
						} 
					} 
				?>
				<td>{{$item->role}}</td>
			</tr>
			<?php } ?>
		<?php }else{ ?>
			<tr>
				<td class="no-data" >{{trans("backend::publisher/text.no_data")}}</td>
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


