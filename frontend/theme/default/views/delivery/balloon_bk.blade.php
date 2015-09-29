<?php
    
    $wrapperAds = 'YoMediaBalloon';
    $elAds = "YoMediaBalloon_".$data['zid'];
    $elWidth = $data['ad']->width;
    $elHeight = $data['ad']->height;
    $preExpandWidth = 300;
    $preExpandHeight = 250;

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

function showYoMediaPopupAd_{{$data['zid']}}(s) {
    var eWidth = parseInt('{{$elWidth}}');
    var eHeight = parseInt('{{$elHeight}}');
    var iWidth = parseInt('{{$preExpandWidth}}');
    var iHeight = parseInt('{{$preExpandHeight}}');
    var sPos = 'right-bottom';

    var flash = '{{$data['ad']->source_url}}';
    var impressionTrack = encodeURIComponent("http://yomedia.vn/track?evt=impression&aid={{$data['aid']}}&fpid={{$data['fpid']}}&zid={{$data['zid']}}&rt=1&cs={{$data['checksum']}}");
<?php if(!empty($thirdImpressionTrackArr)){ ?>
    <?php foreach( $thirdImpressionTrackArr as $item ){ ?>
        impressionTrack += '|'+encodeURIComponent("{{trim($item)}}");
    <?php } ?>
<?php } ?>

    
    var clickTag = encodeURIComponent("http://yomedia.vn/track?evt=click&aid={{$data['aid']}}&fpid={{$data['fpid']}}&zid={{$data['zid']}}&rt=1&to={{urlencode($data['ad']->destination_url)}}&cs={{$data['checksum']}}");
    var clickTrack= "";

<?php if(!empty($thirdClickTrackArr)){ ?>
    <?php $count = 0; ?>
    <?php foreach( $thirdClickTrackArr as $item ){ ?>
        <?php $count++; ?>
        <?php if( $count == 1 ){ ?>
            clickTrack += encodeURIComponent("{{trim($item)}}");
        <?php }else{ ?>
            clickTrack += '|'+encodeURIComponent("{{trim($item)}}");
        <?php } ?>
    <?php } ?>
<?php } ?>
    

    var ff = flash+'?impression='+impressionTrack+"&clickTrack="+clickTrack+"&clickTag="+clickTag;

    Default ='';

    avlInteractModule.initBalloon(
    	'{{$wrapperAds}}','{{$elAds}}',iWidth,iHeight,eWidth,eHeight,ff,Default,'VIB',parseInt('{{$data['zid']}}'),'popup','top-down','{{$data['ad']->flash_wmode}}','VN', parseInt('1'),sPos
    );
    avlInteractModule.showBalloon('{{$wrapperAds}}', sPos, iWidth, iHeight, eWidth, eHeight, '{{$elAds}}', 'min', parseInt('30000'), parseInt('900000'));
}


function minYoMediaPopupAd_{{$data['zid']}}() {
    var sPos = 'right-bottom';
    avlInteractModule.rectAd('{{$wrapperAds}}', 'top-down', sPos, 'min', parseInt('{{$preExpandWidth}}'), parseInt('{{$preExpandHeight}}'), parseInt('{{$elWidth}}'), parseInt('{{$elHeight}}'), parseInt('50'));
}


function restoreYoMediaPopupAd_{{$data['zid']}}() {
    var sPos = 'right-bottom';
    avlInteractModule.rectAd('{{$wrapperAds}}', 'top-down', sPos, 'max', parseInt('{{$preExpandWidth}}'), parseInt('{{$preExpandHeight}}'), parseInt('{{$elWidth}}'), parseInt('{{$elHeight}}'), parseInt('50'));
}

function setYoMediaExpand_{{$data['zid']}}() {
    var sPos = 'right-bottom';
    avlInteractModule.rectExpand('{{$wrapperAds}}', 'ex', sPos, parseInt('{{$preExpandWidth}}'), parseInt('{{$preExpandHeight}}'), parseInt('{{$elWidth}}'), parseInt('{{$elHeight}}'));
}


function setYoMediaPre_{{$data['zid']}}() {
    var sPos = 'right-bottom';
    avlInteractModule.rectExpand('{{$wrapperAds}}', 'pre', sPos, parseInt('{{$preExpandWidth}}'), parseInt('{{$preExpandHeight}}'), parseInt('{{$elWidth}}'), parseInt('{{$elHeight}}'));
}

function closeYoMediaPopupAd_{{$data['zid']}}() {
    avlInteractModule.closeAd('{{$wrapperAds}}', parseInt('900000'), 'showYoMediaPopupAd_{{$data['zid']}}');
}

showYoMediaPopupAd_{{$data['zid']}}(1);
