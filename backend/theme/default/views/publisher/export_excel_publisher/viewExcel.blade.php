<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
{{HTML::style("{$assetURL}css/export.css")}} 	
</head>
<body>
<table id="table-header-excel">
	<tr>
		<td colspan="2" height="40"><img src="public/logo.png" alt="" style="margin:10px;" /></td>
		<td colspan="5" height="40"><h2>Publisher Advanced Report</h2></td>
	</tr>
	<tr>
		<td colspan="4">Site : {{$siteName}}</td>
	</tr>
	<tr>
		<td colspan="4">Date: {{$date}}</td>
	</tr>
</table>
<?php if(isset($lists) && count($lists) ){ ?>
<table id="tableList">
    <thead>
		<tr class="tr-total">
			<th width="16">{{trans('backend::publisher/text.date')}}</th>
			<th width="16">{{trans('backend::publisher/text.impressions')}}</th>
			<th width="16">{{trans('backend::publisher/text.clicks')}}</th>
			<th width="16">CTR</th>
			<th width="16">eCPM (đ)</th>
			<th width="16">eCPC (đ)</th>
			<th width="16">{{trans('backend::publisher/text.earnings')}}</th>
		</tr>
    </thead>

	<tbody>

		<?php if( count($lists) ){ 
			$totalImpression=0;
			$totalClick=0;
			$totalCRT=0;
			$totalECPM=0;
			$totalECPC=0;
			$totalEarnings=0;
			foreach( $lists as $item ){ ?>
			<tr>
				<td align="left">{{date('d-M-Y',strtotime($item['dateG']))}}</td>
				<td align="left">{{numberVN($item['totalImpression'])}}</td>
				<td align="left">{{numberVN($item['totalClick'])}}</td>
				<?php $ctr=mathCRT($item['totalImpression'],$item['totalClick']) ?>
				<td align="left">{{ $ctr }}%</td>
				<td align="left">{{numberVN($item['total_ecpm'])}}</td>	
				<td align="left">{{numberVN($item['total_ecpc'])}}</td>	
				<td align="left">{{numberVN($item['total_earnings'])}}</td>
			</tr>
			<?php 
				$totalImpression+=$item['totalImpression'];
				$totalClick+=$item['totalClick'];
				$totalCRT+=$ctr;
				$totalECPM+=$item['total_ecpm'];
				$totalECPC+=$item['total_ecpc'];
				$totalEarnings+=$item['total_earnings'];
			?>
			<?php } ?>
			<tr class="tr-total">
				<td align="left"><strong>{{trans('backend::publisher/text.total')}}</strong></td>
				<td align="left"><strong>{{numberVN($totalImpression)}}</strong></td>
				<td align="left"><strong>{{numberVN($totalClick)}}</strong></td>
				<td align="left"><strong>{{$totalCRT}}%</strong></td>
				<td align="left"><strong>{{numberVN($totalECPM)}}</strong></td>	
				<td align="left"><strong>{{numberVN($totalECPC)}}</strong></td>	
				<td align="left"><strong>{{numberVN($totalEarnings)}}</strong></td>
			</tr>
		<?php }else{ ?>
			<tr>
				<td class="no-data" >{{trans("backend::publisher/text.no_data")}}</td>
			</tr>
		<?php } ?>
	</tbody>

</table>
<?php } ?>
</body>
</html>
