<?php

class PublisherModel extends PublisherBaseModel {

    protected $table = 'publisher';

    /**
     *     Module
     *     @var string
     */
    public $module = 'publisher';

    /**
     *     Fillable field of table
     *     @var array
     */
    protected $fillable = array(
        'first_name',
        'last_name',
        'title',
        'company',
        'address',
        'city',
        'state',
        'postcode',
        'country',
        'phone',
        'fax',
        'email',
        'payment_to',
        'site_name',
        'site_url',
        'site_description',
        'languages',
        'orther_lang',
        'unique_visitor',
        'pageview',
        'traffic_report_file',
        'category',
        'other_category',
        'reason',
        'status'

    );          

	public function getRegisterRules(){
        return array(
            "first_name"            =>  "required",
            "last_name"             =>  "required",
            "title"                 =>  "required",
            "company"               =>  "required",
            "address"               =>  "required",
            "city"                  =>  "required",
            "state"                 =>  "required",
            "postcode"              =>  "required",
            "country"               =>  "required",
            "phone"                 =>  "required",
            "fax"                   =>  "required",
            "email"                 =>  "required|email",
            "payment_to"            =>  "required",
            "site_name"             =>  "required",
            "site_url"              =>  "required|url",
            "site_description"      =>  "required",
            "languages"             =>  "required",
            "unique_visitor"        =>  "required",
            "pageview"              =>  "required",
            'traffic_report_file'   =>  "required|mimes:jpeg,gif,png,jpg,pdf",
            "category"              =>  "required",
            "agree"                 =>  "required",
        );
    }

    public function getRegisterLangs(){
        return array(
            "first_name.required"	=>  trans($this->module."::message.first_name.required"),
            "last_name.required"	=>  trans($this->module."::message.last_name.required"),
            "title.required"		=>  trans($this->module."::message.title.required"),
            "company.required"		=>  trans($this->module."::message.company.required"),
            "address.required"		=>  trans($this->module."::message.address.required"),
            "city.required"			=>  trans($this->module."::message.city.required"),
            "state.required"        =>  trans($this->module."::message.state.required"),
            "postcode.required"		=>  trans($this->module."::message.postcode.required"),
            "country.required"		=>  trans($this->module."::message.country.required"),
            "phone.required"		=>  trans($this->module."::message.phone.required"),
            "fax.required"			=>  trans($this->module."::message.fax.required"),
            "email.required"        =>  trans($this->module."::message.email.required"),
            "email.email"		 =>  trans($this->module."::message.email.email"),
            "payment_to.required"	=>  trans($this->module."::message.payment_to.required"),
            "site_name.required"         =>  trans($this->module."::message.site_name.required"),
            "site_url.required"          =>  trans($this->module."::message.site_url.required"),
            "site_url.url"          =>  trans($this->module."::message.site_url.url"),
            "site_description.required"  =>  trans($this->module."::message.site_description.required"),
            "languages.required"         =>  trans($this->module."::message.languages.required"),
            "languages.between"          =>  trans($this->module."::message.languages.between"),
            "unique_visitor.required"    =>  trans($this->module."::message.unique_visitor.required"),
            "pageview.required"          =>  trans($this->module."::message.pageview.required"),
            "traffic_report_file.required"  =>  trans($this->module."::message.traffic_report_file.required"),
            "traffic_report_file.mimes"  =>  trans($this->module."::message.traffic_report_file.mimes"),
            "category.required"          =>  trans($this->module."::message.category.required"),
            "agree.required"             =>  trans($this->module."::message.agree.required"),
        );
    }

    public function getContactInfoRules(){
        return array(
            "first_name"            =>  "required",
            "last_name"             =>  "required",
            "title"                 =>  "required",
            "company"               =>  "required",
            "address"               =>  "required",
            "city"                  =>  "required",
            "state"                 =>  "required",
            "postcode"              =>  "required",
            "country"               =>  "required",
            "phone"                 =>  "required",
            "fax"                   =>  "required",
            "email"                 =>  "required|email",
            "payment_to"            =>  "required",
            "site_name"             =>  "required",
            "site_url"              =>  "required|url",
            "site_description"      =>  "required",
            "agree"                 =>  "required",
        );
    }

    public function getContactInfoLangs(){
        return array(
            "first_name.required"   =>  trans($this->module."::message.first_name.required"),
            "last_name.required"    =>  trans($this->module."::message.last_name.required"),
            "title.required"        =>  trans($this->module."::message.title.required"),
            "company.required"      =>  trans($this->module."::message.company.required"),
            "address.required"      =>  trans($this->module."::message.address.required"),
            "city.required"         =>  trans($this->module."::message.city.required"),
            "state.required"        =>  trans($this->module."::message.state.required"),
            "postcode.required"     =>  trans($this->module."::message.postcode.required"),
            "country.required"      =>  trans($this->module."::message.country.required"),
            "phone.required"        =>  trans($this->module."::message.phone.required"),
            "fax.required"          =>  trans($this->module."::message.fax.required"),
            "email.required"        =>  trans($this->module."::message.email.required"),
            "email.email"           =>  trans($this->module."::message.email.email"),
            "payment_to.required"   =>  trans($this->module."::message.payment_to.required"),
            "site_name.required"         =>  trans($this->module."::message.site_name.required"),
            "site_url.required"          =>  trans($this->module."::message.site_url.required"),
            "site_url.url"               =>  trans($this->module."::message.site_url.url"),
            "site_description.required"  =>  trans($this->module."::message.site_description.required"),           
            "agree.required"             =>  trans($this->module."::message.agree.required"),
            "captcha.required"           =>  "Code is required",
            "captcha.captcha"            =>  "Code is incorrect",
        );
    }

}
