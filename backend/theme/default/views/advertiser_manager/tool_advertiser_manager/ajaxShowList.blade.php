<div class="admin-pagination">
	{{$lists->links()}}
	<div class="clearfix"></div>
</div>
<div class="box">
<table class="table table-striped table-hover table-condensed">
    <thead>
		<tr>
			<th>#</th>
			<th><a href="javascript:;">Action</a></th>
			@include('partials.show_field')
			
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
					<a href="{{ URL::Route($moduleRoutePrefix.'ShowUpdate',$item['id']) }}" class="btn btn-default btn-sm">
						<span class="glyphicon glyphicon-pencil"></span> Edit
					</a>
					<a href="javascript:;" data-id="{{$item->id}}" class="btn btn-default btn-view-user btn-sm">
						<span class="fa fa-eye"></span> View
					</a>
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
				<td class="no-data" >{{trans("text.no_data")}}</td>
			</tr>
		<?php } ?>
	</tbody>

</table>
</div>
<div class="admin-pagination">
	{{ $lists->links() }}
	<div class="clearfix"></div>
</div>

<div class="modal fade" id="view-user" tabindex="-1" role="dialog" aria-labbelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
					<span aria-hidden="true">&times;</span>
					<span class="sr-only">Close</span>
				</button>
				<h4 class="modal-title" id="myModalLabel">{{trans('backend::publisher/text.preview')}}</h4>
			</div>
			<div class="modal-body">
				<input type="hidden" value="" name="user_id" id="user_ic" />

				<div class="show-view-user">
					
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" id="btn-submit-comment" data-dismiss="modal">{{trans('backend::publisher/text.close')}}</button>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	
	if( $(".no-data").length > 0 ){
		var colspan = $("#tableList th").length;
		$(".no-data").attr("colspan", colspan);
	} 

	$(function(){
	 	$(".btn-view-user").click(function(event) {
	 		var vl=$(this).attr("data-id");
	 		$("#user_id").val(vl);
	 		flag=false;
	 		if(flag==false){
	 			$(".show-view-user").html('<div class="text-center">'
					+'<img src="{{URL::to($assetURL."img/loading-d.GIF")}}" alt="">'
				+'</div>');
				url="{{{ URL::to(Route($moduleRoutePrefix.'GetUser')) }}}";
		 		$.post(url,{
		 			user_id : vl
		 		}, function(data) {
		 			if(data) {
		 				flag=true;
		 				$('.show-view-user').html(data);
		 			}
		 		});
	 		}
	 		
	 		$('#view-user').modal();

	 	});
	 });

</script>


