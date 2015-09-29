<div class="admin-pagination">
	{{$lists->links()}}
	<div class="clearfix"></div>
</div>
<table class="table table-responsive table-striped table-hover table-condensed table-bordered tableList">
    <thead>
		<tr class="bg-primary">
			<?php if( !empty($showField) ){ ?>
				<th>#</th>
				<?php foreach( $showField as $field =>	$title ){ ?>
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
					<th class="<?=$orderClass?>"><a href="javascript:;" onclick="pagination.sort('<?=$field?>','<?=$nextOrder?>')"><?=$title?></a></th>
				<?php } ?>
			<?php } ?>
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
				<?php if( !empty($showField) ){ ?>
					<?php foreach( $showField as $field =>	$title ){ ?>
						<td>{{ $item->{$field} }}</td>
					<?php } ?>
				<?php } ?>
				
				<td>
					<a href="{{ URL::Route('UserGroupAdminShowPermission', $item->id) }}" class="btn btn-default btn-sm"><i class="fa fa-eye"></i> Permission</a>
					<a href="{{ URL::Route('UserGroupAdminShowUpdate', $item->id) }}" class="btn btn-default btn-sm"><i class="fa fa-pencil-square-o"></i> View</a>
					<a onclick="deleteItem({{{$item->id}}})" href="javascript:;" class="btn btn-default btn-sm"><i class="fa fa-trash"></i> Delete</a>
				</td>

			</tr>
			<?php } ?>
		<?php }else{ ?>
			<tr>
				<td colspan="6">Không có dữ liệu</td>
			</tr>
		<?php } ?>
	</tbody>

</table>
<div class="admin-pagination">
	{{$lists->links()}}
	<div class="clearfix"></div>
</div>
