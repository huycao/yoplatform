<div class="part">
    <!-- form start -->
    {{ Form::open(array('role'=>'form','files'=>true)) }}

        <div class="box-body">
            @if(Session::has('msg'))
            <div class="col-sm-12">        
                <div role="alert" class="alert alert-success fade in">
                  <button data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>         
                  <p class="text-success">{{Session::get('msg')}}</p>
                </div>
            </div>
            @endif

            <div class="row">
                <div class="col-sm-6">
                    <h3>{{trans('backend::publisher/text.info_account')}}</h3>
                    <div class="form-group">
                        <label>{{trans('backend::publisher/text.username')}} </label>
                        <input type="text" class="form-control input-sm" disabled id="username" value="{{{ $item->username or Input::get('username') }}}" name="username" placeholder="Username">
                        @if( isset($validate) && $validate->has('username')  )
                        <span class="text-warning">{{ $validate->first('username') }}</span>
                        @endif
                        @if(isset($message))
                        <span class="text-warning">{{{$message}}}</span>
                        @endif
                    </div>    
                  

                    <div class="form-group">
                        <label>{{trans('backend::publisher/text.first_name')}} </label>
                        <input type="text" class="form-control input-sm" id="first_name" value="{{{ $itemPublisher->first_name or Input::get('first_name') }}}" name="first_name" placeholder="Frist Name">
                        @if( isset($validate) && $validate->has('first_name')  )
                        <span class="text-warning">{{ $validate->first('first_name') }}</span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label>{{trans('backend::publisher/text.last_name')}} </label>
                        <input type="text" class="form-control input-sm" id="last_name" value="{{{ $itemPublisher->last_name or Input::get('last_name') }}}" name="last_name" placeholder="Last Name">
                        @if( isset($validate) && $validate->has('last_name'))
                        <span class="text-warning">{{ $validate->first('last_name') }}</span>
                        @endif
                    </div>
            

                    <div class="form-group">
                        <label>{{trans('backend::publisher/text.email')}} </label>
                        <input type="text" class="form-control input-sm" id="email" value="{{{ $item->email or Input::get('email') }}}" name="email" placeholder="Email">
                        @if( isset($validate) && $validate->has('email')  )
                        <span class="text-warning">{{ $validate->first('email') }}</span>
                        @endif
                    </div>

                    <div class="update-pass">
                        <a href="javascript:;" data-toggle="collapse" data-target="#show-reset" id="btn-reset-pass" class="btn btn-default btn-sm">Reset Password</a>
                        <input type="hidden" name="flag_check_pass" id="flag_check_pass" value="{{{ 0 or Input::get('flag_check_pass')}}}">
                        <div id="show-reset" class="collapse @if(Input::get('flag_check_pass')==1) in @endif">
                             <div class="form-group">
                                <label>{{trans('backend::publisher/text.password')}} </label>
                                <input type="password" class="form-control input-sm" id="password" value="{{{Input::get('password') }}}" name="password" placeholder="Password">
                                @if( isset($msgPass) )
                                <span class="text-warning">{{ $msgPass }}</span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label>{{trans('backend::publisher/text.re_password')}} </label>
                                <input type="password" class="form-control input-sm" id="re-password" value="{{{Input::get('re-password') }}}" name="re-password" placeholder="Re-password">
                                <input type="hidden" name="old-password" id="old-password" value="{{ isset($item->password) ? $item->password : ""}}">
                                @if( isset($msgRePass))
                                <span class="text-warning">{{ $msgRePass }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <h3>{{trans('backend::publisher/text.info_contact')}}</h3>
                    <div class="form-group">
                        <label>{{trans('backend::publisher/text.company_name')}} </label>
                        <input type="text" class="form-control input-sm" id="company_name" value="{{{ $itemPublisher->company or Input::get('company_name') }}}" name="company_name" placeholder="Company Name">
                        @if( isset($validate) && $validate->has('company_name')  )
                        <span class="text-warning">{{ $validate->first('company_name') }}</span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label>{{trans('backend::publisher/text.phone')}} </label>
                        <input type="text" class="form-control input-sm" id="phone" value="{{{ $itemPublisher->phone or Input::get('phone') }}}" name="phone" placeholder="Phone">
                        @if( isset($validate) && $validate->has('phone'))
                        <span class="text-warning">{{ $validate->first('phone') }}</span>
                        @endif
                    </div>
                                
                    <div class="form-group">
                        <label>{{trans('backend::publisher/text.contact_address')}} </label>
                        <textarea name="address_contact" id="address_contact" class="form-control input-sm" cols="30" rows="5">{{{ $itemPublisher->address_contact or Input::get('address_contact')}}}</textarea>
                    </div>
                    <div class="form-group">
                        <label>{{trans('backend::publisher/text.city')}} </label>
                        <input type="text" class="form-control input-sm" id="city" value="{{{ $itemPublisher->city or Input::get('email') }}}" name="city" placeholder="City">
                    </div>
                    <div class="form-group">
                        <label>{{trans('backend::publisher/text.country')}} : </label> {{{ $itemPublisher->country->country_name or '' }}}                        
                    </div>
                </div>
            </div>
            

        </div><!-- /.box-body -->

        <div class="box-footer">
            <button type="submit" name="save" value="save" class="btn btn-default btn-sm">{{trans("text.save")}}</button>
        </div>

    {{ Form::close() }}
</div>



<script type="text/javascript">
    $(function(){
        $("#btn-reset-pass").click(function(event) {
            var vl=$("#flag_check_pass").val();
            if(vl==0) $("#flag_check_pass").val(1);
            else $("#flag_check_pass").val(0);
        });
    });
</script>






