<div class="admin-pagination">
	{{$lists->links()}}
	<div class="clearfix"></div>
</div>
<table id="tableList" class="table table-responsive">
	
    <thead>
		<tr>

			<?php if( !empty($showField) ){ ?>
				<th>#</th>
				<th><a href="javascript:;">{{trans('backend::publisher/text.action')}}</a></th>				
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
			
				<th><a href="javascript:;">{{trans("backend::publisher/text.earnings")}}</a></th>
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
					<a href="javascript:;" data-id="{{$item->id}}" class="show-tooltip show-modal-comment" data-toggle="tooltip" data-placement="right" title="commnent"><i class="fa fa-comments-o text-info"></i></a>
				</td>
				<td>{{$item->StatusCampaign}}</td>
				<td class="tooltip-view">
					<?php //$arrAdformat=$item->Adformat; ?>
					<a href="javascript:;" class="show-tooltip" data-toggle="tooltip" data-placement="right" title="ad format"><i class="fa fa-question-circle text-info"></i></a>
					<a href="javascript:;" data-id="{{$item->id}}" class="show-tooltip show-madal-preview" data-toggle="tooltip" data-placement="right" title="preview" style="text-decoration: none;"><i class="fa fa-eye text-info"></i></a>
					{{$item->name}}	
				</td>
				<td>{{$item->cate_name}}</td>
				<td>{{$item->name_advertiser}}</td>
				<td>{{date("d-M-Y",strtotime($item->start_date))}} - {{date("d-M-Y",strtotime($item->end_date))}}</td>
				<td>{{numberVN($item->publisher_cost)}}</td>
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

<div class="modal fade" id="modal-campaign-comment" tabindex="-1" role="dialog" aria-labbelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
					<span aria-hidden="true">&times;</span>
					<span class="sr-only">Close</span>
				</button>
				<h4 class="modal-title" id="myModalLabel">{{trans('backend::publisher/text.comment')}}</h4>
			</div>
			<div class="modal-body">
				<h3>{{trans('backend::publisher/text.what_do_you_think')}}</h3>
				<div class="row">
					<div class="col-sm-12">
						
						{{Form::open(['id'=>'form-comment','role'=>'form'])}}
							<div class="form-group" id="cm-campaign">
								<input type="hidden" name="id_campaign" id="id_campaign" value="">
								<?php $arrComment=commentCampaign(); ?>
								@foreach($arrComment as $key=>$value)
									<input type="radio" name="comment" value="{{$key}}"> {{$value}} <br>
								@endforeach
								<textarea name="orther-comment" style="display:none;" id="orther-comment" cols="30" class="form-control" rows="5"></textarea>
							</div>
						{{Form::close()}}
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" id="btn-submit-comment" data-dismiss="modal">{{trans('backend::publisher/text.send')}}</button>
			</div>
		</div>
	</div>
</div>


<div class="modal fade" id="modal-campaign-preview" tabindex="-1" role="dialog" aria-labbelledby="myModalLabel" aria-hidden="true">
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
				<div class="show-preview-ad-format">
					{{trans('backend::publisher/text.show_ad_format_of_campaign')}}
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" id="btn-submit-comment" data-dismiss="modal">{{trans('backend::publisher/text.send')}}</button>
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
	 	$('.show-tooltip').tooltip();

	 	$(".show-modal-comment").click(function(event) {
	 		var vl=$(this).attr("data-id");
	 		$("#id_campaign").val(vl);
	 		$('#modal-campaign-comment').modal();
	 	});

	 	$(".show-madal-preview").click(function(event) {
	 		$('#modal-campaign-preview').modal();
	 	});

	 	$("#cm-campaign input[type=radio]").click(function(event) {
	 		var vl=$(this).val();
	 		if(vl==-1) $("#orther-comment").show();
	 		else $("#orther-comment").hide();
	 	});

	 	$("#btn-submit-comment").click(function(e) {
	 		var flag=false;
	 		e.preventDefault();
	 		if(flag==false){
	 			$.post('{{URL::to(Route($moduleRoutePrefix."CommnetCampaign"))}}',$("#form-comment").serialize(), function(data) {
	 				if(data==1){
	 					alert('{{trans("backend::publisher/text.success")}}');
	 				}
	 			});
	 		}
	 	});
	});
	
</script>


