<?php
$filterAlls = getFilterAll();
$filters = getFilter(Input::get('filter', array()));

?>
<style>
    .blue {
        color: blue;
    }
</style>
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

    <form class="form-inline" action="" method="GET">
        <div class="col-md-12">
            <div class="form-group">
                <select data-placeholder="Choose a website..." style="width:350px;" name="website[]" multiple
                        class="chosen-select">
                    @if($listswebsite != null)
                        @foreach($listswebsite as $website)

                            @if(array_search($website['website_id'],$websites) !== false)
                                <option value="{{ $website['website']['id'] }}"
                                        selected="selected">{{ $website['website']['name'] }}</option>
                            @else
                                <option value="{{ $website['website']['id'] }}">{{ $website['website']['name'] }}</option>
                            @endif

                        @endforeach
                    @endif
                </select>
            </div>
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
                            <li><input type="checkbox" class="filterAll" name="filterAll" aria-label=""
                                       value="All" @if(Input::get('filterAll') == 'All') checked="checked" @endif> All
                            </li>
                            @foreach($filterAlls as $filterAll)

                                <li><input type="checkbox" class="filter" name="filter[]"
                                    @if(!(in_array($filterAll,$filters) === false))
                                           checked="checked"
                                           @endif
                                           aria-label="" value="{{ $filterAll }}"> {{ $filterAll }}</li>
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
                <input type="submit" class="btn btn-primary" value="show">
            </div>
        </div>
        <input type="hidden" name="generate-report" value="{{ Input::get('generate-report') }}">
        <input type="hidden" name="view" value="detail">
        @foreach( $range as $select )
            <input type="hidden" name="selected[]" value="{{ $select }}">
        @endforeach
    </form>
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
                        <th></th>
                        <th>No.</th>
                        <th>Website</th>
                        <th>Ads Success</th>
                        @foreach($filters as $filter)
                            <th>{{ $filter }}</th>
                            @if($filter =='Impressions' || $filter =='Clicks')
                                <th>Unique {{ $filter }}</th>
                            @endif
                        @endforeach
                        <th>Pay</th>
                    </tr>

                    <?php
                        $sumAdsRequest = 0;
                        $sumImpression = 0;
                        $sumUniqueImpression = 0;
                        $sumFrequency = 0;
                        $sumClick = 0;
                        $sumUniqueClick = 0;
                        $sumCTR = 0;
                        $sumAmount = 0;
                        $sumFirstquartile = 0;
                        $sumStart = 0;
                        $sumMidpoint = 0;
                        $sumThirdquartile = 0;
                        $sumComplete = 0;
                        $sumPause = 0;
                        $sumMute = 0;
                        $sumUnmute = 0;
                        $sumFullscreen = 0;
                        
                        $sumAdsRequestOver = 0;
                        $sumImpressionOver = 0;
                        $sumUniqueImpressionOver = 0;
                        $sumFrequencyOver = 0;
                        $sumClickOver = 0;
                        $sumUniqueClickOver = 0;
                        $sumCTROver = 0;
                        $sumAmountOver = 0;
                        $sumStartOver = 0;
                        $sumFirstquartileOver = 0;
                        $sumMidpointOver = 0;
                        $sumThirdquartileOver = 0;
                        $sumCompleteOver = 0;
                        $sumPauseOver = 0;
                        $sumMuteOver = 0;
                        $sumUnmuteOver = 0;
                        $sumFullscreenOver = 0;
                    ?>

                    @if( !empty($listWebsiteTracking[$flight->id]) )

                        <?php $flightTracking = $listWebsiteTracking[$flight->id]; ?>

                        <?php $no = 0; ?>
                        @foreach( $flightTracking as $tracking )
                            <?php
                                $no++;
                                $frequency = 0;
                                $impressionRow = $tracking['total_impression'] + $tracking['total_impression_over'];
                                $uniqueImpressionRow = $tracking['total_unique_impression'] + $tracking['total_unique_impression_over'];
                                if ($uniqueImpressionRow > 0) {
                                    $frequency = number_format(($impressionRow / $uniqueImpressionRow), 2);
                                }
    
                                $ctr = 0;
                                if ($impressionRow) {
                                    $ctr = number_format(($tracking['total_click'] + $tracking['total_click_over']) / $impressionRow * 100, 2);
                                }
    
    
                                $sumAdsRequest += $tracking['total_ads_request'];
                                $sumImpression += $tracking['total_impression'];
                                $sumUniqueImpression += $tracking['total_unique_impression'];
                                $sumClick += $tracking['total_click'];
                                $sumStart += $tracking['total_start'];
                                $sumFirstquartile += $tracking['total_firstquartile'];
                                $sumMidpoint += $tracking['total_midpoint'];
                                $sumThirdquartile += $tracking['total_thirdquartile'];
                                $sumComplete += $tracking['total_complete'];
                                $sumPause += $tracking['total_pause'];
                                $sumMute += $tracking['total_mute'];
                                $sumUnmute += $tracking['total_unmute'];
                                $sumFullscreen += $tracking['total_fullscreen'];
                                
                                $sumAdsRequestOver += $tracking['total_ads_request_over'];
                                $sumImpressionOver += $tracking['total_impression_over'];
                                $sumUniqueImpressionOver += $tracking['total_unique_impression_over'];
                                $sumClickOver += $tracking['total_click_over'];
                                $sumStartOver += $tracking['total_start_over'];
                                $sumFirstquartileOver += $tracking['total_firstquartile_over'];
                                $sumMidpointOver += $tracking['total_midpoint_over'];
                                $sumThirdquartileOver += $tracking['total_thirdquartile_over'];
                                $sumCompleteOver += $tracking['total_complete_over'];
                                $sumPauseOver += $tracking['total_pause_over'];
                                $sumMuteOver += $tracking['total_mute_over'];
                                $sumUnmuteOver += $tracking['total_unmute_over'];
                                $sumFullscreenOver += $tracking['total_fullscreen_over'];
                                $amount = 0;
                                if ($flight->cost_type == 'cpm') {
                                    $amount = $tracking['total_impression_pay'];
                                } elseif ($flight->cost_type == 'cpc') {
                                    $amount = $tracking['total_click_pay'];
                                } elseif ($flight->cost_type == 'cpv') {
                                    $amount = $tracking['total_complete_pay'];
                                }
                                $sumAmount += $amount;

                            ?>
                            <tr>
                                <td align="center"><span class="view-date-site" style="cursor: pointer"><span
                                                class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> View Date</span>
                                </td>
                                <td>{{$no}}
                                    <div class="flight hidden">{{ $flight->id }}</div>
                                    <div class="campaign hidden">{{ $flight->campaign->id }}</div>
                                    <div class="site hidden">{{$tracking['website']['id']}}</div>
                                    <?php $ad = $flight->ad;  ?>
                                    @if( $ad )
                                        <div class="ad hidden">{{ $flight->ad->id }}</div>
                                    @endif
                                </td>
                                <td><a href="{{$tracking['website']['url']}}"
                                       target="__blank">{{$tracking['website']['name']}}</a></td>
                                <td>{{ number_format($tracking['total_ads_request'] + $tracking['total_ads_request_over'])}}
                                    @if($tracking['total_ads_request_over'])
                                        <span class="blue">({{number_format($tracking['total_ads_request_over'])}})</span>
                                    @endif
                                </td>
								@foreach ($filters as $filter=>$label)
                                    @if('Impressions' == $filter)
                                        <td>{{ number_format($impressionRow)}}
                                        	@if($tracking['total_impression_over'])
                                                <span class="blue">({{number_format($tracking['total_impression_over'])}})</span>
                                            @endif
                                        </td>
                                        <td>{{ number_format($uniqueImpressionRow)}}
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
                                <td>{{ number_format($amount) }}</td>
                            </tr>
                        @endforeach
                    @endif

                    <?php

                    $sumFrequency = 0;
                    if (($sumUniqueImpression + $sumUniqueImpressionOver) != 0) {
                        $sumFrequency = number_format(($sumImpression + $sumImpressionOver) / ($sumUniqueImpression + $sumUniqueImpressionOver), 2);
                    }

                    $sumCTR = 0;
                    if (($sumImpression + $sumImpressionOver) != 0) {
                        $sumCTR = number_format(($sumClick + $sumClickOver) / ($sumImpression + $sumImpressionOver) * 100, 2);
                    }
                    ?>

                    <tr>
                        <th colspan="3">Summary</th>
                         <th>{{ number_format($sumAdsRequest + $sumAdsRequestOver)}} <span
                    			class="blue">({{number_format($sumAdsRequestOver)}})</span></th>
                        @foreach ($filters as $filter=>$label)
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
                        <th>{{ number_format($sumAmount) }}</th>
                    </tr>
                </table>
            </div>
        </div>
    @endforeach
@endif
{{ HTML::script("{$assetURL}js/chosen.jquery.min.js") }}
{{ HTML::style("{$assetURL}css/chosen.min.css") }}
<script>
    $(function () {
        $(".chosen-select").chosen();
        $('.input-daterange').datepicker({
            todayBtn: "linked"
        });

        $('.view-date-site').click(function () {
            $tr = $(this).parent().parent();
            var flight = $tr.find(".flight").html();
            var campaign = $tr.find(".campaign").html();
            var ad = $tr.find(".ad").html();
            var site = $tr.find(".site").html();
            var filter ={{ json_encode($filters) }};
            var dstart = @if($start_date_range =="") ''
            @else '{{date("Y-m-d",strtotime($start_date_range))}}' @endif;
            var dend = @if($end_date_range =="") ''
            @else '{{date("Y-m-d",strtotime($end_date_range))}}' @endif;
            $('#myModal .modal-dialog').css("width", "800px");
            $('#myModal .modal-body').html('<img src="{{ $assetURL.'img/loading-d.GIF' }}"/>');
            $('#myModal').modal("show");
            $.ajax({
                url: '{{ Url::route("CampaignAdvertiserManagerReportDateWebsite") }}',
                data: {
                    flight: flight,
                    campaign: campaign,
                    ad: ad,
                    dstart: dstart,
                    dend: dend,
                    site: site,
                    filter: filter
                },
                type: 'POST',
                success: function (data) {
                    $('#myModal .modal-body').html(data);

                }
            });
        });
        $("#dropdownMenu").click(function () {
            $("#dropdownMenuFilter").slideToggle();
        });
        $('.filterAll').click(function (event) {  //on click
            if (this.checked) { // check select status
                $('.filter').each(function () { //loop through each checkbox
                    this.checked = true;  //select all checkboxes with class "checkbox1"
                });
            } else {
                $('.filter').each(function () { //loop through each checkbox
                    this.checked = false; //deselect all checkboxes with class "checkbox1"
                });
            }
        });
        $('.filter').click(function () { //loop through each checkbox
            $('.filterAll').each(function () { //loop through each checkbox
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
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
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