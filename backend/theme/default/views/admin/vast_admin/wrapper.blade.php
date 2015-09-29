<VAST version="2.0">
    <Ad id="{{$ad->id}}">
        <Wrapper>
            <AdSystem>{{Config::get('vast.adSystem')}}</AdSystem>
            <VASTAdTagURI><![CDATA[{{$ad->wrapper_tag}}]]></VASTAdTagURI>
            @if(empty($ad->isBackupAd))
            {{$ad->impTracksTag}}
            <Creatives>
                <Creative id="{{$ad->id}}">
                    {{-- LINEAR ADS --}}
                    @if($ad->linear)
                    <Linear>
                        {{$ad->linearTracks}}
                        <VideoClicks>
                            <ClickTracking id="tracking_click"><![CDATA[{{$ad->trackClick}}]]></ClickTracking>
                        </VideoClicks>
                    </Linear>    
                    @else
                    {{-- NON-LINEAR ADS --}}}
                    <NonLinearAds>
                        {{$ad->nonLinearTracks}}
                    </NonLinearAds>
                    @endif
                </Creative> 
                {{--TODO : COMPANION ADS --}}
                <Creative id="{{$ad->id}}">
                    <CompanionAds></CompanionAds>
                </Creative>
            </Creatives>
            @endif
        </Wrapper>
    </Ad>
</VAST>