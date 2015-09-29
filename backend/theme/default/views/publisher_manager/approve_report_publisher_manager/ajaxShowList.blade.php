
<table id="tableList" class="table table-responsive table-condensed">
	
    <thead>
		<tr>
			<th><a href="javascript:;">#</a></th>
			<th><a href="javascript:;">User</a></th>
			<th><a href="javascript:;">Approved</a></th>
			<th><a href="javascript:;">Disapproved</a></th>
		</tr>
    </thead>

	<tbody>
		<?php if( count($lists) ){ 
			$stt = 0; 
		?>
			<?php foreach( $lists as $item ){ $stt++; ?>
			<tr>
				<td>{{$stt}}</td>
				<td>{{$item['username']}}</td>
				<td>{{$item['approved']}}</td>		
				<td>{{$item['disapproved']}}</td>	
			</tr>
			<?php } ?>
		<?php }else{ ?>
			<tr>
				<td class="no-data" >{{trans("backend::publisher/text.no_data")}}</td>
			</tr>
		<?php } ?>
	</tbody>

</table>

<script type="text/javascript">
	
	if( $(".no-data").length > 0 ){
		var colspan = $("#tableList th").length;
		$(".no-data").attr("colspan", colspan);
	} 

</script>


