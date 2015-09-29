<div class="tagstabs">
    <ul id="myTab" class="nav nav-tabs" role="tablist">
        <li class="active"><a href="#code6" role="tab" data-toggle="tab">Sample Code JWPlayer 6</a></li>
        <li class=""><a href="#code5" role="tab" data-toggle="tab">Sample Code JWPlayer 5</a></li>
    </ul>
    <div id="myTabContent" class="tab-content">
        <div class="tab-pane fade in active" id="code6">
            <pre>
//Yomedia Pause Ad for jwplayer 6 javascript setup sample code
jwplayer('player_id').setup({
    primary:"flash",
    file: "{{ STATIC_URL }}public/video/pub-video.mp4",
    plugins: {
        "{{ STATIC_URL }}public/flash/jwplayer6/yomedia_pause_6.swf": {
            urlvast : "{{ LINK_VAST."?ec=0&wid=$wid&zid=$zid" }}"
        }
    }
});
            </pre>
        </div>

        <div class="tab-pane" id="code5">
            <pre>
//Yomedia Pause Ad for jwplayer 5 javascript setup sample code
jwplayer('player_id').setup({
    primary:"flash",
    file: "{{ STATIC_URL }}public/video/pub-video.mp4",
    plugins: {
        "{{ STATIC_URL }}public/flash/jwplayer5/yomedia_pause_5.swf": {
            urlvast : "{{ LINK_VAST."?ec=0&wid=$wid&zid=$zid" }}"
        }
    }
});
            </pre>
        </div>
    </div>
    

    <a href="{{URL::Route('PublisherAdvertiserManagerSaveGetCode', [$pid,$wid,$zid])}}" class="btn btn-default btn-sm">Get Code</a>

</div>

