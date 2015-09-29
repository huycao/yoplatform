@if( !empty($listCampaign) )
	<?php $i=0; ?>
	@foreach( $listCampaign as $campaign )
	<?php $i++; ?>
	<div class="col-md-6">

		<div class="panel panel-default">
			<div class="panel-heading">{{$campaign->name}}</div>
			<div class="panel-body">
				<div id="hight-chart-{{$i}}"></div>
			</div>
		</div>
	</div>
	<?php
		$charts = $listCampaignChart[$campaign->id];
		$listDate = '{}';
		$listImpression = '{}';
		$listClick = '{}';

		if( !empty($charts) ){
			$charts = array_reverse($charts);

			$listDate = [];
			$listImpression = [];
			$listClick = [];

			foreach( $charts as $chart ){
				$listDate[] = date('d/m/Y', strtotime($chart['date']));
				$listImpression[] = $chart['total_impression'];
				$listClick[] = $chart['total_click'];
			}

			$listDate = json_encode($listDate);
			$listImpression = json_encode($listImpression, JSON_NUMERIC_CHECK);
			$listClick = json_encode($listClick, JSON_NUMERIC_CHECK);

		}
	?>
	<script type="text/javascript">
	$(function () {

	    $('#hight-chart-{{$i}}').highcharts({
	        chart: {
	            type: 'area'
	        },
	        title: {
	            text: ''
	        },
	        xAxis: {
	            allowDecimals: false,
	            labels:{align:'center',rotation:300,y:40},
	            categories: {{$listDate}}
	        },
	        yAxis: {
	        	title: {
	        		text: ''
	        	}
	        },
	        series: [{
	            name: 'Impressions',
	            data: {{$listImpression}}
	        }, {
	            name: 'Clicks',
	            data: {{$listClick}}
	        }]
	    });
});

	</script>

	@endforeach
@endif