<div class="modal fade bs-contact-modal" id="contactModal" tabindex="-1" role="dialog" aria-labelledby="contactModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">{{trans('text.close')}}</span></button>
                <h4 class="modal-title" id="contactModalLabel">
                    @if( !empty($contactData) )
                        {{trans('text.add_new_contact')}}
                    @else
                        {{trans('text.edit_contact')}}
                    @endif
                </h4>
            </div>
            <div class="modal-body">
                <form id="formUpdateContact" class="form-horizontal" role="form">
                    <div class="form-group form-group-sm">
                        <div id="formUpdateContactMessage" class="col-xs-10 col-xs-offset-2"></div>
                    </div>

                    <input type="hidden" name="id" value="{{$contactData->id or 0}}" id="formUpdateContactID">
                    <input type="hidden" name="type" value="" id="formUpdateContactType">
                    <input type="hidden" name="typeID" value="" id="formUpdateContactTypeID">

                    <div class="form-group form-group-sm">
                        <label class="col-xs-2 control-label">{{trans('text.name')}}</label>
                        <div class="col-xs-10">
                            <input type="text" class="form-control" value="{{$contactData->name or ''}}" name="name" id="formUpdateContactName">
                        </div>
                    </div>
                    <div class="form-group form-group-sm">
                        <label class="col-xs-2 control-label">{{trans('text.email')}}</label>
                        <div class="col-xs-10">
                            <input type="text" class="form-control" value="{{$contactData->email or ''}}" name="email" id="formUpdateContactEmail">
                        </div>
                    </div>
                    <div class="form-group form-group-sm">
                        <label class="col-xs-2 control-label">{{trans('text.phone')}}</label>
                        <div class="col-xs-10">
                            <input type="text" class="form-control" value="{{$contactData->phone or ''}}" name="phone" id="formUpdateContactPhone">
                        </div>
                    </div>
                    <div class="form-group form-group-sm">
                        <label class="col-xs-2 control-label">{{trans('text.fax')}}</label>
                        <div class="col-xs-10">
                            <input type="text" class="form-control" value="{{$contactData->fax or ''}}" name="fax" id="formUpdateContactFax">
                        </div>
                    </div>
                </form>                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">{{trans('text.close')}}</button>
                <button type="button" class="btn btn-primary btn-sm" onclick="Contact.updateContact()" id="btnUpdateContact">
                    @if( !empty($contactData) )
                        {{trans('text.edit')}}
                    @else
                        {{trans('text.add')}}
                    @endif
                </button>
            </div>

        </div>
    </div>
</div>