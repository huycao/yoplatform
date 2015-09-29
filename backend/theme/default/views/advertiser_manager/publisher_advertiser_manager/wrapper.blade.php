<VAST version="2.0">
    <Ad id="{{$ad->id}}">
        <Wrapper>
            <AdSystem>{{Config::get('vast.adSystem')}}</AdSystem>
            <VASTAdTagURI><![CDATA[{{$ad->video_wrapper_tag}}]]></VASTAdTagURI>
            @if(empty($ad->isBackupAd))
            
            <Creatives>
                <Creative id="{{$ad->id}}">
                    {{-- LINEAR ADS --}}
                    
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