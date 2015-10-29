<div class="row mb12">
	<div class="col-md-12">
		<h3>Payment</h3>
		<div class="box">
			<div class="content col-xs-12">
				<div class="alert alert-danger fade in request-fail" style="display:none">
					<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">x</a>
					<strong>Warning!</strong> Your request fail. Please try again <br/>
					(<i>Note: Total income for selected months should be greater than or equal to 300,000 VND and you can send request between 1 - 5 every month</i>)
				</div>
				<!-- warning selected month!-->
				<div class="alert alert-danger fade in non-month " style="display:none">
					<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">x</a>
					<strong>Warning!</strong> Please select month that you want to send request.
				</div>

				<div class="alert alert-success fade in" style="display:none">
					<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
					<strong>Success!</strong> Your request success.
				</div>
				{{ Form::open(array('id'=>'form-request','method'=>'post', 'onsubmit'=>'return false')) }}
				@if(checkSendRequest())
				<div class="row">
					<div class="col-sm-3 right-side">
						{{ Form::submit('Send Request', ['class'=>'btn btn-default', 'id'=>'request-btn']) }}
					</div>
				</div>
				@endif
				{{ Form::close() }}
			</div>
		</div>
		<div id="results">
			{{$listItems}}
		</div>
	</div>
</div>

