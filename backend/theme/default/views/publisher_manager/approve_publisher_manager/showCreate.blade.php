@include("partials.show_messages") 
{{ HTML::script("{$assetURL}js/dual-list-box.js") }}
{{Form::open(['method'=>'post','role'=>'form','enctype'=>'multipart/form-data'])}}

<div class="row">
    <div class="col-sm-12">
        <div class="row">
        <div class="col-sm-12">
            <h3 class="title-view-publisher text-uppercase pull-left">{{trans('backend::publisher/text.site_information')}} :</h3>           
        </div>
        </div>      
        <div class="row">
            <div class="col-sm-6">
                <table class="table table-edit-publisher">
                    <tbody>
                        <!-- SITE NAME -->
                        <tr>
                            <td>{{trans('backend::publisher/text.site_name')}} <span>*</span></td>
                            <td>
                                <div class="form-group">                                    
                                    <input type="text" class="form-control" id="site-name" value="{{{  $item->site_name or Input::get('site-name') }}}" name="site-name" placeholder="{{trans('backend::publisher/text.site_name')}}">              
                                </div>
                            </td>
                        </tr>
                        <!-- SITE URL -->
                        <tr>
                            <td>{{trans('backend::publisher/text.site_URL')}} <span>*</span></td>
                            <td>
                                <div class="form-group">                                    
                                    <input type="text" class="form-control" id="site-url" value="{{{ $item->site_url or Input::get('site-url') }}}" name="site-url" placeholder="{{trans('backend::publisher/text.site_URL')}}">              
                                </div>
                            </td>
                        </tr>
                        <!-- SITE DESCRIPTION -->
                        <tr>
                            <td>{{trans('backend::publisher/text.site_description')}}</td>
                            <td>
                                <div class="form-group">                                    
                                    <textarea name="site-description" class="form-control" id="site-description" cols="30" rows="4">{{{ $item->site_description or Input::get('site-description') }}}</textarea>
                                </div>
                            </td>
                        </tr>
                        <!-- SITE LANGUAGE -->
                        <tr>
                            <td>{{trans('backend::publisher/text.site_language')}}</td>
                            <td>
                                <div class="form-group">                                    
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <?php $listSelected =  ( isset( $languageSelected ) ) ? $languageSelected :  Input::get('selected_site-language', array()); ?>                                            
                                            <select multiple="multiple" data-title="site-language" data-value="index" data-text="name" size="10" data-name="site-language[]" id="manage-country" class="form-control">
                                                @foreach($languageLists as $language)
                                                    <?php
                                                        $selected =''; 
                                                        if( in_array($language->id, $listSelected) ){
                                                            $selected ='selected';
                                                        }
                                                    ?>
                                                    <option {{$selected}}  value="{{$language->id}}">{{ $language->name }}</option>                                                
                                                @endforeach
                                            </select>                                            
                                        </div>
                                        
                                    </div>
                                    
                                </div>
                            </td>
                        </tr>
                        <!-- OTHER LANGUAGE -->
                        <tr>
                            <td>{{trans('backend::publisher/text.other_language')}}</td>
                            <td>
                                <div class="form-group">                                    
                                    <input type="text" class="form-control" id="orther-lang" value="{{{ $item->other_lang or Input::get('orther-lang') }}}" name="orther-lang" placeholder="">              
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>        
            </div>
            <div class="col-sm-6">
                <table class="table table-edit-publisher">
                    <tbody>
                        <!-- MONTHLY UNIQUE VISITOR -->
                        <tr>
                            <td>{{trans('backend::publisher/text.monthly_unique_visitor')}} <span>*</span></td>
                            <td>
                                <div class="form-group">                                    
                                    <input type="text" class="form-control" id="unique-visitor" value="{{{  $item->unique_visitor or Input::get('unique-visitor') }}}" name="unique-visitor" placeholder="">              
                                </div>
                            </td>
                        </tr>
                        <!-- MONTHLY PAGE VIEW -->
                        <tr>
                            <td>{{trans('backend::publisher/text.monthly_page_view')}} <span>*</span></td>
                            <td>
                                <div class="form-group">                                    
                                    <input type="text" class="form-control" id="page-view" value="{{{ $item->pageview or Input::get('page-view') }}}" name="page-view" placeholder="">              
                                </div>
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
                        <!-- PAYMENT -->
                        <tr>
                            <td>{{trans('backend::publisher/text.Paymentpayableto')}} </td>
                            <td>
                                <div class="form-group">                                    
                                    <input type="text" class="form-control" id="payment-to" value="{{{ $item->pageview or Input::get('payment-to') }}}" name="payment-to" placeholder="">              
                                </div>
                            </td>
                        </tr>
                        <!-- COMPANY -->
                        <tr>
                            <td>{{trans('backend::publisher/text.company')}} </td>
                            <td>
                                <div class="form-group">                                    
                                    <input type="text" class="form-control" id="company" value="{{{ $item->company or Input::get('company') }}}" name="company" placeholder="">              
                                </div>
                            </td>
                        </tr>
                        <!-- EMAIL -->
                        <tr>
                            <td>{{trans('backend::publisher/text.email_address')}} </td>
                            <td>
                                <div class="form-group">                                    
                                    <input type="text" class="form-control" id="email-address" value="{{{ $item->email or Input::get('email-address') }}}" name="email-address" placeholder="">              
                                </div>
                            </td>
                        </tr>
                        <!-- GENDER -->
                        <tr>
                            <td>{{trans('backend::publisher/text.gender')}} </td>
                            <td>
                                <div class="form-group">   
                                    <?php $title = isset( $item->title ) ? $item->title : Input::get('title')  ?>                                 
                                    <input type="radio" {{{ ($title=="Mr") ? "checked" : "" }}} name="title" value="Mr" /> Mr
                                    <input type="radio" {{{ ($title=="Mrs") ? "checked" : "" }}} name="title" value="Mrs" /> Mrs
                                    <input type="radio" {{{ ($title=="Ms") ? "checked" : "" }}} name="title" value="Ms" /> Ms
                                </div>
                            </td>
                        </tr>
                        <!-- FIRSTNAME -->
                        <tr>
                            <td>{{trans('backend::publisher/text.first_name')}} </td>
                            <td>
                                <div class="form-group">                                    
                                    <input type="text" class="form-control" id="f-name" value="{{{  $item->first_name or Input::get('f-name') }}}" name="f-name" placeholder="">              
                                </div>
                            </td>
                        </tr>
                        <!-- LASTNAME -->
                        <tr>
                            <td>{{trans('backend::publisher/text.last_name')}} </td>
                            <td>
                                <div class="form-group">                                    
                                    <input type="text" class="form-control" id="l-name" value="{{{  $item->last_name or Input::get('l-name') }}}" name="l-name" placeholder="">              
                                </div>
                            </td>
                        </tr>
                        <!-- COUNTRY -->
                        <tr>
                            <td>{{trans('backend::publisher/text.country')}}</td>
                            <td>
                                <div class="form-group">
                                    <?php
                                        $country = ( isset( $item->country_id ) ) ? $item->country_id : Input::get('country');
                                    ?>                                    
                                    <select class="form-control" name="country">
                                        <option value="">Choose...</option>
                                        @foreach($countryLists as $contry)                                            
                                            <option {{{($contry->id==$country) ? "selected" :  "" }}} value="{{$contry->id}}">{{ $contry->country_name }}</option>                            
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
                        <!-- ADDRESS -->
                        <tr>
                            <td>{{trans('backend::publisher/text.address')}} </td>
                            <td>
                                <div class="form-group">                                    
                                    <textarea name="address" class="form-control" id="" cols="20" rows="4">{{{ $item->address or Input::get('address') }}}</textarea>
                                </div>
                            </td>
                        </tr>
                        <!-- CITY -->
                        <tr>
                            <td>{{trans('backend::publisher/text.city')}} </td>
                            <td>
                                <div class="form-group">                                    
                                    <input type="text" class="form-control" id="city" value="{{{  $item->city or Input::get('city') }}}" name="city" placeholder="">              
                                </div>
                            </td>
                        </tr>
                        <!-- PHONE -->
                        <tr>
                            <td>{{trans('backend::publisher/text.phone')}}</td>
                            <td>
                                <div class="form-group">                                    
                                    <input type="text" class="form-control" id="phone" value="{{{ $item->phone or Input::get('phone') }}}" name="phone" placeholder="">              
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
                        <!-- SITE CHANNEL -->
                        <tr>
                            <td>{{trans('backend::publisher/text.site_channel')}} <span>*</span></td>
                            <td>
                                <div class="form-group">                                    
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <?php $listSelected =  ( isset( $channelSelected ) ) ? $channelSelected : Input::get('selected_site-channel', array()); ?>                                            
                                            <select multiple="multiple"  data-title="site-channel" data-name="site-channel[]" id="site-channel" class="form-control">
                                                @foreach($channelLists as $channel)
                                                    <?php
                                                        $selected =''; 
                                                        if( in_array($channel->id, $listSelected) ){
                                                            $selected ='selected';
                                                        }
                                                    ?>
                                                    <option {{$selected}}  value="{{$channel->id}}">{{ $channel->name }}</option>                                                
                                                @endforeach
                                            </select>                                            
                                        </div>
                                    </div>
                                    
                                </div>
                            </td>
                        </tr>
                        <!-- SITE SERVE COUNTRY -->
                        <tr>
                            <td>{{trans('backend::publisher/text.serve_country')}} <span>*</span></td>
                            <td>
                                <div class="form-group">                                    
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <?php $listSelected =  ( isset( $countryServeSelected ) ) ? $countryServeSelected : Input::get('selected_serve-country', array()); ?>                                            
                                            <select multiple="multiple" data-title="serve-country" data-name="serve-country[]" id="server-country" class="form-control">
                                                @foreach($countryLists as $country)
                                                    <?php
                                                        $selected =''; 
                                                        if( in_array($country->id, $listSelected) ){
                                                            $selected ='selected';
                                                        }
                                                    ?>
                                                    <option {{$selected}}  value="{{$country->id}}">{{ $country->country_name }}</option>                                                
                                                @endforeach
                                            </select>                                            
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
                            <td  style="text-align: left;">
                                <!-- USERNAME -->
                                <div class="form-group">
                                    <label>{{trans('backend::publisher/text.username')}} </label>
                                    @if( $user )
                                        <input type="text" class="form-control" value="{{{ $user->username }}}" name="username" placeholder="{{trans('backend::publisher/text.username')}}" disabled="disabled" />
                                    @else
                                        <input type="text" class="form-control" value="{{{ Input::get('username')}}}" name="username" placeholder="{{trans('backend::publisher/text.username')}}" />
                                    @endif
                                </div>
                                <!-- PASSWORD -->
                                <div class="form-group">
                                    <label>{{trans('backend::publisher/text.password')}} </label>
                                    <input type="text" id="password" class="form-control" value="{{{ $user->show_password or Input::get('password')}}}" name="password" placeholder="{{trans('backend::publisher/text.password')}}" />
                                </div>
                                <div class="form-group">                                
                                    <button type="button" id="btn-ganerate-pass" class="btn btn-primary">{{trans('backend::publisher/text.auto_ganerate')}}</button>
                                </div>
                                  
                                <div class="form-group">
                                    <label for="remark">{{trans('backend::publisher/text.remark')}}</label>
                                    <textarea name="remark" class="form-control">{{{ $item->remark or Input::get('remark')}}}</textarea>
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
                            <td>{{trans('backend::publisher/text.company_name')}} </td>
                            <td>
                                <div class="form-group">                                    
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control" name="billing_company_name" id="billing_company_name" value="{{{  $item->billing_company_name or Input::get('billing_company_name') }}}" />        
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>{{trans('backend::publisher/text.company_address')}} </td>
                            <td>
                                <div class="form-group">                                    
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control" name="billing_company_address" id="billing_company_address" value="{{{ $item->billing_company_address or Input::get('billing_company_address') }}}" />        
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>{{trans('backend::publisher/text.tax_id')}} </td>
                            <td>
                                <div class="form-group">                                    
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control" name="billing_tax_id" id="billing_tax_id" value="{{{ $item->billing_tax_id or Input::get('billing_tax_id') }}}" />        
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>{{trans('backend::publisher/text.revenue_sharing')}} </td>
                            <td>
                                 <div class="form-group">
                                    <input type="text" class="form-control" id="billing_revenue_sharing" value="{{{ $item->billing_revenue_sharing or Input::get('billing_revenue_sharing') }}}" name="billing_revenue_sharing">              
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
                            <td>{{trans('backend::publisher/text.premium_publisher')}}</td>
                            <td>
                                <div class="form-group">
                                    <?php  $isCheck = ( isset( $item->premium_publisher ) ) ? $item->premium_publisher : Input::get('premium-publisher')  ?>                                 
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <input type="radio" {{{ ($isCheck==1) ? "checked" : "checked" }}} name="premium-publisher" value="1" /> {{trans('backend::publisher/text.yes')}}                                        
                                            <input type="radio" {{{ ($isCheck==0) ? "checked" : "" }}} name="premium-publisher" value="0" /> {{trans('backend::publisher/text.no')}} <br>
                                        </div>
                                    </div>                                    
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <?php  $isCheck = ( isset( $item->domain_checking ) ) ? $item->domain_checking : Input::get('domain-checking')  ?>                                 
                            <td>{{trans('backend::publisher/text.domain_checking')}}</td>
                            <td>
                                <input type="radio" {{{ ($isCheck==1) ? "checked" : "checked" }}} name="domain-checking" value="1" /> {{trans('backend::publisher/text.yes')}}                                        
                                <input type="radio" {{{ ($isCheck==0) ? "checked" : "" }}} name="domain-checking" value="0" /> {{trans('backend::publisher/text.no')}} <br>
                            </td>
                        </tr>
                        <tr>
                            <?php  $isCheck = ( isset( $item->vast_tag ) ) ? $item->vast_tag : Input::get('vast-tag')  ?>                                 
                            <td>{{trans('backend::publisher/text.VAST_tag')}}</td>
                            <td>
                                <div class="form-group">                                    
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <input type="radio" {{{ ($isCheck==1) ? "checked" : "checked" }}} name="vast-tag" value="1" /> {{trans('backend::publisher/text.yes')}}                                        
                                            <input type="radio" {{{ ($isCheck==0) ? "checked" : "" }}} name="vast-tag" value="0" /> {{trans('backend::publisher/text.no')}} <br>
                                        </div>
                                    </div>
                                    
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <?php  $isCheck = ( isset( $item->network_publisher ) ) ? $item->network_publisher : Input::get('network-publisher')  ?>                                 
                            <td>{{trans('backend::publisher/text.network_publisher')}} </td>
                            <td>
                                <div class="form-group">                                    
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <input type="radio" {{{ ($isCheck==1) ? "checked" : "checked" }}} name="network-publisher" value="1" /> {{trans('backend::publisher/text.yes')}}                                        
                                            <input type="radio" {{{ ($isCheck==0) ? "checked" : "" }}} name="network-publisher" value="0" /> {{trans('backend::publisher/text.no')}} <br>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr> 
                        <tr>
                            <?php  $isCheck = ( isset( $item->mobile_ad ) ) ? $item->mobile_ad : Input::get('mobile_ad')  ?>                                 
                            <td>{{trans('backend::publisher/text.mobile_ad')}} </td>
                            <td>
                                <div class="form-group">                                    
                                    <div class="row">
                                        <div class="col-sm-12">
                                           <input type="radio" {{{ ($isCheck==1) ? "checked" : "checked" }}} name="mobile-ad" value="1" /> {{trans('backend::publisher/text.yes')}}                                        
                                           <input type="radio" {{{ ($isCheck==0) ? "checked" : "" }}} name="mobile-ad" value="0" /> {{trans('backend::publisher/text.no')}} <br>
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
                            <?php  $isCheck = ( isset( $item->access_to_all_channel ) ) ? $item->access_to_all_channel : Input::get('access-to-all-channels')  ?>                                 
                            <td>{{trans('backend::publisher/text.access_to_all_channels')}} </td>
                            <td>
                                <div class="form-group">                                    
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <input type="radio" {{{ ($isCheck==1) ? "checked" : "checked" }}} name="access-to-all-channels" value="1" /> {{trans('backend::publisher/text.yes')}}                                        
                                            <input type="radio" {{{ ($isCheck==0) ? "checked" : "" }}} name="access-to-all-channels" value="0" /> {{trans('backend::publisher/text.no')}} <br>
                                        </div>
                                    </div>
                                    
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <?php  $isCheck = ( isset( $item->newsletter ) ) ? $item->newsletter : Input::get('newsletter')  ?>                                 
                            <td>{{trans('backend::publisher/text.newsletter')}} </td>
                            <td>
                                <div class="form-group">                                    
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <input type="radio" {{{ ($isCheck==1) ? "checked" : "checked" }}} name="newsletter" value="1" /> {{trans('backend::publisher/text.yes')}}                                        
                                            <input type="radio" {{{ ($isCheck==0) ? "checked" : "" }}} name="newsletter" value="0" /> {{trans('backend::publisher/text.no')}} <br>
                                        </div>
                                    </div>
                                    
                                </div>
                            </td>
                        </tr> 
                        <tr>
                            <?php  $isCheck = ( isset( $item->enable_report_by_model ) ) ? $item->enable_report_by_model : Input::get('enable-report-by-model')  ?>                                 
                            <td>{{trans('backend::publisher/text.enable_report_by_model')}} </td>
                            <td>
                                <div class="form-group">                                    
                                    <div class="row">
                                        <div class="col-sm-12">
                                           <input type="radio" {{{ ($isCheck==1) ? "checked" : "checked" }}} name="enable-report-by-model" value="1" /> {{trans('backend::publisher/text.yes')}}                                        
                                           <input type="radio" {{{ ($isCheck==0) ? "checked" : "" }}} name="enable-report-by-model" value="0" /> {{trans('backend::publisher/text.no')}} <br>
                                        </div>
                                    </div>
                                    
                                </div>
                            </td>
                        </tr>                       
                    </tbody>
                </table>        
            </div>
                     
            <div class="col-sm-6">
                <h3 class="title-view-publisher text-uppercase">{{trans('backend::publisher/text.status')}}</h3>
                <table class="table table-edit-publisher">
                    <tbody>
                       <tr>
                            <td>{{trans('backend::publisher/text.status')}} </td>
                            <td>
                                <div class="form-group">                                    
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <?php  $status = ( isset( $item->status ) ) ? $item->status : Input::get('status') ?>
                                            {{Form::select('status', $statusLists, $status, array('class'=>'form-control'));}}
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
                <div class="col-sm-12 col-md-5 col-md-offset-7 padding-none">
                    <a href="{{URL::Route('ApprovePublisherManagerShowList')}}" class="btn btn-primary pull-right">{{trans('backend::publisher/text.back')}}</a>                 
                    <button type="submit" class="btn btn-primary pull-right">{{trans('backend::publisher/text.save')}}</button>
                </div>
            </div>              
        </div>
    </div>  
</div>
{{Form::close()}}


<script type="text/javascript">
    $(function(){        
        $("#btn-ganerate-pass").click(function(event) {           
            var pass=genarateRandom(8);
            $("#password").val(pass);            
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
   
</script>