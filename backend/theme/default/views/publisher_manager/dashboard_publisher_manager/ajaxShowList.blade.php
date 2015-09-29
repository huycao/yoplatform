<div class="admin-pagination">
	{{$lists->links()}}
	<div class="clearfix"></div>
</div>
<table id="tableList" class="table table-responsive">
	
    <thead>
		<tr>			
			<th>#</th>
			<th><a href="javascript:;">Site</a></th>								
			<th>Impressions</th>
			<th>Engagements</th>
			<th>Clicks</th>
			<th>CRT</th>
			<th>Earnings (<ins>đ</ins>)</th>			
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
				<td><a class="btn btn-default"><i class="fa fa-pencil-square-o"></i> View</a></td>
			</tr>
			<?php } ?>
		<?php }else{ ?>
			<tr>
				<td class="no-data" >{{trans("backend::text.no_data")}}</td>
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


