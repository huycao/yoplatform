<?php
	$fpid = "";
	if (!empty($fwid)) {
		$fpid = "&fpid={$fwid}";
	}
?>
http://delivery.yomedia.vn/track?evt=impression{{$fpid}}&wid={{$wid}}&zid={{$zid}}&rt=1&bc=1
http://delivery.yomedia.vn/track?evt=click{{$fpid}}&wid={{$wid}}&zid={{$zid}}&rt=1&bc=1
http://delivery.yomedia.vn/track?evt=complete{{$fpid}}&wid={{$wid}}&zid={{$zid}}&rt=1&bc=1