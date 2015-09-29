<div class="modal fade bs-publisher-modal" id="flightModal" tabindex="-1" role="dialog" aria-labelledby="publisherModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">{{trans('text.close')}}</span></button>
                <h4 class="modal-title" id="publisherModalLabel">
                    @if( !empty($item) )
                    {{trans('text.edit_price')}}
                    @else
                    {{trans('text.add_price')}}
                    @endif
                </h4>
            </div>
            <div class="modal-body">
                <form id="formUpdateFlight" class="form-horizontal form-cms" role="form">

                    <div class="row">
                        <div class="col-md-12">

                            <div id="formUpdatePublisherMessage" class="col-xs-10 col-xs-offset-2"></div>

                            <input type="hidden" name="flightWebsiteId" value="{{{ $item->id }}}">

                            <div class="form-group">
                                <label class="col-xs-2 control-label">{{trans('text.name')}}</label>
                                <div class="col-xs-10">
                                    <input type="text" class="form-control input-sm" value="{{{ $flightName }}}" readonly>
                                </div>
                            </div>   

                            <div class="form-group">
                                <label class="col-xs-2 control-label">{{trans('text.publisher_cost')}}</label>
                                <div class="col-xs-10">
                                    <input type="text" class="form-control" id="publisher_base_cost" value="{{{ $item->publisher_base_cost }}}" name="publisher_base_cost">
                                </div>
                            </div>	 
                        </div>
                    </div>

                </form>                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">{{trans('text.close')}}</button>
                <button type="button" class="btn btn-primary btn-sm" onclick="Ad.update()" id="btnUpdatePublisher">
                    @if( !empty($item) )
                    {{trans('text.edit')}}
                    @else
                    {{trans('text.add')}}
                    @endif
                </button>
            </div>

        </div>
    </div>
</div>