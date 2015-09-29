<div class="row mb12">
	<div class="col-md-12">
		<div class="box">
			<div class="head">Conversion Detail</div>
			<table class="table table-striped table-hover table-condensed ">
				<tr>
					<td width="25%">{{trans('text.campaign')}}</td>
					<td>({{ $data->campaign->id }}) {{ $data->campaign->name }}</td>
				</tr>
				<tr>
					<td>{{trans('text.name')}}</td>
					<td>{{ $data->name or '-' }}</td>
				</tr>
				<tr>
					<td>{{trans('text.status')}}</td>
					<td>
						@if ($data->status)
							Active
						@else
							Unactive
						@endif
					</td>
				</tr>
				<tr>
					<td>{{trans('text.param')}}</td>
					<td>
						<?php
						    $arrParam = !empty($data->param) ? json_decode($data->param) : array();
					    ?>
					    @foreach ($arrParam as $param)
					    	{{$param}}<br />
					    @endforeach
					</td>
				</tr>
				<tr>
					<td>{{trans('text.source')}}</td>
					<td>{{$data->source}}</td>
				</tr>	
			</table>
		</div>		
	</div>
</div>