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
            </div>

            <div class="form-group">
                <label>Tên nhóm</label>
                <input type="text" class="form-control" id="name" value="{{{ $item->name or Input::get('name') }}}" name="name" placeholder="Nhập tên nhóm">
            </div>

        </div><!-- /.box-body -->

        <div class="box-footer">
            {{View::make("partials.save")}}
        </div>
    {{ Form::close() }}
</div>





