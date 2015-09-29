<?php
	if($flightWebsite->status == 1 ){
		$status = "fa-check-circle";
		$title = "unactive";
	}else{
		$status = "fa-circle-o";
		$title = "active";
	}
?>
<a href="javascript:;" onclick="changeStatus('{{$flightWebsite->id}}', '{{$flightWebsite->status}}')" title="Click to {{$title}}" data-toggle="tooltip" data-placement="top">
	<i class="fa {{$status}} fs20"></i>
</a>
<script type="text/javascript">
$(function () {
	  $('[data-toggle="tooltip"]').tooltip();
});
</script>