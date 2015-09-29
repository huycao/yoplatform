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
			<th><a href="javascript:;">Status</a></th>

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
				
				<?php
					if( $item->activated == 1 ){
						$status = "fa fa-check fa-check-right";
					}else{
						$status = "fa fa-times fa-times-wrong";
					}
				?>
				@if( !$item->isSuperUser() )
				<td class="status-{{{$item->id}}}"><a href="javascript:;" onclick="changeStatus('{{$item->id}}', '{{$item->activated}}')"><i class="{{{ $status }}}"></i></a></td>

				<td>
					<a href="{{ URL::Route('UserAdminShowPermission', $item->id) }}" class="btn btn-default btn-sm"><i class="fa fa-eye"></i> Permission</a>
					<a href="{{ URL::Route('UserAdminShowUpdate', $item->id) }}" class="btn btn-default btn-sm"><i class="fa fa-pencil-square-o"></i> Edit</a>
					<a onclick="deleteItem({{{$item->id}}})" href="javascript:;" class="btn btn-default btn-sm"><i class="fa fa-trash"></i> Delete</a>
				</td>
				@else
				<td></td>
				<td></td>
				@endif
			</tr>
			<?php } ?>
		<?php }else{ ?>
			<tr>
				<td colspan="6">No data</td>
			</tr>
		<?php } ?>
	</tbody>

</table>
<div class="admin-pagination">
	{{$lists->links()}}
	<div class="clearfix"></div>
</div>
