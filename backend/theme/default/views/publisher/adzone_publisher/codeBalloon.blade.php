<div class="tagstabs">
    <ul id="myTab" class="nav nav-tabs" role="tablist">
        <li class="active"><a href="#code" role="tab" data-toggle="tab">Code</a></li>
    </ul>
    <div id="myTabContent" class="tab-content">
        <div class="tab-pane fade in active" id="code">
            <p>Place this code where this unit should show in the page only</p>
            <pre>
<?php
echo htmlentities(
'<script type="text/javascript">
var _avlVar = _avlVar || [];
_avlVar.push(["'.$wid.'", "'.$zid.'", "Balloon"]);
document.write(\'<script src="'.LINK_AVL.'" type="text/javascript"><\/script>\');
</script>'
);
?>
            </pre>
        </div>
    </div>
</div>