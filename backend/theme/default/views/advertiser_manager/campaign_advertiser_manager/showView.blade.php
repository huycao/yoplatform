<div class="row mb12">
	<div class="col-md-12">
		<div class="box">
			<div class="head">Campaign Detail</div>
			<table class="table table-striped table-hover table-condensed ">
				<tr>
					<td width="25%">Campaign</td>
					<td width="75%" colspan="3">{{ $data->name }}</td>
				</tr>
				<tr>
					<td class="bg-default" width="25%">Campaign Category</td>
					<td width="25%">{{ $data->category->name }}</td>
					<td class="bg-default" width="25%">Date</td>
					<td width="25%">{{ $data->dateRange }}</td>
				</tr>
				<tr>
					<td class="bg-default" width="25%">Sale Person</td>
					<td width="25%">{{ $data->sale->username }}</td>
					<td class="bg-default" width="25%">Campain Manager</td>
					<td width="25%">{{ $data->campaign_manager->username }}</td>
				</tr>
				<tr>
					<td class="bg-default" width="25%">Sale Status</td>
					<td width="25%">{{ $listSaleStatus[$data->sale_status] }}</td>
					<td class="bg-default" width="25%">Campain Status</td>
					<td width="25%">{{ $data->statusText }}</td>
				</tr>
				<tr>
					<td class="bg-default" width="25%">Advertiser</td>
					<td width="25%">{{ $data->advertiser->name }}</td>
					<td class="bg-default" width="25%">Agency</td>
					<td width="25%">{{ $data->agency->name }}</td>
				</tr>
				<tr>
					<td class="bg-default" width="25%">Contact</td>
					<td width="25%">{{ $data->contact->name }}</td>
					<td class="bg-default" width="25%">Created Date</td>
					<td width="25%">{{ $data->created_at }}</td>
				</tr>				
				<tr>
					<td class="bg-default" width="25%">Cost Type</td>
					<td width="25%">{{ $data->cost_type }}</td>
					<td class="bg-default" width="25%">Total Inventory</td>
					<td width="25%">{{ $data->total_inventory }}</td>
				</tr>				
				<tr>
					<td class="bg-default" width="25%">Sale Revenue</td>
					<td width="25%"><?php if( isset( $data->sale_revenue ) && is_numeric($data->sale_revenue) ){ echo number_format($data->sale_revenue); }else{ echo 0; } ?></td>
					<td width="25%"></td>
					<td width="25%"></td>
				</tr>				
			</table>
		</div>		
	</div>
</div>

<div class="row mb12">
	<div class="col-md-12">
		<div class="box">
			<div class="head">List Flight Of Campaign</div>
			<table class="table table-striped table-hover table-condensed ">
				<thead>
					<tr>
						<th>Flight Details</th>
						<th>Days</th>
						<th>Inventory</th>
						<th>Rate Card Rate</th>
						<th>Disc (%)</th>
						<th>Rate (After Discount)</th>
						<th>Cost (After Discount)</th>
						<th>Cost To Publisher</th>
						<th>Action</th>
					</tr>
			    </thead>

				<tbody>
					<?php
						$sumRateCard = 0;
						$sumRateAfterDiscount = 0;
						$sumCostAfterDiscount = 0;
						$sumCostToPublisher = 0;
					?>
					@if( $data->flight->count() )
						@foreach( $data->flight as $flight )
							<tr>
								<td><a href="{{ URL::Route('FlightAdvertiserManagerShowView',$flight['id']) }}">({{$flight->id}}) {{$flight->name}}</a></td>
								<td>{{$flight->day}}</td>
								<td>{{$flight->total_inventory}}</td>
								<td class="right">{{ number_format($flight->media_cost)}}</td>
								<td>{{ number_format($flight->discount)}}</td>
								<td class="right">{{ number_format($flight->cost_after_discount)}}</td>
								<td class="right">{{ number_format($flight->total_cost_after_discount)}}</td>
								<td class="right">{{ number_format($flight->publisher_cost)}}</td>
								<td>
									<a href="{{ URL::Route('FlightAdvertiserManagerShowUpdate',$flight['id']) }}" class="btn btn-default btn-sm">
										<span class="glyphicon glyphicon-pencil"></span> Edit
									</a>
								</td>
							</tr>
							<?php
								$sumRateCard += $flight->media_cost;
								$sumRateAfterDiscount += $flight->cost_after_discount;
								$sumCostAfterDiscount += $flight->total_cost_after_discount;
								$sumCostToPublisher += $flight->publisher_cost;
							?>		
						@endforeach
					@endif
				</tbody>

				<tfoot>
					<tr class="bg-footer">
						<th colspan="3">Total</th>
						<th class="right">{{ number_format($sumRateCard)}}</th>
						<th></th>
						<th class="right">{{ number_format($sumRateAfterDiscount)}}</th>
						<th class="right">{{ number_format($sumCostAfterDiscount)}}</th>
						<th class="right">{{ number_format($sumCostToPublisher)}}</th>
						<th></th>
					</tr>	
				</tfoot>	

			</table>
		</div>		
	</div>
</div>
