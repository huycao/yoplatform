<div class="tagstabs">
    <ul id="myTab" class="nav nav-tabs" role="tablist">
        <li class="active"><a href="#ova" role="tab" data-toggle="tab">OVA</a></li>
        <li><a href="#vast" role="tab" data-toggle="tab">Vast</a></li>

    </ul>
    <div id="myTabContent" class="tab-content">
        <div class="tab-pane fade in active" id="ova">
            <p>Place this code where this unit should show in the page only</p>
            <pre>
<?php
echo htmlentities(
'<script type="text/javascript">
document.write(\'<script type="text/javascript" src="'.LINK_JW.'"><\/script>\');
var _avlVar = _avlVar || [];
_avlVar.push(["'.$wid.'", "'.$zid.'", "Popup"]);
document.write(\'<script src="'.LINK_AVL.'" type="text/javascript"><\/script>\');
</script>'
);
?>
            </pre>
            <a href="{{URL::Route('PublisherAdvertiserManagerSaveGetCode', [$pid,$wid,$zid])}}" class="btn btn-default btn-sm">Get Code</a>
        </div>
        <div class="tab-pane fade" id="vast">
        	<pre>{{ LINK_VAST."?ec=0&wid=$wid&zid=$zid" }}</pre>
        </div>
    </div>
</div>