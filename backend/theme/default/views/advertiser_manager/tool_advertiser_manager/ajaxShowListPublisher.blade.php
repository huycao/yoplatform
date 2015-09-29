<div class="admin-pagination">
	{{$lists->links()}}
	<div class="clearfix"></div>
</div>
<table id="" class="table table-responsive table-striped table-hover table-condensed table-bordered tableList">
	
    <thead>
		<tr class="bg-primary">
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
					<a href="javascript:;" data-id="{{$item->id}}" class="btn btn-default btn-sm show-modal"><span class="glyphicon glyphicon-edit "></span></a>
				</td>
				<?php 
					if( !empty($showField) ){ 
						foreach( $showField as $field =>	$info ){
							$value = ( isset($info['alias']) ) ? $item->{$info['alias']} : $item->{$field};
							echo AdminGetTypeContent::make($info['type'], $field, $item->id, $value);
						} 
					} 
				?>
				
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


<div class="modal fade" id="modal-campaign-preview" tabindex="-1" role="dialog" aria-labbelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
					<span aria-hidden="true">&times;</span>
					<span class="sr-only">Close</span>
				</button>
				<h4 class="modal-title" id="myModalLabel">{{trans("backend::publisher/text.sort_flight_running")}}</h4>
			</div>
			<div class="modal-body">
				<div class="show-preview-ad-format">
					{{trans('backend::publisher/text.show_ad_format_of_campaign')}}
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">{{trans('backend::publisher/text.close')}}</button>
				<button type="button" class="btn btn-primary" id="btn-submit-comment" >{{trans('backend::publisher/text.save')}}</button>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	$(function(){
		$(".show-modal").click(function(event) {
			$("#modal-campaign-preview").modal();
			var flag=false;
			var publisher_id=$(this).attr("data-id");
			if(flag==false){
				$(".show-preview-ad-format").html('<div class="text-center">'
					+'<img src="{{URL::to($assetURL."img/loading-d.GIF")}}" alt="">'
				+'</div>');
				$.post("{{ URL::to(Route($moduleRoutePrefix.'SortFlightRunning')) }}",{
					publisher_id : publisher_id
				}, function(data) {
					flag=true;
					$(".show-preview-ad-format").html(data);
				});
			}
		});

		$('#btn-submit-comment').click(function(e){
        	e.preventDefault();
			serialized = $('ol.sortable').nestedSortable('serialize');
			var flag=false;
			if(flag==false){
				$.post(
					"{{{URL::to(Route($moduleRoutePrefix.'UpdateSortFlightRunning'))}}}",
					serialized
					,
					function(data){
						flag=true;
						if(data==1) $(".show-success").show();
					}
				)
			}
			
        });
	});


	if( $(".no-data").length > 0 ){
		var colspan = $("#tableList th").length;
		$(".no-data").attr("colspan", colspan);
	} 

	

</script>


