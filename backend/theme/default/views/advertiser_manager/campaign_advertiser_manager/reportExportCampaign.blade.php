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


<table class="table" border="1">
<tr>
	<th align="center">Date</th>
    @foreach($filters as $filter=>$filterName)
        <th align="center">{{ $filterName }}</th>
        @if($filter =='Impressions' || $filter =='Clicks' )
            <th align="center">Unique {{ $filter }}</th>
        @endif
    @endforeach
    <th align="center">Publisher Receive</th>
</tr>

<?php
	$totalImpression = 0;
	$totalUniqueImpression = 0;
	$totalClick = 0;
    $totalUniqueClick = 0;
    $sumStart = 0;
    $sumFirstquartile = 0;
    $sumMidpoint = 0;
    $sumThirdquartile= 0;
    $sumComplete= 0;
    $sumPause= 0;
    $sumMute= 0;
    $sumUnmute= 0;
    $sumFullscreen= 0;
    $sumPublisherReceive = 0;
?>

@if(  !empty($campaignTracking) )
	@foreach( $campaignTracking as $date=>$tracking )
		<?php
			$totalImpression += $tracking['total_impression'] + $tracking['total_impression_ovr'];
			$totalUniqueImpression += $tracking['total_unique_impression'] + $tracking['total_unique_impression_ovr'];
			$totalClick += $tracking['total_click'] + $tracking['total_click_ovr'];
            $totalUniqueClick += $tracking['total_unique_click'] + $tracking['total_unique_click_ovr'];
            $sumStart += $tracking['total_start'] + $tracking['total_start_ovr'];
            $sumFirstquartile             += $tracking['total_firstquartile'] + $tracking['total_firstquartile_ovr'];
            $sumMidpoint            += $tracking['total_midpoint'] + $tracking['total_midpoint_ovr'];
            $sumThirdquartile           += $tracking['total_thirdquartile'] + $tracking['total_thirdquartile_ovr'];
            $sumComplete            += $tracking['total_complete'] + $tracking['total_complete_ovr'];
            $sumPause            += $tracking['total_pause'] + $tracking['total_pause_ovr'];
            $sumMute            += $tracking['total_mute'] + $tracking['total_mute_ovr'];
            $sumUnmute            += $tracking['total_unmute'] + $tracking['total_unmute_ovr'];
            $sumFullscreen            += $tracking['total_fullscreen'] + $tracking['total_fullscreen_ovr'];

            $sumPublisherReceive += $tracking['publisher_receive'];
            
			$frequency = 0;
            $row_impression = ($tracking['total_impression'] + $tracking['total_impression_ovr']);
			if(($tracking['total_unique_impression'] + $tracking['total_unique_impression_ovr']) != 0 ){
				$frequency = number_format($row_impression / ($tracking['total_unique_impression'] + $tracking['total_unique_impression_ovr']), 2);
			}

			$ctr = 0;
			if($row_impression != 0 ){
				$ctr = ($tracking['total_click'] + $tracking['total_click_ovr']) /$row_impression*100;
			}

		?>

		<tr>
			<td align="center">{{date('d/m/Y', strtotime($date))}}</td>
            @foreach($filters as $filter=>$filterName)
                @if('Impressions' == $filter)
                    <td align="center">{{ $row_impression }}</td>
                    <td align="center">{{ $tracking['total_unique_impression'] + $tracking['total_unique_impression_ovr'] }}</td>
                @endif
                @if('Frequency' == $filter)
                    <td align="center">{{ (float) $frequency }}</td>
                @endif
                @if('Clicks' == $filter)
                    <td align="center">{{ $tracking['total_click'] + $tracking['total_click_ovr'] }}</td>
                    <td align="center">{{ $tracking['total_unique_click'] + $tracking['total_unique_click_ovr'] }}</td>
                @endif
                @if('CTR' == $filter)
                    <td align="center">{{ number_format($ctr, 2) }} %</td>
                @endif
                @if('Start' == $filter)
                    <td>{{ ($row_impression > 0) ? number_format(($tracking['total_start'] + $tracking['total_start_ovr']) / $row_impression * 100, 2) : 0 }}%</td>
                @endif
                @if('Firstquartile' == $filter)
                    <td>{{ ($row_impression > 0) ? number_format(($tracking['total_firstquartile'] + $tracking['total_firstquartile_ovr']) / $row_impression * 100, 2) : 0 }}%</td>
                @endif
                @if('Midpoint' == $filter)
                    <td>{{ ($row_impression > 0) ? number_format(($tracking['total_midpoint'] + $tracking['total_midpoint_ovr']) / $row_impression * 100, 2) : 0 }}%</td>
                @endif
                @if('Thirdquartile' == $filter)
                    <td>{{ ($row_impression > 0) ? number_format(($tracking['total_thirdquartile'] + $tracking['total_thirdquartile_ovr']) / $row_impression * 100, 2) : 0 }}%</td>
                @endif
                @if('Complete' == $filter)
                    <td>{{ ($row_impression > 0) ? number_format(($tracking['total_complete'] + $tracking['total_complete_ovr']) / $row_impression * 100, 2) : 0 }}%</td>
                @endif
                @if('Pause' == $filter)
                    <td>{{ ($row_impression > 0) ? number_format(($tracking['total_pause'] + $tracking['total_pause_ovr']) / $row_impression * 100, 2) : 0 }}%</td>
                @endif
                @if('Mute' == $filter)
                    <td>{{ ($row_impression > 0) ? number_format(($tracking['total_mute'] + $tracking['total_mute_ovr']) / $row_impression * 100, 2) : 0 }}%</td>
                @endif
                @if('Unmute' == $filter)
                    <td>{{ ($row_impression > 0) ? number_format(($tracking['total_unmute'] + $tracking['total_unmute_ovr']) / $row_impression * 100, 2) : 0 }}%</td>
                @endif
                @if('Fullscreen' == $filter)
                    <td>{{ ($row_impression > 0) ? number_format(($tracking['total_fullscreen'] + $tracking['total_fullscreen_ovr']) / $row_impression * 100, 2) : 0 }}%</td>
                @endif
                @if('Conversion' == $filter)
                    <td>0</td>
                @endif
            @endforeach
            <td>{{ $tracking['publisher_receive'] }}</td>
		</tr>
	@endforeach
@endif

<?php
	$frequency = 0;
	if($totalUniqueImpression != 0 ){
		$frequency = number_format($totalImpression / $totalUniqueImpression, 2);
	}

	$ctr = 0;
	if($totalUniqueImpression != 0 ){
		$ctr = $totalClick / $totalImpression*100;
	}

?>
<tr>
	<th align="center">Total</th>
    @foreach($filters as $filter=>$filterName)
        @if('Impressions' == $filter)
            <th align="center">{{ $totalImpression }}</th>
            <th align="center">{{ $totalUniqueImpression }}</th>
        @endif
        @if('Frequency' == $filter)
            <th align="center">{{ (float) $frequency }}</th>
        @endif
        @if('Clicks' == $filter)
            <th align="center">{{ $totalClick }}</th>
            <th align="center">{{ $totalUniqueClick }}</th>
        @endif
    
        @if('CTR' == $filter)
            <th align="center">{{ number_format($ctr, 2) }}%</th>
        @endif
        @if('Start' == $filter)
            <th> {{ ($totalImpression > 0) ? number_format($sumStart / $totalImpression * 100, 2) : 0 }}% </th>
        @endif
        @if('Firstquartile' == $filter)
            <th> {{ ($totalImpression > 0) ? number_format($sumFirstquartile / $totalImpression * 100, 2) : 0 }}% </th>
        @endif
        @if('Midpoint' == $filter)
            <th> {{ ($totalImpression > 0) ? number_format($sumMidpoint / $totalImpression * 100, 2) : 0 }}% </th>
        @endif
        @if('Thirdquartile' == $filter)
            <th>{{ ($totalImpression > 0) ? number_format($sumThirdquartile / $totalImpression * 100, 2) : 0 }}%</th>
        @endif
        @if('Complete' == $filter)
            <th>{{ ($totalImpression > 0) ? number_format($sumComplete / $totalImpression * 100, 2) : 0}}%</th>
        @endif
        @if('Pause' == $filter)
            <th>{{ ($totalImpression > 0) ? number_format($sumPause / $totalImpression * 100, 2) : 0}}%</th>
        @endif
        @if('Mute' == $filter)
            <th>{{ ($totalImpression > 0) ? number_format($sumMute / $totalImpression * 100, 2) : 0}}%</th>
        @endif
        @if('Unmute' == $filter)
            <th>{{ ($totalImpression > 0) ? number_format($sumUnmute / $totalImpression * 100, 2) : 0}}%</th>
        @endif
        @if('Fullscreen' == $filter)
            <th>{{ ($totalImpression > 0) ? number_format($sumFullscreen / $totalImpression * 100, 2) : 0}}%</th>
        @endif
        @if('Conversion' == $filter)
            <th>0</th>
        @endif
    @endforeach
    <th>{{ $sumPublisherReceive }}</th>
</tr>

</table>




</body>
</html>