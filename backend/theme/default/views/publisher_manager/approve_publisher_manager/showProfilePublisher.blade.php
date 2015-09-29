
<div class="row">
    <div class="col-sm-12">
        <h3 class="title-view-publisher text-uppercase" style="margin-top: 0;margin-bottom: 20px;">Update profile</h3>
    </div>  
    @if(Session::has('message'))   
    <div class="col-sm-12">        
        <div role="alert" class="alert alert-success fade in">
          <button data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>         
          <p class="text-success">{{Session::get('message')}}</p>
        </div>
    </div>
    @endif  
</div>
<div class="box box-primary box-update">
    <!-- form start -->
    {{ Form::open(array('role'=>'form','files'=>true,'class'=>'form-update')) }}
        <div class="box-body">                
            <div class="form-group">
                <label>{{trans('backend::publisher/text.username')}}</label>
                <input type="text" disabled="" class="form-control" id="username" value="{{{ $item->username }}}" name="username" placeholder="">              
            </div>
            <div class="form-group">
                <label>{{trans('backend::publisher/text.password')}} <span>*</span></label>
                <input type="password" class="form-control" id="password" value="{{{$item->password or Input::get('password')}}}" name="password" placeholder="Enter password">
                @if( isset($validate) && $validate->has('password')  )
                <span class="text-warning">{{ $validate->first('password') }}</span>
                @endif
                <input type="hidden" name="passwordOld" value="{{$item->password}}" placeholder="">
            </div>
            <div class="form-group">
                <label>{{trans('backend::publisher/text.re_password')}} <span>*</span></label>
                <input type="password" class="form-control" id="c-password" value="{{{$item->password or Input::get('c-password')}}}" name="c-password" placeholder="Confirm Password">
                @if( isset($validate) && $validate->has('c-password')  )
                <span class="text-warning">{{ $validate->first('c-password') }}</span>
                @endif
            </div>
            <div class="form-group">
                <label>{{trans('backend::publisher/text.first_name')}} <span>*</span></label>
                <input type="text" class="form-control" id="f-name" value="{{{ $item->first_name or Input::get('f-name') }}}" name="f-name" placeholder="Enter first name">
                @if( isset($validate) && $validate->has('f-name')  )
                <span class="text-warning">{{ $validate->first('f-name') }}</span>
                @endif
            </div>
            <div class="form-group">
                <label>{{trans('backend::publisher/text.last_name')}} <span>*</span></label>
                <input type="text" class="form-control" id="l-name" value="{{{ $item->last_name or Input::get('l-name') }}}" name="l-name" placeholder="Enter last name">
                @if( isset($validate) && $validate->has('l-name')  )
                <span class="text-warning">{{ $validate->first('l-name') }}</span>
                @endif
            </div>
            <div class="form-group">
                <label>{{trans('backend::publisher/text.email')}} <span>*</span></label>
                <input type="text" class="form-control" id="email" value="{{{ $item->email or Input::get('email') }}}" name="email" placeholder="Enter email">
                <input type="hidden" name="old-email" id="old-email" value="{{$item->email}}" />
                @if( isset($validate) && $validate->has('email')  )
                <span class="text-warning">{{ $validate->first('email') }}</span>
                @endif
                @if( isset($messageExistsEmail) )
                <span class="text-warning">{{ $messageExistsEmail }}</span>
                @endif
            </div>
            
        </div><!-- /.box-body -->

        <div class="box-footer">
            <div class="row">
                <div class="col-xs-2">
                    <button type="submit" name="save" value="save" class="btn btn-primary btn-block">{{trans("text.save")}}</button>
                </div>
            </div>
        </div>

    {{ Form::close() }}
</div>










