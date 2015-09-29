<div class="admin-pagination mb12">
	{{$lists->links()}}
	<div class="clearfix"></div>
</div>
<div class="box mb12">
	<table class="table table-striped table-hover table-condensed">
	    <colgroup>
    		<col width="45%">
    		<col width="15%">
    		<col width="10%">
    		<col width="5%">
    		<col width="5%">
    		<col width="20%">
    	</colgroup>
	    <thead>
			<tr>
				<th>Flight</th>
				<th>Total Inventory</th>
				<th>Days</th>
				<th>Cost Type</th>
				<th>Active</th>
				<th><a href="javascript:;">Action</a></th>
			</tr>
	    </thead>

		<tbody>
			<?php if( count($lists) ){ ?>
				<?php foreach( $lists as $item ){ ?>
				<tr>
					<td><a href="{{ URL::Route($moduleRoutePrefix.'ShowView',$item['id']) }}">({{$item['id']}}) {{$item->name}}</a></td>
					<td><span class="badge badge-info">{{number_format($item->total_inventory)}}</span></td>
					<td><span class="badge badge-info">{{$item->day}}</span></td>
					<td>{{strtoupper($item->cost_type)}}</td>
					<?php
    					if($item->status == 1 ){
    						$status = "fa-check-circle";
    						$title = "unactive";
    					}else{
    						$status = "fa-circle-o";
    						$title = "active";
    					}
    				?>
					<td class="status-{{$item['id']}} center">
						<a href="javascript:;" onclick="changeStatus('{{$item['id']}}', '{{$item->status}}')" title="Click to {{$title}} this flight" data-toggle="tooltip" data-placement="top">
							<i class="fa {{$status}} fs20"></i>
						</a>
                    </td>
					<td>
						<div>
							<ul class="fontawesome-icon-list fa-hover list-inline">
								<li>
									<a class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top" href="{{ URL::Route($moduleRoutePrefix.'ShowUpdate',$item['id']) }}" title="Edit">
										<i class="fa fa-pencil-square-o"></i>
									</a>
								</li>
								<li>
									<a class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top" href="{{ URL::Route($moduleRoutePrefix.'ShowView',$item['id']) }}" title="View">
										<i class="fa fa-eye"></i>
									</a>
								</li>
								<li>
									<a class="btn btn-default btn-sm renewCache" data-toggle="tooltip" data-placement="top" href="{{ URL::Route($moduleRoutePrefix.'renewCache',$item['id']) }}" title="Renew Cache">
										<i class="fa fa-refresh"></i>
									</a>
								</li>
								<li>
									<a class="btn btn-default btn-sm" target="_blank" data-toggle="tooltip" data-placement="top" href="{{ URL::Route($moduleRoutePrefix.'ShowSelectWebsite', $item['id']) }}" title="List Website">
										<i class="fa fa-sitemap"></i>
									</a>
								</li>
								<li>
								<a class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top" title="Preview Flight" href="javascript:;" onclick="Preview.getPreview('flight', {{$item['id']}})">
									<i class="fa fa-desktop"></i>
								</a>							
							</li>
							</ul>
						</div>
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
</div>

<div class="admin-pagination">
	{{ $lists->links() }}
	<div class="clearfix"></div>
</div>
<script type="text/javascript">


	if( $(".no-data").length > 0 ){
		var colspan = $(".tableList th").length;
		$(".no-data").attr("colspan", colspan);
	} 
	$(function () {
	  $('[data-toggle="tooltip"]').tooltip()

	  //renew cache
	  $('.renewCache').click(function(e){
	  	 e.preventDefault();
	  	 showLoading()
	  	 $.post(
	  	 	$(this).prop('href'),
	  	 	{},
	  	 	function(rs){
	  	 		if(rs == 'success'){
	  	 			renewCacheSuccess();
	  	 		}
	  	 		else{
	  	 			renewCacheFailed();
	  	 		}
	  	 		hideLoading();
	  	 	}
	  	 )
	  })
	});

	function renewCacheSuccess(){
		$('.right-wrap').prepend(
			'<div class="alert alert-success alert-dismissible fade in renewCacheSuccess" role="alert">'+
	  			'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="fa fa-times-circle-o"></i></button>'+
	  			'<h4>Renew Cache Success!</h4>'+
			'</div>');
	}

	function renewCacheFailed(){
		$('.right-wrap').prepend(
			'<div class="alert alert-danger alert-dismissible fade in renewCacheSuccess" role="alert">'+
	  			'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="fa fa-times-circle-o"></i></button>'+
	  			'<h4>Renew Cache Failed, please try again later!</h4>'+
			'</div>');
	}
	function changeStatus(id, status) {
		var url = root+module+"/change-status";

	   	$.post(
	        url,
	        {
	            id : id,
	            status : status
	        },
	        function(data){
	        	if( data != "fail" ){
	                $(".status-"+id).html(data);
	            }
	        }
	    );
	}
</script>

<div style="display:none">
	<div class="alert alert-success alert-dismissible fade in renewCacheSuccess" role="alert">
	  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">�</span></button>
	  Renew Cache Success!
	</div>
	<div class="alert alert-danger alert-dismissible fade in renewCacheFailed" role="alert">
	  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">�</span></button>
	  Renew Cache Failed, please try again later!
	</div>
</div>
<style>
<!--
.center {text-align:center;}

.fs20{
  font-size:20px;
  color:#5cb85c !important;	
}
-->
</style>
