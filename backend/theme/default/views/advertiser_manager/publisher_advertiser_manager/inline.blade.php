<VAST version="2.0">
    <Ad id="{{$ad->id}}">
        <InLine>
            <AdSystem>{{Config::get('vast.adSystem')}}</AdSystem>
            <AdTitle>{{$ad->name}}</AdTitle>
            <?php 
	    	    $array_source = explode('.', trim($ad->source_url));
                $ext = end($array_source);
                $creativeType = '';
                switch ($ext) {
                    case 'flv':
                        $creativeType = 'video/x-flv';
                        break;
                    case 'mp4':
                        $creativeType = 'video/mp4';
                        break;
                    case 'swf':
                        $creativeType = 'application/x-shockwave-flash';break;
                    case 'png':
                        $creativeType = 'image/png';break;
                    case 'jpg':
                        $creativeType = 'image/jpeg';break;
                    case 'gif':
                        $creativeType = 'image/gif';break;
                }
	    	?>
            <Creatives>
			    <Creative>
			    	@if($ad->video_linear == 'linear')
					<Linear>
			            <MediaFiles>
			                <MediaFile bitrate="{{$ad->video_bitrate}}" delivery="progressive" height="480" maintainAspectRatio="true" scalable="true" type="{{$creativeType}}" width="{{$ad->width}}"><![CDATA[{{$ad->source_url}}]]></MediaFile>
			            </MediaFiles>
			        </Linear>
			    	@else
			    	
					<NonLinearAds>
			            {{$ad->nonLinearTracks}}
			            <NonLinear height="480" width="640" minSuggestedDuration="{{$ad->durationText}}">
			                <StaticResource creativeType="{{$creativeType}}"><![CDATA[{{$ad->source_url}}]]></StaticResource>
			                <NonLinearClickThrough><![CDATA[{{$ad->trackClick}}]]></NonLinearClickThrough>             
			            </NonLinear>
			        </NonLinearAds>
			    	@endif
			    </Creative>        
			</Creatives>
        </InLine>
    </Ad>
</VAST>