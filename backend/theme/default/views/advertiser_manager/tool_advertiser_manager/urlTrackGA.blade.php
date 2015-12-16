{{ HTML::style("{$assetURL}css/checkbox.css") }}
<div class="part">
<div class="box-body">
    <!-- form start -->
    {{ Form::open(array('role'=>'form','files'=>true)) }}
     
            <div class="row">
                <div class="col-sm-9">
                    <div class="form-group">
                        <label>URL <span class="text-danger">*</span></label>
                        <textarea name="url" class="form-control" id="url" style="text-align:left;height:200px;">@if(isset($item))@foreach($item as $k){{trim($k->url) . PHP_EOL}}@endforeach @endif</textarea>  
                    </div>
                </div>
            </div>
             <div class="row">
                <div class="col-sm-9">
                    <div class="form-group form-group-sm">
                        <label class="col-md-2">Active</label>
                        <div class="col-md-10">
                            <div class="radio radio-info radio-inline">
                                {{ Form::radio('active', '1', '1' == Input::get('active') || ( isset($active) && 1 == $active), array('id'=>'active') )}}
                                <label for="active"> Yes </label>
                            </div>
                            <div class="radio radio-info radio-inline">
                                {{ Form::radio('active', '0', '0' == Input::get('active') || ( isset($active) && 0 == $active), array('id'=>'inactive') )}}
                                <label for="inactive"> No </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-9">
                    <div class="form-group form-group-sm">
                        <label class="col-md-2">Run</label>
                        <div class="col-md-10">
                            <div class="radio radio-info radio-inline">
                                {{ Form::radio('run', 'all', 'all' == Input::get('run') || ( !empty($run) && 'all' == $run), array('id'=>'all') )}}
                                <label for="all"> All </label>
                            </div>
                            <div class="radio radio-info radio-inline">
                                {{ Form::radio('run', 'random', 'random' == Input::get('run') || ( !empty($run) && 'random' == $run), array('id'=>'random'))}}
                                <label for="random"> Random </label>
                            </div>
                        </div>
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







