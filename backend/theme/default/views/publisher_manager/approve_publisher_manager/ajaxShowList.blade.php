<div class="admin-pagination">
	{{$lists->links()}}
	<div class="clearfix"></div>
</div>
<table id="tableList" class="table table-responsive table-condensed">
	
    <thead>
		<tr class="bg-primary">
			<?php if( !empty($showField) ){ ?>
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
			<?php } ?>
			<th><a href="javascript:;">{{trans('backend::publisher/text.action')}}</a></th>
		</tr>
    </thead>

	<tbody>
		<?php if( count($lists) ){ ?>
			<?php foreach( $lists as $item ){ ?>
			<tr>
				<td><a href="{{ URL::Route($moduleRoutePrefix.'ShowView',$item['id']) }}">({{$item['id']}}) {{$item->company}}</a></td>
				<td>{{$item->site_url}}</td>
				<td><span class="badge badge-info">{{number_format($item->pageview)}}</span></td>
				<td><span class="badge badge-info">{{number_format($item->unique_visitor)}}</span></td>
				<td>{{$item->email}}</td>
				<td>{{$item->statusText}}</td>			
				<td>{{$item->created_at}}</td>
				<td>					
					<a href="{{ URL::Route('ApprovePublisherManagerShowUpdate',$item['id']) }}" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-pencil"></span> {{trans('backend::publisher/text.edit')}}</a>
					<a href="{{ URL::Route('ApprovePublisherManagerShowView',$item['id']) }}" class="btn btn-default btn-sm"><i class="fa fa-pencil-square-o"></i> {{trans('backend::publisher/text.view')}}</a>
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


