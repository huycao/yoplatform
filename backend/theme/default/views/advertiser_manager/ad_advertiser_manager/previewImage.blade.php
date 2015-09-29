@if($data->ad_type == 'flash')
    <object type="application/x-shockwave-flash" id="banner" width="{{ $data->width }}" height="{{ $data->height }}"
            data="{{ $data->source_url }}">
        <param name="movie" value="{{ $data->source_url }}">
        <param name="allowScriptAccess" value="always">
        <param name="wmode" value="opaque">
        <param name="allowFullScreen" value="false">
        <param name="flashvars"
               value="clickTAG={{ $data->destination_url }}">
        <embed style="position:absolute;z-index:1;" id="banner" width="300" height="250"
               type="application/x-shockwave-flash" pluginspace="http://www.macromedia.com/go/getflashplayer"
               src="{{ $data->destination_url }}"
               flashvars="redirectUrl={{ $data->destination_url }}"
               allowscriptaccess="always" wmode="opaque" allowfullscreen="false">
    </object>
@elseif($data->ad_type == 'video')
    <script type="text/javascript" src="{{URL::to('/public/source/js/jwplayer5/jwp5.js')}}"></script>
    <script type="text/javascript" src="{{URL::to('/public/js/swfobject.js')}}"></script>
    <div id="player"></div>
    <script>
        <?php
            $assetURL = URL::to('/public') . "/";
        ?>
        var assetURL = '{{$assetURL}}';
        var defaultObj = {
            player : 'player',
            mediaFile : "{{ $data->source_url }}"
        }
        jwplayer(defaultObj.player).setup({
            autoplay : true,
            "flashplayer": "{{$assetURL}}source/flash/jwplayer5/player.swf",
            "playlist": [{
                "file": defaultObj.mediaFile
            }],
            "width": {{ $data->width }},
            "height": {{ $data->height }},
            "controlbar": {
                "position": "bottom"
            }
        });
    </script>
@else
    <a    href="{{ $data->destination_url }}"
            target="_blank"><img
                src="{{ $data->source_url }}" width="{{ $data->width }}"
                height="{{ $data->height }}"></a>
@endif
