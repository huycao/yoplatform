@if(sizeof($audiences)>0)
	<select name="audience_id" class="form-control" style="width:37%">
	<option value="">Select Audience</option>
		@foreach($audiences as $audience)
			<option value="{{ $audience->audience_id }}" {{ ($selected_audience == $audience->audience_id)?'selected':''}}>{{ $audience->name }}</option>
		@endforeach
	</select>
@else
	No data
@endif