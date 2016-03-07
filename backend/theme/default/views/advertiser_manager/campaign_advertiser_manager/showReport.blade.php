<?php

$filterAlls = getFilterAll();
$filters = getFilter(Input::get('filter', array()));

?>
<style>
    .blue {
        color: blue;
    }

    .popover {
        max-width: 600px;
        width: auto;
    }
</style>
<div class="row mb12">
    <div class="col-md-12">
        <div class="box">
            <div class="head">Campaign Report</div>
            <table class="table table-striped table-hover table-condensed ">
                <tr>
                    <td width="25%">Campaign</td>
                    <td width="75%" colspan="3"><a
                                href="{{ URL::Route($moduleRoutePrefix.'ShowView',$campaign->id) }}">{{ $campaign->name }}</a>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>

<div class="row mb12">
    <?php
    $sumTotalImpression = $sumTotalUniqueImpression = $sumTotalClick = $sumTotalUniqueClick = $sumTotalImpressionOver = $sumTotalClickOver = $sumTotalUniqueImpressionOver = $sumTotalUniqueClickOver = 0;
    ?>
    @if( !$campaign->flight->isEmpty() && !empty($listFlightTracking) )
        @foreach( $campaign->flight as $flight )
            <?php

            if (isset($listFlightTracking[$flight->id])) {
                $sumTotalImpression += $listFlightTracking[$flight->id]['total_impression'];
                $sumTotalUniqueImpression += $listFlightTracking[$flight->id]['total_unique_impression'];
                $sumTotalClick += $listFlightTracking[$flight->id]['total_click'];
                $sumTotalUniqueClick += $listFlightTracking[$flight->id]['total_unique_click'];
                //over report
                $sumTotalImpressionOver += $listFlightTracking[$flight->id]['total_impression_over'];
                $sumTotalUniqueImpressionOver += $listFlightTracking[$flight->id]['total_unique_impression_over'];
                $sumTotalClickOver += $listFlightTracking[$flight->id]['total_click_over'];
                $sumTotalUniqueClickOver += $listFlightTracking[$flight->id]['total_unique_click_over'];
            }

            ?>
        @endforeach
    @endif


    <?php

    $frequency = 0;
    if ($sumTotalImpression != 0 && $sumTotalUniqueImpression != 0) {
        $frequency = number_format(($sumTotalImpression + $sumTotalImpressionOver) / ($sumTotalUniqueImpression + $sumTotalUniqueImpressionOver), 2);
    }

    $ctr = 0;
    if ($sumTotalClick != 0 && $sumTotalImpression != 0) {
        $ctr = number_format(($sumTotalClick + $sumTotalClickOver) / ($sumTotalImpression + $sumTotalImpressionOver) * 100, 2);
    }

    ?>

    <div class="col-md-6">
        <div class="box">
            <div class="head">Summary</div>
            <table class="table table-striped table-hover table-condensed ">
                <tr>
                    @if(!1)
                    <td class="bg-default" width="25%">Process</td>
                    <td width="75%" colspan="3">
                        <?php
                        $process = 0;

                        $process = $campaign->getProcess($sumTotalImpression + $sumTotalImpressionOver);

                        $processtype = 'danger';
                        if ($process > 40 && $process < 80) {
                            $processtype = 'info';
                        }
                        if ($process > 80) {
                            $processtype = 'success';
                        }
                        ?>
                        <div class="progress">
                            <div class="progress-bar progress-bar-{{ $processtype }}  progress-bar-striped"
                                 role="progressbar" aria-valuenow="{{ $process }}" aria-valuemin="0" aria-valuemax="100"
                                 style="width: {{ $process }}%">
                                {{ $process }}%
                            </div>
                        </div>
                    </td>
                    @endif
                </tr>
                <tr>
                    <td class="bg-default" width="25%">Total Impression</td>
                    <td width="75%" colspan="3">{{number_format($sumTotalImpression + $sumTotalImpressionOver)}} <span
                                class="blue">({{number_format($sumTotalImpressionOver)}})</span></td>
                </tr>
                <tr>
                    <td class="bg-default" width="25%">Total Unique Impression</td>
                    <td width="75%"
                        colspan="3">{{number_format($sumTotalUniqueImpression + $sumTotalUniqueImpressionOver)}} <span
                                class="blue">({{number_format($sumTotalUniqueImpressionOver)}})</span></td>
                </tr>
                <tr>
                    <td class="bg-default" width="25%">Frequency</td>
                    <td width="75%" colspan="3">{{$frequency}} </td>
                </tr>
                <tr>
                    <td class="bg-default" width="25%">Total Clicks</td>
                    <td width="75%" colspan="3">{{number_format($sumTotalClick + $sumTotalClickOver)}} <span
                                class="blue">({{number_format($sumTotalClickOver)}})</span></td>
                </tr>
                <tr>
                    <td class="bg-default" width="25%">Total Unique Clicks</td>
                    <td width="75%" colspan="3">{{number_format($sumTotalUniqueClick + $sumTotalUniqueClickOver)}} <span
                                class="blue">({{number_format($sumTotalUniqueClickOver)}})</span></td>
                </tr>
                <tr>
                    <td class="bg-default" width="25%">CTR</td>
                    <td width="75%" colspan="3">{{$ctr}}%</td>
                </tr>
            </table>
        </div>
    </div>
    <div class="col-md-6">
        <div id="hight-chart"></div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">

        {{
            Form::open(array(
                'role'      =>  'form',
                'class'     =>  'form-horizontal',
                'url'       =>  URL::current(),
                'method'    =>  'get'
            ))
        }}
        <div class="box mb12">
            <div class="head row-fluid">
                <div class="col-md-6">List Flight Of Campaign</div>
                <div class="col-md-6 text-right selectreport">
                    <div class="">
                        <button class="btn btn-default" type="button" id="dropdownMenu">
                            Metrics <span class="caret"></span>
                        </button>
                        <ul id="dropdownMenuFilter" class="dropdown-menu" role="menu">
                            <li><input type="checkbox" class="filterAll" name="filterAll" aria-label=""
                                       value="All" @if(Input::get('filterAll') == 'All') checked="checked" @endif> All
                            </li>
                            @foreach($filterAlls as $filterAll=>$nameFilter)

                                <li><input type="checkbox" class="filter" name="filter[]"
                                    @if(isset($filters[$filterAll]))
                                           checked="checked"
                                           @endif
                                           aria-label="" value="{{ $filterAll }}"> {{ $nameFilter }}</li>
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
            <table class="table table-striped table-hover table-condensed ">
                <tr class="bg-primary">
                    <th><input type="checkbox" id="select-all"></th>
                    <th>ID</th>
                    <th>Flight</th>
                    <th>Status</th>
                    <th>Process</th>
                    <th>Ads Success</th>
                    @foreach($filters as $filter)
                        <th>{{ $filter }}</th>
                        @if($filter =='Impressions' || $filter =='Clicks' )
                            <th>Unique {{ $filter }}</th>
                        @endif
                    @endforeach
                </tr>

                @if( !$campaign->flight->isEmpty() && !empty($listFlightTracking) )
                    @foreach( $campaign->flight as $flight )
                        <?php
                        $totalImpression = $totalUniqueImpression = $totalClick = $totalUniqueClick = $totalAdsRequest = 0;
                        $totalImpressionOver = $totalUniqueImpressionOver = $totalClickOver = $totalUniqueClickOver = $totalAdsRequestOver = 0;

                        $status = $flight->getStatusInventory($campaign);
                        $totalImpression = 0;
                        $totalUniqueImpression = 0;
                        $totalClick = 0;
                        $totalUniqueClick = 0;
                        $totalAdsRequest = 0;
                        $totalFirstquartile = 0;
                        $totalMidpoint = 0;
                        $totalStart = 0;
                        $totalThirdquartile = 0;
                        $totalComplete = 0;
                        $totalPause = 0;
                        $totalMute = 0;
                        $totalUnmute = 0;
                        $totalFullscreen = 0;
                        //over Report
                        $totalImpressionOver = 0;
                        $totalUniqueImpressionOver = 0;
                        $totalClickOver = 0;
                        $totalUniqueClickOver = 0;
                        $totalAdsRequestOver = 0;
                        $totalFirstquartileOver = 0;
                        $totalMidpointOver = 0;
                        $totalThirdquartileOver = 0;
                        $totalCompleteOver = 0;
                        $totalPauseOver = 0;
                        $totalMuteOver = 0;
                        $totalUnmuteOver = 0;
                        $totalFullscreenOver = 0;
                        
                        if (isset($listFlightTracking[$flight->id])) {
                            $totalImpression = $listFlightTracking[$flight->id]['total_impression'];
                            $totalUniqueImpression = $listFlightTracking[$flight->id]['total_unique_impression'];
                            $totalClick = $listFlightTracking[$flight->id]['total_click'];
                            $totalUniqueClick = $listFlightTracking[$flight->id]['total_unique_click'];
                            $totalAdsRequest = $listFlightTracking[$flight->id]['total_ads_request'];
                            $totalStart = $listFlightTracking[$flight->id]['total_start'];
                            $totalFirstquartile = $listFlightTracking[$flight->id]['total_firstquartile'];
                            $totalMidpoint = $listFlightTracking[$flight->id]['total_midpoint'];
                            $totalThirdquartile = $listFlightTracking[$flight->id]['total_thirdquartile'];
                            $totalComplete = $listFlightTracking[$flight->id]['total_complete'];
                            $totalPause = $listFlightTracking[$flight->id]['total_pause'];
                            $totalMute = $listFlightTracking[$flight->id]['total_mute'];
                            $totalUnmute = $listFlightTracking[$flight->id]['total_unmute'];
                            $totalFullscreen = $listFlightTracking[$flight->id]['total_fullscreen'];
                            //over Report
                            $totalImpressionOver = $listFlightTracking[$flight->id]['total_impression_over'];
                            $totalUniqueImpressionOver = $listFlightTracking[$flight->id]['total_unique_impression_over'];
                            $totalClickOver = $listFlightTracking[$flight->id]['total_click_over'];
                            $totalUniqueClickOver = $listFlightTracking[$flight->id]['total_unique_click_over'];
                            $totalAdsRequestOver = $listFlightTracking[$flight->id]['total_ads_request_over'];
                            $totalStartOver = $listFlightTracking[$flight->id]['total_start_over'];
                            $totalFirstquartileOver = $listFlightTracking[$flight->id]['total_firstquartile_over'];
                            $totalMidpointOver = $listFlightTracking[$flight->id]['total_midpoint_over'];
                            $totalThirdquartileOver = $listFlightTracking[$flight->id]['total_thirdquartile_over'];
                            $totalCompleteOver = $listFlightTracking[$flight->id]['total_complete_over'];
                            $totalPauseOver = $listFlightTracking[$flight->id]['total_pause_over'];
                            $totalMuteOver = $listFlightTracking[$flight->id]['total_mute_over'];
                            $totalUnmuteOver = $listFlightTracking[$flight->id]['total_unmute_over'];
                            $totalFullscreenOver = $listFlightTracking[$flight->id]['total_fullscreen_over'];
                        }
                        $flight_dates = $flight->getDate;
                        $tmpdate = "";
                        if (count($flight_dates) > 0) {
                            foreach ($flight_dates as $flight_date) {
                                $tmpdate .= "<p>" . date("m-d-Y", strtotime($flight_date->start)) . ' -> ' . date("m-d-Y", strtotime($flight_date->end)) . "</p>";
                            }
                        }
                        $flight_times = $flight->getTime();
                        $tmptime = "";
                        if (count($flight_times) > 0) {
                            foreach ($flight_times as $flight_time) {
                                $tmptime .= "<p>" . $flight_time['start'] . ' -> ' . $flight_time['end'] . "</p>";
                            }
                        }
                        ?>
                        <tr>
                            <td><input type="checkbox" class="checkbox" name="selected[]" value="{{$flight->id}}"></td>
                            <td>{{$flight->id}}</td>
                            <td class="nameflight"><a
                                        href="{{URL::Route('FlightAdvertiserManagerShowView', $flight->id)}}"
                                        tabindex="0"
                                        data-toggle="popover" data-trigger="hover"
                                        data-popover-content="#a{{$flight->id}}">{{$flight->name}}</a>
                                <!-- Content for Popover #2 -->
                                <div id="a{{$flight->id}}" class="hidden">
                                    <div class="popover-heading">({{ $flight->id}}) {{ $flight->name}}</div>
                                    <div class="popover-body">
                                        <p><b>Cost Type:</b> {{ strtoupper($flight->cost_type) }}</p>

                                        <p><b>Total Inventory:</b> {{ number_format($flight->total_inventory) }}</p>

                                        <p><b>{{trans('text.flight_date')}}:</b> {{$tmpdate}}</p>
                                        @if($tmptime != "")
                                            <p><b>{{trans('text.flight_time')}}:</b> {{$tmptime}}</p>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="text-center">


                                @if($status['status'] == 'play')
                                    <span class="label label-success" data-toggle="popover" data-trigger="hover"
                                          data-popover-content="#status{{$flight->id}}"><span
                                                class="  glyphicon glyphicon-play"></span></span>
                                @else
                                    <span class="label label-danger" data-toggle="popover" data-trigger="hover"
                                          data-popover-content="#status{{$flight->id}}"><span
                                                class="  glyphicon glyphicon-stop"></span></span>
                                    @endif
                                            <!-- Content for Popover #2 -->
                                    <div id="status{{$flight->id}}" class="hidden">
                                        <div class="popover-heading">({{ $flight->id}}) {{ $flight->name}}</div>
                                        <div class="popover-body">
                                            {{ trans($status['msg']) }}
                                        </div>
                                    </div>
                            </td>
                            <td class="text-center">
                                <?php
                                $process = $flight->getProcess();
                                $processtype = 'danger';
                                if ($process > 40 && $process < 80) {
                                    $processtype = 'info';
                                }
                                if ($process > 80) {
                                    $processtype = 'success';
                                }
                                ?>
                                <div class="progress">
                                    <div class="progress-bar progress-bar-{{ $processtype }}  progress-bar-striped"
                                         role="progressbar" aria-valuenow="{{ $process }}" aria-valuemin="0"
                                         aria-valuemax="100" style="width: {{ $process }}%">
                                        {{ $process }}%
                                    </div>
                                </div>
                            </td>
                            <td>{{ number_format($totalAdsRequest + $totalAdsRequestOver)}}
                                @if($totalAdsRequestOver)
                                    <span class="blue">({{number_format($totalAdsRequestOver)}})</span>
                                @endif
                            </td>
                            @foreach($filters as $filter=>$filterName)
                                @if('Impressions' == $filter)
                                    <td>{{ number_format($totalImpression + $totalImpressionOver )}}
                                        @if($totalImpressionOver)
                                            <span class="blue">({{number_format($totalImpressionOver)}})</span>
                                        @endif
                                    </td>
    
                                    <td>{{ number_format($totalUniqueImpression + $totalUniqueImpressionOver)}}
                                        @if($totalUniqueImpressionOver)
                                            <span class="blue">({{number_format($totalUniqueImpressionOver)}})</span>
                                        @endif
                                    </td>
                                @endif
                                @if('Frequency' == $filter)
                                    <td>{{ ( $totalUniqueImpression == 0 ) ? 0 : number_format( ($totalImpression + $totalImpressionOver) / ($totalUniqueImpression + $totalUniqueImpressionOver) , 2) }}</td>
                                @endif
                                @if('Clicks' == $filter)
                                    <td>{{ number_format($totalClick + $totalClickOver)}}
                                        @if($totalClickOver)
                                            <span class="blue">({{number_format($totalClickOver)}})</span>
                                        @endif
                                    </td>
                                    <td>{{ number_format($totalUniqueClick + $totalUniqueClickOver)}}
                                        @if($totalUniqueClickOver)
                                            <span class="blue">({{number_format($totalUniqueClickOver)}})</span>
                                        @endif
                                    </td>
                                @endif
                                @if('CTR' == $filter)
                                    <td>{{  ( ($totalImpression + $totalImpressionOver) == 0 ) ? 0 : number_format( ($totalClick + $totalClickOver) / ($totalImpression + $totalImpressionOver) *100, 2)}}
                                        %
                                    </td>
                                @endif
                                @if('Start' == $filter)
                                    <td>{{  ( ($totalImpression + $totalImpressionOver) == 0 ) ? 0 : number_format( ($totalStart + $totalStartOver) / ($totalImpression + $totalImpressionOver) *100, 2) }}%
                                    </td>
                                @endif
                                @if('Firstquartile' == $filter)
                                    <td>{{  ( ($totalFirstquartile + $totalFirstquartileOver) == 0 ) ? 0 : number_format( ($totalFirstquartile + $totalFirstquartileOver) / ($totalImpression + $totalImpressionOver) *100, 2) }}%
                                    </td>
                                @endif
                                @if('Midpoint' == $filter)
                                    <td>{{  ( ($totalMidpoint + $totalMidpointOver) == 0 ) ? 0 : number_format( ($totalMidpoint + $totalMidpointOver) / ($totalImpression + $totalImpressionOver) *100, 2) }}%
                                    </td>
                                @endif
                                @if('Thirdquartile' == $filter)
                                    <td>{{  ( ($totalThirdquartile + $totalThirdquartileOver) == 0 ) ? 0 : number_format( ($totalThirdquartile + $totalThirdquartileOver) / ($totalImpression + $totalImpressionOver) *100, 2) }}%
                                    </td>
                                @endif
                                @if('Complete'== $filter)
                                    <td>{{  ( ($totalComplete + $totalCompleteOver) == 0 ) ? 0 : number_format( ($totalComplete + $totalCompleteOver) / ($totalImpression + $totalImpressionOver) *100, 2) }}%
                                    </td>
                                @endif
                                @if('Pause' == $filter)
                                    <td>{{  ( ($totalPause + $totalPauseOver) == 0 ) ? 0 : number_format( ($totalPause + $totalPauseOver) / ($totalImpression + $totalImpressionOver) *100, 2) }}%
                                    </td>
                                @endif
                                @if('Mute' == $filter)
                                    <td>{{  ( ($totalMute + $totalMuteOver) == 0 ) ? 0 : number_format( ($totalMute + $totalMuteOver) / ($totalImpression + $totalImpressionOver) *100, 2) }}%
                                    </td>
                                @endif
                                @if('Unmute' == $filter)
                                    <td>{{  ( ($totalUnmute + $totalUnmuteOver) == 0 ) ? 0 : number_format( ($totalUnmute + $totalUnmuteOver) / ($totalImpression + $totalImpressionOver) *100, 2) }}%
                                    </td>
                                @endif
                                @if('Fullscreen' == $filter)
                                    <td>{{  ( ($totalFullscreen + $totalFullscreenOver) == 0 ) ? 0 : number_format( ($totalFullscreen + $totalFullscreenOver) / ($totalImpression + $totalImpressionOver) *100, 2) }}%
                                    </td>
                                @endif
                                @if('Conversion' == $filter)
                                    <td>0</td>
                                @endif
                            @endforeach
                        </tr>
                    @endforeach
                @endif
            </table>

        </div>

        <input type="button" class="btn btn-default btn-sm mb12" name="generate-report" value="Generate Report"
               onclick="generateReport()">
        <a href="javascript:;" class="btn btn-default btn-sm mb12" data-toggle="modal"
           data-target="#modalExport">Export</a>
        {{ Form::close() }}


    </div>
</div>

<!-- Modal Export -->
<div class="modal fade" id="modalExport" tabindex="-1" role="dialog" aria-labelledby="modalExportLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="modalExportLabel">Report Export</h4>
            </div>
            <div class="modal-body">
                <form id="formExport" role="form">
                    <h5>Select option:</h5>

                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="option[]" id="reportOption1" value="campaign">Campaign
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="option[]" id="reportOption2" value="flight">Flight
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="option[]" id="reportOption3" value="website">Website
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="option[]" id="reportOption3" value="website_campaign">Website Campaign
                        </label>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button id="btnGetLinkReportExport" type="button" onclick="getLinkReportExport()"
                        class="btn btn-primary">Export
                </button>
                <a id="btnGetReportExport" href="javascript:;"></a>
            </div>
        </div>
    </div>
</div>


<?php echo HTML::script("{$assetURL}js/chart/highcharts.js"); ?>
<script type="text/javascript">
    function generateReport() {
        var url = '{{URL::Route($moduleRoutePrefix.'ShowFlightReport')}}';
        $(".form-horizontal").attr('action', url);
        $(".form-horizontal").submit();
    }
    $(function () {

        $('#hight-chart').highcharts({
            chart: {
                type: 'area',
                zoomType: 'xy'
            },
            title: {
                text: ''
            },
            xAxis: {
                allowDecimals: false,
                labels: {align: 'center', rotation: 300, y: 40},
                categories: {{$listDate}},
                crosshair: true
            },
            yAxis: [{
                    title: {
                        text: 'Impression'
                    }
                },
                { // Secondary yAxis
                    title: {
                        text: 'Click',
                        style: {
                            color: Highcharts.getOptions().colors[0]
                        }
                    },
                    min: 0,
                    opposite: true
                }
            ],
            series: [{
                name: 'Impressions',
                data: {{$listImpression}}
            }, {
                yAxis: 1,
                type: 'spline',
                name: 'Clicks',
                data: {{$listClick}}
            }]
        });

        $('#select-all').click(function (event) {  //on click
            if (this.checked) { // check select status
                $('.checkbox').each(function () { //loop through each checkbox
                    this.checked = true;  //select all checkboxes with class "checkbox1"
                });
            } else {
                $('.checkbox').each(function () { //loop through each checkbox
                    this.checked = false; //deselect all checkboxes with class "checkbox1"
                });
            }
        });

        $("[data-toggle=popover]").popover({
            html: true,
            content: function () {
                var content = $(this).attr("data-popover-content");
                return $(content).children(".popover-body").html();
            },
            title: function () {
                var title = $(this).attr("data-popover-content");
                return $(title).children(".popover-heading").html();
            }
        });
    });

    function getLinkReportExport() {
        var formData = $("#formExport").serialize();
        var formhorizontal = $(".form-horizontal").serialize();
        var queryString = "campaignId={{$id}}";
        var url = root + module + "/reportExport?" + queryString + "&" + formData + "&" + formhorizontal;

        window.location = url;
        // $("#btnGetReportExport").attr('href', url);
        // $("#btnGetReportExport").click();
    }
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
</script>
