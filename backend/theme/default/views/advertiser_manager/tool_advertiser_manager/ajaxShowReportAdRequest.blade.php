<div class="admin-pagination mb12">
	{{$lists->links()}}
	<div class="clearfix"></div>
</div>
<div class="box mb12">
	<table class="table table-striped table-hover table-condensed">
		<colgroup>
    		<col width="40%">
    		<col width="40%">
    		<col width="20%">
    	</colgroup>
	    <thead>
			<tr>
				<th>Website</th>
				<th>Zone</th>
				<th>Ad Request</th>
			</tr>
	    </thead>

		<tbody>
            <?php $summary = 0; ?>
			@if( !empty($lists) && count($lists) )
				@foreach( $lists as $item )
                    <?php $summary += $item->total_ad_request; ?>
    				<tr>
    					<td>{{ empty($website) ? !empty($item->website->name) ? $item->website->name : '' : 'All website' }}</td>
    					<td>{{ empty($ad_zone) ? !empty($item->adzone->name) ? $item->adzone->name : '' : 'All zone' }}</td>
    					<td>{{ number_format($item->total_ad_request) }}</td>	
    				</tr>
				@endforeach
			@else
				<tr>
					<td class="no-data" >{{trans("text.no_data")}}</td>
				</tr>
			@endif
		</tbody>
        @if( !empty($lists) && count($lists) )
        <tfoot>
            <tr>
                <th class="text-center" colspan="2">
                    Summary
                </th>
                <th>{{ number_format($summary) }}</th>
            </tr>
        </tfoot>
        @endif
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
