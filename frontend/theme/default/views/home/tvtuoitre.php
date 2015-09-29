<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>DEMO RUN VAST</title>
    <link rel="stylesheet" href="{{URL::to('/backend/theme/default/assets/css/normalize.css')}}">
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
    <script type="text/javascript" src="{{URL::to('/public/js/swfobject.js')}}"></script>
    <script>
    <?php
        $assetURL = URL::to('/public') . "/";
    ?>
    var assetURL = '{{$assetURL}}';
    var defaultObj = {
        player : 'player',
        adTag : 'http://at.hayhaytv.vn/ads_vast/getvast/51',
        vastXML : '',
        mediaFile : "{{URL::to('/backend/theme/default/assets/video')}}/pub-video.mp4",
        mediaImage:"{{URL::to('/backend/theme/default/assets/video')}}/traintracks480.jpg"
    }
    </script>
    
</head>

<body class="demo_vast tvtuoitre" style="background: url({{$assetURL}}images/demo/phim14.jpg) no-repeat">
<div class="container">
    <a id="btn_play" href="javascript:;"></a>
    <div class="text-center">
        <div id="player_container">
            <div id="player"></div>
        </div>
    </div>
</div>

<script type="text/javascript">
$('#btn_play').click(function(){
   $('#player_container').html('<div id="player"></div>');
    jwplayer(defaultObj.player).setup({
        autoplay : true,
        "flashplayer": assetURL + "/flash/jwplayer5/player.swf",
        "playlist": [{
            "file": defaultObj.mediaFile
        }],
        "width": 960,
        "height": 480,
        "controlbar": {
            "position": "bottom"
        },
        "plugins": {
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
            }
        }
    });
 
})


</script>
<div id="banner_demo"></div>
</body>
</html>
