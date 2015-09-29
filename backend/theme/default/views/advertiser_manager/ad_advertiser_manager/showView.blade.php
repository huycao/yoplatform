<div class="row mb12">
	<div class="col-md-12">
		<div class="box">
			<div class="head">Flight Detail</div>
			<table class="table table-striped table-hover table-condensed ">
				<?php
					$campaign = $data->campaign;
					$adFormat = $data->adFormat;
				?>
				<tr>
					<td>Ad</td>
					<td>({{ $data->id }}){{ $data->name }}</td>
				</tr>
				<tr>
					<td>Campaign</td>
					<td>({{ $campaign->id or '-' }}) {{ $campaign->name or '-' }}</td>
				</tr>
				<tr>
					<td>Flight</td>
					<td>({{ $data->flight->id or '-' }}) {{ $data->flight->name or '-' }}</td>
				</tr>
				<tr>
					<td>Display Date</td>
					<td>{{ $data->campaign->dateRange or '-' }}</td>
				</tr>
				<tr>
					<td>Ad Type</td>
					<td>{{ $data->ad_type or '-' }}</td>
				</tr>
				<tr>
					<td>Ad Format</td>
					<td>{{ $adFormat->name or '-' }}</td>
				</tr>
				<tr>
					<td>Full Dimension</td>
					<td>{{ $data->dimension or '-' }}</td>
				</tr>
				<tr>
					<td>Wmode</td>
					<td>{{ $data->wmode or '-' }}</td>
				</tr>
				<tr>
					<td>Destination URL</td>
					<td>{{ $data->destination_url or '-' }}</td>
				</tr>

			</table>
		</div>
	</div>
</div>