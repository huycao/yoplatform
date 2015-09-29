<h5>Ad Detail</h5>
<table class="table table-responsive table-condensed">
	<?php
		$campaign = $data->ad->campaign;
		$adFormat = $data->ad->adFormat;
	?>
	<tr>
		<td class="bg-default">Ad</td>
		<td>({{ $data->ad->id }})</td>
		<td>{{ $data->ad->name }}</td>
	</tr>
	<tr>
		<td class="bg-default">Campaign</td>
		<td>({{ $campaign->id or '-' }})</td>
		<td>{{ $campaign->name or '-' }}</td>
	</tr>
	<tr>
		<td class="bg-default">Flight</td>
		<td>({{ $data->flight->id or '-' }})</td>
		<td>{{ $data->flight->name or '-' }}</td>
	</tr>
	<tr>
		<td class="bg-default">Display Date</td>
		<td colspan="2">{{ $data->ad->campaign->dateRange or '-' }}</td>
	</tr>
	<tr>
		<td class="bg-default">Ad Type</td>
		<td colspan="2">{{ $data->ad->type or '-' }}</td>
	</tr>
	<tr>
		<td class="bg-default">Ad Format</td>
		<td colspan="2">{{ $adFormat->name or '-' }}</td>
	</tr>
	<tr>
		<td class="bg-default">Full Dimension</td>
		<td colspan="2">{{ $data->ad->dimension or '-' }}</td>
	</tr>
	<tr>
		<td class="bg-default">Wmode</td>
		<td colspan="2">{{ $data->ad->wmode or '-' }}</td>
	</tr>
	<tr>
		<td class="bg-default">Destination URL</td>
		<td colspan="2">{{ $data->ad->destination_url or '-' }}</td>
	</tr>
</table>

<h5>Ad Detail</h5>