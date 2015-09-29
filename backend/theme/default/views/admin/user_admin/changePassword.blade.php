<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">Change Password</h3>
            </div><!-- /.box-header -->
            <!-- form start -->
            {{ Form::open(array('role'=>'form')) }}
                <div class="box-body">
                    @if( isset($message) && isset($status) )
                        <div class="{{{ ($status) ? 'text-success' : 'text-warning' }}}"> {{{$message}}} </div>
                    @endif
                    <div class="form-group">
                        <label for="oldPassword">Mật khẩu hiện tại</label>
                        <input type="password" name="oldPassword" class="form-control fo" id="oldPassword" placeholder="Nhập mật khẩu cũ">
                        @if( isset($validate) && $validate->has('oldPassword')  )
                        <span class="text-warning">{{{ $validate->first('oldPassword') }}}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="newPassword">Mật khẩu mới</label>
                        <input type="password" name="newPassword" class="form-control" id="newPassword" placeholder="Nhập mật khẩu mới">
                        @if( isset($validate) && $validate->has('newPassword')  )
                        <span class="text-warning">{{{ $validate->first('newPassword') }}}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="vertifyNewPassword">Mật khẩu xác thực</label>
                        <input type="password" name="newPassword_confirmation" class="form-control" id="vertifyNewPassword" placeholder="Nhập mật khẩu xác thực">
                        @if( isset($validate) && $validate->has('newPassword_confirmation')  )
                        <span class="text-warning">{{{ $validate->first('newPassword_confirmation') }}}</span>
                        @endif
                    </div>
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            {{ Form::close() }}
        </div>
    </div>
</div>