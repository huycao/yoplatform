<?php
	if( $item->status == 1 ){
		$status = "fa fa-check fa-check-right";
	}else{
		$status = "fa fa-times fa-times-wrong";
	}
?>
<a href="javascript:;" onclick="changeStatus('{{$item->id}}', '{{$item->status}}')"><i class="{{{ $status }}}"></i></a>