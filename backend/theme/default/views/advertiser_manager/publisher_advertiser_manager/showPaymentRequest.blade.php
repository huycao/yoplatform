<div class="row mb12">
	<div class="col-md-12">
		<h3>Payment</h3>
		<div class="box">
			<div class="content col-xs-12">
				<div class="alert2 alert-danger fade in">
					<strong>Notice!</strong> The payment request can send between <strong>1st and 5th</strong> of the month, with condition <strong>total income</strong> must greater than or equal to <strong>{{LIMIT_PAY}},000 VND</strong>
				</div>

				<div class="alert alert-danger fade in request-fail" style="display:none">
					<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">x</a>
					<strong>Warning!</strong> Your request fail. Please try again <br/>
					(<i>Note: Total income for selected months should be greater than or equal to {{LIMIT_PAY}},000 VND</i>)
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

				<div class="row">
					<div class="col-sm-3 right-side">
						@if(checkSendRequest())
							{{ Form::submit('Send Request', ['class'=>'btn btn-primary', 'id'=>'request-btn']) }}
						@else
							{{ Form::submit('Send Request', ['class'=>'btn btn-default', 'id'=>'request-btn', 'disabled'=>'false']) }}
						@endif
					</div>
				</div>


			</div>
		</div>
		<div id="results">
			{{$listItems}}
		</div>
	</div>
</div>

