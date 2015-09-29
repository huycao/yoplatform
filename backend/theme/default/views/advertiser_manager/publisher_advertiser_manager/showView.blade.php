<div class="row mb12">
	<div class="col-md-12">
		<div class="box">
			<div class="head">{{trans('backend::publisher/text.account_information')}}</div>
			<table class="table table-striped table-hover table-condensed ">
				<tbody>
					<tr>
						<td>{{trans('backend::publisher/text.username')}}</td>
						<td>
							@if( isset($user) )
							{{ $user->username or "N\A" }}
							@endif
						</td>
						<td>{{trans('backend::publisher/text.address')}}</td>
						<td>{{{ isset($item->address) ? $item->address : "N\A" }}}</td>
					</tr>
					<tr>
						<td>{{trans('backend::publisher/text.Paymentpayableto')}}</td>
						<td><span class="badge badge-info">{{{ (isset($item->payment_to) ) ? number_format(intval($item->payment_to)) : "N\A" }}}</span></td>
						<td>{{trans('backend::publisher/text.phone')}}</td>
						<td>{{{ isset($item->phone) ? $item->phone : "N\A" }}}</td>
					</tr>
					<tr>
						<td>{{trans('backend::publisher/text.company')}}</td>
						<td>{{{ isset($item->company) ? $item->company : "N\A" }}}</td>
						<td>{{trans('backend::publisher/text.publisher_name')}}</td>
						<td>{{{ isset($item->first_name) ? $item->first_name." ".$item->last_name : "N\A" }}}</td>
					</tr>
					<tr>
						<td>{{trans('backend::publisher/text.email_address')}}</td>
						<td>{{{ isset($item->email) ? $item->email : "N\A" }}}</td>
						<td>{{trans('backend::publisher/text.country')}}</td>
						<td>{{{ isset($item->country->country_name) ? $item->country->country_name : "N\A" }}}</td>
					</tr>
				</tbody>
			</table>
		</div>		
	</div>
</div>

<div class="row mb12">
	<div class="col-md-12">
		<div class="box">
			<div class="head">{{trans('backend::publisher/text.billing_setting')}}</div>
			<table class="table table-striped table-hover table-condensed ">
                <tbody>
                    <tr>
                        <td>{{trans('backend::publisher/text.company_name')}}</td>
                        <td>
                            {{{ $item['billing_company_name'] or "N/A" }}}
                        </td>
                        <td>{{trans('backend::publisher/text.tax_id')}}</td>
                        <td>
                            {{{ $item['billing_tax_id'] or "N/A" }}}
                        </td>
                    </tr>
                    <tr>
                        <td>{{trans('backend::publisher/text.company_address')}}</td>
                        <td>
                            {{{ $item['billing_company_address'] or "N/A" }}}
                        </td>
                        <td>{{trans('backend::publisher/text.revenue_sharing')}}</td>
                        <td>
                            {{{ ($item['billing_revenue_sharing']) ? $item['billing_revenue_sharing']."%" : "N/A" }}}
                        </td>
                    </tr>
                </tbody>
			</table>
		</div>		
	</div>
</div>

<div class="row mb12">
	<div class="col-md-12">
		<div class="box">
			<div class="head">List Website</div>
			<table class="table table-striped table-hover table-condensed ">
			    <thead>
					<tr>
						<th>Name</th>
						<th>Url</th>
						<th>Action</th>
					</tr>
			    </thead>
				
				<tbody>
					
					@if( $item->publisherSite  )
						@foreach( $item->publisherSite as $website )
						<tr>
							<td><a href="{{ URL::Route($moduleRoutePrefix.'ShowViewSite', [$item['id'], $website->id ] ) }}">({{$website->id}}) {{$website->name}}</a></td>
							<td>{{$website->url}}</td>
							<td>
								<a href="{{ URL::Route($moduleRoutePrefix.'ShowUpdateSite', [$item['id'], $website->id ] ) }}" class="btn btn-default btn-sm">
									<span class="fa fa-pencil"></span> Edit
								</a>					
								<a href="{{ URL::Route($moduleRoutePrefix.'ShowDelSite', [$item['id'], $website->id ] ) }}" onclick="return confirm('You want to delete?')" class="btn btn-default btn-sm">
									<span class="fa fa-trash"></span> Del
								</a>					
							</td>
						</tr>
						@endforeach
					@else
						<tr><td colspan="4">No data</td>
					@endif
				</tbody>
			</table>
		</div>		
	</div>
</div>

