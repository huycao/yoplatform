<div class="row mb12">
	<div class="col-md-12">
		<div class="box">
			<div class="head">List Payment Request</div>
			<table class="table table-striped table-hover table-condensed ">
			    <thead>
					<tr>
						<th>Month</th>
						<th>Amount(đ)</th>
						<th>Report</th>
					</tr>
			    </thead>
				
				<tbody>
					
					@if( $listPaymentRequests->count()  )
						@foreach( $listPaymentRequests as $item )
						<tr>
							<td>{{$item->date}}</td>
							<td>{{number_format($item->amount)}}</td>
							<td><a href="{{URL::Route(!empty($routeExport) ? $routeExport . 'PaymentRequestDetail' : 'PublisherAdvertiserManagerPaymentRequestDetail', $item->id)}}">Report</a></td>
						</tr>
						@endforeach
					@else
						<tr><td colspan="3">No data</td>
					@endif
				</tbody>
			</table>
		</div>		
	</div>
</div>