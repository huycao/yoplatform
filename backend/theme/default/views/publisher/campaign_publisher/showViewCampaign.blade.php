<div class="row">
	<div class="col-sm-12">
		<h3>View Campaign</h3>
	</div>
</div>
<div class="row">
	<div class="col-sm-12">
		<table class="table table-view-campaign" role="table">
			<tbody>
				<tr>
					<td class="warning">Name Campaign :</td>
					<td>{{$item->name}}</td>
				</tr>
				<tr>
					<td class="warning">Channel :</td>
					<td>{{$item->cate_name}}</td>
				</tr>
				<tr>
					<td class="warning">Advertiser :</td>
					<td>{{$item->name_advertiser}}</td>
				</tr>
				<tr>
					<td class="warning">Campaign Duration :</td>
					<td>{{date("d-M-Y",strtotime($item->start_date))}} - {{date("d-M-Y",strtotime($item->end_date))}}</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>