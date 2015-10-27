
<div class="filter-wrapper">
	<fieldset>
		<legend>Tools</legend>
		<div class="row">
			<div class="col-sm-12">
				<table class="table table-bordered table-tools">
					<tbody>
						<tr>
							<td style="width:20px;"><span class="glyphicon glyphicon-user"></span></td>
							<td><a href="{{URL::to(Route($moduleRoutePrefix.'ShowUserList'))}}">User List - List all existing users</a></td>
						</tr>
						 <tr>
							<td style="width:20px;"><span class="fa fa-dollar"></span></td>
							<td><a href="{{URL::to(Route($moduleRoutePrefix.'PaymentRequest',['request']))}}">Payment Request</a></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</fieldset>
</div>

