@include("partials.show_messages")
{{ Form::open(array('role'=>'form','class'=>'form-horizontal form-cms')) }}
    <div class="row">
        <div class="col-md-12">
            <!-- CAMPAIGN -->
            <div class="form-group">
                <label class="col-md-2">{{trans('text.campaign')}}</label>
                <div class="col-md-4">
                    <input type="hidden" id="campaign_id" value="{{{ $item->campaign_id or Input::get('campaign_id') }}}" name="campaign_id">
                    <input type="text" class="form-control input-sm" id="campaign" value="{{{ $item->campaign->name or Input::get('campaign') }}}" name="campaign" readonly>
                </div>
                <div class="col-md-3 text-select">
                    <a href="javascript:;" onclick="Select.openModal('campaign')" class="btn btn-primary btn-block btn-sm">{{trans('text.select_campaign')}}</a>
                </div>
            </div>
            <!-- CHANNEL ( CATEGORY ) -->
            <div class="form-group">
                <label class="col-md-2">{{trans('text.channel')}}</label>
                <div class="col-md-4">
                <?php
                    $categoryValue = ( isset($item->category_id) ) ? $item->category_id : Input::get('category_id');
                ?>
                {{ 
                    Form::select(
                        'category_id', 
                        $listCategory,
                        $categoryValue, 
                        array('class'=>'form-control input-sm','id'=>'category_id')
                    ) 
                }}
                </div>
            </div>
            <div class="belongCategory"  @if( empty($categoryValue) ) style="display:none" @endif>
                <!-- PUBLISHER -->
                <div class="form-group">
                    <label class="col-md-2">{{trans('text.publisher')}}</label>
                    <div class="col-md-4">
                        <input type="hidden" id="publisher_id" value="{{{ $item->publisher_id or Input::get('publisher_id') }}}" name="publisher_id">
                        <input type="text" class="form-control input-sm" id="publisher" value="{{{ $item->publisher->company or Input::get('publisher') }}}" name="publisher" readonly>
                    </div>
                    <div class="col-md-3 text-select">
                        <a href="javascript:;" onclick="Select.openModal('publisher')" class="btn btn-primary btn-block btn-sm">{{trans('text.select_publisher')}}</a>
                    </div>
                </div>
                <!-- PUBLISHER SITE ( SECTION ) -->
                <div class="form-group">
                    <label class="col-md-2">{{trans('text.section')}}</label>
                    <div class="col-md-4">
                        <input type="hidden" id="publisher_site_id" value="{{{ $item->publisher_site_id or Input::get('publisher_site_id') }}}" name="publisher_site_id">
                        <input type="text" class="form-control input-sm" id="publisher_site" value="{{{ $item->publisherSite->name or Input::get('publisher_site') }}}" name="publisher_site" readonly>
                        <input type="hidden" id="publisher_site_parent_id" value="publisher_id">
                    </div>
                    <div class="col-md-3 text-select">
                        <a href="javascript:;" onclick="Select.openModal('publisher_site')" class="btn btn-primary btn-block btn-sm">{{trans('text.select_section')}}</a>
                    </div>
                </div>            
                <!-- PUBLISHER SITE AD ZONE -->
                <div class="form-group">
                    <label class="col-md-2">{{trans('text.zone')}}</label>
                    <div class="col-md-4">
                        <input type="hidden" id="publisher_ad_zone_id" value="{{{ $item->publisher_ad_zone_id or Input::get('publisher_ad_zone_id') }}}" name="publisher_ad_zone_id">
                        <input type="text" class="form-control input-sm" id="publisher_ad_zone" value="{{{ $item->publisher_ad_zone->name or Input::get('publisher_ad_zone') }}}" name="publisher_ad_zone" readonly>
                        <input type="hidden" id="publisher_ad_zone_parent_id" value="publisher_site_id">
                    </div>
                    <div class="col-md-3 text-select">
                        <a href="javascript:;" onclick="Select.openModal('publisher_ad_zone')" class="btn btn-primary btn-block btn-sm">{{trans('text.select_zone')}}</a>
                    </div>
                </div>
            </div>            
            <!-- FLIGHT OBJECTIVE -->
            <div class="form-group">
                <label class="col-md-2">{{trans('text.flight_objective')}}</label>
                <div class="col-md-4">
                    @if( !empty($listFlightObjective) )
                        @foreach( $listFlightObjective as $flighObjective )
                        <div class="radio input-sm">
                            <label>
                                {{ Form::radio('flight_objective',$flighObjective, $flighObjective == Input::get('flight_objective') || ( !empty($item->flight_objective) && $flighObjective == $item->flight_objective) )}}
                                {{$flighObjective}}
                            </label>
                        </div>
                        @endforeach
                    @endif
                </div>
            </div>                
            <!-- ALLOW OVER DELIVERY REPORT -->
            <div class="form-group form-group-sm">
                <label class="col-md-2">{{trans('text.allow_over_delivery_report')}}</label>
                <div class="col-md-4">
                    <label class="radio-inline">
                        {{ Form::radio('allow_over_delivery_report', 1, 1 == Input::get('allow_over_delivery_report') || ( !empty($item->allow_over_delivery_report) && 1 == $item->allow_over_delivery_report) )}}
                        Yes
                    </label>
                    <label class="radio-inline">
                        {{ Form::radio('allow_over_delivery_report', 2, 2 == Input::get('allow_over_delivery_report') || ( !empty($item->allow_over_delivery_report) && 2 == $item->allow_over_delivery_report) )}}
                        No
                    </label>
                </div>
            </div>                
            <!-- REMARK -->
            <div class="form-group form-group-sm">
                <label class="col-md-2">{{trans('text.remark')}}</label>
                <div class="col-md-4">
                    <input type="text" class="form-control" id="remark" value="{{{ $item->remark or Input::get('remark') }}}" name="remark">
                </div>
            </div>                        
            <!-- CAMPAIGN DATE -->
            <div class="form-group form-group-sm">
                <label class="col-md-2">{{trans('text.campaign_date')}}</label>
                <div class="col-md-4">
                    <input type="text" class="no-border" id="campaign_date" value="{{{ $item->campaign->dateRange or Input::get('campaign_date') }}}" name="campaign_date" readonly>
                </div>
            </div>                        
            <!-- DATE -->
            <?php
                $date = ( isset($item->date) ) ? json_decode($item->date, true) : Input::get('date');
            ?>
            <div class="form-group form-group-sm">
                <label class="col-md-2">{{trans('text.date')}} <i class="fa fa-calendar"></i>
                </label>
                <div class="col-md-4">
                    <div class="input-daterange input-group" id="datepicker">
                        <input type="text" class="form-control" name="start_date_range" id="start_date_range" />
                        <span class="input-group-addon">to</span>
                        <input type="text" class="form-control" name="end_date_range" id="end_date_range" />
                    </div>
                    <div id="list-date-range">
                        @if(!empty( $date ))
                            @foreach( $date as $key => $value )
                                <div class="date-range">
                                    <span><a onclick="removeDate('{{$key}}')" href="javascript:;"><i class="fa fa-times"></i></a>{{$value['start']}} - {{$value['end']}}</span>
                                    <input type="hidden" id="date-start-{{$key}}" name="date[{{$key}}][start]" value="{{$value['start']}}">
                                    <input type="hidden" id="end-start-{{$key}}" name="date[{{$key}}][end]" value="{{$value['end']}}">
                                    <input type="hidden" id="diff-{{$key}}" name="date[{{$key}}][diff]" value="{{$value['diff']}}">
                                </div>
                            @endforeach
                        @endif
                    </div>                    
                </div>
                <div class="col-md-2">
                    <a href="javascript:;" onclick="addDate()" class="btn btn-primary btn-block btn-sm">{{trans('text.add_date')}}</a>
                </div>
            </div>                        
            <!-- DAY -->
            <div class="form-group form-group-sm">
                <label class="col-md-2">{{trans('text.days')}}</label>
                <div class="col-md-4">
                    <input type="text" class="no-border" id="day" value="{{{ $item->day or Input::get('day') }}}" name="day" readonly>
                </div>
            </div>    
            <!-- COST TYPE -->
            <div class="form-group form-group-sm">
                <label class="col-md-2">{{trans('text.cost_type')}}</label>
                <div class="col-md-4">
                    <label class="radio-inline">
                        {{ Form::radio('cost_type', 'cpm', 'cpm' == Input::get('cost_type') || ( !empty($item->cost_type) && 'cpm' == $item->cost_type) )}}
                        CPM
                    </label>
                    <label class="radio-inline">
                        {{ Form::radio('cost_type', 'cpc', 'cpc' == Input::get('cost_type') || ( !empty($item->cost_type) && 'cpc' == $item->cost_type) )}}
                        CPC
                    </label>
                    <label class="radio-inline">
                        {{ Form::radio('cost_type', 'cpv', 'cpv' == Input::get('cost_type') || ( !empty($item->cost_type) && 'cpv' == $item->cost_type) )}}
                        CPV
                    </label>
                    <label class="radio-inline">
                        {{ Form::radio('cost_type', 'cpe', 'cpe' == Input::get('cost_type') || ( !empty($item->cost_type) && 'cpe' == $item->cost_type) )}}
                        CPE
                    </label>
                    <label class="radio-inline">
                        {{ Form::radio('cost_type', 'cpa', 'cpa' == Input::get('cost_type') || ( !empty($item->cost_type) && 'cpa' == $item->cost_type) )}}
                        CPA
                    </label>
                </div>
            </div>                         
            <!-- TOTAL INVENTORY -->
            <div class="form-group form-group-sm">
                <label class="col-md-2">{{trans('text.total_inventory')}}</label>
                <div class="col-md-4">
                    <input type="text" class="form-control" id="total_inventory" value="{{{ $item->total_inventory or Input::get('total_inventory') }}}" name="total_inventory">
                </div>
            </div>                        
            <!-- VALUE ADDED -->
            <div class="form-group form-group-sm">
                <label class="col-md-2">{{trans('text.value_added')}}</label>
                <div class="col-md-4">
                    <input type="text" class="form-control" id="value_added" value="{{{ $item->value_added or Input::get('value_added') }}}" name="value_added">
                </div>
            </div>                                                           
            <!-- BASE MEDIA COST -->
            <div class="form-group form-group-sm">
                <label class="col-md-2">{{trans('text.base_media_cost')}}</label>
                <div class="col-md-4">
                    <input type="text" class="form-control" id="base_media_cost" value="{{{ $item->base_media_cost or Input::get('base_media_cost') }}}" name="base_media_cost">
                    <input type="hidden" class="form-control" id="real_base_media_cost" value="{{{ $item->real_base_media_cost or Input::get('real_base_media_cost') }}}" name="real_base_media_cost">
                    <input type="hidden" class="form-control" id="real_media_cost" value="{{{ $item->real_media_cost or Input::get('real_media_cost') }}}" name="real_media_cost">
                </div>
            </div>                        
            <!-- MEDIA COST -->
            <div class="form-group form-group-sm">
                <label class="col-md-2">{{trans('text.media_cost')}}</label>
                <div class="col-md-4">
                    <input type="text" class="form-control" id="media_cost" value="{{{ $item->media_cost or Input::get('media_cost') }}}" name="media_cost">
                </div>
            </div>                        
            <!-- DISCOUNT -->
            <div class="form-group form-group-sm">
                <label class="col-md-2">{{trans('text.discount')}}</label>
                <div class="col-md-4">
                    <input type="text" class="form-control" id="discount" value="{{{ $item->discount or Input::get('discount') }}}" name="discount">
                </div>
                <div class="pull-left">%</div>
            </div>                        
            <!-- COST AFTER DISCOUNT -->
            <div class="form-group form-group-sm">
                <label class="col-md-2">{{trans('text.cost_after_discount')}}</label>
                <div class="col-md-4">
                    <input type="text" class="no-border" id="cost_after_discount" value="{{{ $item->cost_after_discount or Input::get('cost_after_discount') }}}" name="cost_after_discount" readonly>
                </div>
            </div>                        
            <!-- TOTAL COST AFTER DISCOUNT -->
            <div class="form-group form-group-sm">
                <label class="col-md-2">{{trans('text.total_cost_after_discount')}}</label>
                <div class="col-md-4">
                    <input type="text" class="no-border" id="total_cost_after_discount" value="{{{ $item->total_cost_after_discount or Input::get('total_cost_after_discount') }}}" name="total_cost_after_discount" readonly>
                </div>
            </div>                        
            <!-- AGENCY COMMISSION -->
            <div class="form-group form-group-sm">
                <label class="col-md-2">{{trans('text.agency_commission')}}</label>
                <div class="col-md-4">
                    <input type="text" class="form-control" id="agency_commission" value="{{{ $item->agency_commission or Input::get('agency_commission') }}}" name="agency_commission">
                </div>
                <div class="pull-left">%</div>
            </div>                        
            <!-- COST AFTER AGENCY COMMISSION -->
            <div class="form-group form-group-sm">
                <label class="col-md-2">{{trans('text.cost_after_agency_commission')}}</label>
                <div class="col-md-4">
                    <input type="text" class="no-border" id="cost_after_agency_commission" value="{{{ $item->cost_after_agency_commission or Input::get('cost_after_agency_commission') }}}" name="cost_after_agency_commission" readonly>
                </div>
            </div>    
            <!-- ADVALUE COMMISSION -->
            <div class="form-group form-group-sm">
                <label class="col-md-2">{{trans('text.advalue_commission')}}</label>
                <div class="col-md-4">
                    <input type="text" class="form-control" id="advalue_commission" value="{{{ $item->advalue_commission or Input::get('advalue_commission') }}}" name="advalue_commission">
                </div>
                <div class="pull-left">%</div>
            </div>                        
            <!-- PUBLISHER COST -->
            <div class="form-group form-group-sm">
                <label class="col-md-2">{{trans('text.publisher_cost')}}</label>
                <div class="col-md-4">
                    <input type="text" class="no-border" id="publisher_cost" value="{{{ $item->publisher_cost or Input::get('publisher_cost') }}}" name="publisher_cost" readonly>
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

<script type="text/javascript">

    var index = 0;

    function embedDatePicker(){
        $('.input-daterange').datepicker({ dateFormat: 'dd-mm-yy'});
    }

    function dateDiff(start, end){
        return ((end - start)/1000/60/60/24) + 1;
    }

    function getCurrentDate(){
        return ($('#day').val() == '' ) ? 0 : $('#day').val();
    }

    function setDate(days){
        if( !isNaN(days) ){
            $('#day').val(days);  
        }
    }

    function addDate(){
        var startString = $('#start_date_range').val();
        var endString   = $('#end_date_range').val();

        if( startString == '' || endString == '' ) {
            return;
        }

        var start       = $('#start_date_range').datepicker('getDate');
        var end         = $('#end_date_range').datepicker('getDate');
        var diff        = dateDiff(start, end);
        var currentDate = getCurrentDate();
        days = parseInt(currentDate) + parseInt(diff);
        setDate(days);
        $("#list-date-range").append(createDateRange(startString, endString, diff));
        $('#start_date_range').val('');
        $('#end_date_range').val('');
        $('.input-daterange').datepicker('remove');
        embedDatePicker();
        index++;
    }

    function removeDate(index){

        var diff = $('#diff-'+index);
        var diffValue = $('#diff-'+index).val();
        var currentDate  = getCurrentDate();
        var days = parseInt(currentDate) - parseInt(diffValue);
        setDate(days);
        diff.parent().remove();
    }

    function createDateRange(start, end, diff){
        return '<div class="date-range">'
                +'<span><a onclick="removeDate(\''+index+'\')" href="javascript:;"><i class="fa fa-times"></i></a>'+start+' - '+end+'</span>'
                +'<input type="hidden" id="date-start-'+index+'" name="date['+index+'][start]" value="'+start+'">'
                +'<input type="hidden" id="end-start-'+index+'" name="date['+index+'][end]" value="'+end+'">'
                +'<input type="hidden" id="diff-'+index+'" name="date['+index+'][diff]" value="'+diff+'">'
            +'</div>';
    }

    function calculateRatio(value, percent){
        return value * ( 100-percent )/100;
    }

    function calculateCostAfterDiscount(){
        var mediaCost = $('#media_cost').val();
        var discount = $('#discount').val();

        var costAfterDiscount = calculateRatio(mediaCost, discount);
        var totalInventory = $('#total_inventory').val();
        var totalCostAfterDiscount = costAfterDiscount*totalInventory;

        $('#cost_after_discount').val(costAfterDiscount);
        $('#total_cost_after_discount').val(totalCostAfterDiscount);

        calculateCostAfterAgencyCommission();

    }

    function calculateCostAfterAgencyCommission(){
        var totalCostAfterDiscount  = $('#total_cost_after_discount').val();
        var agencyCommision         = $('#agency_commission').val();

        var costAfterAgencyComission =  calculateRatio(totalCostAfterDiscount, agencyCommision);

        $('#cost_after_agency_commission').val(costAfterAgencyComission);
        calculcatePublisherCost();

    }

    function calculcatePublisherCost(){
        var costAfterAgencyComission = $('#cost_after_agency_commission').val();
        var adValueCommission = $('#advalue_commission').val();
        var publisherCost = calculateRatio(costAfterAgencyComission, adValueCommission);
        $('#publisher_cost').val(publisherCost);
    }

    function calculateRealCost(){

        var baseMediaCost = $("#base_media_cost").val();
        var mediaCost = $('#media_cost').val();

        var discount          = $('#discount').val();
        var agencyCommision   = $('#agency_commission').val();
        var adValueCommission = $('#advalue_commission').val();

        var realBaseMediaCost = calculateRatio(baseMediaCost, discount);
        realBaseMediaCost = calculateRatio(realBaseMediaCost, agencyCommision);
        realBaseMediaCost = calculateRatio(realBaseMediaCost, adValueCommission);
        
        var realMediaCost = calculateRatio(mediaCost, discount);
        realMediaCost = calculateRatio(realMediaCost, agencyCommision);
        realMediaCost = calculateRatio(realMediaCost, adValueCommission);

        $("#real_base_media_cost").val(realBaseMediaCost);
        $("#real_media_cost").val(realMediaCost);

    }

    $().ready(function(){
        embedDatePicker();
        $('#base_media_cost,#media_cost,#discount,#total_inventory').change(function(){
            calculateCostAfterDiscount();
            calculateRealCost();
        });

        $('#agency_commission').change(function(){
            calculateCostAfterAgencyCommission();
        });

        $('#advalue_commission').change(function(){
            calculcatePublisherCost();
        });

        $('#category_id').change(function(){
            var value = $(this).val();
            if( value == 0 ){
                $('.belongCategory').fadeOut();
                $('#publisher_id, #publisher_site_id, #publisher_ad_zone_id').val(0);
            }else{
                $('.belongCategory').fadeIn();
            }
        })

        $("#total_cost_after_discount, #cost_after_agency_commission, #publisher_cost").number(true);
    })


</script>



