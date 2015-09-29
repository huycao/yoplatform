@include("partials.show_messages")
{{ Form::open(array('role'=>'form','class'=>'form-horizontal form-cms')) }}
    <div class="row">
        <div class="col-md-12">
            <!-- CATEGORY -->
            <div class="form-group form-group-sm">
                <label class="col-md-2">{{trans('text.campaign_category')}}</label>
                <div class="col-md-5">
                <?php
                    $categoryValue = ( isset($item->category_id) ) ? $item->category_id : Input::get('category');
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

                    <input type="text" onclick="Select.openModal('advertiser')" class="form-control" id="advertiser" value="{{{ $item->advertiser->name or Input::get('advertiser') }}}" name="advertiser">

                </div>
                <div class="col-md-3 text-select">
                    <a href="javascript:;" onclick="Select.openModal('advertiser')" class="btn btn-primary btn-block btn-sm">{{trans('text.select_advertiser')}}</a>
                </div>
            </div>
            <!-- AGENCY -->
            <div class="form-group form-group-sm">
                <label class="col-md-2">{{trans('text.agency')}}</label>
                <div class="col-md-5">
                    <input type="hidden" class="form-control" id="agency_id" value="{{{ $item->agency_id or Input::get('agency_id') }}}" name="agency_id">
                    <input type="text" onclick="Select.openModal('agency')" class="form-control" id="agency" value="{{{ $item->agency->name or Input::get('agency') }}}" name="agency">
                </div>
                <div class="col-md-3 text-select">
                    <a href="javascript:;" onclick="Select.openModal('agency')" class="btn btn-primary btn-block btn-sm">{{trans('text.select_agency')}}</a>
                </div>
            </div>            
            <!-- CONTACT -->
            <div class="form-group form-group-sm">
                <label class="col-md-2">{{trans('text.contact')}}</label>
                <div class="col-md-5">
                    <input type="hidden" class="form-control" id="contact_id" value="{{{ $item->contact_id or Input::get('contact_id') }}}" name="contact_id">
                    <input type="text" onclick="Select.openModal('contact')" class="form-control" id="contact" value="{{{ $item->contact->name or Input::get('contact') }}}" name="contact">
                </div>
                <div class="col-md-3 text-select">
                    <a href="javascript:;" onclick="Select.openModal('contact')" class="btn btn-primary btn-block btn-sm">{{trans('text.select_contact')}}</a>
                </div>
            </div>            
            <!-- PRODUCT -->
            <div class="form-group form-group-sm">
                <label class="col-md-2">{{trans('text.product')}}</label>
                <div class="col-md-5">
                    <input type="text" class="form-control" id="product" value="{{{ $item->product or Input::get('product') }}}" name="product">
                </div>
            </div>            
            <!-- CAMPAIGN NAME -->
            <div class="form-group form-group-sm">
                <label class="col-md-2">{{trans('text.campaign')}}</label>
                <div class="col-md-5">
                    <input type="text" class="form-control" id="name" value="{{{ $item->name or Input::get('name') }}}" name="name">
                </div>
            </div>
            <!-- SALE PERSON -->
            <div class="form-group form-group-sm">
                <label class="col-md-2">{{trans('text.sale_person')}}</label>
                <div class="col-md-5">
                    <input type="hidden" class="form-control" id="sale_id" value="{{{ $item->sale_id or Input::get('sale_id') }}}" name="sale_id">
                    <input type="text" onclick="Select.openModal('sale')" class="form-control" id="sale" value="{{{ $item->sale->username or Input::get('sale') }}}" name="sale">
                </div>
                <div class="col-md-3 text-select">
                    <a href="javascript:;" onclick="Select.openModal('sale')" class="btn btn-primary btn-block btn-sm">{{trans('text.select_sale')}}</a>
                </div>
            </div>
            <!-- CAMPAGIN MANAGER -->
            <div class="form-group form-group-sm">
                <label class="col-md-2">{{trans('text.campaign_manager')}}</label>
                <div class="col-md-5">
                    <input type="hidden" class="form-control" id="campaign_manager_id" value="{{{ $item->campaign_manager_id or Input::get('campaign_manager_id') }}}" name="campaign_manager_id">
                    <input type="text" onclick="Select.openModal('campaign_manager')" class="form-control" id="campaign_manager" value="{{{ $item->campaign_manager->username or Input::get('campaign_manager') }}}" name="campaign_manager">
                </div>
                <div class="col-md-3 text-select">
                    <a href="javascript:;" onclick="Select.openModal('campaign_manager')" class="btn btn-primary btn-block btn-sm">{{trans('text.select_campaign_manager')}}</a>
                </div>
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
                    <input type="text" class="form-control" id="start_date" value="{{{ $item->start_date or Input::get('start_date') }}}" name="start_date">
                </div>
            </div>            
            <!-- END DATE -->
            <div class="form-group form-group-sm">
                <label class="col-md-2">{{trans('text.end_date')}}</label>
                <div class="col-md-5">
                    <input type="text" class="form-control" id="end_date" value="{{{ $item->end_date or Input::get('end_date') }}}" name="end_date">
                </div>
            </div>                        
            <!-- BILLING DATE -->
            <div class="form-group form-group-sm">
                <label class="col-md-2">{{trans('text.billing_date')}}</label>
                <div class="col-md-5">
                    <input type="text" class="form-control" id="billing_date" value="{{{ $item->billing_date or Input::get('billing_date') }}}" name="billing_date">
                </div>
            </div>                                    
            <!-- COUNTRY -->
            <div class="form-group form-group-sm">
                <label class="col-md-2">{{trans('text.country')}}</label>
                <div class="col-md-5">
                <?php
                    $countryValue = ( isset($item->country_id) ) ? $item->country_id : Input::get('country_id');
                ?>
                {{ 
                    Form::select(
                        'country_id', 
                        $listCountry, 
                        $countryValue, 
                        array('class'=>'form-control','id'=>'country_id')
                    ) 
                }}
                </div>
            </div>
            <!-- CURRENT -->
            <div class="form-group form-group-sm">
                <label class="col-md-2">{{trans('text.currency')}}</label>
                <div class="col-md-5">
                <?php
                    $currencyValue = ( isset($item->currency_id) ) ? $item->currency_id : Input::get('currency_id');
                ?>
                {{ 
                    Form::select(
                        'currency_id', 
                        $listCurrency, 
                        $currencyValue, 
                        array('class'=>'form-control','id'=>'currency_id')
                    ) 
                }}
                </div>
            </div>
            <!-- ATTENTION INVOICE -->
            <div class="form-group form-group-sm">
                <label class="col-md-2">{{trans('text.attention')}} ( {{trans('text.invoice')}} )</label>
                <div class="col-md-5">
                    <input type="hidden" class="form-control" id="invoice_contact_id" value="{{{ $item->invoice_contact_id or Input::get('invoice_contact_id') }}}" name="invoice_contact_id">
                    <input type="text" onclick="Select.openModal('invoice_contact')" class="form-control" id="invoice_contact" value="{{{ $item->invoice_contact->name or Input::get('invoice_contact') }}}" name="invoice_contact">
                </div>
                <div class="col-md-3 text-select">
                    <a href="javascript:;" onclick="Select.openModal('invoice_contact')" class="btn btn-primary btn-block btn-sm">{{trans('text.select_contact')}}</a>
                </div>
            </div>            
            <!-- INVOICE TERM -->
            <div class="form-group form-group-sm">
                <label class="col-md-2">{{trans('text.invoice_term')}}</label>
                <div class="col-md-5">
                    <label class="radio-inline">
                        {{ 
                            Form::radio(
                                'invoice_term',
                                'pdc',
                                'pdc' == Input::get('invoice_term') || ( !empty($item->invoice_term) && 'pdc' == $item->invoice_term) 
                            )
                        }}
                        PDC
                    </label>
                    <label class="radio-inline">
                        {{ 
                            Form::radio(
                                'invoice_term',
                                'cash',
                                'cash' == Input::get('invoice_term') || ( !empty($item->invoice_term) && 'cash' == $item->invoice_term)
                            )
                        }}
                        Cash
                    </label>
                    <label class="radio-inline">
                        {{ 
                            Form::radio(
                                'invoice_term',
                                '30 days',
                                '30 days' == Input::get('invoice_term') || ( !empty($item->invoice_term) && '30 days' == $item->invoice_term)
                            )
                        }}
                        30 days
                    </label>
                    <label class="radio-inline">
                        {{ 
                            Form::radio(
                                'invoice_term',
                                '60 days',
                                '60 days' == Input::get('invoice_term') || ( !empty($item->invoice_term) && '60 days' == $item->invoice_term)
                            )
                        }}
                        60 days
                    </label>
                </div>
            </div>              
            <!-- SALES DISTRIBUTION -->
            <div class="form-group form-group-sm">
                <label class="col-md-2">{{trans('text.sale_distribution')}}</label>
                <div class="col-md-5">
                    <label class="radio-inline">
                        {{ 
                            Form::radio(
                                'sale_distribution',
                                'join',
                                'join' == Input::get('sale_distribution') || ( !empty($item->sale_distribution) && 'join' == $item->sale_distribution)
                            )
                        }}
                        Join
                    </label>
                    <label class="radio-inline">
                        {{ 
                            Form::radio(
                                'sale_distribution',
                                'split',
                                'split' == Input::get('sale_distribution') || ( !empty($item->sale_distribution) && 'split' == $item->sale_distribution)
                            )
                        }}
                        Split
                    </label>
                </div>
            </div>                          
            <!-- SALES ORDER TAX -->
            <div class="form-group form-group-sm">
                <label class="col-md-2">{{trans('text.sale_order_tax')}} (%)</label>
                <div class="col-md-5">
                    <input type="text" class="form-control" id="sale_order_tax" value="{{{ $item->sale_order_tax or Input::get('sale_order_tax') }}}" name="sale_order_tax">
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
    $("#start_date").datepicker();
    $("#end_date").datepicker();
    $("#billing_date").datepicker();
</script>



