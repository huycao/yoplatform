<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Yomedia Demo Ads on Player</title>
    <link rel="stylesheet" href="{{URL::to('/backend/theme/default/assets/css/normalize.css')}}">
    <link rel="stylesheet" href="{{URL::to('/backend/theme/default/assets/css/demo-vast.css')}}">
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
    <script type="text/javascript" src="{{URL::to('/public/source/js/jwplayer5/jwp5.js')}}"></script>
    <script type="text/javascript" src="{{URL::to('/public/js/swfobject.js')}}"></script>
    <script>
        <?php
            $assetURL = URL::to('/public') . "/";
        ?>
        @if ($isActive)
			var tag = "{{URL::Route('PublisherAdvertiserManagerShowPreviewVast', $data->ad->id)}}"; 
        @else
        	var tag = "{{URL::Route('PublisherAdvertiserManagerShowPreviewVast', 0)}}";
        @endif
        
        var assetURL = '{{$assetURL}}';
        var defaultObj = {
            player : 'player',
            
            adTag : tag,
            vastXML : '',
            mediaFile : "{{$assetURL}}video/pub-video.mp4",
            mediaImage:"{{$assetURL}}video/traintracks480.jpg"
        }
    </script>

</head>
<?php
$site = Input::get('s');
switch ($site) {
    case 'p14':
        $site = 'phim14';
        $w = 657;
        $h = 430;
        break;
    case '3s':
        $site = 'phim3s';
        $w = 652;
        $h = 400;
        break;
    case 'hh':
        $site = 'hayhaytv';
        $w = 960;
        $h = 480;
        break;
    default:
        $site = 'tvtuoitre';
        $w = 569;
        $h = 357;
        break;
}
?>
<body class="demo_vast {{$site}}" style="background: url({{$assetURL}}images/demo/{{$site}}.jpg) top center no-repeat">
<div class="container">
    <a id="btn_play" href="javascript:;"></a>
    <div class="text-center">
        <div id="player_container">
            <div id="player"></div>
        </div>
    </div>
</div>
<div class="mask">

</div>
<?php

?>
<script type="text/javascript">
    $('#player_container').html('<div id="player"></div>');
    jwplayer(defaultObj.player).setup({
        autoplay : true,
        "flashplayer": "{{$assetURL}}source/flash/jwplayer5/player.swf",
        "playlist": [{
            "file": defaultObj.mediaFile
        }],
        "width": {{$w}},
        "height": {{$h}},
        "controlbar": {
            "position": "bottom"
        },
        "plugins": {
            @if(!Input::get('pause'))
            "ova-jw": {
                "ads": {
                    "skipAd": {
                        "enabled": "true"
                    },
                    "schedule": [{
                        "position": "pre-roll",
                        "tag": defaultObj.adTag
                    }]
                }
            },
            @endif

        }
    });

</script>

</body>
</html>
