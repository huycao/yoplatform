<?php
$filterAlls =getFilterAll();
$filters =  getFilter(Input::get('filter',array()));
?>
<style>.blue {
        color: blue
    }</style>
<div class="row mb12">
    <div class="col-md-12">
        <div class="part">
		<span>
			Flight Report
		</span>
            <a href="{{ $url }}">View By Date</a>
            |
            <a href="{{ $url.'&view=detail' }}">View By Webiste</a>
        </div>
    </div>
    <div class="col-md-12">
        <form class="form-inline" action="" method="GET">
            <div class="form-group">
                <div class="input-daterange input-group" id="datepicker">
                    <input type="text" class="form-control" name="start_date_range" value="{{ $start_date_range }}"
                           id="start_date_range">
                    <span class="input-group-addon">to</span>
                    <input type="text" class="form-control" name="end_date_range" value="{{ $end_date_range}}"
                           id="end_date_range">
                </div>
                <div class=" selectreport" style="display:inline-block;margin-right: 15px;">
                    <div class="">
                        <button class="btn btn-default" type="button" id="dropdownMenu">
                            Metrics <span class="caret"></span>
                        </button>
                        <ul id="dropdownMenuFilter" class="dropdown-menu" role="menu">
                            <li ><input type="checkbox" class="filterAll" name="filterAll" aria-label="" value="All" @if(Input::get('filterAll') == 'All') checked="checked" @endif> All</li>
                            @foreach($filterAlls as $filterAll=>$filterAllName)

                                <li ><input type="checkbox" class="filter" name="filter[]"
                                    @if(isset($filters[$filterAll]))
                                            checked="checked"
                                            @endif
                                            aria-label="" value="{{ $filterAll }}"> {{ $filterAllName }}</li>
                            @endforeach

                            <li class="btn-ok">
                                <button class="btn btn-primary" type="submit">
                                    OK
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Show">
            </div>
            <input type="hidden" name="generate-report" value="{{ Input::get('generate-report') }}">
            @foreach( $range as $select )
                <input type="hidden" name="selected[]" value="{{ $select }}">
            @endforeach

        </form>
    </div>
</div>


@if(  !empty($listFlight) && $listFlight->count() )
    @foreach( $listFlight as $flight )
        <div class="box mb12">
            <div class="">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-condensed table-bordered">
                            <tr>
                                <td width="25%">Campaign</td>
                                <td>
                                    <div class="row">
                                        <div class="col-md-12">({{ $flight->campaign->id or '-' }}) {{ $flight->campaign->name }}</div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td width="25%">Flight</td>
                                <td>
                                    <div class="row">
                                        <div class="col-md-12">({{ $flight->id or '-' }}) {{ $flight->name }}</div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td width="25%">Ad</td>
                                <td>
                                    <?php $ad = $flight->ad;  ?>
                                    @if( $ad )
                                        <div class="row">
                                            <div class="col-md-12">({{ $ad->id or '-' }}) {{ $ad->name }}</div>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <div class="">
                <table class="table table-striped table-hover">
                    <tr>
                        <th class="text-center"  width="15%">View</th>
                        <th>Date</th>
                        <th>Ads Success</th>
                        @foreach($filters as $filter=>$filterName)
                            <th>{{ $filterName }}</th>
                            @if($filter =='Impressions' || $filter =='Clicks' )
                                <th>Unique {{ $filter }}</th>
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
                    $sumStart = 0;
                    $sumFirstquartile = 0;
                    $sumMidpoint = 0;
                    $sumThirdquartile= 0;
                    $sumComplete = 0;
                    $sumPause = 0;
                    $sumMute = 0;
                    $sumUnmute = 0;
                    $sumFullscreen = 0;
                    
                    $sumAdsRequestOver = 0;
                    $sumImpressionOver = 0;
                    $sumUniqueImpressionOver = 0;
                    $sumClickOver = 0;
                    $sumUniqueClick = 0;
                    $sumUniqueClickOver = 0;
                    $sumStartOver = 0;
                    $sumFirstquartileOver = 0;
                    $sumMidpointOver = 0;
                    $sumThirdquartileOver = 0;
                    $sumCompleteOver =0;
                    $sumPauseOver = 0;
                    $sumMuteOver = 0;
                    $sumUnmuteOver = 0;
                    $sumFullscreenOver = 0;
                    ?>
                    @if( !empty($listFlightTracking[$flight->id]) )
                        <?php $flightTracking = $listFlightTracking[$flight->id] ?>
                        @if( !empty($flightTracking) )
                            @foreach( $flightTracking as $tracking )
                                <?php
                                    if (isset($start_date_range) && $start_date_range != "" && (strtotime($tracking['date']) < strtotime($start_date_range) || (strtotime($tracking['date']) > strtotime($end_date_range))) ) {
                                        continue;
                                    }
                                $frequency = 0;
                                if (($tracking['total_impression'] + $tracking['total_impression_over']) > 0 && ($tracking['total_unique_impression'] + $tracking['total_unique_impression_over']) > 0) {
                                    $frequency = number_format(($tracking['total_impression'] + $tracking['total_impression_over']) / ($tracking['total_unique_impression'] + $tracking['total_unique_impression_over']), 2);
                                }

                                $ctr = 0;
                                if (($tracking['total_click'] + $tracking['total_click_over']) > 0 && ($tracking['total_impression'] + $tracking['total_impression_over']) > 0) {
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
                                ?>
                                <tr >
                                    <td align="center" ><span  class="view-date" style="cursor: pointer"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> View Hour</span>&nbsp;&nbsp;<span  class="view-date-site" style="cursor: pointer"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> View Site</span></td>
                                    <td>{{date('d/m/Y', strtotime($tracking['date']))}}
                                    <div class="flight hidden">{{ $flight->id }}</div>
                                    <div class="campaign hidden">{{ $flight->campaign->id }}</div>
                                        <?php $ad = $flight->ad;  ?>
                                        @if( $ad )
                                    <div class="ad hidden">{{ $flight->ad->id }}</div>
                                        @endif
                                    <div class="date hidden">{{ $tracking['date'] }}</div>
                                    </td>
                                    <td>{{ number_format($tracking['total_ads_request'] + $tracking['total_ads_request_over'])}}
                                        @if($tracking['total_ads_request_over'])
                                            <span class="blue">({{number_format($tracking['total_ads_request_over'])}})</span>
                                        @endif
                                    </td>
                                    <?php $impressionRow = $tracking['total_impression'] + $tracking['total_impression_over']; ?>
                                    @foreach ($filters as $filter=>$filterName)
                                        @if('Impressions' == $filter)
                                            <td>{{ number_format($impressionRow)}}
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
                                            <td>{{  ( $impressionRow == 0 ) ? 0 : number_format( ($tracking['total_start'] + $tracking['total_start_over']) / $impressionRow *100, 2) }}%
                                            </td>
                                        @endif
                                        @if('Firstquartile' == $filter)
                                            <td>{{  ( $impressionRow == 0 ) ? 0 : number_format( ($tracking['total_firstquartile'] + $tracking['total_firstquartile_over']) / $impressionRow *100, 2) }}%
                                            </td>
                                        @endif
                                        @if('Midpoint' == $filter)
                                            <td>{{  ( $impressionRow == 0 ) ? 0 : number_format( ($tracking['total_midpoint'] + $tracking['total_midpoint_over']) / $impressionRow *100, 2) }}%
                                            </td>
                                        @endif
                                        @if('Thirdquartile' == $filter)
                                            <td>{{  ( $impressionRow == 0 ) ? 0 : number_format( ($tracking['total_thirdquartile'] + $tracking['total_thirdquartile_over']) / $impressionRow *100, 2) }}%
                                            </td>
                                        @endif
                                        @if('Complete' == $filter)
                                            <td>{{  ( $impressionRow == 0 ) ? 0 : number_format( ($tracking['total_complete'] + $tracking['total_complete_over']) / $impressionRow *100, 2) }}%
                                            </td>
                                        @endif
                                        @if('Pause' == $filter)
                                            <td>{{  ( $impressionRow == 0 ) ? 0 : number_format( ($tracking['total_pause'] + $tracking['total_pause_over']) / $impressionRow *100, 2) }}%
                                            </td>
                                        @endif
                                        @if('Mute' == $filter)
                                            <td>{{  ( $impressionRow == 0 ) ? 0 : number_format( ($tracking['total_mute'] + $tracking['total_mute_over']) / $impressionRow *100, 2) }}%
                                            </td>
                                        @endif
                                        @if('Unmute' == $filter)
                                            <td>{{  ( $impressionRow == 0 ) ? 0 : number_format( ($tracking['total_unmute'] + $tracking['total_unmute_over']) / $impressionRow *100, 2) }}%
                                            </td>
                                        @endif
                                        @if('Fullscreen' == $filter)
                                            <td>{{  ( $impressionRow == 0 ) ? 0 : number_format( ($tracking['total_fullscreen'] + $tracking['total_fullscreen_over']) / $impressionRow *100, 2) }}%
                                            </td>
                                        @endif
                                        @if('Conversion' == $filter)
                                            <td>0</td>
                                        @endif
                                @endforeach
                                </tr>
                            @endforeach
                        @endif
                    @endif
                    <?php

                    $sumFrequency = 0;
                    if ($sumImpression > 0 && $sumUniqueImpression > 0) {
                        $sumFrequency = number_format(($sumImpression + $sumImpressionOver) / ($sumUniqueImpression + $sumUniqueImpressionOver), 2);
                    }

                    $sumCTR = 0;
                    if ($sumClick > 0 && $sumImpression > 0) {
                        $sumCTR = number_format(($sumClick + $sumClickOver) / ($sumImpression + $sumImpressionOver) * 100, 2);
                    }
                    ?>

                    <tr>
					
                        <th colspan="2" class="text-center">
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
                                <th>{{(($sumImpression + $sumImpressionOver)== 0) ? 0 : number_format( ($sumStart + $sumStartOver) / ($sumImpression + $sumImpressionOver) *100, 2) }}%</th>
                            @endif
                            @if('Firstquartile' == $filter)
                                <th>{{(($sumImpression + $sumImpressionOver)== 0) ? 0 : number_format( ($sumFirstquartile + $sumFirstquartileOver) / ($sumImpression + $sumImpressionOver) *100, 2) }}%</th>
                            @endif
                            @if('Midpoint' == $filter)
                                <th>{{(($sumImpression + $sumImpressionOver)== 0) ? 0 : number_format( ($sumMidpoint + $sumMidpointOver) / ($sumImpression + $sumImpressionOver) *100, 2) }}%</th>
                            @endif
                            @if('Thirdquartile' == $filter)
                                <th>{{(($sumImpression + $sumImpressionOver)== 0) ? 0 : number_format( ($sumThirdquartile + $sumThirdquartileOver) / ($sumImpression + $sumImpressionOver) *100, 2) }}%</th>
                            @endif
                            @if('Complete' == $filter)
                                <th>{{(($sumImpression + $sumImpressionOver)== 0) ? 0 : number_format( ($sumComplete + $sumCompleteOver) / ($sumImpression + $sumImpressionOver) *100, 2) }}%</th>
                            @endif
                            @if('Pause' == $filter)
                                <th>{{(($sumImpression + $sumImpressionOver)== 0) ? 0 : number_format( ($sumPause + $sumPauseOver) / ($sumImpression + $sumImpressionOver) *100, 2) }}%</th>
                            @endif
                            @if('Mute' == $filter)
                                <th>{{(($sumImpression + $sumImpressionOver)== 0) ? 0 : number_format( ($sumMute + $sumMuteOver) / ($sumImpression + $sumImpressionOver) *100, 2) }}%</th>
                            @endif
                            @if('Unmute' == $filter)
                                <th>{{(($sumImpression + $sumImpressionOver)== 0) ? 0 : number_format( ($sumUnmute + $sumUnmuteOver) / ($sumImpression + $sumImpressionOver) *100, 2) }}%</th>
                            @endif
                            @if('Fullscreen' == $filter)
                                <th>{{(($sumImpression + $sumImpressionOver)== 0) ? 0 : number_format( ($sumFullscreen + $sumFullscreenOver) / ($sumImpression + $sumImpressionOver) *100, 2) }}%</th>
                            @endif
                            @if('Conversion' == $filter)
                                <th>0</th>
                            @endif
                        @endforeach
                    </tr>


                </table>
            </div>
        </div>
    @endforeach
@endif
<script>
    $(function () {

        $('.input-daterange').datepicker({
            todayBtn: "linked"
        });
        $('.view-date').click(function(){
            $tr = $(this).parent().parent();
            var flight = $tr.find(".flight").html();
            var campaign =$tr.find(".campaign").html();
            var ad = $tr.find(".ad").html();
            var date =$tr.find(".date").html();
            var filter ={{ json_encode($filters) }};
            $('#myModal .modal-dialog').css("width","1000px");
            $('#myModal .modal-body').html('<img src="{{ $assetURL.'img/loading-d.GIF' }}"/>');
            $('#myModal').modal("show");
            $.ajax({
                url:'{{ Url::route("CampaignAdvertiserManagerReportDate") }}',
                data:{flight:flight,campaign:campaign,ad:ad,date:date,filter:filter},
                type:'POST',
                success:function(data){
                    $('#myModal .modal-body').html(data);

                }
            });
        });
        $('.view-date-site').click(function(){
            $tr = $(this).parent().parent();
            var flight = $tr.find(".flight").html();
            var campaign =$tr.find(".campaign").html();
            var ad = $tr.find(".ad").html();
            var date =$tr.find(".date").html();
            var filter ={{ json_encode($filters) }};
            $('#myModal .modal-dialog').css("width","1000px");
            $('#myModal .modal-body').html('<img src="{{ $assetURL.'img/loading-d.GIF' }}"/>');
            $('#myModal').modal("show");
            $.ajax({
                url:'{{ Url::route("CampaignAdvertiserManagerReportDate") }}',
                data:{flight:flight,campaign:campaign,ad:ad,date:date,typeapp:"site",filter:filter},
                type:'POST',
                success:function(data){
                    $('#myModal .modal-body').html(data);

                }
            });
        });
        $("#dropdownMenu").click(function() {
            $("#dropdownMenuFilter").slideToggle();
        });
        $('.filterAll').click(function(event) {  //on click
            if(this.checked) { // check select status
                $('.filter').each(function() { //loop through each checkbox
                    this.checked = true;  //select all checkboxes with class "checkbox1"
                });
            }else{
                $('.filter').each(function() { //loop through each checkbox
                    this.checked = false; //deselect all checkboxes with class "checkbox1"
                });
            }
        });
        $('.filter').click(function() { //loop through each checkbox
            $('.filterAll').each(function() { //loop through each checkbox
                this.checked = false;  //select all checkboxes with class "checkbox1"
            });
        });
    })

</script>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Flight Report</h4>
            </div>
            <div class="modal-body">
                <img src="{{ $assetURL.'img/loading-d.GIF' }}"/>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>