{{ HTML::style("{$assetURL}css/checkbox.css") }}
<div class="part">
<div class="box-body">
    <!-- form start -->
    {{ Form::open(array('role'=>'form','files'=>true)) }}
            <div class="form-group">
                @if( isset($validate) && $validate->has('url')  )
                <span class="text-warning">{{ $validate->first('url') }}</span> <br/>
                @endif
               
                @if( isset($validate) && $validate->has('amount')  )
                <span class="text-warning">{{ $validate->first('amount') }}</span> <br/>
                @endif
              
            </div>    
                  
            <div class="row">
                <div class="col-sm-9">
                    <div class="form-group">
                        <label class="col-md-2">URL <span class="text-danger">*</span></label>
                        <div class="col-md-10">
                            <input type="text" name="url" value="{{ $url or Input::get('url') }}" class="form-control"/>
                        </div>
                    </div>
                </div>
            </div>
            <br/>
            <div class="row">
                <div class="col-sm-9">
                    <div class="form-group form-group-sm">
                        <label class="col-md-2">Amount <span class="text-danger">*</span></label>
                        <div class="col-md-10">
                            <input type="text" name="amount" value="{{ $amount or Input::get('amount', '0') }}" class="form-control"/>
                        </div>
                    </div>
                </div>
            </div>
            <br/>
             <div class="row">
                <div class="col-sm-9">
                    <div class="form-group form-group-sm">
                        <label class="col-md-2">Website</label>
                        <div class="col-md-10">
                            <textarea name="website" class="form-control" style="height:100px;">{{ $website or Input::get('website', '') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
            <br/>
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
            <br/>
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
                                {{ Form::radio('run', 'day', 'day' == Input::get('run') || ( !empty($run) && 'day' == $run), array('id'=>'day'))}}
                                <label for="day"> Day </label>
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







