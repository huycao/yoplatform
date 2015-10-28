<div class="filter-wrapper">
	<fieldset>
		<legend>Payment</legend>
	</fieldset>
</div>

<div class="row">
	<div class="col-xs-12">

		<div class="bts-tabs">
			<ul role="tablist" class="nav nav-tabs filter-status upper-text" id="myTab">
				<li class="{{($status=='request')?'active':''}}">
					<a href="{{URL::to(Route($moduleRoutePrefix.'PaymentRequest', ['request']))}}"><strong>{{STATUS_REQUEST}}</strong></a>
				</li>
				<li class="{{($status=='approve')?'active':''}}">
					<a href="{{URL::to(Route($moduleRoutePrefix.'PaymentRequest', ['approve']))}}"><strong>{{STATUS_APPROVE}}</strong></a>
				</li>
				<li class="{{($status=='decline')?'active':''}}">
					<a href="{{URL::to(Route($moduleRoutePrefix.'PaymentRequest', ['decline']))}}"><strong>{{STATUS_DECLINE}}</strong></a>
				</li>
				<li class="{{($status=='waiting')?'active':''}}">
					<a href="{{URL::to(Route($moduleRoutePrefix.'PaymentRequest', ['waiting']))}}"><strong>{{STATUS_WAITING}}</strong></a>
				</li>
			</ul>
			<input type="hidden" name="status" id="status" value="0"/>
			<div class="tab-content" id="myTabContent">
				<div class="wrap-table">
					<div class="row col-md-12 filter-publisher">
						{{Form::open(array('method'=>'get','class'=>'form-inline'))}}
						<div class="form-group">
							<label>Publisher</label>
							{{Form::text('publisher',Input::get('publisher')?Input::get('publisher'):'', array('class'=>'form-control', 'id'=>'publisher'))}}
						</div>
						<div class="form-group">
							<label>Month</label>
							{{Form::select('month', getMonths(), Input::get('month')?Input::get('month'):'',['id'=>'month', 'class'=>'form-control'])}}
						</div>
						<div class="form-group">
							<label>Year</label>
							{{Form::select('year', getYears(), Input::get('year')?Input::get('year'):'',['id'=>'year','class'=>'form-control'])}}
						</div>
						{{Form::submit('Search', ['class'=>'btn btn-primary'])}}
						{{Form::close()}}
					</div>
					<div id="results">
						{{$listItems}}
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


<script type="text/javascript">
	function sendRequest(pub_val, month_val, year_val){
		$.ajax({
			type:'post',
			url:'{{URL::to(Route($moduleRoutePrefix.'PaymentRequest', [$status]))}}',
			data:{'publisher':pub_val, 'month':month_val, 'year':year_val},
			success: function(data){
				$('#results').html(data);
			}
		})
	}

	function actionSort($field, $order){
		pub_val = $("#publisher").val();
		month_val = $("#month").find("option:selected").val();
		year_val = $("#year").find("option:selected").val();
		$.ajax({
			type:'post',
			url:'{{URL::to(Route($moduleRoutePrefix.'PaymentRequest', [$status]))}}',
			data:{'publisher':pub_val, 'month':month_val, 'year':year_val, 'field':$field, 'order':$order},
			success: function(data){
				$('#results').html(data);
			}
		})
	}
	$(document).ready(function(){
//		$("#publisher").keyup(function(){
//			pub_val = $("#publisher").val();
//			month_val = $("#month").find("option:selected").val();
//			year_val = $("#year").find("option:selected").val();
//			sendRequest(pub_val, month_val, year_val);
//		})
//		//month
//		$("#month").change(function(){
//			month_val = $(this).val();
//			year_val = $("#year").find("option:selected").val();
//			pub_val = $("#publisher").val();
//			sendRequest(pub_val, month_val, year_val);
//		})
//
//		$("#year").change(function(){
//			month_val = $("#month").find("option:selected").val();
//			year_val = $(this).val();
//			pub_val = $("#publisher").val();
//			sendRequest(pub_val, month_val, year_val);
//		})
	})
</script>