
{{ HTML::style("{$assetURL}css/multi-select.css") }}
{{ HTML::script("{$assetURL}js/jquery.multi-select.js") }}
<script type="text/javascript">
    $(function(){        
        var val_check = {{{ Input::has('checkflaguser') ? Input::get('checkflaguser') : 0 }}};
        if(val_check == '2') $("#show-register-user").show();
        else $("#show-register-user").hide();                                

        $(".flag-exist-suser").click(function(event) {            
            var vl = $(this).val();
            if(vl=="1"){
                $("#show-register-user").hide();                
            }else{
                $("#show-register-user").show();            
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

        $('#manage-country').multiSelect(); 
        $('#server-country').multiSelect();             
        $('#site-channel').multiSelect();
    });

    function genarateRandom(len)
    {
        var text = "";
        var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

        for( var i=0; i < len; i++ )
            text += possible.charAt(Math.floor(Math.random() * possible.length));

        return text;
    }

    function moveStatus(status){
        var flag=false;
        if(flag == false){
            $.post("{{URL::Route('ApprovePublisherManagerMoveStatus')}}",{
                id : {{$item->id}},
                status : status,
                _token :"{{csrf_token()}}"                  
            },function(data){
                if(data){
                    if(status==1){
                        flag=true;
                        alert('Move to archive success');
                    }else if(status==3){
                        flag=true;
                        alert('Move to approve success');
                    }else if(status==2){
                        flag=true;
                        alert('Move to disapprove success');
                    }
                    
                }                   
            });
        }
    }
</script>
{{Form::open(['method'=>'post','role'=>'form'])}}
<div class="row">
    <div class="col-sm-12">
        <div class="row">
        <div class="col-sm-12">
            <h3 class="title-view-publisher text-uppercase pull-left">site information :</h3>           
            <div class="pull-right">               
                <button type="button" onclick="return moveStatus(1);" class="btn btn-primary btn-move-archive"><span class="glyphicon glyphicon-share-alt"></span> Move To Archive</button>             
                <input type="hidden" name="_token" value="{{csrf_token()}}" placeholder="">
            </div>
            <div class="clearfix"></div>
             @if(Session::has('message'))
            <div class="col-sm-12">        
                <div role="alert" class="alert alert-success fade in">
                  <button data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>         
                  <p class="text-success">{{Session::get('message')}}</p>
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
                            <td>Site name <span>*</span></td>
                            <td>
                                <div class="form-group">                                    
                                    <input type="text" class="form-control" id="site-name" value="{{{ $item->site_name }}}" name="site-name" placeholder="Site name">              
                                    @if(isset($validate) && $validate->has("site-name"))
                                    <span class="text-warning">{{ $validate->first("site-name") }}</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Site URL <span>*</span></td>
                            <td>
                                <div class="form-group">                                    
                                    <input type="text" class="form-control" id="site-url" value="{{{ $item->site_url }}}" name="site-url" placeholder="Site URL">              
                                    @if(isset($validate) && $validate->has("site-url"))
                                    <span class="text-warning">{{ $validate->first("site-url") }}</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Site Description <span>*</span></td>
                            <td>
                                <div class="form-group">                                    
                                    <textarea name="site-description" class="form-control" id="site-description" cols="30" rows="4">{{$item->site_description}}</textarea>
                                    @if(isset($validate) && $validate->has("site-description"))
                                    <span class="text-warning">{{ $validate->first("site-description") }}</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Site Category <span>*</span></td>
                            <td>
                                <div class="form-group">                                    
                                    <select class="form-control" name="site-category" id="site-category">
                                       @foreach($itemCate as $itemCate)
                                       <option @if($itemCate->name=$item->category) selected @endif value="{{$itemCate->name}}">{{$itemCate->name}}</option>
                                       @endforeach
                                    </select>
                                    @if(isset($validate) && $validate->has("site-category"))
                                    <span class="text-warning">{{ $validate->first("site-category") }}</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Site Language</td>
                            <td>
                                <div class="form-group">                                    
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <select multiple='multiple' size="10" name="site-language[]" id="manage-country" class="form-control">
                                            <?php $selected =''; ?>
                                            @foreach($itemLanguage as $itemC)
                                                @foreach($itemSiteLang as $itemSiteL)
                                                    @if($itemSiteL->name_country == $itemC->name)
                                                        <?php $selected ='selected';break; ?>
                                                    @else
                                                        <?php $selected =''; ?>
                                                    @endif
                                                @endforeach
                                                
                                                <option {{$selected}} value="elem_{{$itemC->name}}">{{ $itemC->name }}</option>                                                
                                            @endforeach
                                            </select>                                            
                                        </div>
                                        
                                    </div>
                                    
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Other Language</td>
                            <td>
                                <div class="form-group">                                    
                                    <input type="text" class="form-control" id="orther-lang" value="{{{ $item->orther_lang }}}" name="orther-lang" placeholder="">              
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
                            <td>Date Registered</td>
                            <td>{{isset($item->created_at) ? formatDate($item->created_at) : "N\A" }}</td>
                        </tr>
                        <tr>
                            <td>Monthly Unique Visitor <span>*</span></td>
                            <td>
                                <div class="form-group">                                    
                                    <input type="text" class="form-control" id="unique-visitor" value="{{{ $item->unique_visitor }}}" name="unique-visitor" placeholder="">              
                                    @if(isset($validate) && $validate->has("unique-visitor"))
                                    <span class="text-warning">{{ $validate->first("unique-visitor") }}</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Monthly Page View <span>*</span></td>
                            <td>
                                <div class="form-group">                                    
                                    <input type="text" class="form-control" id="page-view" value="{{{ $item->pageview }}}" name="page-view" placeholder="">              
                                    @if(isset($validate) && $validate->has("page-view"))
                                    <span class="text-warning">{{ $validate->first("page-view") }}</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Daily Unique Visitor <span>*</span></td>
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
                            <td></td>
                            <td><button class="btn btn-primary"><span class="glyphicon glyphicon-search"></span> View Traffic Report</button></td>
                        </tr>
                    </tbody>
                </table>
            </div>          
        </div>
        
    </div>
</div>


<div class="row">
    <div class="col-sm-12">
        <h3 class="title-view-publisher text-uppercase">Account information :</h3>
        <div class="row">
            <div class="col-sm-6">
                <table class="table table-edit-publisher">
                    <tbody>                       
                        <tr>
                            <td>PaymentPayable To <span>*</span></td>
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
                            <td>Company <span>*</span></td>
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
                            <td>Email Address <span>*</span></td>
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
                            <td>Title <span>*</span></td>
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
                            <td>First Name <span>*</span></td>
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
                            <td>Last Name <span>*</span></td>
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
                            <td>Country</td>
                            <td>
                                <div class="form-group">                                    
                                    <select class="form-control" name="country">
                                        <option value="">Choose...</option>
                                        @foreach($itemCountry as $itemC)                                            
                                            <option {{{($itemC->country_name==$item->country) ? "selected" : ( (Input::get('country')==$itemC->country_name) ? "selected" : "") }}} value="{{$itemC->country_name}}">{{ $itemC->country_name }}</option>                            
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
                            <td>Address <span>*</span></td>
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
                            <td>City <span>*</span></td>
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
                            <td>State <span>*</span></td>
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
                            <td>PostCode <span>*</span></td>
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
                            <td>Phone</td>
                            <td>
                                <div class="form-group">                                    
                                    <input type="text" class="form-control" id="phone" value="{{{ $item->phone }}}" name="phone" placeholder="">              
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Fax</td>
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
                <h3 class="title-view-publisher text-uppercase">approver : site</h3>
                <table class="table table-edit-publisher">
                    <tbody>
                        <tr>
                            <td>Site Channel <span>*</span></td>
                            <td>
                                <div class="form-group">                                    
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <select multiple='multiple' size="10" name="site-channel[]" id="site-channel" class="form-control">
                                            <?php $selected =''; ?>
                                            @foreach($itemChannel as $itemChannel)
                                                @foreach($itemSiteChannel as $itemSiteC)
                                                    @if($itemSiteC->name_channel == $itemChannel->name)
                                                        <?php $selected ='selected';break; ?>
                                                    @else
                                                        <?php $selected =''; ?>
                                                    @endif
                                                @endforeach
                                                <option {{$selected}} value="elem_{{$itemChannel->name}}">{{ $itemChannel->name }}</option>                            
                                            @endforeach
                                            </select>
                                            @if(isset($validate) && $validate->has("site-channel"))
                                            <span class="text-warning">{{ $validate->first("site-channel") }}</span>
                                            @endif                                            
                                        </div>
                                    </div>
                                    
                                </div>
                            </td>
                        </tr>
                       <!--  <tr>
                           <td>Primary Channel <span>*</span></td>
                           <td>
                               <button type="button">Set As Primary</button>
                               @if(isset($validate) && $validate->has("site-name"))
                               <span class="text-warning">{{ $validate->first("site-name") }}</span>
                               @endif
                           </td>
                       </tr> -->
                        <tr>
                            <td>Serve Country <span>*</span></td>
                            <td>
                                <div class="form-group">                                    
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <select multiple='multiple' size="10" name="serve-country[]" id="server-country" class="form-control">
                                            <?php $selected =''; ?>
                                            @foreach($itemCountry as $itemC)
                                                @foreach($itemSiteLang as $itemSiteL)
                                                    @if($itemSiteL->name_country == $itemC->country_name)
                                                        <?php $selected ='selected';break; ?>
                                                    @else
                                                        <?php $selected =''; ?>
                                                    @endif
                                                @endforeach
                                                <option {{$selected}} value="elem_{{$itemC->country_name}}">{{ $itemC->country_name }}</option>                            
                                            @endforeach
                                            </select>  
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
                <h3 class="title-view-publisher text-uppercase">approver : publisher</h3>
                <table class="table table-edit-publisher">
                    <tbody>
                        <tr>
                            <td style="text-align: left;">
                                <input type="radio" name="checkflaguser" {{{ (Input::get('checkflaguser')==1) ? "checked" : "checked"}}} class="flag-exist-suser" value="1"> Existing publisher <br>
                                <input type="radio" name="checkflaguser" {{{ (Input::get('checkflaguser')==2) ? "checked" : ""}}} class="flag-exist-suser" value="2"> New publisher
                            </td>
                            <td></td>                            
                        </tr>                        
                        <tr>
                            <td id="show-register-user" colspan="2" style="text-align: left;">
                                <div class="form-group">
                                    <label>Username <span>*</span></label>
                                    <input type="text" class="form-control" value="{{{Input::get('username')}}}" name="username" placeholder="Username" />

                                    @if(isset($msgUserName) && isset($msgUserName["username"]))
                                    <p class="text-warning">{{{ $msgUserName["username"] or $message }}}</p>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label>Password <span>*</span></label>
                                    <input type="text" id="password" class="form-control" value="{{{Input::get('password')}}}" name="password" placeholder="Password" />
                                    @if(isset($msg) && isset($msg["pass"]))
                                    <p class="text-warning">{{ $msg["pass"] }}</p>
                                    @endif
                                </div>
                                <div class="form-group">                                
                                    <button type="button" id="btn-ganerate-pass" class="btn btn-primary">Auto Ganerate</button>
                                </div>
                                <div class="form-group">
                                    <label for="revenue sharing">Revenue Sharing <span>*</span></label>
                                    <div class="clearfix"></div>
                                    <input type="radio" {{{ (Input::get('revenue-sharing')==40) ? "checked" : "checked" }}} name="revenue-sharing" class="revenue-sharing-orther" value="40"> 40%
                                    <input type="radio" {{{ (Input::get('revenue-sharing')==50) ? "checked" : "" }}} name="revenue-sharing" class="revenue-sharing-orther" value="50"> 50%
                                    <input type="radio" {{{ (Input::get('revenue-sharing')==60) ? "checked" : "" }}} name="revenue-sharing" class="revenue-sharing-orther" value="60"> 60%
                                    <input type="radio" {{{ (Input::get('revenue-sharing')==-1) ? "checked" : "" }}} name="revenue-sharing" class="revenue-sharing-orther" value="-1"> orther
                                    <input type="text" class="{{{ (Input::get('revenue-sharing')==-1) ? "show" : "hidden" }}} form-control" value="{{{Input::get('revenue-other')}}}" name="revenue-other" max="2" id="revenue-other" />
                                    @if(isset($msgRevenueSharing) && isset($msgRevenueSharing['revenue']))
                                    <p class="text-warning">{{ $msgRevenueSharing['revenue'] }}</p>
                                    @endif
                                </div>   
                                <div class="form-group">
                                    <label for="remark">Remark</label>
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


<div class="row navbar-fixed-bottom">
    <div class="container">
        <div class="col-sm-12 padding-none">
            <div class="row fixed-disapprove">
                <div class="col-sm-12 col-md-7 padding-none p-fixed-disapprove">
                    <p>Publisher Status: <strong>{{$item->StatusText}}</strong> ( Last Update: <b>{{formatDate($item->updated_at,'d-M-Y g:i A')}}</b> )</p>
                </div>
                <div class="col-sm-12 col-md-5 padding-none">
                    <button type="button" class="btn btn-primary pull-right">View History</button>
                    <a href="{{URL::Route('ApprovePublisherManagerShowList')}}" class="btn btn-primary pull-right">Back</a>                 
                    <button type="button" onclick="return moveStatus(2);" class="btn btn-primary pull-right">Disapprove</button>
                    <button type="button" onclick="return moveStatus(3);" class="btn btn-primary pull-right">Approve</button>
                    <button type="submit" class="btn btn-primary pull-right">Save</button>
                </div>
            </div>              
        </div>
    </div>  
</div>
{{Form::close()}}