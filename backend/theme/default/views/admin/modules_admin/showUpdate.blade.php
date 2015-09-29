<div class="box box-primary">
    <!-- form start -->
    {{ Form::open(array('role'=>'form')) }}
        <div class="box-body">
            @if( !empty($message) && isset($status) )
                <div class="{{{ ($status) ? 'text-success' : 'text-warning' }}}"> {{{$message}}} </div>
            @endif
    
            <div class="row">
                <div class="col-xs-3">
                    <div class="form-group">
                        <label>Trạng Thái</label>
                        <select class="form-control" id="status" name="status">
                            <option value="1" <?php if( isset($item->status) &&  $item->status == 1 ){ echo "selected='selected'"; }?> >Mở</option>
                            <option value="0" <?php if( isset($item->status) &&  $item->status == 0 ){ echo "selected='selected'"; }?>>Đóng</option>
                        </select>
                    </div>
                </div>

                <div class="col-xs-3">
                    <div class="form-group">
                        <label>Module</label>
                        <select class="form-control" id="module" name="module">
                            <option value="0">Chọn Module</option>
                            @if( count($modules) )
                                @foreach ($modules as $module)
                                    <option value="{{{ $module->id }}}" @if( isset($item->module_id) && $item->module_id == $module->id ) {{{ "selected='selected'" }}}  @endif > {{{ $module->name }}}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>Tên</label>
                <input type="text" class="form-control" id="name" value="{{{ $item->name or Input::get('name') }}}" name="name" placeholder="Nhập tên">
                @if( isset($validate) && $validate->has('name')  )
                <span class="text-warning">{{{ $validate->first('name') }}}</span>
                @endif
            </div>

            <div class="form-group">
                <label>Đường dẫn</label>
                <input type="text" class="form-control" id="slug" value="{{{ $item->slug or Input::get('slug') }}}" name="slug" placeholder="Nhập đường dẫn">
                @if( isset($validate) && $validate->has('slug')  )
                <span class="text-warning">{{{ $validate->first('slug') }}}</span>
                @endif
            </div>

            <div class="form-group">
                <label>Biểu tượng</label>
                <input type="text" class="form-control" id="icon" value="{{{ $item->icon or Input::get('icon') }}}" name="icon" placeholder="Nhập biểu tượng">
                @if( isset($validate) && $validate->has('icon')  )
                <span class="text-warning">{{{ $validate->first('icon') }}}</span>
                @endif
            </div>

        </div><!-- /.box-body -->

        <div class="box-footer">
            {{View::make("partials.save")}}
        </div>
    {{ Form::close() }}
</div>





