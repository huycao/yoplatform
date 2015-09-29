<div class="tagstabs">
    <ul id="myTab" class="nav nav-tabs" role="tablist">
        <li class="active"><a href="#code" role="tab" data-toggle="tab">Code</a></li>
    </ul>
    <div id="myTabContent" class="tab-content">
        <div class="tab-pane fade in active" id="code">
            <pre>
http://yomedia.vn/track?evt=impression&wid={{$wid}}&zid={{$zid}}&rt=1
http://yomedia.vn/track?evt=click&wid={{$wid}}&zid={{$zid}}&rt=1
http://yomedia.vn/track?evt=complete&wid={{$wid}}&zid={{$zid}}&rt=1
            </pre>
            <a href="{{URL::Route('PublisherAdvertiserManagerSaveGetCode', [$pid,$wid,$zid])}}" class="btn btn-default btn-sm">Get Code</a>
        </div>
    </div>
</div>