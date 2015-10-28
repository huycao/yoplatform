<div class="box mb12">
	<div>
		<table class="table table-striped table-hover">
			<tr>
				<td>Date: {{date('Y-m', strtotime($payment->created_at))}} - Amount: {{number_format($payment->amount,0,'',',')}} VND </td>
			</tr>
		</table>
	</div>

		<table class="table table-striped table-border table-hover">
			<tr>
				<th></th>
				<th>Campaign</th>
				<th>Amount (VND)</th>
				<th>Impressions</th>
				<th>Click</th>
				<th>CTR</th>
			</tr>
			@if(count($items)>0)
				<?php $count = 1;?>
				@foreach($items as $item)
					<tr>
						<td width="40">
							<a class="fa fa-plus-circle show-flight" data-toggle="collapse" data-target="#flight_{{$item->id}}" href="javascript:;"></a>
						</td>
						<td><strong>{{$item->campaign->name}}</strong></td>
						<td width="150">{{number_format($item->amount,0,'',',')}}</td>
						<td width="150">{{number_format($item->impression, 0,'',',')}}</td>
						<td width="150">{{$item->click}}</td>
						<td width="150">{{number_format($item->ctr *100, 2)}}%</td>
					</tr>
					<tr id="flight_{{$item->id}}" class="content collapse">
						<td colspan="6" class="list-flight"><h5>List Flights</h5>
							<table  class="table table-striped custom-table-border">
								<tr>
									<th>No.</th>
									<th>Title</th>
									<th>Amount (VND)</th>
									<th>Impressions</th>
									<th>Click</th>
									<th>CTR</th>
								</tr>
								<?php $flights = TrackingSummaryBaseModel::getListFlight($item->campaign_id, date('m', strtotime($item->created_at)), date('Y',strtotime($item->created_at)));
								?>
								@if(count($flights)>0)
									<?php $num=1;?>
									@foreach($flights as $flight)

								<tr>
									<td width="25">{{$num}}</td>
									<td>{{$flight->flight->name}}</td>
									<td width="150">{{number_format($flight->amount_impression,0,'',',')}}</td>
									<td width="150">{{number_format($flight->impression, 0,'',',')}}</td>
									<td width="150">{{$flight->click}}</td>
									<td width="150">{{number_format($flight->ctr, 2)}}%</td>
								</tr>
										<?php $num++;?>
									@endforeach
								@endif
							</table>
						</td>

					</tr>
					<?php $count++; ?>
				@endforeach
				@else
				<tr><td colspan="11">No data</td></tr>
			@endif
		</table>
	</div>
</div>
<script type="text/javascript">
	$().ready(function(){
		$(".show-flight").click(function(){
			if($(this).hasClass('fa-minus-circle')){
				$(this).removeClass('fa-minus-circle').addClass('fa-plus-circle');
			}else{
				$(this).removeClass('fa-plus-circle').addClass('fa-minus-circle');
			}
		})
	})
</script>