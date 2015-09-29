<?php
$filterAlls =getFilterAll();
$filters =  getFilter(Input::get('filter',array()));
$colum_number = count($filters);
if(!(in_array("Impressions",$filters) === false)){
    $colum_number++;
}
if(!(in_array("Clicks",$filters) === false)){
    $colum_number++;
}
?>
<!DOCTYPE html>
<html xmlns='http://www.w3.org/1999/xhtml'>
<head>
	<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
	{{ HTML::style("{$assetURL}css/excel.css") }}
</head>
<body>

<table>
	<tr class="mb12"><th colspan="{{($colum_number+1)}}" class="brand" valign="middle">Yomedia Digital - Flight Report Summary</th></tr>
	<tr><th align="center">Campaign Name:</th><th  colspan="{{($colum_number)}}" align="center" >{{$campaign->name}}</th></tr>
	<tr><th align="center">Duration:</th><th colspan="{{$colum_number}}" align="center">{{$campaign->dateRange}}</th></tr>
	<tr><th align="center">Advertise:</th><th colspan="{{$colum_number}}" align="center">{{$campaign->advertiser->name}}</th></tr>
	<tr><th align="center">Agency:</th><th colspan="{{$colum_number}}" align="center">{{$campaign->agency->name}}</th></tr>
</table>


@if(  !empty($listFlight) && $listFlight->count() )
	@foreach( $listFlight as $flight )
	<table class="table" border="1">
	<tr><th class="bg-primary">Flight</th><th colspan="{{$colum_number}}" align="center" class="bg-primary">({{ $flight->id or '-' }}) {{ $flight->name }}</th></tr>
	<tr>
		<th align="center">Date</th>
        @foreach($filters as $filter=>$filterName)
            <th align="center">{{ $filterName }}</th>
            @if($filter =='Impressions' || $filter =='Clicks' )
                <th align="center">Unique {{ $filter }}</th>
            @endif
        @endforeach
	</tr>
	<?php
		$totalInpression = 0;
		$totalUniqueImpression = 0;
		$totalClick = 0;
        $totalUniqueClick = 0;
        $sumStart= 0;
        $sumFirstquartile = 0;
        $sumMidpoint = 0;
        $sumThirdquartile= 0;
        $sumComplete= 0;
        $sumPause= 0;
        $sumMute= 0;
        $sumUnmute= 0;
        $sumFullscreen= 0;
        
        //over report
        $totalInpressionOver = 0;
		$totalUniqueImpressionOver = 0;
		$totalClickOver = 0;
        $totalUniqueClickOver = 0;
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
	@if( !empty($listFlightTracking[$flight->id]) )
		<?php $flightTracking = $listFlightTracking[$flight->id] ?>
		@if( !empty($flightTracking) )
			@foreach( $flightTracking as $tracking )

			<?php
				$totalInpression += $tracking['total_impression'];
				$totalUniqueImpression += $tracking['total_unique_impression'];
				$totalClick += $tracking['total_click'];
                $totalUniqueClick += $tracking['total_unique_click'];
                $sumStart             += $tracking['total_start'];
                $sumFirstquartile             += $tracking['total_firstquartile'];
                $sumMidpoint            += $tracking['total_midpoint'];
                $sumThirdquartile           += $tracking['total_thirdquartile'];
                $sumComplete            += $tracking['total_complete'];
                $sumPause            += $tracking['total_pause'];
                $sumMute            += $tracking['total_mute'];
                $sumUnmute            += $tracking['total_unmute'];
                $sumFullscreen            += $tracking['total_fullscreen'];
                
                $totalInpressionOver += $tracking['total_impression_over'];
				$totalUniqueImpressionOver += $tracking['total_unique_impression_over'];
				$totalClickOver += $tracking['total_click_over'];
                $totalUniqueClickOver += $tracking['total_unique_click_over'];
                $sumStartOver += $tracking['total_start_over'];
                $sumFirstquartileOver += $tracking['total_firstquartile_over'];
                $sumMidpointOver += $tracking['total_midpoint_over'];
                $sumThirdquartileOver += $tracking['total_thirdquartile_over'];
                $sumCompleteOver += $tracking['total_complete_over'];
                $sumPauseOver += $tracking['total_pause_over'];
                $sumMuteOver += $tracking['total_mute_over'];
                $sumUnmuteOver += $tracking['total_unmute_over'];
                $sumFullscreenOver += $tracking['total_fullscreen_over'];
                
				$frequency = 0;
				$impressionRow = $tracking['total_impression'] + $tracking['total_impression_over'];
				if( ($tracking['total_unique_impression'] + $tracking['total_unique_impression_over']) != 0 ){
					$frequency = number_format($impressionRow/($tracking['total_unique_impression'] + $tracking['total_unique_impression_over']), 2);
				}

				$ctr = 0;
				if( $impressionRow != 0 ){
					$ctr = number_format(($tracking['total_click'] + $tracking['total_click_over'])/$impressionRow*100, 2);
				}
				
			?>

			<tr>
				<td align="center">{{date('d/m/Y', strtotime($tracking['date']))}}</td>
				@foreach($filters as $filter=>$filterName)
                    @if('Impressions' == $filter)
                        <td align="center">{{ $impressionRow }}</td>
                        <td align="center">{{ $tracking['total_unique_impression'] + $tracking['total_unique_impression_over'] }}</td>
                    @endif
                    @if('Frequency' == $filter)
                        <td align="center">{{ (float) $frequency }}</td>
                    @endif
                    @if('Clicks' == $filter)
                        <td align="center">{{ $tracking['total_click'] + $tracking['total_click_over'] }}</td>
                        <td align="center">{{ $tracking['total_unique_click'] + $tracking['total_unique_click_over'] }}</td>
                    @endif
                    @if('CTR' == $filter)
                        <td align="center">{{ (float) $ctr }} %</td>
                    @endif
                    @if('Start' == $filter)
                        <td>{{ ($impressionRow > 0) ? number_format(($tracking['total_start'] + $tracking['total_start_over']) / $impressionRow * 100, 2) : 0 }}%</td>
                    @endif
                    @if('Firstquartile' == $filter)
                        <td>{{ ($impressionRow > 0) ? number_format(($tracking['total_firstquartile'] + $tracking['total_firstquartile_over']) / $impressionRow * 100, 2) : 0 }}%</td>
                    @endif
                    @if('Midpoint' == $filter)
                        <td>{{ ($impressionRow > 0) ? number_format(($tracking['total_midpoint'] + $tracking['total_midpoint_over']) / $impressionRow * 100, 2) : 0 }}%</td>
                    @endif
                    @if('Thirdquartile' == $filter)
                        <td>{{ ($impressionRow > 0) ? number_format(($tracking['total_thirdquartile'] + $tracking['total_thirdquartile_over']) / $impressionRow * 100, 2) : 0 }}%</td>
                    @endif
                    @if('Complete' == $filter)
                        <td>{{ ($impressionRow > 0) ? number_format(($tracking['total_complete'] + $tracking['total_complete_over']) / $impressionRow * 100, 2) : 0 }}%</td>
                    @endif
                    @if('Pause' == $filter)
                        <td>{{ ($impressionRow > 0) ? number_format(($tracking['total_pause'] + $tracking['total_pause_over']) / $impressionRow * 100, 2) : 0 }}%</td>
                    @endif
                    @if('Mute' == $filter)
                        <td>{{ ($impressionRow > 0) ? number_format(($tracking['total_mute'] + $tracking['total_mute_over']) / $impressionRow * 100, 2) : 0 }}%</td>
                    @endif
                    @if('Unmute' == $filter)
                        <td>{{ ($impressionRow > 0) ? number_format(($tracking['total_unmute'] + $tracking['total_unmute_over']) / $impressionRow * 100, 2) : 0 }}%</td>
                    @endif
                    @if('Fullscreen' == $filter)
                        <td>{{ ($impressionRow > 0) ? number_format(($tracking['total_fullscreen'] + $tracking['total_fullscreen_over']) / $impressionRow * 100, 2) : 0 }}%</td>
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
		$frequency = 0;
		if( ($totalUniqueImpression + $totalUniqueImpressionOver) != 0 ){
			$frequency = number_format(($totalInpression + $totalInpressionOver)/($totalUniqueImpression + $totalUniqueImpressionOver), 2);
		}

		$ctr = 0;
		if( ($totalInpression + $totalInpressionOver) != 0 ){
			$ctr = number_format(($totalClick + $totalClickOver)/($totalInpression + $totalInpressionOver)*100, 2);
		}

	?>
	<tr>
		<th align="center">Total</th>
		@foreach($filters as $filter=>$filterName)
            @if('Impressions' == $filter)
                <th align="center">{{ $totalInpression + $totalInpressionOver }}</th>
                <th align="center">{{ $totalUniqueImpression + $totalUniqueImpressionOver }}</th>
            @endif
            @if('Frequency' == $filter)
                <th align="center">{{ (float) $frequency }}</th>
            @endif
            @if('Clicks' == $filter)
                <th align="center">{{ $totalClick + $totalClickOver }}</th>
                <th align="center">{{ $totalUniqueClick + $totalUniqueClickOver }}</th>
            @endif

            @if('CTR' == $filter)
                <th align="center">{{ (float) $ctr }}%</th>
            @endif
            @if('Start' == $filter)
                <th> {{ (($totalInpression + $totalInpressionOver) > 0) ? number_format(($sumStart + $sumStartOver) / ($totalInpression + $totalInpressionOver) * 100, 2) : 0 }}% </th>
            @endif
            @if('Firstquartile' == $filter)
                <th> {{ (($totalInpression + $totalInpressionOver) > 0) ? number_format(($sumFirstquartile + $sumFirstquartileOver) / ($totalInpression + $totalInpressionOver) * 100, 2) : 0 }}% </th>
            @endif
            @if('Midpoint' == $filter)
                <th> {{ (($totalInpression + $totalInpressionOver) > 0) ? number_format(($sumMidpoint + $sumMidpointOver) / ($totalInpression + $totalInpressionOver) * 100, 2) : 0 }}% </th>
            @endif
            @if('Thirdquartile' == $filter)
                <th>{{ (($totalInpression + $totalInpressionOver) > 0) ? number_format(($sumThirdquartile + $sumThirdquartileOver) / ($totalInpression + $totalInpressionOver) * 100, 2) : 0 }}%</th>
            @endif
            @if('Complete' == $filter)
                <th>{{ (($totalInpression + $totalInpressionOver) > 0) ? number_format(($sumComplete + $sumCompleteOver) / ($totalInpression + $totalInpressionOver) * 100, 2) : 0}}%</th>
            @endif
            @if('Pause' == $filter)
                <th>{{ (($totalInpression + $totalInpressionOver)> 0) ? number_format(($sumPause + $sumPauseOver) / ($totalInpression + $totalInpressionOver) * 100, 2) : 0}}%</th>
            @endif
            @if('Mute' == $filter)
                <th>{{ (($totalInpression + $totalInpressionOver) > 0) ? number_format(($sumMute + $sumMuteOver) / ($totalInpression + $totalInpressionOver) * 100, 2) : 0}}%</th>
            @endif
            @if('Unmute' == $filter)
                <th>{{ (($totalInpression + $totalInpressionOver) > 0) ? number_format(($sumUnmute + $sumUnmuteOver) / ($totalInpression + $totalInpressionOver) * 100, 2) : 0}}%</th>
            @endif
            @if('Fullscreen' == $filter)
                <th>{{ (($totalInpression + $totalInpressionOver) > 0) ? number_format(($sumFullscreen + $sumFullscreenOver) / ($totalInpression + $totalInpressionOver) * 100, 2) : 0}}%</th>
            @endif
            @if($filter =='Conversion')
                <th>0</th>
            @endif
        @endforeach
	</tr>	

	</table>
	@endforeach
@endif





</body>
</html>