<table class="table table-striped table-hover">
    <tr>
    	<th>Flight Name</th>
        <th>Cost (Website)</th>    
        <th>Active</th>
        <th>Action</th>
    </tr>
	
	@if(!empty($data))
    	@foreach($data as $flightWebsite)
    		<tr>
    			<td><a href="{{URL::Route('FlightAdvertiserManagerShowView', $flightWebsite->flight_id)}}" target="_blank">({{$flightWebsite->flight_id}}) {{$flightWebsite->name}}</a></td>
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
					<a href="javascript:;" onclick="changeStatus('{{$flightWebsite->id}}', '{{$flightWebsite->status}}')" title="Click to {{$title}}" data-toggle="tooltip" data-placement="top">
						<i class="fa {{$status}} fs20"></i>
					</a>
                </td>
                <td class="preview-{{$flightWebsite->id}}">
                	<a href="{{URL::Route('PublisherAdvertiserManagerShowPreview', [$flightWebsite->id,$flightWebsite->flight_id])}}" class=" view-flight btn btn-default"  target="_blank" title="Preview Ad" data-toggle="tooltip" data-placement="top">
                        <i class="fa fa-desktop"></i>
                    </a>
                </td>
    		</tr>
    	@endforeach
    @else
    	<tr>
    		<td colspan="5">No data</td>
    	</tr>
    @endif
</table>
<script type="text/javascript">
    $(function () {
    	  $('[data-toggle="tooltip"]').tooltip();
    });
    $("[data-toggle=popover]").popover({
        html : true,
        content: function() {
            var content = $(this).attr("data-popover-content");
            return $(content).children(".popover-body").html();
        },
        title: function() {
            var title = $(this).attr("data-popover-content");
            return $(title).children(".popover-heading").html();
        }
    });
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

<style>
<!--
.center {text-align:center;}

.fs20{
  font-size:20px;
  color:#5cb85c !important;	
}
-->
</style>