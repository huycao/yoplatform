<?php
    $wrapperAds = "YoMediaBanner_".$data['zid'];
    $elAds = "YoMediaBanner_".$data['zid'];
    $iWidth = $data['ad']->width;
    $iHeight = $data['ad']->height;
    $eWidth = $data['ad']->width_after;
    $eHeight = $data['ad']->height_after;

    if( !empty( $data['ad']->third_impression_track ) ){
        $thirdImpressionTrackArr = explode("\n", $data['ad']->third_impression_track);
    }else{
        $thirdImpressionTrackArr = [];   
    }

    if( !empty( $data['ad']->third_click_track ) ){
        $thirdClickTrackArr = explode("\n", $data['ad']->third_click_track);
    }else{
        $thirdClickTrackArr = [];   
    }
    
?>
avlHelperModule.loadAvlStyle();

var secondFlashYoURI_{{ $data['zid'] }} = "{{ $data['ad']->source_url2 }}";
var eWidth_{{ $data['zid'] }} = {{ $iWidth }};
var eHeight_{{ $data['zid'] }} = {{ $iHeight }};
var iWidth_{{ $data['zid'] }} = {{ $eWidth }};
var iHeight_{{ $data['zid'] }} = {{ $eHeight }};
var ox_{{ $data['zid'] }} = 0;
var oy_{{ $data['zid'] }} = 0;
var expanded_{{ $data['zid'] }} = false;
var YoPreviousCx_{{ $data['zid'] }} = 0;
var YoPreviousCy_{{ $data['zid'] }} = 0;
var YoFlagEnd_{{ $data['zid'] }} = false;
var timerScroller_{{ $data['zid'] }} = false;


window.size = function() {
    var w = 0;
    var h = 0;
    if(!window.innerWidth) {
        if(!(document.documentElemsent.clientWidth == 0)) {
            w = document.documentElement.clientWidth;
            h = document.documentElement.clientHeight;
        }else {
            w = document.body.clientWidth;
            h = document.body.clientHeight;
        }
    }else {
        if(document.body.clientWidth) {
            w = document.body.clientWidth;
        }else {
            w = window.innerWidth;
        }
        h = window.innerHeight;
    }
    return {width:w, height:h};
}
// Window scroll
window.scroller = function() {
    var x = 0;
    var y = 0;
    if(typeof window.pageYOffset == "number") {
        y = window.pageYOffset;
        x = window.pageXOffset;
    }else if(document.body && (document.body.scrollLeft || document.body.scrollTop)) {
        y = document.body.scrollTop;
        x = document.body.scrollLeft;
    }else if(document.documentElement && (document.documentElement.scrollLeft || document.documentElement.scrollTop)) {
        y = document.documentElement.scrollTop;
        x = document.documentElement.scrollLeft;
    }
    return {x:x, y:y};
}

function showYoMediaBannerAd_{{ $data['zid'] }}(s) {
var flash = '{{$data['ad']->source_url}}';
    var impressionTrack = encodeURIComponent("{{ Tracking::impressionTrackingLink($data['aid'], $data['fpid'], $data['zid'], $data['checksum']) }}{{ !empty($data['ovr']) ? "&ovr=1" : '' }}");
<?php if(!empty($thirdImpressionTrackArr)){ ?>
    <?php foreach( $thirdImpressionTrackArr as $item ){ ?>
        impressionTrack += '|'+encodeURIComponent("{{trim(str_replace('[timestamp]', time(), $item))}}");
    <?php } ?>
<?php } ?>

    
    var clickTag = encodeURIComponent("{{ Tracking::expandTrackingLink($data['aid'], $data['fpid'], $data['zid'], $data['checksum']) }}{{ !empty($data['ovr']) ? "&ovr=1" : '' }}");
    var clickTrack= "";

<?php if(!empty($thirdClickTrackArr)){ ?>
    <?php $count = 0; ?>
    <?php foreach( $thirdClickTrackArr as $item ){ ?>
        <?php $count++; ?>
        <?php if( $count == 1 ){ ?>
            clickTrack += encodeURIComponent("{{trim(str_replace('[timestamp]', time(), $item))}}");
        <?php }else{ ?>
            clickTrack += '|'+encodeURIComponent("{{trim(str_replace('[timestamp]', time(), $item))}}");
        <?php } ?>
    <?php } ?>
<?php } ?>
    
    var flashVars = {
        impression: impressionTrack,
        clickTrack : clickTrack,
        clickUrl : clickTag,
        zid : {{ $data['zid'] }}
    }


    avlInteractModule.initBanner(
        'YoMediaBanner_{{ $data['zid'] }}',
        'YoMediaBanner_{{ $data['zid'] }}',
        eWidth_{{ $data['zid'] }},
        eHeight_{{ $data['zid'] }},
        flash,
        flashVars,
        'none'
    );

    ga('_gaYomedia.send', 'event', 'FL{{ $data['fid'] }}', 'impression', 'BannerFW{{ $data['fpid'] }}');
}


function setYoMediaExpand_{{ $data['zid'] }}() {
    if(!expanded_{{ $data['zid'] }}) {
        //get curent window scroll offset
        ox_{{ $data['zid'] }} = window.scroller().x;
        oy_{{ $data['zid'] }} = window.scroller().y;
        //append second flash
        createYomediaSideKick_{{ $data['zid'] }}();

        scrolling_{{ $data['zid'] }}(getX_{{ $data['zid'] }}(domManipulate.getElid('Yomedia_SK_Wrapper_{{ $data['zid'] }}')) , getY_{{ $data['zid'] }}(domManipulate.getElid('Yomedia_SK_Wrapper_{{ $data['zid'] }}') ));
       
        expanded_{{ $data['zid'] }} = true;
    }
}

function createYomediaSideKick_{{ $data['zid'] }}(){
    domManipulate.getElid('YoMediaBanner_{{ $data['zid'] }}').style.position = 'relative';
    var secondFlashId = 'Yomedia_SK_Obj_{{ $data['zid'] }}';
    var sideKickWrapper = domManipulate.create('div', 'Yomedia_SK_Wrapper_{{ $data['zid'] }}', '', '<div id="'+secondFlashId+'"></div>');
    sideKickWrapper.style.position = "absolute";
    sideKickWrapper.style.width = iWidth_{{ $data['zid'] }} + "px";
    sideKickWrapper.style.height = iHeight_{{ $data['zid'] }} + "px";
    sideKickWrapper.style.zIndex = 99999;
    var marginLeft = 10;
    sideKickWrapper.style.left = (eWidth_{{ $data['zid'] }}+marginLeft) + "px";
    sideKickWrapper.style.top = "0px";
     

    var expandTrack = encodeURIComponent("{{ Tracking::expandTrackingLink($data['aid'], $data['fpid'], $data['zid'], $data['checksum']) }}");

    
    var clickUrl = encodeURIComponent("{{ Tracking::clickTrackingLink($data['ad']->destination_url, $data['aid'], $data['fpid'], $data['zid'], $data['checksum']) }}");

    var clickTrack = encodeURIComponent("{{ $data['ad']->third_click_track }}");


    var bM = {
        allowScriptAccess: "always",
        allowDomain: "*",
        quality: "high",
        wmode: 'opaque'
    };
    var bN = {
        id: secondFlashId,
        name: secondFlashId
    };

    var flashVars = {
        expandTag: expandTrack,
        clickTrack : clickTrack,
        clickUrl : clickTag,
        zid : {{ $data['zid'] }}
    }


    domManipulate.getElid('YoMediaBanner_{{ $data['zid'] }}').appendChild(sideKickWrapper);
    swfobject.embedSWF(secondFlashYoURI_{{ $data['zid'] }}, secondFlashId, iWidth_{{ $data['zid'] }}, iHeight_{{ $data['zid'] }}, "9.0.0", avlConfig.get('EI'), flashVars, bM, bN);

    ga('_gaYomedia.send', 'event', 'FL{{ $data['fid'] }}', 'expand', 'BannerFW{{ $data['fpid'] }}');
}


function minYoMediaPopupAd_{{ $data['zid'] }}() {
    if(expanded_{{ $data['zid'] }}) {
        domManipulate.getElid('YoMediaBanner_{{ $data['zid'] }}').removeChild(domManipulate.getElid('Yomedia_SK_Wrapper_{{ $data['zid'] }}'));
        window.scrollTo(ox_{{ $data['zid'] }}, oy_{{ $data['zid'] }});
        expanded_{{ $data['zid'] }} = false;
        YoPreviousCx_{{ $data['zid'] }} = 0;
        YoPreviousCy_{{ $data['zid'] }} = 0;
        YoFlagEnd_{{ $data['zid'] }} = false;
    }
}



function scrolling_{{ $data['zid'] }}(x, y) {
    var speed = 30;
    var cx = x + iWidth_{{ $data['zid'] }} - window.scroller().x;
    var cxs = cx > 0 ? speed : -1 * speed;
    var changeX = Math.abs(cx) < speed ? x : window.scroller().x + cxs;
    var changeY = window.scroller().y;

    if(cx == YoPreviousCx_{{ $data['zid'] }}){
        cx = 0;
    }
    else{
        YoPreviousCx_{{ $data['zid'] }} = cx;
    }

    if(cx <= 0) {
        var cy = y - window.scroller().y;
        var cys = cy > 0 ? speed : -1 * speed;
        changeY = Math.abs(cy) < speed ? y : window.scroller().y + cys;

        if(cy == YoPreviousCy_{{ $data['zid'] }}){
            YoFlagEnd_{{ $data['zid'] }} = true;
        }
        else{
            YoPreviousCy_{{ $data['zid'] }} = cy;
        }
    }
    window.scrollTo(changeX, changeY);
    function r() {
        scrolling_{{ $data['zid'] }}(x, y);
    }
    if(window.scroller().x == x && window.scroller().y == y || YoFlagEnd_{{ $data['zid'] }}) {
        try {
            clearTimeout(timerScroller_{{ $data['zid'] }});
        }catch(e) {}
        return;
    }
    timerScroller_{{ $data['zid'] }} = setTimeout(r, 50);
}

function getX_{{ $data['zid'] }}(obj) {
    var x = 0;
    if(obj.offsetParent) {
        while(obj) {
            x += obj.offsetLeft;
            obj = obj.offsetParent;
        }
    }else if(obj.x) {
        x += obj.x;
    }
    return x;
}
function getY_{{ $data['zid'] }}(obj) {
    var y = 0;
    if(obj.offsetParent) {
        while(obj) {
            y += obj.offsetTop;
            obj = obj.offsetParent;
        }
    }else if(obj.y) {
        y += obj.y;
    }
    return y;
}

(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

ga('create','UA-60304488-1', 'auto', {'name': '_gaYomedia'});
ga('_gaYomedia.send','pageview');
ga('_gaYomedia.send', 'event', 'FL{{ $data['fid'] }}', 'Ads Success', 'BannerFW{{ $data['fpid'] }}');

showYoMediaBannerAd_{{ $data['zid'] }}(1);
