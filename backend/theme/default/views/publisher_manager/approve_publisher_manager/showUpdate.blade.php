
{{ HTML::script("{$assetURL}js/dual-list-box.js") }}
<script type="text/javascript">
    $(function(){        
        var val_check = {{{ Input::has('checkflaguser') ? Input::get('checkflaguser') : 0 }}};
        if(val_check == '3') $("#show-register-user").show();
        else $("#show-register-user").hide();                                

        $(".flag-exist-suser").click(function(event) {            
            var vl = $(this).val();
            if(vl=="1"){
                $("#show-register-user").hide();                
            }else{
                $("#show-register-user").show();            
            }
        });  

        $(".edit-traffic-report").click(function(event) {
           var vl = $("#flag-e").val();
           if(vl==0){
                $("#flag-e").val(1);
                $("#show-edit-tracffic").removeClass('hidden');
                $("#show-edit-tracffic").addClass('show');
            }else{
                $("#flag-e").val(0);
                 $("#show-edit-tracffic").removeClass('show');
                $("#show-edit-tracffic").addClass('hidden');
            }
        });      

        $("#btn-ganerate-pass").click(function(event) {           
            var pass=genarateRandom(8);
            $("#password").val(pass);            
        }); 

        $(".revenue-sharing-orther").click(function(event) {
            var vl=$(this).val();
            if(vl=="-1"){
                $("#revenue-other").removeClass('hidden');
                $("#revenue-other").addClass('show');
            }else{
                $("#revenue-other").removeClass('show');
                $("#revenue-other").addClass('hidden');
            }
        });

        $(".btn-add-site").click(function(event) {
            $(".show-site-name").append('<div class="input-group">'
                                          +'<span class="input-group-addon">'
                                            +'<input type="radio" onclick="chooseSite($(this))" name="company-name">'
                                          +'</span>'
                                          +'<input type="text" class="form-control" name="site-name-s[]" value="">'
                                        +'</div>');
        });

        $("#site-name").change(function(e) {
           var vl =$(this).val();
           $("#company-name-e").val(vl);
           $("#site-name-s").val(vl);
        });

        $("#set-as-primary").click(function(event) {
            var vl=$("#selected_site-channel").val();
            var flag=false;
            if(flag == false){
                $("#loading").show();
                $.post("{{URL::Route('ApprovePublisherManagerSetCate')}}",{
                    id : {{$item->id}},
                    cate : vl,
                    _token :"{{csrf_token()}}"                  
                },function(data){
                    if(data==true){
                        alert("Success");
                    }                   
                });
            }

        });

        $('#manage-country').DualListBox(); 
        $('#server-country').DualListBox();             
        $('#site-channel').DualListBox();
    });

    function genarateRandom(len)
    {
        var text = "";
        var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

        for( var i=0; i < len; i++ )
            text += possible.charAt(Math.floor(Math.random() * possible.length));

        return text;
    }

    function chooseSite(_this){
        var vlSiteName=_this.parent().parent().find('input[type=text]').val();
        $("#company-name-e").val(vlSiteName);
    }

    function moveStatus(status){
        var flag=false;
        if(flag == false){
            $("#loading").show();
            $.post("{{URL::Route('ApprovePublisherManagerMoveStatus')}}",{
                id : {{$item->id}},
                status : status,
                _token :"{{csrf_token()}}"                  
            },function(data){
                if(data){
                    if(status==1){//archived
                        $("#loading").hide();
                        flag=true;
                        alert('{{trans("backend::publisher/text.move_success_archive")}}');
                    }else if(status==2){//disapproved
                        $("#loading").hide();
                        flag=true;
                        alert('{{trans("backend::publisher/text.move_success_disapprove")}}');
                    }
                    else if(status==3){//approved
                        $("#loading").hide();
                        flag=true;
                        alert('{{trans("backend::publisher/text.move_success_approve")}}');
                    }
                    
                }                   
            });
        }
    }

    
</script>
{{Form::open(['method'=>'post','role'=>'form','enctype'=>'multipart/form-data'])}}
<div class="row">
    <div class="col-sm-12">
        <div class="row">
        <div class="col-sm-12">
            <h3 class="title-view-publisher text-uppercase pull-left">{{trans('backend::publisher/text.site_information')}} :</h3>           
            <div class="pull-right">               
                <button type="button" onclick="return moveStatus(1);" class="btn btn-primary btn-move-archive"><span class="glyphicon glyphicon-share-alt"></span> {{trans('backend::publisher/text.move_to_archive')}}</button>             
            </div>
            <div class="clearfix"></div>
           
            @if( Session::has('mess') )
            <div class="">        
                <div role="alert" class="alert alert-success fade in">
                  <button data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>         
                  <p class="">{{Session::get('mess')}}</p>
                </div>
            </div>
            @endif 
        </div>
        </div>      
        <div class="row">
            <div class="col-sm-6">
                <table class="table table-edit-publisher">
                    <tbody>
                        <tr>
                            <td>{{trans('backend::publisher/text.site_name')}} <span>*</span></td>
                            <td>
                                <div class="form-group">                                    
                                    <input type="text" class="form-control" id="site-name" value="{{{ isset($item->site_name) ? $item->site_name : "" }}}" name="site-name" placeholder="{{trans('backend::publisher/text.site_name')}}">              
                                    @if(isset($validate) && $validate->has("site-name"))
                                    <span class="text-warning">{{ $validate->first("site-name") }}</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>{{trans('backend::publisher/text.site_URL')}} <span>*</span></td>
                            <td>
                                <div class="form-group">                                    
                                    <input type="text" class="form-control" id="site-url" value="{{{ isset($item->site_url) ? $item->site_url : "" }}}" name="site-url" placeholder="{{trans('backend::publisher/text.site_URL')}}">              
                                    @if(isset($validate) && $validate->has("site-url"))
                                    <span class="text-warning">{{ $validate->first("site-url") }}</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>{{trans('backend::publisher/text.site_description')}} <span>*</span></td>
                            <td>
                                <div class="form-group">                                    
                                    <textarea name="site-description" class="form-control" id="site-description" cols="30" rows="4">{{{ isset($item->site_description) ? $item->site_description : "" }}}</textarea>
                                    @if(isset($validate) && $validate->has("site-description"))
                                    <span class="text-warning">{{ $validate->first("site-description") }}</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>{{trans('backend::publisher/text.site_category')}} <span>*</span></td>
                            <td>
                                <div class="form-group">                                    
                                    <select class="form-control" name="site-category" id="site-category">
                                       <option value="">{{trans('backend::publisher/text.choose')}}</option>
                                       @foreach($itemCate as $itemca)
                                       <option {{{ ($itemca->id==$item->category) ? "selected" : "" }}} value="{{$itemca->id}}">{{$itemca->name}}</option>
                                       @endforeach
                                    </select>
                                    @if(isset($validate) && $validate->has("site-category"))
                                    <span class="text-warning">{{ $validate->first("site-category") }}</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>{{trans('backend::publisher/text.site_language')}}</td>
                            <td>
                                <div class="form-group">                                    
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <select multiple="multiple" data-title="site-language" data-value="index" data-text="name" size="10" data-name="site-language[]" id="manage-country" class="form-control">
                                            <?php $selected =''; ?>
                                            @foreach($itemLanguage as $itemC)
                                                @foreach($itemSiteLang as $itemSiteL)
                                                    @if($itemSiteL->language_name == $itemC->name)
                                                        <?php $selected ='selected';break; ?>
                                                    @else
                                                        <?php $selected =''; ?>
                                                    @endif
                                                @endforeach
                                                
                                                <option {{$selected}} value="{{$itemC->id}},{{$itemC->name}}">{{ $itemC->name }}</option>                                                
                                            @endforeach
                                            </select>                                            
                                        </div>
                                        
                                    </div>
                                    
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>{{trans('backend::publisher/text.other_language')}}</td>
                            <td>
                                <div class="form-group">                                    
                                    <input type="text" class="form-control" id="orther-lang" value="{{{ isset($item->orther_lang) ? $item->orther_lang : "" }}}" name="orther-lang" placeholder="">              
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>        
            </div>
            <div class="col-sm-6">
                <table class="table table-edit-publisher">
                    <tbody>
                        <tr>
                            <td>{{trans('backend::publisher/text.date_registered')}}</td>
                            <td>{{isset($item->created_at) ? formatDate($item->created_at) : "N\A" }}</td>
                        </tr>
                        <tr>
                            <td>{{trans('backend::publisher/text.monthly_unique_visitor')}} <span>*</span></td>
                            <td>
                                <div class="form-group">                                    
                                    <input type="text" class="form-control" id="unique-visitor" value="{{{ isset($item->unique_visitor) ? $item->unique_visitor : "" }}}" name="unique-visitor" placeholder="">              
                                    @if(isset($validate) && $validate->has("unique-visitor"))
                                    <span class="text-warning">{{ $validate->first("unique-visitor") }}</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>{{trans('backend::publisher/text.monthly_page_view')}} <span>*</span></td>
                            <td>
                                <div class="form-group">                                    
                                    <input type="text" class="form-control" id="page-view" value="{{{ isset($item->pageview) ? $item->pageview : "" }}}" name="page-view" placeholder="">              
                                    @if(isset($validate) && $validate->has("page-view"))
                                    <span class="text-warning">{{ $validate->first("page-view") }}</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>{{trans('backend::publisher/text.daily_unique_visitor')}} <span>*</span></td>
                            <td>
                                <div class="form-group">                                    
                                    <input type="text" class="form-control" id="daily-view" value="{{{ isset($item->username) ? $item->username : 0 }}}" name="daily-view" placeholder="">              
                                    @if(isset($validate) && $validate->has("daily-view"))
                                    <span class="text-warning">{{ $validate->first("daily-view") }}</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        
                        <tr>
                            <td>{{trans('backend::publisher/text.traffic_report')}}</td>
                            <td>
                                <a target="_blank" href="{{URL::to(Route('ApprovePublisherManagerShowPdf',$item->id))}}" class="btn btn-primary"><span class="glyphicon glyphicon-search"></span> {{trans('backend::publisher/text.view_traffic_report')}}</a>
                                <br><a href="javascript:;" style="margin: 15px 0px; display: block;" class="edit-traffic-report"><i class="fa fa-edit"></i> {{trans('backend::publisher/text.edit')}}</a>
                                <div class="form-group {{{ (Input::get('flag-e')==1) ? 'show' : 'hidden' }}}" id="show-edit-tracffic">
                                    <input type="hidden" name="flag-e" id="flag-e" value="0"/ >
                                    <input type="file" name="traffic_report_file" class="form-control" data-bv-field="traffic_report_file">
                                    @if(isset($msg_upload_file))
                                    <span class="text-warning">{{{ $msg_upload_file['uploadfile'] }}}</span>
                                    @endif    
                                </div>                                                            
                                <input type="hidden" name="file-report-old" id="file-report-old" value="{{{$item->traffic_report_file}}}"/>
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>          
        </div>
        
    </div>
</div>


<div class="row">
    <div class="col-sm-12">
        <h3 class="title-view-publisher text-uppercase">{{trans('backend::publisher/text.account_information')}} :</h3>
        <div class="row">
            <div class="col-sm-6">
                <table class="table table-edit-publisher">
                    <tbody>                       
                        <tr>
                            <td>{{trans('backend::publisher/text.Paymentpayableto')}} <span>*</span></td>
                            <td>
                                <div class="form-group">                                    
                                    <input type="text" class="form-control" id="payment-to" value="{{{ $item->payment_to }}}" name="payment-to" placeholder="">              
                                    @if(isset($validate) && $validate->has("payment-to"))
                                    <span class="text-warning">{{ $validate->first("payment-to") }}</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>{{trans('backend::publisher/text.company')}} <span>*</span></td>
                            <td>
                                <div class="form-group">                                    
                                    <input type="text" class="form-control" id="company" value="{{{ $item->company }}}" name="company" placeholder="">              
                                    @if(isset($validate) && $validate->has("company"))
                                    <span class="text-warning">{{ $validate->first("company") }}</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>{{trans('backend::publisher/text.email_address')}} <span>*</span></td>
                            <td>
                                <div class="form-group">                                    
                                    <input type="text" class="form-control" id="email-address" value="{{{ $item->email }}}" name="email-address" placeholder="">              
                                    @if(isset($validate) && $validate->has("email-address"))
                                    <span class="text-warning">{{ $validate->first("email-address") }}</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>{{trans('backend::publisher/text.gender')}} <span>*</span></td>
                            <td>
                                <div class="form-group">                                    
                                    <input type="radio" @if($item->title=="Mr") checked="" @endif name="title" value="Mr" /> Mr
                                    <input type="radio" @if($item->title=="Mrs") checked="" @endif name="title" value="Mrs" /> Mrs
                                    <input type="radio" @if($item->title=="Ms") checked="" @endif name="title" value="Ms" /> Ms
                                </div>
                                @if(isset($validate) && $validate->has("title"))
                                    <span class="text-warning">{{ $validate->first("title") }}</span>
                                    @endif
                            </td>
                        </tr>
                        <tr>
                            <td>{{trans('backend::publisher/text.first_name')}} <span>*</span></td>
                            <td>
                                <div class="form-group">                                    
                                    <input type="text" class="form-control" id="f-name" value="{{{ $item->first_name }}}" name="f-name" placeholder="">              
                                    @if(isset($validate) && $validate->has("f-name"))
                                    <span class="text-warning">{{ $validate->first("f-name") }}</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>{{trans('backend::publisher/text.last_name')}} <span>*</span></td>
                            <td>
                                <div class="form-group">                                    
                                    <input type="text" class="form-control" id="l-name" value="{{{ $item->last_name }}}" name="l-name" placeholder="">              
                                    @if(isset($validate) && $validate->has("l-name"))
                                    <span class="text-warning">{{ $validate->first("l-name") }}</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>{{trans('backend::publisher/text.country')}}</td>
                            <td>
                                <div class="form-group">                                    
                                    <select class="form-control" name="country">
                                        <option value="">{{trans('backend::publisher/text.choose')}}</option>
                                        @foreach($itemCountry as $itemC)                                            
                                            <option {{{($itemC->id==$item->country) ? "selected" : ( (Input::get('country')==$itemC->id) ? "selected" : "") }}} value="{{$itemC->id}}">{{ $itemC->country_name }}</option>                            
                                        @endforeach
                                    </select>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>        
            </div>
            <div class="col-sm-6">
                <table class="table table-edit-publisher">
                    <tbody>
                        <tr>
                            <td>{{trans('backend::publisher/text.address')}} <span>*</span></td>
                            <td>
                                <div class="form-group">                                    
                                    <textarea name="address" class="form-control" id="" cols="20" rows="4">{{$item->address}}</textarea>
                                    @if(isset($validate) && $validate->has("address"))
                                    <span class="text-warning">{{ $validate->first("address") }}</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>{{trans('backend::publisher/text.city')}} <span>*</span></td>
                            <td>
                                <div class="form-group">                                    
                                    <input type="text" class="form-control" id="city" value="{{{ $item->city }}}" name="city" placeholder="">              
                                    @if(isset($validate) && $validate->has("city"))
                                    <span class="text-warning">{{ $validate->first("city") }}</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>{{trans('backend::publisher/text.state')}} <span>*</span></td>
                            <td>
                                <div class="form-group">                                    
                                    <input type="text" class="form-control" id="state" value="{{{ $item->state or Input::get('state') }}}" name="state" placeholder="">              
                                    @if(isset($validate) && $validate->has("state"))
                                    <span class="text-warning">{{ $validate->first("state") }}</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>{{trans('backend::publisher/text.postcode')}} <span>*</span></td>
                            <td>
                                <div class="form-group">                                    
                                    <input type="text" class="form-control" id="postcode" value="{{{ $item->postcode }}}" name="postcode" placeholder="">              
                                    @if(isset($validate) && $validate->has("postcode"))
                                    <span class="text-warning">{{ $validate->first("postcode") }}</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>{{trans('backend::publisher/text.phone')}}</td>
                            <td>
                                <div class="form-group">                                    
                                    <input type="text" class="form-control" id="phone" value="{{{ $item->phone }}}" name="phone" placeholder="">              
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>{{trans('backend::publisher/text.fax')}}</td>
                            <td>
                                <div class="form-group">                                    
                                    <input type="text" class="form-control" id="fax" value="{{{ $item->fax }}}" name="fax" placeholder="">              
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>          
        </div>
        
    </div>
</div>

<div class="row margin-button-view">
    <div class="col-sm-12">
        
        <div class="row">
            <div class="col-sm-6">
                <h3 class="title-view-publisher text-uppercase">{{trans('backend::publisher/text.approver_site')}}</h3>
                <table class="table table-edit-publisher">
                    <tbody>
                        <tr>
                            <td>{{trans('backend::publisher/text.site_channel')}} <span>*</span></td>
                            <td>
                                <div class="form-group">                                    
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <select multiple="multiple"  data-title="site-channel" data-name="site-channel[]" id="site-channel" class="form-control">
                                            <?php $selected =''; ?>
                                            @foreach($itemCate as $itemC)
                                                @foreach($itemSiteChannel as $itemSiteC)
                                                    @if($itemSiteC->channel_id == $itemC->id)
                                                        <?php $selected ='selected';break; ?>
                                                    @else
                                                        <?php $selected =''; ?>
                                                    @endif
                                                @endforeach
                                                <option {{$selected}} value="{{$itemC->id}},{{$itemC->name}}">{{ $itemC->name }}</option>                            
                                            @endforeach
                                            </select>
                                                                                      
                                        </div>
                                        <div class="col-sm-12">
                                            @if(isset($validate) && $validate->has("site-channel"))
                                                <span class="text-warning">{{ $validate->first("site-channel") }}</span>
                                            @endif 
                                        </div>
                                    </div>
                                    
                                </div>
                            </td>
                        </tr>
                        <tr>
                              <td>{{trans('backend::publisher/text.primary_channel')}}</td>
                              <td>
                                  <button type="button" id="set-as-primary">{{trans('backend::publisher/text.set_as_primary')}}</button>
                              </td>
                        </tr>
                        <tr>
                            <td>{{trans('backend::publisher/text.serve_country')}} <span>*</span></td>
                            <td>
                                <div class="form-group">                                    
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <select multiple="multiple" data-title="serve-country" data-name="serve-country[]" id="server-country" class="form-control">
                                            <?php $selected =''; ?>
                                            @foreach($itemCountry as $itemC)
                                                @foreach($itemServeCountry as $itemSiteL)
                                                    @if($itemSiteL->country_name == $itemC->country_name)
                                                        <?php $selected ='selected';break; ?>
                                                    @else
                                                        <?php $selected =''; ?>
                                                    @endif
                                                @endforeach
                                                <option {{$selected}} value="{{$itemC->id}},{{$itemC->country_name}}">{{ $itemC->country_name }}</option>                            
                                            @endforeach
                                            </select>  
                                                                                    
                                        </div>
                                        <div class="col-sm-12">
                                            @if(isset($validate) && $validate->has("serve-country"))
                                                <span class="text-warning">{{ $validate->first("serve-country") }}</span>
                                            @endif 
                                        </div>
                                    </div>
                                    
                                </div>
                            </td>
                        </tr>                       
                    </tbody>
                </table>        
            </div>
            <div class="col-sm-6">
                <h3 class="title-view-publisher text-uppercase">{{trans('backend::publisher/text.approver_publisher')}}</h3>
                <table class="table table-edit-publisher">
                    <tbody>
                        <tr>
                            <td style="text-align: left;">
                                <input type="radio" name="checkflaguser" {{{ (Input::get('checkflaguser')==1) ? "checked" : "checked"}}} class="flag-exist-suser" value="1"> {{trans('backend::publisher/text.existing_publisher')}} <br>
                                <input type="radio" name="checkflaguser" {{{ (Input::get('checkflaguser')==3) ? "checked" : ""}}} class="flag-exist-suser" value="3"> {{trans('backend::publisher/text.new_publisher')}}
                            </td>
                            <td></td>                            
                        </tr>                        
                        <tr>
                            <td id="show-register-user" colspan="2" style="text-align: left;">
                                <div class="form-group">
                                    <label>{{trans('backend::publisher/text.username')}} <span>*</span></label>
                                    <input type="text" class="form-control" value="{{{Input::get('username')}}}" name="username" placeholder="{{trans('backend::publisher/text.username')}}" />

                                    @if(isset($msgUserName) && isset($msgUserName["username"]))
                                    <p class="text-warning">{{{ $msgUserName["username"] or $message }}}</p>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label>{{trans('backend::publisher/text.password')}} <span>*</span></label>
                                    <input type="text" id="password" class="form-control" value="{{{Input::get('password')}}}" name="password" placeholder="{{trans('backend::publisher/text.password')}}" />
                                    @if(isset($msg) && isset($msg["pass"]))
                                    <p class="text-warning">{{ $msg["pass"] }}</p>
                                    @endif
                                </div>
                                <div class="form-group">                                
                                    <button type="button" id="btn-ganerate-pass" class="btn btn-primary">{{trans('backend::publisher/text.auto_ganerate')}}</button>
                                </div>
                                  
                                <div class="form-group">
                                    <label for="remark">{{trans('backend::publisher/text.remark')}}</label>
                                    <textarea name="remark" class="form-control">{{{Input::get('remark')}}}</textarea>
                                </div>
                            </td>                            
                        </tr>                       
                    </tbody>
                </table> 
            </div>          
        </div>
        
    </div>
</div>


<div class="row margin-button-view">
    <div class="col-sm-12">
        
        <div class="row">
            <div class="col-sm-6">
                <h3 class="title-view-publisher text-uppercase">{{trans('backend::publisher/text.billing_setting')}}</h3>
                <table class="table table-edit-publisher">
                    <tbody>
                        <tr>
                            <td>{{trans('backend::publisher/text.company_name')}} <span>*</span></td>
                            <td>
                                <div class="form-group">                                    
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="row">
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="company-name-e" id="company-name-e" value="{{{ $itemR['company_name'] or $item->site_name }}}" />        
                                                    @if(isset($validate) && $validate->has("company-name"))
                                                    <span class="text-warning">{{ $validate->first("company-name") }}</span>
                                                    @endif 
                                                </div>    
                                                <div class="col-sm-3">
                                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-site">{{trans('backend::publisher/text.manage_site')}}</button>
                                                    <div class="modal fade" id="modal-site" role="dialog" aria-hidden="true" tabindex="-1" aria-labelledby="myModalLabel">
                                                        <div class="modal-dialog modal-sm">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <button type="button" class="close" data-dismiss="modal">
                                                                        <span aria-hidden="true">&times;</span>
                                                                        <span class="sr-only">Close</span>
                                                                    </button>
                                                                    <h4 class="modal-title">{{trans('backend::publisher/text.manage_site')}}</h4>
                                                                </div>
                                                                <div class="modal-body" id="radio-manage-site">
                                                                     <div class="show-site-name">
                                                                        @if(count($itemSiteName) > 0)
                                                                            @foreach($itemSiteName as $value)
                                                                            <div class="input-group">
                                                                              <span class="input-group-addon">
                                                                                <input type="radio" onclick="chooseSite($(this))" name="company-name">
                                                                              </span>
                                                                              <input type="text" class="form-control" id="site-name-s" name="site-name-s[]" value="{{$value->name}}">
                                                                            </div>
                                                                            @endforeach
                                                                        @else
                                                                            <div class="input-group">
                                                                              <span class="input-group-addon">
                                                                                <input type="radio" onclick="chooseSite($(this))" name="company-name">
                                                                              </span>
                                                                              <input type="text" class="form-control" id="site-name-s" name="site-name-s[]" value="{{{$item->site_name}}}">
                                                                            </div>
                                                                        @endif
                                                                    </div>
                                                                    <button type="button" class="btn btn-primary btn-add-site"><span class="glyphicon glyphicon-plus-sign"></span> {{trans('backend::publisher/text.add_site')}}</button>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" data-dismiss="modal" class="btn btn-primary">{{trans('backend::publisher/text.done')}}</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>{{trans('backend::publisher/text.contact_list')}}</td>
                            <td>
                                <a href="javascript:;" data-toggle="modal" data-target="#mymodal"><i class="fa fa-plus-square"></i> {{trans('backend::publisher/text.more')}}</a>
                               
                                <div class="modal fade" id="mymodal" role="dialog" aria-hidden="true" tabindex="-1" aria-labelledby="myModalLabel">
                                    <div class="modal-dialog modal-sm">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">
                                                    <span aria-hidden="true">&times;</span>
                                                    <span class="sr-only">Close</span>
                                                </button>
                                                <h4 class="modal-title">{{trans('backend::publisher/text.contact_list')}}</h4>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label>{{trans('backend::publisher/text.name')}}</label>
                                                    <input type="text" class="form-control" name="name_contact" value="{{{ $itemR['name_contact'] or Input::get('name_contact') }}}">
                                                </div>
                                                <div class="form-group">
                                                    <label>{{trans('backend::publisher/text.email')}}</label>
                                                    <input type="text" class="form-control" name="email_contact" value="{{{ $itemR['email_contact'] or Input::get('email_contact') }}}">
                                                </div>
                                                <div class="form-group">
                                                    <label>{{trans('backend::publisher/text.phone')}}</label>
                                                    <input type="text" class="form-control" name="phone_contact" value="{{{ $itemR['phone_contact'] or Input::get('phone_contact') }}}">
                                                </div>
                                                <div class="form-group">
                                                    <label>{{trans('backend::publisher/text.address')}}</label>
                                                    <input type="text" class="form-control" name="address_contact" value="{{{ $itemR['address_contact'] or Input::get('address_contact') }}}">
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" data-dismiss="modal" class="btn btn-primary">{{trans('backend::publisher/text.done')}}</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                               
                            </td>
                        </tr>
                        <tr>
                            <td>{{trans('backend::publisher/text.tax')}} <span>*</span></td>
                            <td>
                                <div class="form-group">                                    
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control input-e" name="tax" id="tax" value="{{{ $itemR['tax'] or Input::get('tax') }}}" /> %
                                            @if(isset($validate) && $validate->has("tax"))
                                            <span class="text-warning">{{ $validate->first("tax") }}</span>
                                            @endif                                          
                                        </div>
                                    </div>
                                    
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>{{trans('backend::publisher/text.management_free')}} <span>*</span></td>
                            <td>
                                <div class="form-group">                                    
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control input-e" name="management-free" id="management-free" value="{{{$itemR['management_free'] or Input::get('management-free')}}}" /> %
                                            @if(isset($validate) && $validate->has("management-free"))
                                            <span class="text-warning">{{ $validate->first("management-free") }}</span>
                                            @endif                                          
                                        </div>
                                    </div>
                                    
                                </div>
                            </td>
                        </tr> 
                        <tr>
                            <td>{{trans('backend::publisher/text.split_billing')}} <span>*</span></td>
                            <td>
                                <div class="form-group">                                    
                                    <div class="row">
                                        <div class="col-sm-12">
                                           <input type="radio" {{{ ($itemR['split_billing']==1) ? "checked" : "checked" }}} name="split-billing" value="1" /> {{trans('backend::publisher/text.yes')}}                                        
                                           <input type="radio" {{{ ($itemR['split_billing']==0) ? "checked" : "" }}} name="split-billing" value="0" /> {{trans('backend::publisher/text.no')}} <br>
                                            @if(isset($validate) && $validate->has("split-billing"))
                                            <span class="text-warning">{{ $validate->first("split-billing") }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    
                                </div>
                            </td>
                        </tr> 
                        <tr>
                            <td>{{trans('backend::publisher/text.revenue_sharing')}} <span>*</span></td>
                            <td>
                                 <div class="form-group">
                                    <input type="radio" {{{ ($itemR['revenue_sharing']==40) ? "checked" : "checked" }}} name="revenue-sharing" class="revenue-sharing-orther" value="40"> 40%
                                    <input type="radio" {{{ ($itemR['revenue_sharing']==50) ? "checked" : "" }}} name="revenue-sharing" class="revenue-sharing-orther" value="50"> 50%
                                    <input type="radio" {{{ ($itemR['revenue_sharing']==60) ? "checked" : "" }}} name="revenue-sharing" class="revenue-sharing-orther" value="60"> 60%
                                    <input type="radio" {{{ ($itemR['revenue_sharing']!=-1 && $itemR['revenue_sharing']!=40 && $itemR['revenue_sharing']!=50 && $itemR['revenue_sharing']!=60) ? "checked" : "" }}} name="revenue-sharing" class="revenue-sharing-orther" value="-1"> {{trans('backend::publisher/text.orther')}}
                                    <input type="text" class="{{{ ($itemR['revenue_sharing']!=-1 && $itemR['revenue_sharing']!=40 && $itemR['revenue_sharing']!=50 && $itemR['revenue_sharing']!=60) ? "show" : "hidden" }}} form-control" value="{{{$itemR['revenue_sharing']}}}" name="revenue-other" max="2" id="revenue-other" />
                                    @if(isset($msgRevenueSharing) && isset($msgRevenueSharing['revenue']))
                                    <p class="text-warning">{{ $msgRevenueSharing['revenue'] }}</p>
                                    @endif
                                </div>
                            </td>
                        </tr>                        
                    </tbody>
                </table>        
            </div>
            <div class="col-sm-6">
                <h3 class="title-view-publisher text-uppercase">{{trans('backend::publisher/text.smart_publisher_setting')}}</h3>
                <table class="table table-edit-publisher">
                    <tbody>
                        <tr>
                            <td>{{trans('backend::publisher/text.primium_publisher')}} <span>*</span></td>
                            <td>
                                <div class="form-group">                                    
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <input type="radio" {{{ ($itemR['primium_publisher']==1) ? "checked" : "checked" }}} name="primium-publisher" value="1" /> {{trans('backend::publisher/text.yes')}}                                        
                                            <input type="radio" {{{ ($itemR['primium_publisher']==0) ? "checked" : "" }}} name="primium-publisher" value="0" /> {{trans('backend::publisher/text.no')}} <br>
                                            @if(isset($validate) && $validate->has("primium-publisher"))
                                            <span class="text-warning">{{ $validate->first("primium-publisher") }}</span>
                                            @endif                                         
                                        </div>
                                    </div>
                                    
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>{{trans('backend::publisher/text.domain_checking')}} <span>*</span></td>
                            <td>
                                <input type="radio" {{{ ($itemR['domain_checking']==1) ? "checked" : "checked" }}} name="domain-checking" value="1" /> {{trans('backend::publisher/text.yes')}}                                        
                                <input type="radio" {{{ ($itemR['domain_checking']==0) ? "checked" : "" }}} name="domain-checking" value="0" /> {{trans('backend::publisher/text.no')}} <br>
                                @if(isset($validate) && $validate->has("domain-checking"))
                                <span class="text-warning">{{ $validate->first("domain-checking") }}</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>{{trans('backend::publisher/text.VAST_tag')}} <span>*</span></td>
                            <td>
                                <div class="form-group">                                    
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <input type="radio" {{{ ($itemR['vast_tag']==1) ? "checked" : "checked" }}} name="vast-tag" value="1" /> {{trans('backend::publisher/text.yes')}}                                        
                                            <input type="radio" {{{ ($itemR['vast_tag']==0) ? "checked" : "" }}} name="vast-tag" value="0" /> {{trans('backend::publisher/text.no')}} <br>
                                             @if(isset($validate) && $validate->has("vast-tag"))
                                            <span class="text-warning">{{ $validate->first("vast-tag") }}</span>
                                            @endif                                         
                                        </div>
                                    </div>
                                    
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>{{trans('backend::publisher/text.network_publisher')}} <span>*</span></td>
                            <td>
                                <div class="form-group">                                    
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <input type="radio" {{{ ($itemR['network_publisher']==1) ? "checked" : "checked" }}} name="network-publisher" value="1" /> {{trans('backend::publisher/text.yes')}}                                        
                                            <input type="radio" {{{ ($itemR['network_publisher']==0) ? "checked" : "" }}} name="network-publisher" value="0" /> {{trans('backend::publisher/text.no')}} <br>
                                             @if(isset($validate) && $validate->has("network-publisher"))
                                            <span class="text-warning">{{ $validate->first("network-publisher") }}</span>
                                            @endif                                        
                                        </div>
                                    </div>
                                    
                                </div>
                            </td>
                        </tr> 
                        <tr>
                            <td>{{trans('backend::publisher/text.mobile_ad')}} <span>*</span></td>
                            <td>
                                <div class="form-group">                                    
                                    <div class="row">
                                        <div class="col-sm-12">
                                           <input type="radio" {{{ ($itemR['mobile_ad']==1) ? "checked" : "checked" }}} name="mobile-ad" value="1" /> {{trans('backend::publisher/text.yes')}}                                        
                                           <input type="radio" {{{ ($itemR['mobile_ad']==0) ? "checked" : "" }}} name="mobile-ad" value="0" /> {{trans('backend::publisher/text.no')}} <br>
                                           @if(isset($validate) && $validate->has("mobile-ad"))
                                            <span class="text-warning">{{ $validate->first("mobile-ad") }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    
                                </div>
                            </td>
                        </tr>                                             
                    </tbody>
                </table> 
            </div>          
        </div>
        
    </div>
</div>

<div class="row margin-button-view">
    <div class="col-sm-12">
        
        <div class="row">
            <div class="col-sm-6">
                <h3 class="title-view-publisher text-uppercase">{{trans('backend::publisher/text.orther_infomation')}}</h3>
                <table class="table table-edit-publisher">
                    <tbody>
                       <tr>
                            <td>{{trans('backend::publisher/text.access_to_all_channels')}} <span>*</span></td>
                            <td>
                                <div class="form-group">                                    
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <input type="radio" {{{ ($itemR['access_to_all_channels']==1) ? "checked" : "checked" }}} name="access-to-all-channels" value="1" /> {{trans('backend::publisher/text.yes')}}                                        
                                            <input type="radio" {{{ ($itemR['access_to_all_channels']==0) ? "checked" : "" }}} name="access-to-all-channels" value="0" /> {{trans('backend::publisher/text.no')}} <br>
                                             @if(isset($validate) && $validate->has("access-to-all-channels"))
                                            <span class="text-warning">{{ $validate->first("access-to-all-channels") }}</span>
                                            @endif                                        
                                        </div>
                                    </div>
                                    
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>{{trans('backend::publisher/text.newsletter')}} <span>*</span></td>
                            <td>
                                <div class="form-group">                                    
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <input type="radio" {{{ ($itemR['newsletter']==1) ? "checked" : "checked" }}} name="newsletter" value="1" /> {{trans('backend::publisher/text.yes')}}                                        
                                            <input type="radio" {{{ ($itemR['newsletter']==0) ? "checked" : "" }}} name="newsletter" value="0" /> {{trans('backend::publisher/text.no')}} <br>
                                             @if(isset($validate) && $validate->has("newsletter"))
                                            <span class="text-warning">{{ $validate->first("newsletter") }}</span>
                                            @endif                                        
                                        </div>
                                    </div>
                                    
                                </div>
                            </td>
                        </tr> 
                        <tr>
                            <td>{{trans('backend::publisher/text.enable_report_by_model')}} <span>*</span></td>
                            <td>
                                <div class="form-group">                                    
                                    <div class="row">
                                        <div class="col-sm-12">
                                           <input type="radio" {{{ ($itemR['enable_report_by_model']==1) ? "checked" : "checked" }}} name="enable-report-by-model" value="1" /> {{trans('backend::publisher/text.yes')}}                                        
                                           <input type="radio" {{{ ($itemR['enable_report_by_model']==0) ? "checked" : "" }}} name="enable-report-by-model" value="0" /> {{trans('backend::publisher/text.no')}} <br>
                                           @if(isset($validate) && $validate->has("enable-report-by-model"))
                                            <span class="text-warning">{{ $validate->first("enable-report-by-model") }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    
                                </div>
                            </td>
                        </tr>                       
                    </tbody>
                </table>        
            </div>
                     
        </div>
        
    </div>
</div>

<div class="row navbar-fixed-bottom">
    <div class="container">
        <div class="col-sm-12 padding-none">
            <div class="row fixed-disapprove">
                <div class="col-sm-12 col-md-5 padding-none p-fixed-disapprove">
                    <p>{{trans('backend::publisher/text.publisher_status')}}: <strong>{{$item->StatusText}}</strong> ( {{trans('backend::publisher/text.last_update')}}: <b>{{formatDate($item->updated_at,'d-M-Y g:i A')}}</b> )</p>
                </div>
                <div class="col-sm-12 col-md-7 padding-none">
                   <!--  <button type="button" class="btn btn-primary pull-right">{{trans('backend::publisher/text.view_history')}}</button> -->
                    <a href="{{URL::Route('ApprovePublisherManagerShowList')}}" class="btn btn-primary pull-right">{{trans('backend::publisher/text.back')}}</a>                 
                    <button type="button" onclick="return moveStatus(2);" class="btn btn-primary pull-right">{{trans('backend::publisher/text.disapproved')}}</button>
                    <button type="button" onclick="return moveStatus(3);" class="btn btn-primary pull-right">{{trans('backend::publisher/text.approved')}}</button>
                    <button type="submit" class="btn btn-primary pull-right">{{trans('backend::publisher/text.save')}}</button>
                </div>
            </div>              
        </div>
    </div>  
</div>
{{Form::close()}}