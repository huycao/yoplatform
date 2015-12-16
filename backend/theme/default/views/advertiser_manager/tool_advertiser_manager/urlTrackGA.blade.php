<div class="part">
<div class="box-body">
    <!-- form start -->
    {{ Form::open(array('role'=>'form','files'=>true)) }}
        <div class="box-body">
            <div class="row">
                <div class="col-sm-9">
                    <div class="form-group">
                        <label>URL <span class="text-danger">*</span></label>
                        <textarea name="url" class="form-control" id="url" style="text-align:left;height:200px;">@if(sizeof($items) >0)@foreach($items as $k=>$v){{trim($v)}}@endforeach @endif</textarea>  
                    </div>
                </div>
            </div>
        </div><!-- /.box-body -->

        <div class="box-footer">
            <button type="submit" name="save" value="save" class="btn btn-primary">{{trans("text.save")}}</button>
        </div>
    {{ Form::close() }}
</div>
</div>







