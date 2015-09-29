<?php
class ToolsPublisherModel extends PublisherBaseModel {
	
	public static function getUpdateUserRules(){
		return array(
			"username"			=>	"required|min:5",
			"first_name"		=>	"required|min:3",
			"last_name"			=>	"required|min:3",
			// "password"			=>	"required|min:6",
			// "re-password"	    =>  "required|min:6|same:password",
			"email"	            =>  "required|email",

			"company_name"	            =>  "required",
			"first_name_contact"	    =>  "required",
			"email_contact"	            =>  "required|email",
			"phone_contact"	            =>  "required"	 
		);
	}

	public static function getUpdateUserLangs(){
		return array(
			"username.required"		=>	trans('backend::publisher/validation.username.required'),
			"username.min"			=>	trans('backend::publisher/validation.username.min'),
			"first_name.required"	=>	trans('backend::publisher/validation.f-name.required'),
			"first_name.min"		=>	trans('backend::publisher/validation.f-name.min'),
			"last_name.required"	=>	trans('backend::publisher/validation.l-name.required'),
			"last_name.min"			=>	trans('backend::publisher/validation.l-name.min'),
			// "password.required"		=>	trans('backend::publisher/validation.password.required'),
			// "password.min"			=>	trans('backend::publisher/validation.password.min'),
			// "re-password.required"	=>	trans('backend::publisher/validation.c-password.required'),
			// "re-password.min"		=>	trans('backend::publisher/validation.c-password.min'),
			// "re-password.same"		=>	trans('backend::publisher/validation.c-password.same'),
			"email.required"		=>	trans('backend::publisher/validation.email.required'),
			"email.email"			=>	trans('backend::publisher/validation.email.email'),

			"company_name.required"			=>	trans('backend::publisher/validation.company.required'),
			"first_name_contact.required"	=>	trans('backend::publisher/validation.c-name.required'),
			"email_contact.required"		=>	trans('backend::publisher/validation.email.required'),
			"email_contact.email"			=>	trans('backend::publisher/validation.email.email'),
			"phone_contact.required"		=>	trans('backend::publisher/validation.phone.required'),
		);
	}


	public function relationsCountry(){
		return $this->belongsTo('CountryBaseModel','country');
	}

	
}