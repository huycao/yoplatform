<div class="row mb12">
	<div class="col-md-12">
		<div class="box">
			<div class="head">Website Infomation</div>
			<table class="table table-striped table-hover table-condensed ">
				<tbody>
					<tr>
						<td>Name</td>
						<td>
							{{ $item->name or '' }}
						</td>
                        <td>{{trans('backend::publisher/text.VAST_tag')}}</td>
                        <?php  $isCheck = ( isset( $item->vast_tag ) ) ? $item->vast_tag : Input::get('vast-tag')  ?>                                 
                        <td>
                            <input type="radio" disabled {{{ ($isCheck==1) ? "checked" : "checked" }}} name="vast-tag" value="1" /> {{trans('backend::publisher/text.yes')}}                                        
                            <input type="radio" disabled {{{ ($isCheck==0) ? "checked" : "" }}} name="vast-tag" value="0" /> {{trans('backend::publisher/text.no')}} <br>
                        </td>
					</tr>
					<tr>
						<td>Url</td>
						<td>
							{{ $item->url or '' }}
						</td>
                        <td>{{trans('backend::publisher/text.network_publisher')}}</td>
                        <?php  $isCheck = ( isset( $item->network_publisher ) ) ? $item->network_publisher : Input::get('network-publisher')  ?>                                 
                        <td>
                            <input type="radio" disabled {{{ ($isCheck==1) ? "checked" : "checked" }}} name="network-publisher" value="1" /> {{trans('backend::publisher/text.yes')}}                                        
                            <input type="radio" disabled {{{ ($isCheck==0) ? "checked" : "" }}} name="network-publisher" value="0" /> {{trans('backend::publisher/text.no')}} <br>
                        </td>
					</tr>
					<tr>
                        <td>{{trans('backend::publisher/text.premium_publisher')}}</td>
                        <?php  $isCheck = ( isset( $item->premium_publisher ) ) ? $item->premium_publisher : Input::get('premium-publisher')  ?>                                
                        <td>
                            <input type="radio" disabled {{{ ($isCheck==1) ? "checked" : "checked" }}} name="premium-publisher" value="1" /> {{trans('backend::publisher/text.yes')}}                                        
                            <input type="radio" disabled {{{ ($isCheck==0) ? "checked" : "" }}} name="premium-publisher" value="0" /> {{trans('backend::publisher/text.no')}} <br>
                        </td>
                        <td>{{trans('backend::publisher/text.mobile_ad')}}</td>
                        <?php  $isCheck = ( isset( $item->mobile_ad ) ) ? $item->mobile_ad : Input::get('mobile_ad')  ?>                                 
                        <td>
                           <input type="radio" disabled {{{ ($isCheck==1) ? "checked" : "checked" }}} name="mobile-ad" value="1" /> {{trans('backend::publisher/text.yes')}}                                        
                           <input type="radio" disabled {{{ ($isCheck==0) ? "checked" : "" }}} name="mobile-ad" value="0" /> {{trans('backend::publisher/text.no')}} <br>
                        </td>

                    </tr>
                    <tr>
                        <td>{{trans('backend::publisher/text.domain_checking')}}</td>
                        <?php  $isCheck = ( isset( $item->domain_checking ) ) ? $item->domain_checking : Input::get('domain-checking')  ?>                                 
                        <td>
                            <input type="radio" disabled {{{ ($isCheck==1) ? "checked" : "checked" }}} name="domain-checking" value="1" /> {{trans('backend::publisher/text.yes')}}                                        
                            <input type="radio" disabled {{{ ($isCheck==0) ? "checked" : "" }}} name="domain-checking" value="0" /> {{trans('backend::publisher/text.no')}} <br>
                        </td>
                        <td></td>
                        <td></td>
                    </tr>
				</tbody>
			</table>
		</div>		
	</div>
</div>

<div class="row mb12">
	<div class="col-md-12">
		<div class="box">
			<div class="head">List Zone</div>
			<table class="table table-striped table-hover table-condensed ">
			    <colgroup>
            		<col width="30%">
            		<col width="45%">
            		<col width="15%">
            		<col width="10%">
            	</colgroup>	
			    <thead>
					<tr>
						<th>Action</th>
						<th>Name</th>
						<th>Ad Format</th>
						<th>Target Platform</th>
					</tr>
			    </thead>
				
				<tbody>
					@if( !$item->publisherAdZone->isEmpty()  )
						@foreach( $item->publisherAdZone as $zone )
						<tr>
                            <td>
                                <a href="{{URL::Route('PublisherAdvertiserManagerSaveGetCode', [$pid,$wid,$zone->id])}}" class="btn btn-default">
									Get Code
                                </a>
                                <a href="{{URL::Route('PublisherAdvertiserManagerShowUpdateZone', [$pid,$wid,$zone->id])}}" class="btn btn-default">
                                    <span class="glyphicon glyphicon-edit">Edit</span>
                                </a>
                                <a href="javascript:;" onclick="viewFlight({{$wid}},{{$zone->ad_format_id}}, {{$pid}}, {{$zone->id}});" class=" view-flight btn btn-default">
                                    <span class="fa fa-list"> Flight</span>
                                </a>
                            </td>
                            <td>({{$zone->id}}) {{$zone->name}}</td>
							<td>{{$zone->adFormat->name}}</td>
							<td>{{ ($zone->platform == 1) ? "Web" : "Mobile" }}</td>
						</tr>
						@endforeach
					@else
						<tr><td colspan="4">No data</td></tr>
					@endif
				</tbody>
			</table>
		</div>		
	</div>
</div>

<!-- Phuong-VM 2015/06/03 -->

<script><!--
    
    function viewFlight(wid, ad_format, pid, zid) {
    	$('#myModal .modal-dialog').css("width","800px");
        $('#myModal .modal-body').html('<img src="{{ $assetURL.'img/loading-d.GIF' }}"/>');
        $('#myModal').modal("show");

        $.ajax({
            url:'{{ Url::route("PublisherAdvertiserManagerShowListFlight") }}',
            data:{website:wid,ad_format:ad_format,pid:pid,zid:zid},
            type:'POST',
            success:function(data){
                $('#myModal .modal-body').html(data);

            }
        });
	}

--></script>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">List Flight</h4>
            </div>
            <div class="modal-body">
                <img src="{{ $assetURL.'img/loading-d.GIF' }}"/>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

