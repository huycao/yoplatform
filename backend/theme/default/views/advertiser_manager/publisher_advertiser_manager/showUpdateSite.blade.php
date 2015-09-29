{{ HTML::style("{$assetURL}css/checkbox.css") }}
<div class="part">
@include("partials.show_messages") 
{{ Form::open(array('role'=>'form','class'=>'form-horizontal form-cms')) }}
    <div class="row">
        <div class="col-md-12">
            <div class="form-group form-group-sm">
                <label class="col-md-2">{{trans('text.site_name')}}</label>
                <div class="col-md-4">
                    <input type="text" class="form-control" id="name" value="{{{ $item->name or Input::get('name') }}}" name="name">
                </div>
            </div>                        
        </div>
        <div class="col-md-12">
            <div class="form-group form-group-sm">
                <label class="col-md-2">{{trans('text.site_url')}}</label>
                <div class="col-md-4">
                    <input type="text" class="form-control" id="url" value="{{{ $item->url or Input::get('url') }}}" name="url">
                </div>
            </div>                        
        </div>
        <div class="col-md-12">
            <div class="form-group form-group-sm">
                <label class="col-md-2">{{trans('text.premium_publisher')}}</label>
                <div class="col-md-4">
                    <div class="radio radio-info radio-inline">
                        {{ Form::radio('premium_publisher', '1', '1' == Input::get('premium_publisher') || ( isset($item->premium_publisher) && '1' == $item->premium_publisher), array('id'=>'premium_publisher_1') )}}
                        <label for="premium_publisher_1"> Yes </label>
                    </div>
                    <div class="radio radio-info radio-inline">
                        {{ Form::radio('premium_publisher', '0', '0' == Input::get('premium_publisher') || ( isset($item->premium_publisher) && '0' == $item->premium_publisher), array('id'=>'premium_publisher_0') )}}
                        <label for="premium_publisher_0"> No </label>
                    </div>
                </div>
            </div>                             
        </div>
        <div class="col-md-12">
            <div class="form-group form-group-sm">
                <label class="col-md-2">{{trans('text.domain_checking')}}</label>
                <div class="col-md-4">
                    <div class="radio radio-info radio-inline">
                        {{ Form::radio('domain_checking', '1', '1' == Input::get('domain_checking') || ( isset($item->domain_checking) && '1' == $item->domain_checking), array('id'=>'domain_checking_1') )}}
                        <label for="domain_checking_1"> Yes </label>
                    </div>
                    <div class="radio radio-info radio-inline">
                        {{ Form::radio('domain_checking', '0', '0' == Input::get('domain_checking') || ( isset($item->domain_checking) && '0' == $item->domain_checking), array('id'=>'domain_checking_0') )}}
                        <label for="domain_checking_0"> No </label>
                    </div>
                </div>
            </div>                             
        </div>
        <div class="col-md-12">
            <div class="form-group form-group-sm">
                <label class="col-md-2">{{trans('text.vast_tag')}}</label>
                <div class="col-md-4">
                    <div class="radio radio-info radio-inline">
                        {{ Form::radio('vast_tag', '1', '1' == Input::get('vast_tag') || ( isset($item->vast_tag) && '1' == $item->vast_tag), array('id'=>'vast_tag_1') )}}
                        <label for="vast_tag_1"> Yes </label>
                    </div>
                    <div class="radio radio-info radio-inline">
                        {{ Form::radio('vast_tag', '0', '0' == Input::get('vast_tag') || ( isset($item->vast_tag) && '0' == $item->vast_tag), array('id'=>'vast_tag_0') )}}
                        <label for="vast_tag_0"> No </label>
                    </div>
                </div>
            </div>                             
        </div>
        <div class="col-md-12">
            <div class="form-group form-group-sm">
                <label class="col-md-2">{{trans('text.network_publisher')}}</label>
                <div class="col-md-4">
                    <div class="radio radio-info radio-inline">
                        {{ Form::radio('network_publisher', '1', '1' == Input::get('network_publisher') || ( isset($item->network_publisher) && '1' == $item->network_publisher), array('id'=>'network_publisher_1') )}}
                        <label for="network_publisher_1"> Yes </label>
                    </div>
                    <div class="radio radio-info radio-inline">
                        {{ Form::radio('network_publisher', '0', '0' == Input::get('network_publisher') || ( isset($item->network_publisher) && '0' == $item->network_publisher), array('id'=>'network_publisher_0') )}}
                        <label for="network_publisher_0"> No </label>
                    </div>
                </div>
            </div>                             
        </div>
        <div class="col-md-12">
            <div class="form-group form-group-sm">
                <label class="col-md-2">{{trans('text.mobile_ad')}}</label>
                <div class="col-md-4">
                    <div class="radio radio-info radio-inline">
                        {{ Form::radio('mobile_ad', '1', '1' == Input::get('mobile_ad') || ( isset($item->mobile_ad) && '1' == $item->mobile_ad), array('id'=>'mobile_ad_1') )}}
                        <label for="mobile_ad_1"> Yes </label>
                    </div>
                    <div class="radio radio-info radio-inline">
                        {{ Form::radio('mobile_ad', '0', '0' == Input::get('mobile_ad') || ( isset($item->mobile_ad) && '0' == $item->mobile_ad), array('id'=>'mobile_ad_0') )}}
                        <label for="mobile_ad_0"> No </label>
                    </div>
                </div>
            </div>                             
        </div>        
    </div>
    <div class="row">
        <div class="col-md-12">
            @include("partials.save")
        </div>
    </div>
{{ Form::close() }}
</div>
