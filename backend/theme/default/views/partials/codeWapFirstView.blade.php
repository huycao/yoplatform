<div class="tagstabs">
    <ul id="myTab" class="nav nav-tabs" role="tablist">
        <li class="active"><a href="#code" role="tab" data-toggle="tab">Code</a></li>

    </ul>
    <div id="myTabContent" class="tab-content">
        <div class="tab-pane fade in active" id="code">
            <p>In the edit zone, enter part of the tag Element id value content . If the ID is to add the "# " if the class is more marked " . " in front of the tag</p>
            <p>For example:</p>
            <p>Tag content is id="main_content" it added "#main_content"</p>
            <p>Tag content is class="main_content" then added ".main_content"</p>
            <p>Place this code where this unit should show in the page only</p>
            <pre>
<?php
echo htmlentities('<script type="text/javascript">var _avlVar = _avlVar || [];
_avlVar.push(["'.$wid.'", "'.$zid.'", "Wap_First_View", "'.$el_id.'", "'.$width.'", "'.$height.'"]);
document.write(\'<script src="'.LINK_AVL.'" type="text/javascript"><\/script>\');
</script>');
?>            	
            </pre>
            <a href="{{URL::Route('PublisherAdvertiserManagerSaveGetCode', [$pid,$wid,$zid])}}" class="btn btn-default btn-sm">Get Code</a>
        </div>
    </div>
</div>
