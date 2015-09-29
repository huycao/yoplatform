<div class="modal fade bs-contact-modal" id="loadPreviewModal" tabindex="-1" role="dialog" aria-labelledby="selectModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
            	<h4 class="modal-title">Preview Campaign</h4>
        	</div>
            <div class="modal-body">
                <div class="">
					<style>
						.blue {
							color: blue;
                      	}
                      	.popover {
                  			max-width: 600px;
                      		width: auto;
                      	}
                      	.mb20{margin-bottom:20px;}
                      	.mt20{margin-top:20px;}
                      	.bg-default{font-weight: bold; width:20%;}
                   	</style>
					<div>
						<div class="box">
                            <div class="head">Campaign</div>
								<table class="campaign table table-striped table-hover table-condensed ">
                               		<tbody>
                                		<tr>
                                     		<td class="bg-default">Campaign Name</td>
                                     		<td width="30%">({{$campaign->id}}) {{$campaign->name}}</td>
                                     		<td class="bg-default">Duration</td>
                                     		<td width="30%">{{$campaign->dateRange}}</td>
                                  		</tr>
                                  		<tr>
                                     		<td class="bg-default">Category</td>
                                     		<td width="30%">{{$campaign->category->name}}</td>
                                     		<td class="bg-default" width="25%">Total Inventory</td>
                                     		<td width="30%">
                                     			<span class="badge badge-info">{{number_format($campaign->total_inventory)}}</span>
                                 			</td>
                                  		</tr>
                                  		<?php
                                        $sumTotalImpression = $sumTotalUniqueImpression = $sumTotalClick = $sumTotalUniqueClick = $sumTotalImpressionOver = $sumTotalClickOver = $sumTotalUniqueImpressionOver = $sumTotalUniqueClickOver = 0;
                                        ?>
                                        @if( !$campaign->flight->isEmpty() && !empty($listFlightTracking) )
                                            @foreach( $campaign->flight as $flight )
                                                <?php
                                    
                                                if (isset($listFlightTracking[$flight->id])) {
                                                    $sumTotalImpression += $listFlightTracking[$flight->id]['total_impression'];
                                                    $sumTotalUniqueImpression += $listFlightTracking[$flight->id]['total_unique_impression'];
                                                    $sumTotalClick += $listFlightTracking[$flight->id]['total_click'];
                                                    $sumTotalUniqueClick += $listFlightTracking[$flight->id]['total_unique_click'];
                                                    //over report
                                                    $sumTotalImpressionOver += $listFlightTracking[$flight->id]['total_impression_over'];
                                                    $sumTotalUniqueImpressionOver += $listFlightTracking[$flight->id]['total_unique_impression_over'];
                                                    $sumTotalClickOver += $listFlightTracking[$flight->id]['total_click_over'];
                                                    $sumTotalUniqueClickOver += $listFlightTracking[$flight->id]['total_unique_click_over'];
                                                }
                                    
                                                ?>
                                            @endforeach
                                        @endif
                                        <tr>
                                     		<td class="bg-default">Total Impression</td>
                                     		<td width="30%">
                                     			<span class="badge badge-info">{{number_format($sumTotalImpression + $sumTotalImpressionOver)}}</span>
                                     			@if ($sumTotalImpressionOver)
													<span class="blue">({{number_format($sumTotalImpressionOver)}})</span>
												@endif
											</td>
											<td class="bg-default">Total Unique Impression</td>
                                     		<td width="30%">
												<span class="badge badge-info">{{number_format($sumTotalUniqueImpression + $sumTotalUniqueImpressionOver)}}</span>
												@if ($sumTotalUniqueImpressionOver)
													<span class="blue">({{number_format($sumTotalUniqueImpressionOver)}})</span>
												@endif
											</td>
                                  		</tr>
                                      	<tr>
                                         	<td class="bg-default">Total Clicks</td>
                                         	<td width="30%">
												<span class="badge badge-info">{{number_format($sumTotalClick + $sumTotalClickOver)}}</span> 
												@if ($sumTotalClickOver)
													<span class="blue">({{number_format($sumTotalClickOver)}})</span>
												@endif												
											</td>
											<td class="bg-default">Total Unique Clicks</td>
                                         	<td width="30%">
												<span class="badge badge-info">{{number_format($sumTotalUniqueClick + $sumTotalUniqueClickOver)}}</span>
												@if ($sumTotalUniqueClickOver)
													<span class="blue">({{number_format($sumTotalUniqueClickOver)}})</span>
												@endif												
											</td>
                                      	</tr>
                                      	@if(!1)
                                		<tr>
                                    		<td class="bg-default">Process</td>
                                     		<td colspan="3">
                                        		<div class="progress">
                                               		<?php
                                                        $process = 0;
                                
                                                        $process = $campaign->getProcess($sumTotalImpression + $sumTotalImpressionOver);
                                
                                                        $processtype = 'danger';
                                                        if ($process > 40 && $process < 80) {
                                                            $processtype = 'info';
                                                        }
                                                        if ($process > 80) {
                                                            $processtype = 'success';
                                                        }
                                                        ?>
                                                        
                                                        <div class="progress">
                                                            <div class="progress-bar progress-bar-{{ $processtype }}  progress-bar-striped"
                                                                 role="progressbar" aria-valuenow="{{ $process }}" aria-valuemin="0" aria-valuemax="100"
                                                                 style="width: {{ $process }}%">
                                                                {{ $process }}%
                                                            </div>
                                                        </div>
                                    			</div>
                                     		</td>
                                  		</tr>   
                                  		@endif                               		
                               		</tbody>
                            	</table>
                         	</div>
						</div>
                   	<div class="mt20">
                    	<div class="box">
                        	<div class="head">List Flight Of Campaign</div>
                        	<table class="table table-striped table-hover table-condensed ">
                        		<tr class="bg-primary fs12">
                             		<th>Flight</th>
                             		<th>Impression</th>
                             		<th>Unique Impression</th>
                             		<th>Click</th>
                             		<th>Unique Click</th>
                          		</tr>
                          		 @if( !$campaign->flight->isEmpty() )
                    				@foreach( $campaign->flight as $flight )
                    					<?php
                                            $totalImpression = 0;
                                            $totalUniqueImpression = 0;
                                            $totalClick = 0;
                                            $totalUniqueClick = 0;
                                            //over Report
                                            $totalImpressionOver = 0;
                                            $totalUniqueImpressionOver = 0;
                                            $totalClickOver = 0;
                                            $totalUniqueClickOver = 0;
                                            $totalFailedRequestOver = 0;
                                            if (isset($listFlightTracking[$flight->id])) {
                                                $totalImpression = $listFlightTracking[$flight->id]['total_impression'];
                                                $totalUniqueImpression = $listFlightTracking[$flight->id]['total_unique_impression'];
                                                $totalClick = $listFlightTracking[$flight->id]['total_click'];
                                                $totalUniqueClick = $listFlightTracking[$flight->id]['total_unique_click'];
                                                
                                                //over Report
                                                $totalImpressionOver = $listFlightTracking[$flight->id]['total_impression_over'];
                                                $totalUniqueImpressionOver = $listFlightTracking[$flight->id]['total_unique_impression_over'];
                                                $totalClickOver = $listFlightTracking[$flight->id]['total_click_over'];
                                                $totalUniqueClickOver = $listFlightTracking[$flight->id]['total_unique_click_over'];
                                            }
                                        ?>
                                  		<tr>
                                     		<td>
                                     			<a href="{{URL::Route('FlightAdvertiserManagerShowView', $flight->id)}}" target="_blank">({{$flight->id}}) {{$flight->name}}</a></td>
                                     		<td>
                                     			<span class="badge badge-info">{{ number_format($totalImpression + $totalImpressionOver )}}</span>
                                        		@if($totalImpressionOver)
                                            		<span class="blue">({{number_format($totalImpressionOver)}})</span>
                                        		@endif
                                        	</td>
                                     		<td>
												<span class="badge badge-info">{{ number_format($totalUniqueImpression + $totalUniqueImpressionOver)}}</span>
                                        		@if($totalUniqueImpressionOver)
                                            		<span class="blue">({{number_format($totalUniqueImpressionOver)}})</span>
                                        		@endif
											</td>
                                     		<td>
												<span class="badge badge-info">{{ number_format($totalClick + $totalClickOver)}}</span>
                                                @if($totalClickOver)
                                                    <span class="blue">({{number_format($totalClickOver)}})</span>
                                                @endif
											</td>
                                     		<td>
												<span class="badge badge-info">{{ number_format($totalUniqueClick + $totalUniqueClickOver)}}</span>
                                                @if($totalUniqueClickOver)
                                                    <span class="blue">({{number_format($totalUniqueClickOver)}})</span>
                                                @endif
											</td>
                                  		</tr>
                          			@endforeach
                      			@endif
                        	</table>                        
                     	</div>
                  	</div>
            	</div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{trans('text.close')}}</button>
            </div>
    	</div>
	</div>
</div>