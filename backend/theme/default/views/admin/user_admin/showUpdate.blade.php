{{HTML::script("{$assetURL}js/bootstrap-multiselect.js")}}
{{HTML::style("{$assetURL}css/bootstrap-multiselect.css")}}
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
                        <select class="form-control input-sm" id="status" name="status">
                            <option value="1" <?php if( isset($item->status) &&  $item->status == 1 ){ echo "selected='selected'"; }?> >Mở</option>
                            <option value="0" <?php if( isset($item->status) &&  $item->status == 0 ){ echo "selected='selected'"; }?>>Đóng</option>
                        </select>
                    </div>
                </div>

                <div class="col-xs-3">
                    <div class="form-group">
                        <label>Chọn nhóm</label>
                        <select class="form-control input-sm" id="group" name="group[]" multiple="multiple">
                            @if( count($groups) )
                                <option>- Chọn nhóm -</option>
                                @foreach ($groups as $group)
                                    <option value="{{{ $group->id }}}" @if( isset($item->group) && is_array($item->group) && in_array($group->id, $item->group)) {{{ "selected='selected'" }}}  @endif> {{{ $group->name }}}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>

            </div>

            <div class="form-group">
                <label>Tên đăng nhập</label>
                <input type="text" class="form-control input-sm" id="username" value="{{{ $item->username or Input::get('username') }}}" name="username" placeholder="Nhập tên đăng nhập">
                @if( isset($validate) && $validate->has('username')  )
                <span class="text-warning">{{{ $validate->first('username') }}}</span>
                @endif
            </div>

            <div class="form-group">
                <label>Mật khẩu</label>
                <input type="password" class="form-control input-sm" id="password" value="" name="password" placeholder="Nhập mật khẩu">
                @if( isset($validate) && $validate->has('password')  )
                <span class="text-warning">{{{ $validate->first('password') }}}</span>
                @endif
            </div>

        </div><!-- /.box-body -->

        <div class="box-footer">
            {{View::make("partials.save")}}
        </div>
    {{ Form::close() }}
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $('#group').multiselect({
            includeSelectAllOption: true,
            enableFiltering: true,
            buttonClass: 'form-control input-sm',
        });
    });
</script>
