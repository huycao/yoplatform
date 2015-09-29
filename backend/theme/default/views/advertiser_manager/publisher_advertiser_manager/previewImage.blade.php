@if ($isActive)
    @if($data->ad->ad_type == 'flash')
        <object type="application/x-shockwave-flash" id="banner" width="{{ $data->ad->width }}" height="{{ $data->ad->height }}"
                data="{{ $data->ad->source_url }}">
            <param name="movie" value="{{ $data->ad->source_url }}">
            <param name="allowScriptAccess" value="always">
            <param name="wmode" value="opaque">
            <param name="allowFullScreen" value="false">
            <param name="flashvars"
                   value="clickTAG={{ $data->ad->destination_url }}">
            <embed style="position:absolute;z-index:1;" id="banner" width="300" height="250"
                   type="application/x-shockwave-flash" pluginspace="http://www.macromedia.com/go/getflashplayer"
                   src="{{ $data->ad->destination_url }}"
                   flashvars="redirectUrl={{ $data->ad->destination_url }}"
                   allowscriptaccess="always" wmode="opaque" allowfullscreen="false">
        </object>
    @elseif($data->ad->ad_type == 'video')
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
                mediaFile : "{{ $data->ad->source_url }}"
            }
            jwplayer(defaultObj.player).setup({
                autoplay : true,
                "flashplayer": "{{$assetURL}}source/flash/jwplayer5/player.swf",
                "playlist": [{
                    "file": defaultObj.mediaFile
                }],
                "width": {{ $data->ad->width }},
                "height": {{ $data->ad->height }},
                "controlbar": {
                    "position": "bottom"
                }
            });
        </script>
    @else
        <a    href="{{ $data->ad->destination_url }}"
                target="_blank"><img
                    src="{{ $data->ad->source_url }}" width="{{ $data->ad->width }}"
                    height="{{ $data->ad->height }}"></a>
    @endif
@endif
