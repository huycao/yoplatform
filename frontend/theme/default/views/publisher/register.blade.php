<style type="text/css">
    
    #registerForm .radio.half,
    #registerForm .checkbox.half
    {
        width: 50%;
        float: left;
    }

    .help-block-custom{
        margin: 5px 0px;
        display: block;
        border-left: 5px solid #f0ad4e;
        color: #f0ad4e;
        padding-left: 15px;
    }

    .errors-list{
        border-left: 5px solid #a94442;
        padding-left: 15px;
        color: #a94442;
        list-style-position: inside;
    }


</style>
@include("partials.show_errors")
<div class="row">
    <div class="col-md-12">
        <form id="registerForm" class="form-horizontal" role="form" method="post" enctype="multipart/form-data">
            <h2>Contact Information</h2>
            <div class="row">
                <div class="col-md-6">
                    
                    <!-- FIRST NAME -->
                    <div class="form-group">
                        <label for="first_name" class="col-md-4 control-label">First Name</label>
                        <div class="col-md-8">
                            <input type="text" name="first_name" id="first_name" value="{{{ Input::old('first_name')}}}" class="form-control"  placeholder="First Name">
                        </div>
                    </div>
                    
                    <!-- LAST NAME -->
                    <div class="form-group">
                        <label for="last_name"  class="col-md-4 control-label">Last Name</label>
                        <div class="col-md-8">
                            <input type="text" name="last_name" id="last_name" value="{{{ Input::old('last_name')}}}" class="form-control"  placeholder="Last Name">
                        </div>
                    </div>
                    
                    <!-- TITLE -->
                    <div class="form-group">
                        <label for="title" class="col-md-4 control-label">Title</label>
                        <div class="col-md-8">

                            {{ 
                                Form::select(
                                    'title', 
                                    array(''=>'Select','Mr'=>'Mr','Mrs'=>'Mrs','Ms'=>'Ms'), 
                                    Input::old('title'), 
                                    array('class'=>'form-control','id'=>'title')
                                ) 
                            }}

                        </div>
                    </div>
                    
                    <!-- COMPANY -->
                    <div class="form-group">
                        <label for="company" class="col-md-4 control-label">Company</label>
                        <div class="col-md-8">
                            <input type="text" name="company" class="form-control" id="company" value="{{{ Input::old('company') }}}" placeholder="Company">
                            <span class="help-block-custom">If you do not have a company name, please fill in your full name. We will issue your payment based on one of these two details</span>
                        </div>
                    </div>
                    
                    <!-- ADDRESS -->
                    <div class="form-group">
                        <label for="address" class="col-md-4 control-label">Address</label>
                        <div class="col-md-8">
                            <textarea name="address" id="address" class="form-control" rows="3" placeholder="Address">{{{ Input::old('address')}}}</textarea>
                        </div>
                    </div>
                    
                    <!-- CITY -->
                    <div class="form-group">
                        <label for="city" class="col-md-4 control-label">City</label>
                        <div class="col-md-8">
                            <input type="text" name="city" class="form-control" id="city" value="{{{ Input::old('city')}}}" placeholder="City">
                        </div>
                    </div>

                </div>

                <div class="col-md-6">
                    
                    <!-- STATE -->
                    <div class="form-group">
                        <label for="state" class="col-md-4 control-label">State</label>
                        <div class="col-md-8">
                            <input type="text" name="state" class="form-control" id="state" value="{{{ Input::old('state') }}}" placeholder="State">
                        </div>
                    </div>
                    
                    <!-- POSTCODE -->
                    <div class="form-group">
                        <label for="postcode" class="col-md-4 control-label">Postcode</label>
                        <div class="col-md-8">
                            <input type="text" name="postcode" class="form-control" id="postcode" value="{{{ Input::old('postcode') }}}" placeholder="Postcode">
                        </div>
                    </div>
                    
                    <!-- COUNTRY -->
                    <div class="form-group">
                        <label for="country" class="col-md-4 control-label">Country</label>
                        <div class="col-md-8">
                            {{ 
                                Form::select(
                                    'country', 
                                    $listCountry, 
                                    Input::old('country'), 
                                    array('class'=>'form-control','id'=>'country')
                                ) 
                            }}
                        </div>
                    </div>
                    
                    <!-- PHONE -->
                    <div class="form-group">
                        <label for="phone" class="col-md-4 control-label">Phone</label>
                        <div class="col-md-8">
                            <input type="text" name="phone" class="form-control" id="phone" value="{{{ Input::old('phone') }}}" placeholder="Phone">
                        </div>
                    </div>
                    
                    <!-- FAX -->
                    <div class="form-group">
                        <label for="fax" class="col-md-4 control-label">Fax</label>
                        <div class="col-md-8">
                            <input type="text" name="fax" class="form-control" id="fax" value="{{{ Input::old('fax') }}}" placeholder="Fax">
                        </div>
                    </div>
                    
                    <!-- EMAIL -->
                    <div class="form-group">
                        <label for="email" class="col-md-4 control-label">Email</label>
                        <div class="col-md-8">
                            <input type="text" name="email" class="form-control" id="email" value="{{{ Input::old('email') }}}" placeholder="Email">
                        </div>
                    </div>
                    
                    <!-- PAYMENT TO -->
                    <div class="form-group">
                        <label for="payment_to" class="col-md-4 control-label">Payment to</label>
                        <div class="col-md-8">
                            <input type="text" name="payment_to" class="form-control" id="payment_to" value="{{{ Input::old('payment_to') }}}" placeholder="Payment to">
                            <span class="help-block-custom">Please fill in your name on your bank account, we will issue your payment to this account.</span>
                        </div>
                    </div>

                </div>

            </div>
            <hr>
            <h2>Website Information</h2>
            
            <div class="row">
                <div class="col-md-6">
                    
                    <!-- SITE NAME -->
                    <div class="form-group">
                        <label for="site_name" class="col-md-4 control-label">Site Name</label>
                        <div class="col-md-8">
                            <input type="text" name="site_name" id="site_name" value="{{{ Input::old('site_name') }}}" class="form-control"  placeholder="Site Name">
                        </div>
                    </div>
                    
                    <!-- SITE URL -->
                    <div class="form-group">
                        <label for="site_url" class="col-md-4 control-label">Site Url</label>
                        <div class="col-md-8">
                            <input type="text" name="site_url" id="site_url" value="{{{ Input::old('site_url') }}}" class="form-control"  placeholder="Site Url">
                        </div>
                    </div>
                    
                    <!-- SITE DESCRIPTION -->
                    <div class="form-group">
                        <label for="site_description" class="col-md-4 control-label">Site Description</label>
                        <div class="col-md-8">
                            <textarea name="site_description" id="site_description" class="form-control" rows="3" placeholder="Site Description">{{{ Input::old('site_description') }}}</textarea>
                        </div>
                    </div>
                    
                    <!-- SITE LANGUAGE -->
                    <div class="form-group">
                        <label class="col-md-4 control-label">Site Languages</label>
                        <div class="col-md-8">
                            <span class="help-block-custom">Only 3 maximum languages can be selected</span>
                            @if( !empty($listLanguage) )
                                @foreach( $listLanguage as $language )

                                <div class="checkbox">
                                    <label>
                                        {{
                                            Form::checkbox(
                                                'languages[]',
                                                $language['name'],
                                                in_array($language['name'], Input::old('languages', array()))
                                            )
                                        }}
                                        {{ $language['name'] }}
                                    </label>
                                </div>
                                @endforeach
                            @endif
                            <div class="checkbox">
                                <label>
                                    {{
                                        Form::checkbox(
                                            'languages[]',
                                            'otherlanguage',
                                            in_array('otherlanguage', Input::old('languages', array()))
                                        )
                                    }}
                                    <input type="text" name="otherlanguage" id="otherlanguage" value="{{{ Input::old('otherlanguage') }}}" class="form-control"  placeholder="Other Language">
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    <!-- MONTHLY UNIQUE VISITORS -->
                    <div class="form-group">
                        <label for="unique_visitor" class="col-md-4 control-label">Monthly Unique Visitors</label>
                        <div class="col-md-8">
                            <input type="text" name="unique_visitor" id="unique_visitor" value="{{{ Input::old('unique_visitor') }}}" class="form-control"  placeholder="Monthly Unique Visitors">
                        </div>
                    </div>
                    
                    <!-- MONTHLY PAGE VIEWS -->
                    <div class="form-group">
                        <label for="pageview" class="col-md-4 control-label">Monthly Page Views</label>
                        <div class="col-md-8">
                            <input type="text" name="pageview" id="pageview" value="{{{ Input::old('pageview') }}}" class="form-control"  placeholder="Page View">
                        </div>
                    </div>
                    
                    <!-- TRAFFIC REPORT FILE -->
                    <div class="form-group">
                        <label class="col-md-4 control-label">Traffic Report</label>
                        <div class="col-md-8">
                            <span class="help-block-custom">Only image format or pdf allowed</span>
                            <input type="file" class="form-control" name="traffic_report_file" />
                        </div>
                    </div>

                </div>

                <div class="col-md-6">
                    
                    <!-- CATEGORIES -->
                    <div class="form-group">
                        <label class="col-md-4 control-label">Categories</label>
                        <div class="col-md-8">
                            <div>
                                <span class="help-block-custom">Feel free to suggest new categories if your site's content do not fit any existing categories.</span>
                                
                                @if( !empty($listWebsiteCategory) )
                                    @foreach( $listWebsiteCategory as $category )
                                    <div class="radio half">
                                        <label>
                                            {{ 
                                                Form::radio(
                                                    'category',
                                                    $category['id'],
                                                    $category['id'] == Input::old('category'),
                                                    array(
                                                        'id' =>  "category-".$category['id']
                                                    )
                                                )
                                            }}
                                            {{$category['name']}}
                                        </label>
                                    </div>
                                    @endforeach
                                @endif
                                <div class="clearfix"></div>

                            </div>

                            <div>
                                <div class="radio">
                                    <label class="radio-inline">
                                            {{ 
                                                Form::radio(
                                                    'category',
                                                    'othercategory',
                                                    'othercategory' == Input::old('category'),
                                                    array(
                                                        'id' =>  "category-other"
                                                    )
                                                )
                                            }}
                                            Others
                                    </label>
                                    <label class="radio-inline">
                                        <input type="text" name="othercategory" id="othercategory" value="{{{ Input::old('othercategory') }}}" class="form-control"  placeholder="Other Category">
                                    </label>

                                </div>
                            </div>

                        </div>
                    </div>

                </div>

                <div class="col-md-12">
                    <span class="help-block-custom">please key in accurate data, this will affect the result of your application</span>
                </div>

            </div>
            <hr>
            <h2>How did you get to know about Yomedia</h2>
            <div class="row">
                <div class="col-md-6">
                    
                    <!-- REASON -->
                    <div class="form-group">
                        <div class="col-md-12">
                            <div>

                                @if( !empty($listReason) )
                                    @foreach( $listReason as $key   =>  $value )
                                        <div class="checkbox half">
                                            <label>
                                                {{
                                                    Form::checkbox(
                                                        'reason[]',
                                                        $key,
                                                        in_array($key, Input::old('reason', array()))
                                                    )
                                                }}
                                                {{ $value }}
                                            </label>
                                        </div>
                                    @endforeach
                                @endif

                                <div class="clearfix"></div>
                            </div>

                            <div>
                                <div class="checkbox">
                                    <label class="checkbox col-md-4">
                                        {{
                                            Form::checkbox(
                                                'reason[]',
                                                'reasonblog',
                                                in_array('reasonblog', Input::old('reason', array()))
                                            )
                                        }}
                                        Blog                                       
                                    </label>
                                    <label class="checkbox col-md-8">
                                        <span class="help-block-custom">please enter the name/URL of the blog</span>
                                        <input type="text" name="reasonblog" id="reasonblog" value="{{{ Input::old('reasonblog') }}}" class="form-control"  placeholder="Blog">
                                    </label>
                                </div>
                            </div>

                            <div>
                                <div class="checkbox">
                                    <label class="checkbox col-md-4">
                                        {{
                                            Form::checkbox(
                                                'reason[]',
                                                'reasonother',
                                                in_array('reasonother', Input::old('reason', array()))
                                            )
                                        }}
                                        Others                           
                                    </label>
                                    <label class="checkbox col-md-8">
                                        <input type="text" name="reasonother" id="reasonother" value="{{{ Input::old('reasonother') }}}" class="form-control"  placeholder="Others">
                                    </label>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>

            <hr>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="col-md-12">
                            <div class="checkbox">
                                <label>
                                    <input name="agree" type="checkbox"> I have read and accept the terms and conditions of the Web Publisher Agreement.
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <hr>

            <div class="row">
                <div class="col-md-5">
                    <div class="form-group">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-default btn-primary">Submit</button>
                            <button type="button" id="resetBtn" class="btn btn-default btn-info">Reset</button>
                        </div>
                    </div>
                </div>
            </div>

        </form>
    </div>
</div>