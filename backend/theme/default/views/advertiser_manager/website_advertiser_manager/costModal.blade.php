<div class="modal fade bs-cost-modal" id="modalCost" tabindex="-1" role="dialog" aria-labelledby="modalLabelCost" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">{{trans('text.close')}}</span></button>
                <h4 class="modal-title" id="modalLabelCost">
                    Base Cost
                </h4>
            </div>
            <div class="modal-body">
                <form id="formUpdateCost" class="form-horizontal form-cms" role="form">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                            <div id="formUpdateMessageCost" class="col-xs-10 col-xs-offset-2"></div>
                            </div>
                            
                            <input type="hidden" name="wid" value="{{$wid}}">
                            <input type="hidden" name="waid" value="{{$waid}}">

                            <!-- AD FORMAT -->
                                <div class="form-group">
                                    <label class="col-md-2">{{trans('text.ad_format')}}</label>
                                    <div class="col-md-10">
                                    @if( isset($adFormatLists) )
                                        <?php
                                            $adFormat = 0;
                                        ?>
                                        {{ 
                                            Form::select(
                                                'ad_format_id', 
                                                $adFormatLists,
                                                $adFormat, 
                                                array('class'=>'form-control input-sm','id'=>'ad_format_id')
                                            ) 
                                        }}
                                    @else
                                        <input type="hidden" name="ad_format_id" value="{{$item->adFormat->id}}">
                                        {{ $item->adFormat->name }}                              
                                    @endif
                                    </div>
                                </div> 

                            
                            <div class="form-group form-group-sm">
                                <label class="col-md-2">CPM</label>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" id="cpm" value="{{{ $item->cpm or 0 }}}" name="cpm">
                                </div>
                            </div>  

                            <div class="form-group form-group-sm">
                                <label class="col-md-2">CPC</label>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" id="cpc" value="{{{ $item->cpc or 0 }}}" name="cpc">
                                </div>
                            </div>  

                            <div class="form-group form-group-sm">
                                <label class="col-md-2">CPD</label>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" id="cpd" value="{{{ $item->cpd or 0 }}}" name="cpd">
                                </div>
                            </div>  

                            <div class="form-group form-group-sm">
                                <label class="col-md-2">CPA</label>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" id="cpa" value="{{{ $item->cpa or 0 }}}" name="cpa">
                                </div>
                            </div>

                            <div class="form-group form-group-sm">
                                <label class="col-md-2">CPA(%)</label>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" id="cpa_percent" value="{{{ $item->cpa_percent or 0 }}}" name="cpa_percent">
                                </div>
                            </div>  

                        </div>
                    </div>

                </form>                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">{{trans('text.close')}}</button>
                <button type="button" class="btn btn-primary btn-sm" onclick="costApp.update()" id="btnUpdateCost">
                    Add
                </button>
            </div>

        </div>
    </div>
</div>