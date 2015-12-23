<div class="admin-pagination mb12">
	{{$lists->links()}}
	<div class="clearfix"></div>
</div>
<div class="box mb12">
	<table class="table table-striped table-hover table-condensed">
		<colgroup>
    		<col width="10%">
    		<col width="10%">
    		<col width="30%">
    		<col width="30%">
    		<col width="20%">
    	</colgroup>
	    <thead>
			<tr>
				<th>View</th>
				<th>Date</th>
				<th>Website</th>
				<th>Zone</th>
				<th>Ad Request</th>
			</tr>
	    </thead>

		<tbody>
			@if( !empty($lists) && count($lists) )
				@foreach( $lists as $item )
    				<tr>
    					<td align="center" ><span onclick="reportHour({{$item->website_id}}, {{$item->publisher_ad_zone_id}}, '{{$item->date}}', '{{$item->website->name}}', '{{$item->adzone->name}}');" class="view-hour" style="cursor: pointer"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> View Hour</span></td>
    					<td>{{date('Y-m-d', strtotime($item->date))}}</td>
    					<td>{{ $item->website->name }}</td>
    					<td>{{ $item->adzone->name }}</td>
    					<td>{{ number_format($item->total_ad_request) }}</td>	
    				</tr>
				@endforeach
			@else
				<tr>
					<td class="no-data" >{{trans("text.no_data")}}</td>
				</tr>
			@endif
		</tbody>

	</table>
</div>

<div class="admin-pagination">
	{{ $lists->links() }}
	<div class="clearfix"></div>
</div>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Flight Report</h4>
            </div>
            <div class="modal-body">
                <img src="{{ $assetURL.'img/loading-d.GIF' }}"/>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
	if( $(".no-data").length > 0 ){
		var colspan = $(".tableList th").length;
		$(".no-data").attr("colspan", colspan);
	} 

    function reportHour(wid, zid, date, wname, zname) {
    	$('#myModal .modal-dialog').css("width","800px");
        $('#myModal .modal-body').html('<img src="{{ $assetURL.'img/loading-d.GIF' }}"/>');
        $('#myModal').modal("show");
        $.ajax({
            url:'{{ Url::route("ToolAdvertiserManagerReportAdRequestHour") }}',
            data:{wid:wid,zid:zid,date:date, wname:wname, zname: zname},
            type:'POST',
            success:function(data){
                $('#myModal .modal-body').html(data);

            }
        });
    }
</script>
