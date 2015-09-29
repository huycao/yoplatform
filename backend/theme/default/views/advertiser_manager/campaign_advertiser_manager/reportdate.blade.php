<?php
$filterAlls =getFilterAll();
$filters =  getFilter(Input::get('filter',array()));
?>
<table class="table table-condensed table-bordered">
    <tr>
        <td width="25%">Campaign</td>
        <td>
            <div class="row">
                <div class="col-md-12">({{ $tracking['campaign']['id'] or '-' }}) {{ $tracking['campaign']['name'] }}</div>
            </div>
        </td>
    </tr>
    <tr>
        <td width="25%">Flight</td>
        <td>
            <div class="row">
                <div class="col-md-12">({{ $tracking['flight']['id'] or '-' }}) {{ $tracking['flight']['name'] }}</div>
            </div>
        </td>
    </tr>
    <tr>
        <td width="25%">Ad</td>
        <td>
            @if( $tracking['ad'] )
                <div class="row">
                    <div class="col-md-12">({{ $tracking['ad']['id'] or '-' }}) {{ $tracking['ad']['name'] }}</div>
                </div>
            @endif
        </td>
    </tr>
    <tr>
        <td width="25%">Date</td>
        <td>
            <div class="row">
                <div class="col-md-12">{{date('d/m/Y', strtotime($tracking['date']))}}</div>
            </div>
        </td>
    </tr>
</table>
<table class="table table-striped table-hover">
    <tr>
        @if($typeapp == 'site')
            <th>Site</th>
        @else
            <th>Hour</th>
        @endif

        <th>Ads Success</th>
        @foreach($filters as $filter=>$namefilter)
            <th>{{ $namefilter }}</th>
            @if($namefilter =='Impressions' || $namefilter =='Clicks' )
                <th>Unique {{ $namefilter }}</th>
            @endif
        @endforeach
    </tr>
    <?php
        $sumAdsRequest = 0;
        $sumImpression = 0;
        $sumUniqueImpression = 0;
        $sumFrequency = 0;
        $sumClick = 0;
        $sumUniqueClick = 0;
        $sumCTR = 0;
        $sumAdsRequestOver = 0;
        $sumImpressionOver = 0;
        $sumUniqueImpressionOver = 0;
        $sumClickOver = 0;
        $sumUniqueClick = 0;
        $sumUniqueClickOver = 0;
        $sumStart = 0;
        $sumStartOver = 0;
        $sumFirstquartile = 0;
        $sumFirstquartileOver = 0;
        $sumMidpoint = 0;
        $sumMidpointOver = 0;
        $sumThirdquartile = 0;
        $sumThirdquartileOver = 0;
        $sumComplete = 0;
        $sumCompleteOver = 0;
        $sumPause = 0;
        $sumPauseOver = 0;
        $sumMute = 0;
        $sumMuteOver = 0;
        $sumUnmute = 0;
        $sumUnmuteOver = 0;
        $sumFullscreen = 0;
        $sumFullscreenOver = 0;
    ?>


        @if( !empty($tracking['summary']) )
            @foreach($tracking['summary'] as $tracking )
                <?php
                $frequency = 0;
                if (($tracking['total_unique_impression'] + $tracking['total_unique_impression_over']) > 0) {
                    $frequency = number_format(($tracking['total_impression'] + $tracking['total_impression_over']) / ($tracking['total_unique_impression'] + $tracking['total_unique_impression_over']), 2);
                }

                $ctr = 0;
                if (($tracking['total_impression'] + $tracking['total_impression_over']) > 0) {
                    $ctr = number_format(($tracking['total_click'] + $tracking['total_click_over']) / ($tracking['total_impression'] + $tracking['total_impression_over']) * 100, 2);
                }


                $sumAdsRequest += $tracking['total_ads_request'];
                $sumAdsRequestOver += $tracking['total_ads_request_over'];
                $sumImpression += $tracking['total_impression'];
                $sumImpressionOver += $tracking['total_impression_over'];
                $sumUniqueImpression += $tracking['total_unique_impression'];
                $sumUniqueImpressionOver += $tracking['total_unique_impression_over'];
                $sumClick += $tracking['total_click'];
                $sumClickOver += $tracking['total_click_over'];
                $sumUniqueClick += $tracking['total_unique_click'];
                $sumUniqueClickOver += $tracking['total_unique_click_over'];
                $sumStart += $tracking['total_start'];
                $sumStartOver += $tracking['total_start_over'];
                $sumFirstquartile += $tracking['total_firstquartile'];
                $sumFirstquartileOver += $tracking['total_firstquartile_over'];
                $sumMidpoint += $tracking['total_midpoint'];
                $sumMidpointOver += $tracking['total_midpoint_over'];
                $sumThirdquartile += $tracking['total_thirdquartile'];
                $sumThirdquartileOver += $tracking['total_thirdquartile_over'];
                $sumComplete += $tracking['total_complete'];
                $sumCompleteOver += $tracking['total_complete_over'];
                $sumPause += $tracking['total_pause'];
                $sumPauseOver += $tracking['total_pause_over'];
                $sumMute += $tracking['total_mute'];
                $sumMuteOver += $tracking['total_mute_over'];
                $sumUnmute += $tracking['total_unmute'];
                $sumUnmuteOver += $tracking['total_unmute_over'];
                $sumFullscreen += $tracking['total_fullscreen'];
                $sumFullscreenOver += $tracking['total_fullscreen_over'];
                $impressionRow = $tracking['total_impression'] + $tracking['total_impression_over'];
                ?>
                <tr >
                    @if($typeapp == 'site')
                        <td>
                            @if(!empty($tracking['website']))
                            {{$tracking['website']['name']}}
                            @endif
                        </td>
                    @else
                        <td>{{$tracking['hour']}}
                        </td>
                    @endif

                    <td>{{ number_format($tracking['total_ads_request'] + $tracking['total_ads_request_over'])}}
                        @if($tracking['total_ads_request_over'])
                            <span class="blue">({{number_format($tracking['total_ads_request_over'])}})</span>
                        @endif
                    </td>
                    @foreach ($filters as $filter=>$nameFilter)
                        @if('Impressions' == $filter)
                            <td>{{ number_format($tracking['total_impression'] + $tracking['total_impression_over'])}}
                                @if($tracking['total_impression_over'])
                                    <span class="blue">({{number_format($tracking['total_impression_over'])}})</span>
                                @endif
                            </td>
                            <td>{{ number_format($tracking['total_unique_impression'] + $tracking['total_unique_impression_over'])}}
                                @if($tracking['total_unique_impression_over'])
                                    <span class="blue">({{number_format($tracking['total_unique_impression_over'])}})</span>
                                @endif
                            </td>
                        @endif
                        @if('Frequency' == $filter)
                            <td>{{ $frequency }}</td>
                        @endif
                        @if('Clicks' == $filter)
                            <td>{{ number_format($tracking['total_click'] + $tracking['total_click_over'])}}
                                @if($tracking['total_click_over'])
                                    <span class="blue">({{number_format($tracking['total_click_over'])}})</span>
                                @endif
                            </td>
                            <td>{{ number_format($tracking['total_unique_click'] + $tracking['total_unique_click_over'])}}
                                @if($tracking['total_unique_click_over'])
                                    <span class="blue">({{number_format($tracking['total_unique_click_over'])}})</span>
                                @endif
                            </td>
                        @endif
                        @if('CTR' == $filter)
                            <td>{{ $ctr }}%</td>
                        @endif
                        @if('Start' == $filter)
                            <td>{{ ($impressionRow > 0) ? number_format(($tracking['total_start'] + $tracking['total_start_over']) / $impressionRow * 100, 2) : 0 }}
                                %
                            </td>
                        @endif
                        @if('Firstquartile' == $filter)
                            <td>{{ ($impressionRow > 0) ? number_format(($tracking['total_firstquartile'] + $tracking['total_firstquartile_over']) / $impressionRow * 100, 2) : 0 }}
                                %
                            </td>
                        @endif
                        @if('Midpoint' == $filter)
                            <td>{{ ($impressionRow > 0) ? number_format(($tracking['total_midpoint'] + $tracking['total_midpoint_over']) / $impressionRow * 100, 2) : 0 }}
                                %
                            </td>
                        @endif
                        @if('Thirdquartile' == $filter)
                            <td>{{ ($impressionRow > 0) ? number_format(($tracking['total_thirdquartile'] + $tracking['total_thirdquartile_over']) / $impressionRow * 100, 2) : 0 }}
                                %
                            </td>
                        @endif
                        @if('Complete' == $filter)
                            <td>{{ ($impressionRow > 0) ? number_format(($tracking['total_complete'] + $tracking['total_complete_over']) / $impressionRow * 100, 2) : 0 }}
                                %
                            </td>
                        @endif
                        @if('Pause' == $filter)
                            <td>{{ ($impressionRow > 0) ? number_format(($tracking['total_pause'] + $tracking['total_pause_over']) / $impressionRow * 100, 2) : 0 }}
                                %
                            </td>
                        @endif
                        @if('Mute' == $filter)
                            <td>{{ ($impressionRow > 0) ? number_format(($tracking['total_mute'] + $tracking['total_mute_over']) / $impressionRow * 100, 2) : 0 }}
                                %
                            </td>
                        @endif
                        @if('Unmute' == $filter)
                            <td>{{ ($impressionRow > 0) ? number_format(($tracking['total_unmute'] + $tracking['total_unmute_over']) / $impressionRow * 100, 2) : 0 }}
                                %
                            </td>
                        @endif
                        @if('Fullscreen' == $filter)
                            <td>{{ ($impressionRow > 0) ? number_format(($tracking['total_fullscreen'] + $tracking['total_fullscreen_over']) / $impressionRow * 100, 2) : 0 }}
                                %
                            </td>
                        @endif
                        @if('Conversion' == $filter)
                            <td>0</td>
                        @endif
                    @endforeach
                </tr>
            @endforeach
        @endif

    <?php

    $sumFrequency = 0;
    if (($sumUniqueImpression + $sumUniqueImpressionOver) > 0) {
        $sumFrequency = number_format(($sumImpression + $sumImpressionOver) / ($sumUniqueImpression + $sumUniqueImpressionOver), 2);
    }

    $sumCTR = 0;
    if (($sumImpression + $sumImpressionOver) > 0) {
        $sumCTR = number_format(($sumClick + $sumClickOver) / ($sumImpression + $sumImpressionOver) * 100, 2);
    }
    ?>

    <tfoot>
    <tr>

        <th class="text-center">
            Summary
        </th>
        <th>{{ number_format($sumAdsRequest + $sumAdsRequestOver)}} <span
                    class="blue">({{number_format($sumAdsRequestOver)}})</span></th>
        
        @foreach ($filters as $filter=>$filterName)
        	@if('Impressions' == $filter)
                <th>{{ number_format($sumImpression + $sumImpressionOver)}} <span
                            class="blue">({{number_format($sumImpressionOver)}})</span></th>
                <th>{{ number_format($sumUniqueImpression + $sumUniqueImpressionOver)}} <span
                            class="blue">({{number_format($sumUniqueImpressionOver)}})</span></th>
            @endif
            @if('Frequency' == $filter)
                <th>{{ $sumFrequency }}</th>
            @endif
            @if('Clicks' == $filter)
                <th>{{ number_format($sumClick + $sumClickOver)}} <span
                            class="blue">({{number_format($sumClickOver)}})</span></th>
                <th>{{ number_format($sumUniqueClick + $sumUniqueClickOver)}} <span
                            class="blue">({{number_format($sumUniqueClickOver)}})</span></th>
            @endif
            @if('CTR' == $filter)
                <th>{{ $sumCTR }}%</th>
            @endif
            @if('Start' == $filter)
                <th> {{ (($sumImpression + $sumImpressionOver) > 0) ? number_format(($sumStart + $sumStartOver) / ($sumImpression + $sumImpressionOver) * 100, 2) : 0 }}%</th>
            @endif
            @if('Firstquartile' == $filter)
                <th> {{ (($sumImpression + $sumImpressionOver) > 0) ? number_format(($sumFirstquartile + $sumFirstquartileOver) / ($sumImpression + $sumImpressionOver) * 100, 2) : 0 }}%</th>
            @endif
            @if('Midpoint' == $filter)
                <th> {{ (($sumImpression + $sumImpressionOver) > 0) ? number_format(($sumMidpoint + $sumMidpointOver) / ($sumImpression + $sumImpressionOver) * 100, 2) : 0 }}%</th>
            @endif
            @if('Thirdquartile' == $filter)
                <th>{{ (($sumImpression + $sumImpressionOver) > 0) ? number_format(($sumThirdquartile + $sumThirdquartileOver) / ($sumImpression + $sumImpressionOver) * 100, 2) : 0 }}%</th>
            @endif
            @if('Complete' == $filter)
                <th>{{ (($sumImpression + $sumImpressionOver) > 0) ? number_format(($sumComplete + $sumCompleteOver) / ($sumImpression + $sumImpressionOver) * 100, 2) : 0}}%</th>
            @endif
            @if('Pause' == $filter)
                <th>{{ (($sumImpression + $sumImpressionOver) > 0) ? number_format(($sumPause + $sumPauseOver) / ($sumImpression + $sumImpressionOver) * 100, 2) : 0}}%</th>
            @endif
            @if('Mute' == $filter)
                <th>{{ (($sumImpression + $sumImpressionOver) > 0) ? number_format(($sumMute + $sumMuteOver) / ($sumImpression + $sumImpressionOver) * 100, 2) : 0}}%</th>
            @endif
            @if('Unmute' == $filter)
                <th>{{ (($sumImpression + $sumImpressionOver) > 0) ? number_format(($sumUnmute + $sumUnmuteOver) / ($sumImpression + $sumImpressionOver) * 100, 2) : 0}}%</th>
            @endif
            @if('Fullscreen' == $filter)
                <th>{{ (($sumImpression + $sumImpressionOver) > 0) ? number_format(($sumFullscreen + $sumFullscreenOver) / ($sumImpression + $sumImpressionOver) * 100, 2) : 0}}%</th>
            @endif
            @if('Conversion' == $filter)
                <th>0</th>
            @endif
        @endforeach
    </tr>
    </tfoot>


</table>