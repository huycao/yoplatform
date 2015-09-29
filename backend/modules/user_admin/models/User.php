<?php

class User extends Cartalyst\Sentry\Users\Eloquent\User {


	public function __construct(){
		parent::__construct();
	}

	public static $loginRules	=	array(
		"loginUsername"	=>	"required",
		"loginPassword"	=>	"required"
	);

	public static $loginLangs	=	array(
		"loginUsername.required"	=>	"Please enter your username",
		"loginPassword.required"	=>	"Please enter your password"
	);

	public static $changePasswordRules	=	array(
		"oldPassword"				=>	"required",
		"newPassword"				=>	"required|Confirmed|min:6",
		"newPassword_confirmation"	=>	"required|min:6"
	);

	public static $changePasswordLangs	=	array(
		"oldPassword.required"			=>	"Vui lòng nhập mật khẩu hiện tại",
		"newPassword.required"			=>	"Vui lòng nhập mật khẩu mới",
		"newPassword.confirmed"			=>	"Mật khẩu mới và mật khẩu xác thực không trùng khớp",
		"newPassword.min"				=>	"Mật khẩu mới phải có ít nhất 6 ký tự",
		"newPassword_confirmation.required"	=>	"Vui lòng nhập mật khẩu xác thực",
		"newPassword_confirmation.min"	=>	"Mật khẩu xác thực phải có ít nhất 6 ký tự"
	);

	public function getUpdateRules(){
		return array(
			"username"			=>	"required|min:5",
			'password'			=>	"required|min:6"
		);
	}

	public function getUpdateLangs(){
		return array(
			"username.required"	=>	trans('user::validation.username.required'),
			"username.min"		=>	trans('user::validation.username.min'),
			"password.required"	=>	trans('user::validation.password.required'),
			"password.min"		=>	trans('user::validation.password.min'),
		);
	}

	public static function getUpdateUserRules(){
		return array(
			"username"			=>	"required|min:5",
			"first_name"		=>	"required|min:3",
			"last_name"			=>	"required|min:3",
			// "password"			=>	"required|min:6",
			// "re-password"	    =>  "required|min:6|same:password",
			"phone"	        	=>  "required",
			"contact_phone"	    =>  "required",	 
			"email"	            =>  "required|email",
			"address"	        =>  "required",
			"country"	        =>  "required",
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
			"phone.required"	        	=>  trans('backend::publisher/validation.phone.required'),
			"contact_phone.required"	    =>  trans('backend::publisher/validation.contact_phone.required'),
			"email.required"		=>	trans('backend::publisher/validation.email.required'),
			"email.email"			=>	trans('backend::publisher/validation.email.email'),
			"address.required"	    =>  trans('backend::publisher/validation.address.required'),
			"country.required"	    =>  trans('backend::publisher/validation.country.required'),
		);
	}

	public function getShowField(){
		return array(
			'username'		=>	trans('text.username'),
			'created_at'	=>	trans('text.created_at'),
		);
	}

	 public function getShowFieldUser(){        
        return array(
            'username'         =>  array(
                'label'         =>  trans("backend::publisher/text.username"),
                'type'          =>  'text'
            ),
            'first_name'         =>  array(
                'label'         =>  trans("backend::publisher/text.first_name"),
                'type'          =>  'text'
            ),
            'last_name'  =>  array(
                'label'         =>  trans("backend::publisher/text.last_name"),
                'type'          =>  'text',
            ),            
            'email'  =>  array(
                'label'         =>  trans("backend::publisher/text.email"),
                'type'          =>  'text',
            ),
            'activated'  =>  array(
                'label'         =>  trans("backend::publisher/text.status"),
                'type'          =>  'text',
                'alias'         => 'ShowStatus'
            )
        );   
    }

    public function getShowFieldUserManager(){
		return array(
	        'first_name'    =>  array(
	            'label'         =>  trans("backend::publisher/text.first_name"),
	            'type'          =>  'text'
	        ),
	        'username'      =>  array(
	            'label'         =>  trans("backend::publisher/text.username"),
	            'type'          =>  'text'
	        ),
	        'phone'  =>  array(
	            'label'         => 	trans("backend::publisher/text.phone"),
	            'type'          =>  'text'
	        ),
	        'phone_contact'  	=>  array(
	            'label'         =>  trans("backend::publisher/text.contact_phone"),
	            'type'          =>  'text'
	        ),
	        'email'  		=>  array(
	            'label'         =>  trans("backend::publisher/text.email"),
	            'type'          =>  'text'
	        )
	    );  
	}

	public function getSearchField(){
		return array(
			'username'		=>	trans('text.username'),
		);
	}

	public function scopeSearch($query, $keyword = '', $filterBy = 0)
	{
		if( !empty($keyword) ){
			if( !empty($filterBy)  ){
				$query->where($filterBy, 'LIKE', "%{$keyword}%");
			}else{
				if( !empty($this->searchField) ){
					foreach( $this->searchField as $field => $title){
						$query->orWhere($field, 'LIKE', "%{$keyword}%");
					}
				}
			}

		}

		return $query;
	}

	public function getShowStatusAttribute(){
		$status=$this->activated;
		if($status==1){
			$class='<div class="activated-'.$this->id.'"><a href="javascript:;" onclick="changeBooleanType('.$this->id.',0,\'activated\');" class="text-success"><span class="glyphicon glyphicon-ok"></span> Active</a></div>';
		}else{
			$class='<div class="activated-'.$this->id.'"><a href="javascript:;" onclick="changeBooleanType('.$this->id.',1,\'activated\');" class="text-warning"><span class="glyphicon glyphicon-remove"></span> Off</a></div>';
		}

		return $class;
    }

  	public function scopeShowListUser($query,$searchData){
  		$query->select('users.*','groups.name as role')
			->join('users_groups','users.id','=','users_groups.user_id')
			->join('groups','users_groups.group_id','=','groups.id');

		if( !empty($searchData) ){
            
            $typeName   =$searchData[0]['value'];
            $keyword    =$searchData[1]['value'];
           
            if(!empty($keyword)){
                if($typeName=="name"){
                    $query->where(DB::raw("(first_name"),"LIKE",DB::raw("'%{$keyword}%'"));
                    $query->orWhere("last_name","LIKE",DB::raw("'%{$keyword}%')"));
                }elseif($typeName=="username"){
                    $query->orWhere("username","LIKE",DB::raw("'%{$keyword}%'"));
                }else
                    $query->where('email', 'LIKE', DB::raw("'%{$keyword}%'"));
            }
        }     	
		return $query;
			
  	}

  	public function searchSaleByCapital($keyword){
  		$group = Sentry::findGroupByID(Config::get('backend.group_advertiser_manager_id'));
  		$query = $group->users();
  		if( !empty($keyword) ){
  			$query->where('username', 'LIKE' ,"{$keyword}");
  		}
  		return $query->get();
  	}

  	public function scopesearchUserManager($query,$searchData=[]){
  		if( !empty($searchData) ){
  			$textUserName	=$searchData[0]['value'];
  			$textFirstName	=$searchData[1]['value'];
  			$textLastName	=$searchData[2]['value'];
			$textEmail		=$searchData[3]['value'];
			$country_id		=$searchData[4]['value'];

  			if(isset($textUserName) && $textUserName!=""){
  				$query=$query->where('username','LIKE',"%{$textUserName}%");
  			}

  			if(isset($textFirstName) && $textFirstName!=""){
  				$query=$query->where('first_name','LIKE',"%{$textFirstName}%");
  			}

  			if(isset($textLastName) && $textLastName!=""){
  				$query=$query->where('last_name','LIKE',"%{$textLastName}%");
  			}

  			if(isset($textEmail) && $textEmail!=""){
  				$query=$query->where('email','LIKE',"%{$textEmail}%");
  			}

  			if(isset($country_id) && $country_id!=""){
  				$query=$query->where('country_id',$country_id);
  			}
  		}
  		return $query;
  	}

  	public function relationPulisher(){
  		return $this->belongsTo('PublisherBaseModel','publisher_id');
  	}

  	public function publisher(){
  		return $this->hasOne('PublisherBaseModel');
  	}

  	

}
