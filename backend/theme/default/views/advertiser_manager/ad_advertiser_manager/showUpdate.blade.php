{{ HTML::style("{$assetURL}css/checkbox.css") }}
{{ HTML::style("{$assetURL}css/selectize.default.css") }}
<div class="part">
@include("partials.show_messages")
{{ Form::open(array('enctype'=>'multipart/form-data','role'=>'form','class'=>'form-horizontal form-cms')) }}
	<div class="row">
		<div class="col-md-12">
            <!-- NAME -->
            <div class="form-group form-group-sm">
				<label class="col-md-2">{{trans('text.name')}}</label>
				<div class="col-md-4">
					<input type="text" class="form-control" id="name" value="{{{ $item->name or Input::get('name') }}}" name="name">
              	</div>
            </div>
           	<!-- CAMPAIGN -->
            <div class="form-group">
                <label class="col-md-2">{{trans('text.campaign')}}</label>
                <div class="col-md-4">
                 <input type="hidden" id="campaign_id"
                    value="{{{ $item->campaign_id or Input::get('campaign_id') }}}" name="campaign_id">
                 <input type="text" class="form-control input-sm" id="campaign"
                    value="{{{ $item->campaign->name or Input::get('campaign') }}}" name="campaign" readonly onclick="Select.openModal('campaignR2')" placeholder="Click here to select campaign">
                </div>
              	<!-- <div class="col-md-3 text-select">
					<a href="javascript:;" onclick="Select.openModal('campaign')"
                    class="btn btn-default btn-block btn-sm">{{trans('text.select_campaign')}}</a>
                </div> -->
            </div>
            <!-- Platform -->
            <div class="form-group form-group-sm">
            	<label class="col-md-2">{{trans('text.platform')}}</label>
            	<div class="col-md-6">
                	<div class="checkbox checkbox-info checkbox-inline">
                    	{{ Form::checkbox('selectAll', '', false, array('id'=>"select-all"))}}
                    	<label class="mgr20" for="select-all"> All </label>
                 	</div>
                    @foreach($listPlatform as $key=>$platform)
                    	<div class="checkbox checkbox-info checkbox-inline">
                            <?php 
                                $checked = false;
                                $splatform = Input::get('platform');
                              
                                if ((!empty($item->platform) && in_array($key, $item->platform)) || (!empty($splatform) && in_array($key, $splatform)) || (0 == $id)) {
                                    $checked = true;
                                }
                            ?>
                        	{{ Form::checkbox('platform[]', $key, $checked, array("id"=>"platform_".$key, 'class'=>'check-platform'))}}
                        	<label class="mgr20" for="platform_{{$key}}"> {{$platform}} </label>
                    	</div>
                    @endforeach
				</div>
            </div>
            <!-- AD FORMAT -->
            @if (!1)
            <div class="form-group">
              <label class="col-md-2">{{trans('text.ad_format')}}</label>
              <div class="col-md-4">
                 <?php
                    $AdFormatValue = (isset($item->ad_format_id)) ? $item->ad_format_id : Input::get('ad_format_id');
                    ?>
                 {{ Form::select('ad_format_id', $listAdFormat, $AdFormatValue,  array('class'=>'form-control input-sm','id'=>'ad_format_id')) }}
              </div>
            </div>
            @endif
            <!-- AD FORMAT -->
            <div class="form-group">
            	<label class="col-md-2">{{trans('text.ad_format')}}</label>
                <?php
                    $AdFormatValue = (isset($item->ad_format_id)) ? $item->ad_format_id : Input::get('ad_format_id');
                ?>
           		<div class="col-md-6">
                	<select name="ad_format_id" id="ad_format_id" placeholder="Select Ad Format" tabindex="-1" class="selectized" style="display: none;">
                    	<option value="" selected="selected"></option>
                	</select>
              	</div>
            </div>
            <!-- AD VIEW -->
            <div class="form-group form-group-sm ad-info">
            	<label class="col-md-2">{{trans('text.ad_view')}}</label>
            	<div class="col-md-1">
               		<div class="radio input-sm">
                  		<div class="radio radio-info radio-inline">
                     		{{ Form::radio('ad_view_type','0', 0 == Input::get('ad_view_type',0) || (!empty($item->ad_view_type) && 0 == $item->ad_view_type) ,array("class"=>"ad-view-type","id"=>"default-ad-view-type"))}}
                     		<label for="default-ad-view-type"> Default </label>
                  		</div>
               		</div>
        		</div>
            	<div class="col-md-1">
               		<div class="radio input-sm">
                  		<div class="radio radio-info radio-inline">
                     		{{ Form::radio('ad_view_type','1', 1 == Input::get('ad_view_type',0) || (!empty($item->ad_view_type) && 1 == $item->ad_view_type) ,array("class"=>"ad-view-type","id"=>"other-ad-view-type"))}}
                     		<label for="other-ad-view-type"> Other </label>
                  		</div>
               		</div>
        		</div>
				<div class="col-md-4">
                	<input type="text" class="form-control hidden" id="ad-view" value="{{{ $item->ad_view or Input::get('ad_view') }}}" name="ad_view">
             	</div>
            </div>
            
            <!-- TYPE -->
            <div class="form-group form-group-sm ad-info">
            	<label class="col-md-2">{{trans('text.ad_type')}}</label>
          		<div class="col-md-4">
             		@if( !empty($listAdType) )
             			<div class="row">
                			@foreach( $listAdType as $key => $value )
                				<div class="col-md-4">
                   					<div class="radio input-sm">
                                    	<div class="radio radio-info radio-inline">
                                    		{{ Form::radio('ad_type',$key, $key == Input::get('ad_type','image') || ( !empty($item->ad_type) && $key == $item->ad_type) ,array("class"=>"ad_type", "id"=>"ad_type_".$key))}}
                                        	<label for="ad_type_{{$key}}"> {{$value}} </label>
                                      	</div>
                   					</div>
                				</div>
                			@endforeach
             			</div>
             		@endif
          		</div>
            </div>
            <!-- POSITION -->
            <div class="form-group form-group-sm ad-info">
              <label class="col-md-2">{{trans('text.position')}}</label>
              <div class="col-md-1">
                  <div class="radio input-sm">
                      <div class="radio radio-info radio-inline">
                        {{ Form::radio('position','top', 'top' == Input::get('position','top') || (!empty($item->position) && 'top' == $item->position) ,array("id"=>"position-top"))}}
                        <label for="position-top"> Top </label>
                      </div>
                  </div>
              </div>
              <div class="col-md-1">
                  <div class="radio input-sm">
                      <div class="radio radio-info radio-inline">
                        {{ Form::radio('position','down', 'down' == Input::get('position') || (!empty($item->position) && 'down' == $item->position) ,array("id"=>"position-down"))}}
                        <label for="position-down"> Down </label>
                      </div>
                  </div>
              </div>
              <div class="col-md-1">
                  <div class="radio input-sm">
                      <div class="radio radio-info radio-inline">
                        {{ Form::radio('position','overlay', 'overlay' == Input::get('position') || (!empty($item->position) && 'overlay' == $item->position) ,array("id"=>"position-overlay"))}}
                        <label for="position-overlay"> Overlay </label>
                      </div>
                  </div>
              </div>
            </div>
            <!-- TYPE -->
            <div class="form-group form-group-sm ad-info">
              	<label class="col-md-2 no-html-format">{{trans('text.source_type')}}</label>
              	<div class="col-md-4">
                 	<div class="row">
                    	<div class="col-md-6">
                       		<div class="radio input-sm">
                          		<div class="radio radio-info radio-inline">
                             		{{ Form::radio('sourcea','source_image', 'source' ,array("class"=>"source", "id"=>"source_type_image"))}}
                             		<label for="source_type_image"> Source </label>
                          		</div>
                   			</div>
                    	</div>
                        <div class="col-md-6">
                           	<div class="radio input-sm">
                              	<div class="radio radio-info radio-inline">
                                 	{{ Form::radio('sourcea','source_image_upload', '' ,array("class"=>"source", "id"=>"source_type_image_upload"))}}
                                 	<label for="source_type_image_upload"> File Upload </label>
                              	</div>
                           </div>
                        </div>
                 	</div>
              	</div>
            </div>
            
            <!-- DISPLAY TYPE -->
            <div class="form-group form-group-sm ad-info">
            	<label class="col-md-2 html-format">{{trans('text.display_type')}}</label>
            	<div class="col-md-1">
               		<div class="radio input-sm">
                  		<div class="radio radio-info radio-inline">
                     		{{ Form::radio('display_type','inpage', 'inpage' == Input::get('inpage','inpage') || (!empty($item->display_type) && 'inpage' == $item->display_type) ,array("id"=>"display-type-inpage"))}}
                     		<label for="display-type-inpage"> Inpage </label>
                  		</div>
               		</div>
        		</div>
            	<div class="col-md-1">
               		<div class="radio input-sm">
                  		<div class="radio radio-info radio-inline">
                     		{{ Form::radio('display_type','popup', 'popup' == Input::get('display_type') || (!empty($item->display_type) && 'popup' == $item->display_type) ,array("id"=>"display-type-popup"))}}
                     		<label for="display-type-popup"> Popup </label>
                  		</div>
               		</div>
        		</div>
            </div>
            
            <div id="source_image" class="show ad-info">
              	<!-- SOURCE URL -->
              	<div class="form-group form-group-sm ad-info no-html-format">
                 	<label class="col-md-2 no-html-format">{{trans('text.source_url')}}</label>
                 	<div class="col-md-4">
                    	<input type="text" class="form-control" id="source_url" value="{{{ $item->source_url or Input::get('source_url') }}}" name="source_url">
                 	</div>
              	</div>
              	<!-- SOURCE URL -->
              	<div class="form-group form-group-sm ad-info">
                 	<label class="col-md-2 no-html-format">{{trans('text.source_url2')}}</label>
                 	<div class="col-md-4">
                    	<input type="text" class="form-control" id="source_url2" value="{{{ $item->source_url2 or Input::get('source_url2') }}}" name="source_url2">
                 	</div>
             	 </div>
            </div>
            <!-- HTML SOURCE -->
             <div class="form-group ad-info">
                <label class="col-md-2 html-format">{{trans('text.html_source')}}</label>
                <div class="col-md-10">
                   <textarea class="form-control" name="html_source" id="html_source"
                      rows="10">{{{$item->html_source or Input::get('html_source')}}}</textarea>
                </div>
             </div>
             <div class="form-group form-group-sm ad-info">
             	<label class="col-md-2 html-format">{{trans('text.vast_file')}}</label>
             	<div class="col-md-4">
                	<input type="file" class="form-control" id="vast_file" name="vast_file">
             	</div>
          	</div>
            <div id="source_image_upload" class="hidden ad-info">
              	<!-- FILE SOURCE URL -->
              	<div class="form-group form-group-sm ad-info no-html-format">
                 	<label class="col-md-2">{{trans('text.upload_source')}}</label>
                 	<div class="col-md-4">
                    	<input type="file" class="form-control" id="file_source_url" name="file_source_url">
                 	</div>
              	</div>
              	<!-- FILE SOURCE URL -->
              	<div class="form-group form-group-sm ad-info">
                 	<label class="col-md-2">{{trans('text.upload_source_2')}}</label>
                 	<div class="col-md-4">
                    	<input type="file" class="form-control" id="file_source_url_2" name="file_source_url_2">
                 	</div>
              	</div>
            </div>
            <!-- WIDTH -->
            <div class="form-group form-group-sm ad-info">
              	<label class="col-md-2">{{trans('text.width')}}</label>
              	<div class="col-md-4">
                 	<input type="text" class="form-control" id="width" value="{{{ $item->width or Input::get('width') }}}" name="width">
              	</div>
            </div>
            <!-- HEIGHT -->
            <div class="form-group form-group-sm ad-info">
              	<label class="col-md-2">{{trans('text.height')}}</label>
              	<div class="col-md-4">
                 	<input type="text" class="form-control" id="height" value="{{{ $item->height or Input::get('height') }}}" name="height">
              	</div>
            </div>
            <!-- WIDTH 2-->
            <div class="form-group form-group-sm ad-info">
              	<label class="col-md-2">{{trans('text.width_2')}}</label>
              	<div class="col-md-4">
                 	<input type="text" class="form-control" id="width_2" value="{{{ $item->width_2 or Input::get('width_2') }}}" name="width_2">
              	</div>
            </div>
            <!-- HEIGHT 2 -->
            <div class="form-group form-group-sm ad-info">
              	<label class="col-md-2">{{trans('text.height_2')}}</label>
              	<div class="col-md-4">
                 	<input type="text" class="form-control" id="height_2" value="{{{ $item->height_2 or Input::get('height_2') }}}" name="height_2">
              	</div>
            </div>
            
            <!-- BAR HEIGHT -->
            <div class="form-group form-group-sm ad-info">
              	<label class="col-md-2">{{trans('text.bar_height')}}</label>
              	<div class="col-md-4">
                 	<input type="text" class="form-control" id="bar_height" value="{{{ $item->bar_height or Input::get('bar_height') }}}" name="bar_height">
              	</div>
            </div>
            <!-- Main Source -->
            <div class="form-group form-group-sm ad-info">
              	<label class="col-md-2 no-html-format">{{trans('text.main_source')}}</label>
              	<div class="col-md-4">
	                <?php
                        $source_url = (isset($item->main_source) && $item->main_source == "source_url") ? $item->main_source : "source_url";
                        $source_url2 = (isset($item->main_source) && $item->main_source == "source_url2") ? $item->main_source : "";
                    ?>
                 	<div class="radio radio-info radio-inline">
                    	{{ Form::radio('main_source','source_url', $source_url, array("id"=>"main_source_source_url") )}}
                    	<label for="main_source_source_url"> Source Url </label>
                 	</div>
                 	<div class="radio radio-info radio-inline">
                    	{{ Form::radio('main_source','source_url2',$source_url2, array("id"=>"main_source_source_url2") )}}
                    	<label for="main_source_source_url2"> Source Url 2 </label>
                 	</div>
              	</div>
            </div>
            
            <!-- DESTINATION URL -->
            <div class="form-group form-group-sm ad-info">
              	<label class="col-md-2">{{trans('text.destination_url')}}</label>
              	<div class="col-md-4">
                 	<input type="text" class="form-control" id="destination_url" value="{{{ $item->destination_url or Input::get('destination_url') }}}" name="destination_url">
              	</div>
            </div>
            <!-- TYPE -->
            <div class="form-group form-group-sm">
				<label class="col-md-2">{{trans('text.ad_source_backup')}}</label>
              	<div class="col-md-4">
                 	<div class="row">
                    	<div class="col-md-6">
                       		<div class="radio input-sm">
                          		<div class="radio radio-info radio-inline">
                             		{{ Form::radio('source_backup','source_backup_image', 'source' ,array("class"=>"source_backup", "id"=>"source_backup_image"))}}
                             		<label for="source_backup_image"> Source </label>
                          		</div>
                       		</div>
                		</div>
                    	<div class="col-md-6">
                       		<div class="radio input-sm">
                          		<div class="radio radio-info radio-inline">
                             		{{ Form::radio('source_backup','source_backup_image_upload', '' ,array("class"=>"source_backup", "id"=>"source_backup_image_upload"))}}
                             		<label for="source_backup_image_upload"> File Upload </label>
                          		</div>
                       		</div>
                		</div>
                 	</div>
              	</div>
            </div>
            <div id="source_backup_url">
              	<!-- SOURCE URL -->
              	<div class="form-group form-group-sm">
                 	<label class="col-md-2">{{trans('text.source_backup_url')}}</label>
                 	<div class="col-md-4">
                    	<input type="text" class="form-control" id="source_backup_url-text" value="{{{ $item->source_url_backup or Input::get('source_url_backup') }}}" name="source_url_backup">
             		</div>
          		</div>
            </div>
            <div id="source_backup_upload" class="hidden">
              	<!-- FILE SOURCE URL -->
              	<div class="form-group form-group-sm ad-info">
                 	<label class="col-md-2">{{trans('text.source_backup_url_upload')}}</label>
                 	<div class="col-md-4">
                    	<input type="file" class="form-control" id="file_source_backup_url" name="file_source_backup_url">
                 	</div>
              	</div>
            </div>
           	@if(isset($item) && $item->ad_type == "flash" )
		    	<div class="show ad-info" id="flash">
      	   	@else
			  	<div class="hidden" id="flash">
           	@endif
         	<!-- WIDTH -->
            <!-- <div class="form-group form-group-sm ad-info">
            	<label class="col-md-2">{{trans('text.width_after')}}</label>
                
                <div class="col-md-4">
                    <input type="text" class="form-control" id="width_after"
                           value="{{{ $item->width_after or Input::get('width_after') }}}"
                           name="width_after">
                </div>
                </div> -->
             <!-- HEIGHT -->
             <!-- <div class="form-group form-group-sm ad-info">
                <label class="col-md-2">{{trans('text.height_after')}}</label>
                
                <div class="col-md-4">
                    <input type="text" class="form-control" id="height_after"
                           value="{{{ $item->height_after or Input::get('height_after') }}}"
                           name="height_after">
                </div>
                </div> -->
             <!-- WMODE -->
         	<div class="form-group form-group-sm ad-info">
            	<label class="col-md-2 no-html-format">{{trans('text.flash_wmode')}}</label>
            	<div class="col-md-4">
               		@if( !empty($listWmode) )
               			<div class="row">
                  			@foreach( $listWmode as $wmode)
                  				<div class="col-md-4">
                     				<div class="radio input-sm">
                        				<div class="radio radio-info radio-inline">
                           					{{ Form::radio('flash_wmode',$wmode, $wmode == Input::get('flash_wmode','none') || ( !empty($item->flash_wmode) && $wmode == $item->flash_wmode), array("id"=>$wmode) )}}
                           					<label for="{{$wmode}}"> {{ucfirst($wmode)}} </label>
                        				</div>
                    				</div>
                  				</div>
                  			@endforeach
               			</div>
               		@endif
            	</div>
         	</div>
      	</div>
      	@if(isset($item) && $item->ad_type == "video" )
      		<div class="show" id="video">
 		@else
         	<div class="hidden" id="video">
        @endif
        <!-- VIDEO DURATION -->
        <div class="form-group form-group-sm ad-info">
           <label class="col-md-2 no-html-format">{{trans('text.video_duration')}}</label>
           <div class="col-md-4">
              <input type="text" class="form-control" id="video_duration" value="{{{ $item->video_duration or Input::get('video_duration') }}}" name="video_duration">
           </div>
        </div>
        <!-- VIDEO LINEAR -->
        <div class="form-group form-group-sm ad-info">
           <label class="col-md-2 no-html-format">{{trans('text.video_linear')}}</label>
           <div class="col-md-4">
              @if( !empty($listVideoLinear) )
              @foreach( $listVideoLinear as $key => $videoLinear )
              <div class="radio radio-info radio-inline">
                 {{ Form::radio('video_linear',$key, $key == Input::get('video_linear','linear') || ( !empty($item->video_linear) && $key == $item->video_linear), array("id"=>"video_linear_".$key) )}}
                 <label for="video_linear_{{$key}}"> {{$videoLinear}} </label>
              </div>
              @endforeach
              @endif
           </div>
        </div>
        <!-- VIDEO TYPE VAST -->
        <div class="form-group form-group-sm ad-info">
           <label class="col-md-2 no-html-format">{{trans('text.video_type_vast')}}</label>
           <div class="col-md-4">
              @if( !empty($listTypeVast) )
                  @foreach( $listTypeVast as $key => $typeVast )
                  <div class="radio radio-info radio-inline">
                     {{ Form::radio('video_type_vast',$key, $key == Input::get('video_type_vast','inline') || ( !empty($item->video_type_vast) && $key == $item->video_type_vast), array("id"=>"video_type_vast_".$key) )}}
                     <label for="video_type_vast_{{$key}}"> {{$typeVast}} </label>
                  </div>
                  @endforeach
              @endif
           </div>
        </div>
        <!-- VIDEO WRAPPER TAG -->
        <div class="form-group form-group-sm ad-info">
            <label class="col-md-2 no-html-format">Skip ads</label>
            <div class="col-md-4">
                <input type="text" class="form-control" id="skipads"
                       value="{{{ $item->skipads or Input::get('skipads') }}}"
                       name="skipads">
            </div>
        </div>
        
        <!-- VIDEO WRAPPER TAG -->
        <div class="form-group form-group-sm ad-info">
           <label class="col-md-2 no-html-format">{{trans('text.video_wrapper_tag')}}</label>
           <div class="col-md-4">
              <input type="text" class="form-control" id="video_wrapper_tag"
                 value="{{{ $item->video_wrapper_tag or Input::get('video_wrapper_tag') }}}"
                 name="video_wrapper_tag">
           </div>
        </div>
        <!-- VAST INLUCDE -->
        <div class="form-group form-group-sm">
        	<label class="col-md-2">{{trans('text.vast_include')}}</label>
        	<div class="col-md-6">
            	<div class="checkbox checkbox-info checkbox-inline">
            		<?php 
            		    if (isset($item->vast_include)) {
            		        $checked = $item->vast_include;
            		    } else {
            		        $checked = Input::get('vast_include', 0);
            		    }
            		    
            		?>
                	{{ Form::checkbox('vast_include', 1, $checked, array('id'=>'vast_inclue'))}}
                	<label class="mgr20" for="vast_inclue"> Yes </label>
             	</div>
    		  </div>
        </div>
        <!-- VPAID -->
        <div class="form-group form-group-sm">
          <label class="col-md-2">{{trans('text.vpaid')}}</label>
          <div class="col-md-6">
              <div class="checkbox checkbox-info checkbox-inline">
                <?php 
                    if (isset($item->vpaid)) {
                        $checked = $item->vpaid;
                    } else {
                        $checked = Input::get('vpaid', 0);
                    }
                    
                ?>
                  {{ Form::checkbox('vpaid', 1, $checked, array('id'=>'vpaid'))}}
                  <label class="mgr20" for="vpaid"> Yes </label>
              </div>
          </div>
        </div>
        <!-- VIDEO BITRATE -->
        <div class="form-group form-group-sm ad-info">
           <label class="col-md-2 no-html-format">{{trans('text.video_bitrate')}}</label>
           <div class="col-md-4">
              <input type="text" class="form-control" id="video_bitrate"
                 value="{{{ $item->video_bitrate or Input::get('video_bitrate') }}}"
                 name="video_bitrate">
           </div>
        </div>
     	</div>
      <!-- AUDIENCE -->
      <div class="form-group ad-info">
          <label class="col-md-2">Audience</label>
          <div class="col-md-10" id="audience">
            @if(sizeof($audiences)>0)
              <select name="audience_id" class="form-control" style="width:37%">
              <option value="">Select Audience</option>
                @foreach($audiences as $audience)
                  <option value="{{ $audience->audience_id }}" {{ ($item->audience_id == $audience->audience_id)?'selected':''}}>{{ $audience->name }}</option>
                @endforeach
              </select>
            @else
              No data
            @endif
            </div>
       </div>
     	<!-- THIRD-PARTY TRACKING -->
     	<div class="form-group ad-info">
            <label class="col-md-2">{{trans('text.third_party_tracking_event')}}</label>
            <div class="col-md-10">
               <div class="form-group form-group-sm">
                  <div class="col-md-2">
                     Event
                  </div>
                  <div class="col-md-9">
                     Tracking URL
                  </div>
                  <div class="col-md-1">
                     <div class="add-item"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></div>
                  </div>
               </div>
               <div id="tracking">
                  <?php
                     $trackings  =  (isset($item->third_party_tracking) && $item->third_party_tracking) ? json_decode($item->third_party_tracking) : "";
                     ?>
                  @if($trackings == "")
                  <div class="form-group form-group-sm tracking-item">
                     <div class="col-md-2">
                        <input type="text" class="form-control" value="" name="tracking[1][event]">
                     </div>
                     <div class="col-md-9">
                        <textarea name="tracking[1][url]" class="form-control"></textarea>
                     </div>
                     <div class="col-md-1">
                        <div class="remove-item"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></div>
                     </div>
                  </div>
                  <div id="count-tracking" class="hidden">1</div>
                  @else
                  @foreach($trackings as $key => $tracking)
                  <div class="form-group form-group-sm tracking-item">
                     <div class="col-md-2">
                        <input type="text" class="form-control" value="{{ $tracking->event }}" name="tracking[{{$key}}][event]">
                     </div>
                     <div class="col-md-9">
                        <textarea name="tracking[{{$key}}][url]" class="form-control">{{ $tracking->url }}</textarea>
                     </div>
                     <div class="col-md-1">
                        <div class="remove-item"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></div>
                     </div>
                  </div>
                  @endforeach
                  <div id="count-tracking" class="hidden">{{ $key }}</div>
                  @endif
               </div>
            </div>
         </div>
         <!-- third IMPRESSION TRACKS -->
         <div class="form-group ad-info">
            <label class="col-md-2">{{trans('text.third_impression_track')}}</label>
            <div class="col-md-10">
               <textarea class="form-control" name="third_impression_track"
                  rows="5">{{{$item->third_impression_track or Input::get('third_impression_track')}}}</textarea>
            </div>
         </div>
         <!-- third CLICK TRACKS -->
         <div class="form-group ad-info">
            <label class="col-md-2">{{trans('text.third_click_track')}}</label>
            <div class="col-md-10">
               <textarea class="form-control" name="third_click_track"
                  rows="5">{{{$item->third_click_track or Input::get('third_click_track')}}}</textarea>
            </div>
         </div>
      </div>
   </div>
   <div class="row">
      <div class="col-md-12">
         @include("partials.save")
      </div>
   </div>
   {{ Form::close() }}
   <div id="loadSelectModal">
      @include("partials.select")
   </div>
</div>
<script type="text/javascript">
	$(function () {
		var ad_type = null;
    
		$("#ad_format_id").selectize({
			options: {{$listAdFormat}},
           	optgroups: [{id: 'dynamic', name: 'Dynamic Banner'},
           				{id: 'static', name: 'Static Banner'}],
           	items: [{{$AdFormatValue}}],
           	labelField: 'name',
           	valueField: 'id',
           	optgroupField: 'type',
           	optgroupLabelField: 'name',
           	optgroupValueField: 'id',
           	optgroupOrder: ['dynamic', 'static'],
           	searchField: ['name'],
           	sortField: [{field: 'type', direction: 'asc'}],
           	plugins: ['optgroup_columns'],
   			onChange: function(value) {
           		if ('' == value) {
   					$('.ad-info').hide();
   				} else {
   					var label = this.getItem(value)[0].innerHTML;
   					ad_type = label;
   					$('.ad-info').show();
            ad_format = value;
					showVideoTag(label);
					if ('HTML' == ad_type) {
	           			$("#ad_type_html").parent().parent().parent().hide();
	           		}
   				}
   			},
   			onInitialize: function() {
   				var ad_type = $("#ad_format_id").text();
				if ('' == ad_type) {
   					$('.ad-info').hide();
   				} else {
   					$('.ad-info').show();
   					showVideoTag(ad_type);
   				}
   			}
       	});
   		$('#select-all').click(function() {  //on click 
            var mobile_app = getMobileAppFormat();
            var no_mobile_app = getNoMobileAppFormat();
            if(this.checked) { // check select status
                $('.check-platform').each(function() { //loop through each checkbox
                    this.checked = true;  //select all checkboxes with class "checkbox1"               
                });
                
                addOption($('#ad_format_id'), mobile_app);  
                addOption($('#ad_format_id'), no_mobile_app); 
            }else{
                $('.check-platform').each(function() { //loop through each checkbox
                    this.checked = false; //deselect all checkboxes with class "checkbox1"                       
                }); 
                removeOption($('#ad_format_id'), mobile_app);  
                removeOption($('#ad_format_id'), no_mobile_app);       
            }
    	});
  
   		setCheckAll('#select-all', '.check-platform');      
   
       	$('.check-platform').click(function() {
       		setCheckAll('#select-all', '.check-platform');
       	});
   
       	$(".ad_type").click(function () {
           	$adtype = $(this).val();
           	$("#image").removeClass("show");
           	$("#image").removeClass("hidden");
           	$("#flash").removeClass("show");
           	$("#flash").removeClass("hidden");
           	$("#video").removeClass("show");
           	$("#video").removeClass("hidden");
           	if ($adtype == 'image') {
               	$("#image").addClass("show");
               	$("#video").addClass("hidden");
               	$("#flash").addClass("hidden");
               	showVideoTag(ad_type);
           	}
           	if ($adtype == 'flash') {
               	$("#flash").addClass("show");
               	$("#video").addClass("hidden");
               	$("#image").addClass("hidden");
               	showVideoTag(ad_type);
           	}
           	if ($adtype == 'video') {
               	$("#video").addClass("show");
               	$("#flash").addClass("hidden");
               	$("#image").addClass("hidden");
               	showVideoTag(ad_type);
           	}

           	if ($adtype == 'html') {
           		showVideoTag('HTML');
           		if ('HTML' == $("#ad_format_id").text() || 'Video' == $("#ad_format_id").text()) {
           			$("#ad_type_video").parent().parent().parent().show();
           		} else {
           			$("#ad_type_video").parent().parent().parent().hide();
           		}
           	}
           	
   		});
       	$(".source").click(function () {
           	$adtype = $(this).val();
           	$("#source_image_upload").removeClass("show");
           	$("#source_image").removeClass("hidden");
           	$("#source_image").removeClass("show");
           	$("#source_image_upload").removeClass("hidden");
           	if ($adtype == 'source_image_upload') {
               	$("#source_image_upload").addClass("show");
               	$("#source_image").addClass("hidden");
                if ($("#ad_format_id").text() == 'Mobile Pull'){
                  $("#file_source_url_2").parent().parent().hide();
                }
           	}
           	if ($adtype == 'source_image') {
               	$("#source_image").addClass("show");
               	$("#source_image_upload").addClass("hidden");
           	}
       	});

       	$(".source_backup").click(function () {
           	$adtype = $(this).val();
           	$("#source_backup_url").removeClass("show");
           	$("#source_backup_url").removeClass("hidden");
           	$("#source_backup_upload").removeClass("hidden");
           	$("#source_backup_upload").removeClass("show");
           
           	if ($adtype == 'source_backup_image_upload') {
               	$("#source_backup_upload").addClass("show");
               	$("#source_backup_url").addClass("hidden");
           	}
           	if ($adtype == 'source_backup_image') {
               	$("#source_backup_url").addClass("show");
               	$("#source_backup_upload").addClass("hidden");
           	}
       	});
       
       	// add tracking-item
       	$(".add-item").click(function(){
           	$i = parseInt($("#count-tracking").html()) + 1;
           	$html = '<div class="form-group form-group-sm tracking-item">'+
                   '<div class="col-md-2">'+
                   '<input type="text" class="form-control" value="" name="tracking['+$i+'][event]">'+
                   '</div>'+
                   '<div class="col-md-9">'+
                   '<textarea name="tracking['+$i+'][url]" class="form-control"></textarea>'+
                   '</div>'+
                   '<div class="col-md-1">'+
                   '<div class="remove-item"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></div></div></div>';
           	$("#tracking").append($html);
           	$("#count-tracking").html($i);
   
       	});
       	$(document).on('click', ".remove-item",function(){
           	$(this).parent().parent().remove();
       	});

       	setAdView();
   		$('.ad-view-type').click(function() {
   			setAdView();
   		});
     
   	});
   
   	function showVideoTag(value) {
   		$("#image").removeClass("show");
   		$("#image").removeClass("hidden");
   		$("#flash").removeClass("show");
   		$("#flash").removeClass("hidden");
   		$("#video").removeClass("show");
   		$("#video").removeClass("hidden");
      $("#position-top").parent().parent().parent().parent().hide(); 
   		if('html' == $(".ad_type:checked").val()) {
   			$(".no-html-format").parent().hide();
       		$(".html-format").parent().show();
   		} else {
       		$(".no-html-format").parent().show();
       		$(".html-format").parent().hide();
   		}
   
   		if (value == 'Video') {
   			$("#ad_type_video").parent().parent().parent().show();
   			$("#ad_type_image").parent().parent().parent().hide();
   			$("#ad_type_flash").parent().parent().parent().hide();
   			$("#ad_type_html").parent().parent().parent().show();
   			$("#image").addClass("hidden");
           	$("#flash").addClass("hidden");
       		if ($('#ad_type_video').is(':checked')) {
       			$("#video").addClass("show");
   			} else {
   				$("#video").addClass("hidden");
   			}
   		} else if (value == 'HTML') {
   			$(".no-html-format").parent().hide();
   			$(".html-format").parent().show();
   			$("#ad_type_video").parent().parent().parent().show();
   			$("#ad_type_image").parent().parent().parent().show();
			 //$("#ad_type_flash").parent().parent().parent().show();
        if ($('#ad_format_id').text() == 'Mobile Pull') {
          $("#display-type-inpage").parent().parent().parent().parent().hide();
        }
   		} else if (value == 'Mobile Pull') {
          showInputMobilePull();
      } else {
   			$("#ad_type_video").parent().parent().parent().hide();
   			$("#ad_type_image").parent().parent().parent().show();
			  $("#ad_type_flash").parent().parent().parent().show();
			  $("#ad_type_html").parent().parent().parent().show();
   			$("#image").addClass("show");
       	$("#video").addClass("hidden");
       	$("#flash").addClass("show");
   		}
	}
   
   	function setCheckAll(checkAll, checks) {
   		if ($(checks+':checked').length == $(checks).length) {
    		$(checkAll).prop("checked", true);
    	} else {
    		$(checkAll).prop("checked", false);
    	}
      var ad_format= {{!empty($AdFormatValue) ? $AdFormatValue : 0}};
      if ($('#ad_format_id')[0].selectize.getValue()) {
        ad_format = $('#ad_format_id')[0].selectize.getValue();
      }
      var mobile_app = getMobileAppFormat();
      var no_mobile_app = getNoMobileAppFormat();
      $('#ad_format_id')[0].selectize.clearOptions();
      if ($('#platform_pc').is(':checked') || $('#platform_mobile').is(':checked')) {
        addOption($('#ad_format_id'), no_mobile_app);
      } else {
        removeOption($('#ad_format_id'), no_mobile_app);
      }
      if ($('#platform_mobile_app').is(':checked')) {
        addOption($('#ad_format_id'), mobile_app);
      } else {
        removeOption($('#ad_format_id'), mobile_app);
      }
      
      $('#ad_format_id')[0].selectize.setValue(ad_format);
   	}

   	function setAdView() {
   		$('#ad-view').removeClass('show');
   		$('#ad-view').removeClass('hidden');
  		if (1 == $("[name='ad_view_type']:checked").val()) {
  			$('#ad-view').addClass('show');
  		} else {
  			$('#ad-view').val('');
  			$('#ad-view').addClass('hidden');
  		}
   	}

    function getMobileAppFormat() {
      var mobile_app_formats= [];
      <?php
        $arrAdFormat = json_decode($listAdFormat);
      ?>
      @foreach($arrAdFormat as $adFormat)
        @if ($adFormat->name == 'Mobile Pull')
          mobile_app_formats.push(JSON.parse('{{ json_encode($adFormat) }}'));
        @endif
      @endforeach
      return mobile_app_formats;
    }

    function getNoMobileAppFormat() {
      var mobile_app_formats= [];
      <?php
        $arrAdFormat = json_decode($listAdFormat);
      ?>
      @foreach($arrAdFormat as $adFormat)
        @if ($adFormat->name != 'Mobile Pull')
          mobile_app_formats.push(JSON.parse('{{ json_encode($adFormat) }}'));
        @endif
      @endforeach
      return mobile_app_formats;
    }

    function addOption(el, data) {
       var selectize = el[0].selectize;
       data.forEach(function(item){
         selectize.addOption(item);
       });
    }

    function removeOption(el, data) {
       var selectize = el[0].selectize;
       selectize.clear();
       data.forEach(function(item){
         selectize.removeOption(item.id);
       });
    }

    function showInputMobilePull() {
      $("#ad_type_flash").parent().parent().parent().hide();
      $("#ad_type_video").parent().parent().parent().hide();
      $("#source_url2").parent().parent().hide();
      $("#width_2").parent().parent().hide();
      $("#height_2").parent().parent().hide();
      $("#bar_height").parent().parent().hide();
      $("#main_source_source_url").parent().parent().parent().hide();
      $("#source_backup_image").parent().parent().parent().parent().parent().parent().hide();
      $("#source_backup_url").hide();
      $("#none").parent().parent().parent().parent().parent().parent().parent().hide();
      $("#video_duration").parent().parent().hide();
      $("#video_linear_linear").parent().parent().parent().hide();
      $("#skipads").parent().parent().hide();
      $("#video_wrapper_tag").parent().parent().hide();
      $("#vast_inclue").parent().parent().parent().hide();
      $("#video_bitrate").parent().parent().hide();
      $("#video_type_vast_inline").parent().parent().parent().hide();
      $("#tracking").parent().parent().hide();
      $("#default-ad-view-type").parent().parent().parent().parent().hide();
      $("#display-type-inpage").parent().parent().parent().parent().hide();    

      $("#ad_type_image").parent().parent().parent().show();
      $("#ad_type_html").parent().parent().parent().show();
      if ($('.ad_type:checked').val() == 'html') {
        $("#source_url").parent().parent().hide();
        if ($("#ad_format_id").text() == "Mobile Pull") {
          $("#vast_file").parent().parent().hide();
        } else {
          $("#vast_file").parent().parent().show();
        }
      } else {
        $("#source_url").parent().parent().show();
      }      
      $("#width").parent().parent().show();
      $("#height").parent().parent().show();
      $("#destination_url").parent().parent().show();
      $("#position-top").parent().parent().parent().parent().show(); 
    }   
</script>