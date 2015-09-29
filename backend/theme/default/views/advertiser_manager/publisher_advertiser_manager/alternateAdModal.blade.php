<div class="modal-body">
    <form id="formModal" class="form-horizontal" role="form">
        <div class="form-group form-group-sm">
            <div id="formUpdateContactMessage" class="col-xs-10 col-xs-offset-2"></div>
        </div>

        <div class="form-group form-group-sm">
            <label class="col-xs-2 control-label">{{trans('text.title')}}</label>
            <div class="col-xs-10">
                <input type="text" class="form-control" value="{{$item->name or ''}}" name="name">
            </div>
        </div>
        <div class="form-group">
            <label class="col-xs-2 control-label">{{trans('text.code')}}</label>
            <div class="col-xs-10">
            	<textarea class="form-control" name="code" rows="10">{{{$item->code or ''}}}</textarea>
            </div>
        </div>
        <div class="form-group form-group-sm">
            <label class="col-xs-2 control-label">{{trans('text.weight')}}</label>
            <div class="col-xs-10">
                <input type="text" class="form-control" value="{{$item->weight or ''}}" name="weight">
            </div>
        </div>
    </form>                
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">{{trans('text.close')}}</button>
    <button type="button" class="btn btn-primary btn-sm" onclick="modalApp.update({{$id}})" id="btnUpdateContact">
        {{trans('text.save')}}
    </button>
</div>
