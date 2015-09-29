{{ HTML::style("{$assetURL}css/checkbox.css") }}
<div class="part">
@include("partials.show_messages")

{{ Form::open(array('role'=>'form','class'=>'form-horizontal form-cms')) }}
    <div class="row">
        <div class="col-md-12">
            
            <!-- CATEGORY -->
            <div class="form-group form-group-sm">
                <label class="col-md-2">{{trans('text.campaign_category')}}</label>
                <div class="col-md-5">
                <?php
                    $categoryValue = ( isset($item->category_id) ) ? $item->category_id : Input::get('category_id');
                ?>
                {{ 
                    Form::select(
                        'category_id', 
                        $listCategory,
                        $categoryValue, 
                        array('class'=>'form-control','id'=>'category_id')
                    ) 
                }}
                </div>
            </div>
            <!-- ADVERTISER -->
            <div class="form-group form-group-sm">
                <label class="col-md-2">{{trans('text.advertiser')}}</label>
                <div class="col-md-5">
                    <input type="hidden" class="form-control" id="advertiser_id" value="{{{ $item->advertiser_id or Input::get('advertiser_id') }}}" name="advertiser_id">

                    <input type="text" onclick="Select.openModal('advertiser')" class="form-control" id="advertiser" value="{{{ $item->advertiser->name or Input::get('advertiser') }}}" name="advertiser" readonly placeholder="Click here to select advertiser">

                </div>
                <!-- <div class="col-md-3 text-select">
                    <a href="javascript:;" onclick="Select.openModal('advertiser')" class="btn btn-default btn-block btn-sm">{{trans('text.select_advertiser')}}</a>
                </div> -->
            </div>
            <!-- AGENCY -->
            <div class="form-group form-group-sm">
                <label class="col-md-2">{{trans('text.agency')}}</label>
                <div class="col-md-5">
                    <input type="hidden" class="form-control" id="agency_id" value="{{{ $item->agency_id or Input::get('agency_id') }}}" name="agency_id">
                    <input type="text" onclick="Select.openModal('agency')" class="form-control" id="agency" value="{{{ $item->agency->name or Input::get('agency') }}}" name="agency" readonly placeholder="Click here to select agency">
                </div>
                <!-- <div class="col-md-3 text-select">
                    <a href="javascript:;" onclick="Select.openModal('agency')" class="btn btn-default btn-block btn-sm">{{trans('text.select_agency')}}</a>
                </div> -->
            </div>            
            <!-- CONTACT -->
            <div class="form-group form-group-sm">
                <label class="col-md-2">{{trans('text.contact')}}</label>
                <div class="col-md-5">
                    <input type="hidden" class="form-control" id="contact_id" value="{{{ $item->contact_id or Input::get('contact_id') }}}" name="contact_id">
                    <input type="text" onclick="Select.openModal('contact')" class="form-control" id="contact" value="{{{ $item->contact->name or Input::get('contact') }}}" name="contact" readonly placeholder="Click here to select contact">
                    <input type="hidden" id="contact_parent_id" value="agency_id">
                </div>
                <!-- <div class="col-md-3 text-select">
                    <a href="javascript:;" onclick="Select.openModal('contact')" class="btn btn-default btn-block btn-sm">{{trans('text.select_contact')}}</a>
                </div> -->
            </div>                       
            <!-- CAMPAIGN NAME -->
            <div class="form-group form-group-sm">
                <label class="col-md-2">{{trans('text.campaign_name')}}</label>
                <div class="col-md-5">
                    <input type="text" class="form-control" id="name" value="{{{ $item->name or Input::get('name') }}}" name="name">
                </div>
            </div>
            <!-- STATUS -->
            <div class="form-group form-group-sm">
                <label class="col-md-2">{{trans('text.status')}}</label>
                <div class="col-md-5">
                    <select class="form-control" id="status" name="status">
                        <option value="1" <?php if( isset($item->status) &&  $item->status == 1 ){ echo "selected='selected'"; }?> >{{trans('text.active')}}</option>
                        <option value="0" <?php if( isset($item->status) &&  $item->status == 0 ){ echo "selected='selected'"; }?>>{{trans('text.unactive')}}</option>
                    </select>
                </div>
            </div>
            <!-- SALE STASTUS -->
            <div class="form-group form-group-sm">
                <label class="col-md-2">{{trans('text.sale_status')}}</label>
                <div class="col-md-5">
                <?php
                    $saleStatusValue = ( isset($item->sale_status) ) ? $item->sale_status : Input::get('sale_status');
                ?>
                {{ 
                    Form::select(
                        'sale_status', 
                        $listSaleStatus,
                        $saleStatusValue, 
                        array('class'=>'form-control','id'=>'sale_status')
                    ) 
                }}
                </div>
            </div>            
            <!-- SALE PERSON -->
            <div class="form-group form-group-sm">
                <label class="col-md-2">{{trans('text.sale_person')}}</label>
                <div class="col-md-5">
                    <input type="hidden" class="form-control" id="sale_id" value="{{{ $item->sale_id or Input::get('sale_id') }}}" name="sale_id">
                    <input type="text" onclick="Select.openModal('sale')" class="form-control" id="sale" value="{{{ $item->sale->username or Input::get('sale') }}}" name="sale" readonly placeholder="Click here to select sale">
                </div>
                <!-- <div class="col-md-3 text-select">
                    <a href="javascript:;" onclick="Select.openModal('sale')" class="btn btn-default btn-block btn-sm">{{trans('text.select_sale')}}</a>
                </div> -->
            </div>
            <!-- CAMPAGIN MANAGER -->
            <div class="form-group form-group-sm">
                <label class="col-md-2">{{trans('text.campaign_manager')}}</label>
                <div class="col-md-5">
                    <input type="hidden" class="form-control" id="campaign_manager_id" value="{{{ $item->campaign_manager_id or Input::get('campaign_manager_id') }}}" name="campaign_manager_id">
                    <input type="text" onclick="Select.openModal('campaign_manager')" class="form-control" id="campaign_manager" value="{{{ $item->campaign_manager->username or Input::get('campaign_manager') }}}" name="campaign_manager" readonly placeholder="Click here to select campaign manager">
                </div>
                <!-- <div class="col-md-3 text-select">
                    <a href="javascript:;" onclick="Select.openModal('campaign_manager')" class="btn btn-default btn-block btn-sm">{{trans('text.select_campaign_manager')}}</a>
                </div> -->
            </div>
            <!-- EXPECTED CLOSE MONTH -->
            <div class="form-group form-group-sm">
                <label class="col-md-2">{{trans('text.expected_close_month')}}</label>
                <div class="col-md-5">
                <?php
                    $expectedValue = ( isset($item->expected_close_month) ) ? $item->expected_close_month : Input::get('expected_close_month');
                ?>
                {{ 
                    Form::select(
                        'expected_close_month', 
                        $listExpectedCloseMonth, 
                        $expectedValue, 
                        array('class'=>'form-control','id'=>'expected_close_month')
                    ) 
                }}
                </div>
            </div>
            <!-- START DATE -->
            <div class="form-group form-group-sm">
                <label class="col-md-2">{{trans('text.start_date')}}</label>
                <div class="col-md-5">
                    <?php
                        if( !empty($item->start_date) ){
                            $start_date = date('d-m-Y',strtotime($item->start_date));
                        }else{
                            $start_date = Input::get('start_date');
                        }
                    ?>
                    <input type="text" class="form-control" id="start_date" value="{{{ $start_date }}}" name="start_date">
                </div>
            </div>            
            <!-- END DATE -->
            <div class="form-group form-group-sm">
                <label class="col-md-2">{{trans('text.end_date')}}</label>
                <div class="col-md-5">
                    <?php
                        if( !empty($item->end_date) ){
                            $end_date = date('d-m-Y',strtotime($item->end_date));
                        }else{
                            $end_date = Input::get('end_date');
                        }
                    ?>
                    <input type="text" class="form-control" id="end_date" value="{{{ $end_date }}}" name="end_date">
                </div>
            </div>                                                        
            <!-- INVOICE NUMBER -->
            <div class="form-group form-group-sm">
                <label class="col-md-2">{{trans('text.invoice_number')}}</label>
                <div class="col-md-5">
                    <input type="text" class="form-control" id="invoice_number" value="{{{ $item->invoice_number or Input::get('invoice_number') }}}" name="invoice_number">
                </div>
            </div>       

            <!-- COST TYPE -->
            <!-- <div class="form-group form-group-sm">
                <label class="col-md-2">{{trans('text.cost_type')}}</label>
                <div class="col-md-10">
                    <div class="radio radio-info radio-inline">
                        {{ Form::radio('cost_type', 'cpm', 'cpm' == Input::get('cost_type') || ( !empty($item->cost_type) && 'cpm' == $item->cost_type), array('id'=>'cpm') )}}
                        <label for="cpm"> CPM </label>
                    </div>
                    <div class="radio radio-info radio-inline">
                        {{ Form::radio('cost_type', 'cpc', 'cpc' == Input::get('cost_type') || ( !empty($item->cost_type) && 'cpc' == $item->cost_type), array('id'=>'cpc') )}}
                        <label for="cpc"> CPC </label>
                    </div>
                    <div class="radio radio-info radio-inline">
                        {{ Form::radio('cost_type', 'cpv', 'cpv' == Input::get('cost_type') || ( !empty($item->cost_type) && 'cpv' == $item->cost_type), array('id'=>'cpv') )}}
                        <label for="cpv"> CPV </label>
                    </div>
                    <div class="radio radio-info radio-inline">
                        {{ Form::radio('cost_type', 'cpe', 'cpe' == Input::get('cost_type') || ( !empty($item->cost_type) && 'cpe' == $item->cost_type), array('id'=>'cpe') )}}
                        <label for="cpe"> CPE </label>
                    </div>
                    <div class="radio radio-info radio-inline">
                        {{ Form::radio('cost_type', 'cpa', 'cpa' == Input::get('cost_type') || ( !empty($item->cost_type) && 'cpa' == $item->cost_type), array('id'=>'cpa') )}}
                        <label for="cpa"> CPA </label>
                    </div>
                </div>
            </div> -->                 

            <!-- TOTAL INVENTORY -->
            <div class="form-group form-group-sm">
                <label class="col-md-2">{{trans('text.total_inventory')}}</label>
                <div class="col-md-4">
                    <input type="text" class="form-control" id="total_inventory" value="{{{ $item->total_inventory or Input::get('total_inventory') }}}" name="total_inventory">
                </div>
            </div>    

            <!-- SALE REVENUE -->
            <div class="form-group form-group-sm">
                <label class="col-md-2">{{trans('text.sale_revenue')}}</label>
                <div class="col-md-4">
                    <input type="text" class="form-control" id="sale_revenue" value="{{{ $item->sale_revenue or Input::get('sale_revenue') }}}" name="sale_revenue">
                </div>
            </div>
            <!-- RETARGETING URL -->
            <!-- <div class="form-group form-group-sm">
                <label class="col-md-2">{{trans('text.retargeting_url')}}</label>
                <div class="col-md-4">
                    <input type="text" class="form-control" id="sale_revenue" value="{{{ $item->retargeting_url or Input::get('retargeting_url') }}}" name="retargeting_url">
                </div>
            </div> -->
            <!-- RETARGETING SHOW -->
            <!-- <div class="form-group form-group-sm">
                <label class="col-md-2"> {{trans('text.retargeting_show')}} </label>
                <div class="col-md-4">
                    <div class="radio radio-info radio-inline">
                        {{ Form::radio('retargeting_show', '1', '1' == Input::get('retargeting_show') || ( isset($item->retargeting_show) && '1' == $item->retargeting_show), array('id'=>'retargeting_show_1') )}}
                        <label for="retargeting_show_1"> Yes </label>
                    </div>
                    <div class="radio radio-info radio-inline">
                        {{ Form::radio('retargeting_show', '0', '0' == Input::get('retargeting_show') || ( isset($item->retargeting_show) && '0' == $item->retargeting_show), array('id'=>'retargeting_show_0') )}}
                        <label for="retargeting_show_0"> No </label>
                    </div>
                </div>
            </div> -->

            @include("partials.save")

        </div>
    </div>
{{ Form::close() }}

<div id="loadSelectModal">
    @include("partials.select")
</div>

<script type="text/javascript">
    $("#start_date").datepicker({
        format: 'dd-mm-yyyy'
    });
    $("#end_date").datepicker({
        format: 'dd-mm-yyyy'
    });
    $("#billing_date").datepicker({
        format: 'dd-mm-yyyy'
    });
    
</script>
</div>


