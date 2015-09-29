<table class="table table-striped table-hover table-condensed ">
    <thead>
        <tr>
            <th>Name</th>
            <th>Inventory</th>
            <th>Value Added</th>
            <th>Cost</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
            $runningInventory = 0;
        ?>
        @if( !empty($flightWebsiteList) )
            @foreach( $flightWebsiteList as $flightWebsite )
                <?php
                    $runningInventory += $flightWebsite->total_inventory;
                ?>
                <tr>
                    <td><a href="{{ URL::Route('PublisherAdvertiserManagerShowViewSite',[$flightWebsite->website->publisher_id, $flightWebsite->website->id]) }}">({{$flightWebsite->id}}) {{$flightWebsite->website->name}}</a></td>
                    <td>{{$flightWebsite->total_inventory}}</td>
                    <td>@if ($flightWebsite->value_added >= 0){{$flightWebsite->value_added}}@else Not Apply @endif</td>
                    <td class="right">{{number_format($flightWebsite->publisher_base_cost)}}</td>
                    <?php
    					if($flightWebsite->status == 1 ){
    						$status = "fa-check-circle";
    						$title = "unactive";
    					}else{
    						$status = "fa-circle-o";
    						$title = "active";
    					}
    				?>
                    <td class="status-{{$flightWebsite->id}} center">
                        <a href="javascript:;" onclick="changeStatus('{{$flightWebsite->id}}', '{{$flightWebsite->status}}')" title="Click to {{$title}} this flight website" data-toggle="tooltip" data-placement="top">
							<i class="fa {{$status}} fs20"></i>
						</a>
                    </td>
                    <td>
                        <a href="javascript:;" onclick="Flight.loadModal({{$flightWebsite->id}} ,{{$flightWebsite->flight_id}} ,{{$flightWebsite->website_id}}, '{{$flightWebsite->website->name}}')" class="btn btn-default btn-sm">
                            <span class="glyphicon glyphicon-pencil"></span> Edit
                        </a>
                        <a href="{{ URL::Route($moduleRoutePrefix.'RenewCacheFlightWebsite',$flightWebsite->id) }}" class="btn btn-default btn-sm renewCache">
							<span class="fa fa-refresh"></span> Refresh Cache
						</a>
                        {{-- <a href="javascript:;" onclick="Flight.delete({{$flightWebsite->id}})" class="btn btn-default btn-sm">
                            <span class="fa fa-trash-o"></span> Del
                        </a> --}}
                    </td>
                </tr>
            @endforeach
        @endif

    </tbody>

    <tfoot>
        <tr class="bg-footer">
            <th>Total</th>
            <th>{{ $totalInventory }}</th>
            <th>Remain</th>
            <th colspan="4">{{ $totalInventory - $runningInventory }}</th>
        </tr>
    </tfoot>

</table>
<style>
<!--
.center {text-align:center;}

.fs20{
  font-size:20px;
  color:#5cb85c !important;	
}
-->
</style>
<script type="text/javascript">
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
		var url = root+module+"/website-change-status";

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