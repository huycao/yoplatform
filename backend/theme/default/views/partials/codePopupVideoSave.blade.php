<script type="text/javascript">
document.write('<script type="text/javascript" src="{{LINK_JW}}"></script>');
var _avlVar = _avlVar || [];
_avlVar.push(["{{$wid}}", "{{$zid}}", @if(empty($fwid)) "Popup" @else "{{$fwid}}" @endif]);
document.write('<script src="{{LINK_AVL}}" type="text/javascript"></script>');
</script>