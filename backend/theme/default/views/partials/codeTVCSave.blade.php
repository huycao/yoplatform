// OVA

<script type="text/javascript">
document.write('<sc'+'ript src="{{LINK_JW}}" type="text/javascript"></scr'+'ipt>');
var _avlVar = _avlVar || [];
_avlVar.push(["{{$wid}}", "{{$zid}}", "Video", "{{$el_id}}", "{{$width}}", "{{$height}}"]);
document.write('<sc'+'ript src="{{LINK_AVL}}" type="text/javascript"></scr'+'ipt>');
</script>

// VAST 2.0
{{ LINK_VAST."?ec=0&wid=$wid&zid=$zid" }}
// VAST 3.0
{{ LINK_VAST."?ec=0&wid=$wid&zid=$zid&v=3" }}