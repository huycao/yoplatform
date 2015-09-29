
<div class="row">
	<table class="table table-one-user" border="0" cellpadding="0">

		<tr>
			<td>Username :</td>
			<td>{{{isset($item->username) ? $item->username : "N/A"}}}</td>
		</tr>
		<tr>
			<td>First Name :</td>
			<td>{{{isset($item->first_name) ? $item->first_name : "N/A"}}}</td>
		</tr>
		<tr>
			<td>Last Name :</td>
			<td>{{{($item->last_name !="") ? $item->last_name : "N/A"}}}</td>
		</tr>
		<tr>
			<td>Email :</td>
			<td>{{{($item->email !="") ? $item->email : "N/A"}}}</td>
		</tr>
		<tr>
			<td>Phone :</td>
			<td>{{{($item->phone !="") ? $item->phone : "N/A"}}}</td>
		</tr>
		<tr>
			<td>Phone Contact :</td>
			<td>{{{($item->phone_contact !="") ? $item->phone_contact : "N/A"}}}</td>
		</tr>
		<tr>
			<td>Created at :</td>
			<td>{{{($item->created_at !="") ? formatDate($item->created_at,'d-M-Y') : "N/A"}}}</td>
		</tr>
	</table>
</div>