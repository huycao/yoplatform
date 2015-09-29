<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Yomedia Demo Balloon Standard</title>

    <style>

        .overlay{
            width: 100%;
            height: 100%;
            position: fixed;
            background: #000;
            opacity: 0.3;
            z-index: 1000;
            top: 0px;
            left: 0px;
        }

    </style>

</head>

<body>

<div class="container">
    <img src="/demo/vib-balloon/datviet.jpg" alt="">
    <div class="overlay"></div>
</div>

<script type="text/javascript">
    var _avlVar = _avlVar || [];
    var _avlDemo = true;
    _avlVar.push(["20", "{{trim($data->ad->id)}}", "Balloon"]);
</script>
<script src="/public/source/advalue.js" type="text/javascript"></script>
@if ($isActive)
<script type="text/javascript">

    <?php
	    
	    $wrapperAds = 'YoMediaBalloon';
	    $elAds = "YoMediaBalloon_".$data['zid'];
	    $expandWidth = max($data->ad->width_after, $data->ad->width);
	    $expandHeight = max($data->ad->height_after, $data->ad->height);
	    $preExpandWidth = min($data->ad->width_after, $data->ad->width);
	    $preExpandHeight = min($data->ad->height_after, $data->ad->height);

	    if( !empty( $data->ad->third_impression_track ) ){
	        $thirdImpressionTrackArr = explode("\n", $data->ad->third_impression_track);
	    }else{
	        $thirdImpressionTrackArr = [];   
	    }

	    if( !empty( $data->ad->third_click_track ) ){
	        $thirdClickTrackArr = explode("\n", $data->ad->third_click_track);
	    }else{
	        $thirdClickTrackArr = [];   
	    }

	?>

	avlHelperModule.loadAvlStyle();

	function showYoMediaPopupAd_{{$data['zid']}}(s) {
	    var eWidth = parseInt('{{$expandWidth}}');
	    var eHeight = parseInt('{{$expandHeight}}');
	    var iWidth = parseInt('{{$preExpandWidth}}');
	    var iHeight = parseInt('{{$preExpandHeight}}');
	    var sPos = 'right-bottom';

	    var flash = '{{$data->ad->source_url}}';
	    var impressionTrack = encodeURIComponent("{{URL::to('/')}}/track?evt=impression&aid={{$data['aid']}}&fpid={{$data['fpid']}}&zid={{$data['zid']}}&rt=1&cs={{$data['checksum']}}{{ !empty($data['ovr']) ? "&ovr=1" : '' }}");
	<?php if(!empty($thirdImpressionTrackArr)){ ?>
	    <?php foreach( $thirdImpressionTrackArr as $item ){ ?>
	        impressionTrack += '|'+encodeURIComponent("{{trim(str_replace('[timestamp]', time(), $item))}}");
	    <?php } ?>
	<?php } ?>

	    
	    var clickTag = encodeURIComponent("{{URL::to('/')}}/track?evt=click&aid={{$data['aid']}}&fpid={{$data['fpid']}}&zid={{$data['zid']}}&rt=1&to={{urlencode($data->ad->destination_url)}}&cs={{$data['checksum']}}{{ !empty($data['ovr']) ? "&ovr=1" : '' }}");
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
	    

	    var ff = flash+'?impression='+impressionTrack+"&clickTrack="+clickTrack+"&clickUrl="+clickTag;

	    Default ='';

	    avlInteractModule.initBalloon(
	        '{{$wrapperAds}}','{{$elAds}}',iWidth,iHeight,eWidth,eHeight,ff,Default,'VIB',parseInt('{{$data['zid']}}'),'popup','top-down','{{$data->ad->flash_wmode}}','VN', parseInt('1'),sPos
	    );
	    avlInteractModule.showBalloon('{{$wrapperAds}}', sPos, iWidth, iHeight, eWidth, eHeight, '{{$elAds}}', 'min', parseInt('30000'), parseInt('900000'));
	}


	function minYoMediaPopupAd_{{$data['zid']}}() {
	    var sPos = 'right-bottom';
	    avlInteractModule.rectAd('{{$wrapperAds}}', 'top-down', sPos, 'min', parseInt('{{$preExpandWidth}}'), parseInt('{{$preExpandHeight}}'), parseInt('{{$expandWidth}}'), parseInt('{{$expandHeight}}'), 100);
	}


	function restoreYoMediaPopupAd_{{$data['zid']}}() {
	    var sPos = 'right-bottom';
	    avlInteractModule.rectAd('{{$wrapperAds}}', 'top-down', sPos, 'max', parseInt('{{$preExpandWidth}}'), parseInt('{{$preExpandHeight}}'), parseInt('{{$expandWidth}}'), parseInt('{{$expandHeight}}'), 100);
	}

	function setYoMediaExpand_{{$data['zid']}}() {
	    var sPos = 'right-bottom';
	    avlInteractModule.rectExpand('{{$wrapperAds}}', 'ex', sPos, parseInt('{{$preExpandWidth}}'), parseInt('{{$preExpandHeight}}'), parseInt('{{$expandWidth}}'), parseInt('{{$expandHeight}}'));
	}


	function setYoMediaPre_{{$data['zid']}}() {
	    var sPos = 'right-bottom';
	    avlInteractModule.rectExpand('{{$wrapperAds}}', 'pre', sPos, parseInt('{{$preExpandWidth}}'), parseInt('{{$preExpandHeight}}'), parseInt('{{$expandWidth}}'), parseInt('{{$expandHeight}}'));
	}

	function closeYoMediaPopupAd_{{$data['zid']}}() {
	    avlInteractModule.closeAd('{{$wrapperAds}}', parseInt('900000'), 'showYoMediaPopupAd_{{$data['zid']}}');
	}

	showYoMediaPopupAd_{{$data['zid']}}(1);


</script>
@endif
</body>
</html>
