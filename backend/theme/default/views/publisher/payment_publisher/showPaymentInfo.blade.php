
<div class="row">
	<div class="col-sm-12">
		<div class="alert alert-info">
			Your current payee infomation is as below: <br>
			If you need to change your payee infomation, please send us a support a ticket <a href="#" class="badge-payment-info"><span class="badge">Here</span></a>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-sm-12">
		<div class="col-sm-6 col-sm-offset-3 show-info-payment">
			<table class="table table-payment-info">
				<tr>
					<td width="40%">Payment Preference :</td>
					<td>{{{ $item->payment_preference or "N/A" }}}</td>
				</tr>
				<tr>
					<td>Bank :</td>
					<td>{{{ $item->bank or "N/A"}}}</td>
				</tr>
				
				<tr>
					<td>Account Number :</td>
					<td>{{{ $item->account_number or "N/A"}}}</td>
				</tr>
				<tr>
					<td>Account Name :</td>
					<td>{{{ $item->account_name or "N/A"}}}</td>
				</tr>
			</table>
		</div>
	</div>
</div>
