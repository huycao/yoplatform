// OVA

<script type="text/javascript">
document.write('<sc'+'ript src="{{LINK_JW}}" type="text/javascript"></scr'+'ipt>');
var _avlVar = _avlVar || [];
_avlVar.push(["{{$wid}}", "{{$zid}}", @if(empty($fwid)) "Video" @else "{{$fwid}}" @endif, "{{$el_id}}", "{{$width}}", "{{$height}}"]);
_avlTag = '';
document.write('<sc'+'ript src="{{LINK_AVL}}" type="text/javascript"></scr'+'ipt>');
</script>

<?php
	$fpid = "";
	if (!empty($fwid)) {
		$fpid = "&fpid={$fwid}";
	}
?>

// VAST 2.0
{{ LINK_VAST."?ec=0&wid=$wid&zid=$zid".$fpid."&tag=" }}
// VAST 3.0
{{ LINK_VAST."?ec=0&wid=$wid&zid=$zid&v=3".$fpid."&tag=" }}