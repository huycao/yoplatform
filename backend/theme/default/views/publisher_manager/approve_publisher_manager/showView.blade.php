<div class="row">
	<div class="col-sm-12">	
		<div class="row">
			<div class="col-sm-6">
				<table class="table table-edit-publisher">
					<tbody>
						<tr>
							<td>{{trans('backend::publisher/text.site_name')}}</td>
							<td>{{{ isset($item->site_name) ? $item->site_name : "N\A" }}}</td>
						</tr>
						<tr>
							<td>{{trans('backend::publisher/text.site_URL')}}</td>
							<td>{{{ isset($item->site_url) ? $item->site_url : "N\A" }}}</td>
						</tr>
						<tr>
							<td>{{trans('backend::publisher/text.site_description')}}</td>
							<td>{{{ isset($item->site_description) ? $item->site_description : "N\A" }}}</td>
						</tr>
						<tr>
							<td>{{trans('backend::publisher/text.site_language')}}</td>
							<td>
								@if(isset($languageSelected))
									@foreach($languageSelected as $language)
										{{$language}}<br/>
									@endforeach
								@else
									{{"N\A"}}	
								@endif
							</td>
						</tr>
						<tr>
							<td>{{trans('backend::publisher/text.other_language')}}</td>
							<td>{{{ isset($item->orther_lang) ? $item->orther_lang : "N\A" }}}</td>
						</tr>
					</tbody>
				</table>		
			</div>
			<div class="col-sm-6">
				<table class="table table-edit-publisher">
					<tbody>
						<tr>
							<td>{{trans('backend::publisher/text.date_registered')}}</td>
							<td>{{{ isset($item->created_at) ? date('d-m-Y',strtotime($item->created_at)) : "N\A" }}}</td>
						</tr>
						<tr>
							<td>{{trans('backend::publisher/text.monthly_unique_visitor')}}</td>
							<td><span class="badge badge-info">{{{ isset($item->unique_visitor) ? number_format($item->unique_visitor) : "N\A" }}}</span></td>
						</tr>
						<tr>
							<td>{{trans('backend::publisher/text.monthly_page_view')}}</td>
							<td><span class="badge badge-info">{{{ isset($item->pageview) ? number_format($item->pageview) : "N\A" }}}</span></td>
						</tr>
					</tbody>
				</table>
			</div>			
		</div>
		
	</div>
</div>


<div class="row">
	<div class="col-sm-12">
		<h3 class="title-view-publisher text-uppercase">{{trans('backend::publisher/text.account_information')}} :</h3>
		<div class="row">
			<div class="col-sm-6">
				<table class="table table-edit-publisher">
					<tbody>
						<tr>
							<td>{{trans('backend::publisher/text.username')}}</td>
							<td>
								@if( isset($user) )
								{{ $user->username or "N\A" }}
								@endif
							</td>
						</tr>
						<tr>
							<td>{{trans('backend::publisher/text.Paymentpayableto')}}</td>
							<td><span class="badge badge-info">{{{ isset($item->payment_to) ? $item->payment_to : "N\A" }}}</span></td>
						</tr>
						<tr>
							<td>{{trans('backend::publisher/text.company')}}</td>
							<td>{{{ isset($item->company) ? $item->company : "N\A" }}}</td>
						</tr>
						<tr>
							<td>{{trans('backend::publisher/text.email_address')}}</td>
							<td>{{{ isset($item->email) ? $item->email : "N\A" }}}</td>
						</tr>
						<tr>
							<td>{{trans('backend::publisher/text.publisher_name')}}</td>
							<td>{{{ isset($item->first_name) ? $item->first_name." ".$item->last_name : "N\A" }}}</td>
						</tr>
						<tr>
							<td>{{trans('backend::publisher/text.country')}}</td>
							<td>{{{ isset($item->country->country_name) ? $item->country->country_name : "N\A" }}}</td>
						</tr>
					</tbody>
				</table>		
			</div>
			<div class="col-sm-6">
				<table class="table table-edit-publisher">
					<tbody>
						<tr>
							<td>{{trans('backend::publisher/text.address')}}</td>
							<td>{{{ isset($item->address) ? $item->address : "N\A" }}}</td>
						</tr>
						<tr>
							<td>{{trans('backend::publisher/text.phone')}}</td>
							<td>{{{ isset($item->phone) ? $item->phone : "N\A" }}}</td>
						</tr>
					</tbody>
				</table>
			</div>			
		</div>
		
	</div>
</div>

<div class="row margin-button-view">
	<div class="col-sm-12">
		<h3 class="title-view-publisher text-uppercase">{{trans('backend::publisher/text.approver_site')}} :</h3>
		<div class="row">
			<div class="col-sm-6">
				<table class="table table-edit-publisher">
					<tbody>
						<tr>
							<td>{{trans('backend::publisher/text.site_channel')}}</td>
							<td>
								@if(isset($channelSelected))
									@foreach($channelSelected as $channel)
										{{$channel}}<br/>
									@endforeach
								@else
									{{"N\A"}}	
								@endif
							</td>
						</tr>
					
						<tr>
							<td>{{trans('backend::publisher/text.serve_country')}}</td>
							<td>
								@if(isset($countryServeSelected))
									@foreach($countryServeSelected as $contry)
										{{$contry}}<br/>
									@endforeach
								@else
									{{"N\A"}}	
								@endif
							</td>
						</tr>						
					</tbody>
				</table>		
			</div>
			<div class="col-sm-6">
				
			</div>			
		</div>
		
	</div>
</div>
<div class="row margin-button-view">
    <div class="col-sm-12">
        
        <div class="row">
            <div class="col-sm-6">
                <h3 class="title-view-publisher text-uppercase">{{trans('backend::publisher/text.billing_setting')}}</h3>
                <table class="table table-edit-publisher">
                    <tbody>
                        <tr>
                            <td>{{trans('backend::publisher/text.company_name')}}</td>
                            <td>
                                {{{ $item['billing_company_name'] or "N/A" }}}
                            </td>
                        </tr>
                        <tr>
                            <td>{{trans('backend::publisher/text.company_address')}}</td>
                            <td>
                                {{{ $item['billing_company_address'] or "N/A" }}}
                            </td>
                        </tr>
                        <tr>
                            <td>{{trans('backend::publisher/text.tax_id')}}</td>
                            <td>
                                {{{ $item['billing_tax_id'] or "N/A" }}}
                            </td>
                        </tr>
                        <tr>
                            <td>{{trans('backend::publisher/text.revenue_sharing')}}</td>
                            <td>
                                {{{ ($item['billing_revenue_sharing']) ? $item['billing_revenue_sharing']."%" : "N/A" }}}
                            </td>
                        </tr>                        
                    </tbody>
                </table>        
            </div>
            <div class="col-sm-6">
                <h3 class="title-view-publisher text-uppercase">{{trans('backend::publisher/text.smart_publisher_setting')}}</h3>
                <table class="table table-edit-publisher">
                    <tbody>
                        <tr>
                            <td>{{trans('backend::publisher/text.premium_publisher')}}</td>
                            <?php  $isCheck = ( isset( $item->premium_publisher ) ) ? $item->premium_publisher : Input::get('premium-publisher')  ?>                                
                            <td>
	                            <input type="radio" disabled {{{ ($isCheck==1) ? "checked" : "checked" }}} name="premium-publisher" value="1" /> {{trans('backend::publisher/text.yes')}}                                        
	                            <input type="radio" disabled {{{ ($isCheck==0) ? "checked" : "" }}} name="premium-publisher" value="0" /> {{trans('backend::publisher/text.no')}} <br>
                            </td>
                        </tr>
                        <tr>
                            <td>{{trans('backend::publisher/text.domain_checking')}}</td>
                            <?php  $isCheck = ( isset( $item->domain_checking ) ) ? $item->domain_checking : Input::get('domain-checking')  ?>                                 
                            <td>
                                <input type="radio" disabled {{{ ($isCheck==1) ? "checked" : "checked" }}} name="domain-checking" value="1" /> {{trans('backend::publisher/text.yes')}}                                        
                                <input type="radio" disabled {{{ ($isCheck==0) ? "checked" : "" }}} name="domain-checking" value="0" /> {{trans('backend::publisher/text.no')}} <br>
                            </td>
                        </tr>
                        <tr>
                            <td>{{trans('backend::publisher/text.VAST_tag')}}</td>
                            <?php  $isCheck = ( isset( $item->vast_tag ) ) ? $item->vast_tag : Input::get('vast-tag')  ?>                                 
                            <td>
                                <input type="radio" disabled {{{ ($isCheck==1) ? "checked" : "checked" }}} name="vast-tag" value="1" /> {{trans('backend::publisher/text.yes')}}                                        
                                <input type="radio" disabled {{{ ($isCheck==0) ? "checked" : "" }}} name="vast-tag" value="0" /> {{trans('backend::publisher/text.no')}} <br>
                            </td>
                        </tr>
                        <tr>
                            <td>{{trans('backend::publisher/text.network_publisher')}}</td>
                            <?php  $isCheck = ( isset( $item->network_publisher ) ) ? $item->network_publisher : Input::get('network-publisher')  ?>                                 
                            <td>
                                <input type="radio" disabled {{{ ($isCheck==1) ? "checked" : "checked" }}} name="network-publisher" value="1" /> {{trans('backend::publisher/text.yes')}}                                        
                                <input type="radio" disabled {{{ ($isCheck==0) ? "checked" : "" }}} name="network-publisher" value="0" /> {{trans('backend::publisher/text.no')}} <br>
                            </td>
                        </tr> 
                        <tr>
                            <td>{{trans('backend::publisher/text.mobile_ad')}}</td>
                            <?php  $isCheck = ( isset( $item->mobile_ad ) ) ? $item->mobile_ad : Input::get('mobile_ad')  ?>                                 
                            <td>
                               <input type="radio" disabled {{{ ($isCheck==1) ? "checked" : "checked" }}} name="mobile-ad" value="1" /> {{trans('backend::publisher/text.yes')}}                                        
                               <input type="radio" disabled {{{ ($isCheck==0) ? "checked" : "" }}} name="mobile-ad" value="0" /> {{trans('backend::publisher/text.no')}} <br>
                            </td>
                        </tr>                                             
                    </tbody>
                </table> 
            </div>          
        </div>
        
    </div>
</div>

<div class="row margin-button-view">
    <div class="col-sm-12">
        
        <div class="row">
            <div class="col-sm-6">
                <h3 class="title-view-publisher text-uppercase">{{trans('backend::publisher/text.orther_infomation')}}</h3>
                <table class="table table-edit-publisher">
                    <tbody>
                       <tr>
                            <td>{{trans('backend::publisher/text.access_to_all_channels')}}</td>
                            <?php  $isCheck = ( isset( $item->access_to_all_channel ) ) ? $item->access_to_all_channel : Input::get('access-to-all-channels')  ?>                                 
                            <td>
                                <input type="radio" disabled {{{ ($isCheck==1) ? "checked" : "checked" }}} name="access-to-all-channels" value="1" /> {{trans('backend::publisher/text.yes')}}                                        
                                <input type="radio" disabled {{{ ($isCheck==0) ? "checked" : "" }}} name="access-to-all-channels" value="0" /> {{trans('backend::publisher/text.no')}} <br>
                            </td>
                        </tr>
                        <tr>
                            <td>{{trans('backend::publisher/text.newsletter')}}</td>
                            <?php  $isCheck = ( isset( $item->newsletter ) ) ? $item->newsletter : Input::get('newsletter')  ?>                                 
                            <td>
                                <input type="radio" disabled {{{ ($isCheck==1) ? "checked" : "checked" }}} name="newsletter" value="1" /> {{trans('backend::publisher/text.yes')}}                                        
                                <input type="radio" disabled {{{ ($isCheck==0) ? "checked" : "" }}} name="newsletter" value="0" /> {{trans('backend::publisher/text.no')}} <br>
                            </td>
                        </tr> 
                        <tr>
                            <td>{{trans('backend::publisher/text.enable_report_by_model')}}</td>
                            <?php  $isCheck = ( isset( $item->enable_report_by_model ) ) ? $item->enable_report_by_model : Input::get('enable-report-by-model')  ?>                                 
                            <td>
                               <input type="radio" disabled {{{ ($isCheck==1) ? "checked" : "checked" }}} name="enable-report-by-model" value="1" /> {{trans('backend::publisher/text.yes')}}                                        
                               <input type="radio" disabled {{{ ($isCheck==0) ? "checked" : "" }}} name="enable-report-by-model" value="0" /> {{trans('backend::publisher/text.no')}} <br>
                            </td>
                        </tr>                       
                    </tbody>
                </table>        
            </div>
                     
        </div>
        
    </div>
</div>