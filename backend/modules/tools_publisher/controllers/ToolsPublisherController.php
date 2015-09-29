<?php

class ToolsPublisherController extends PublisherBackendController 
{

	public function __construct(ToolsPublisherModel $model) {
		parent::__construct(pathinfo(dirname(__DIR__), PATHINFO_BASENAME));
		$this->model = $model;
	}

	///my profile
	
    public function myProfile(){

    	if( Session::get('reviewUid') ){
    		$currentUser=Sentry::findUserById(Session::get('reviewUid'));
    	}else{
    		$currentUser=$this->user;
    	}

    	$this->data['item'] = $currentUser;
    	$id=$currentUser->id;

    	//get info publisher
    	$this->data['itemPublisher']=$this->model->with('country')->where('id',$this->getPublisher()->id)->first();
    	
    	if (Request::isMethod('post')) {
            
            // check validate
	        $validate = Validator::make(Input::all(), $this->model->getUpdateUserRules(), $this->model->getUpdateUserLangs());
	        $flag=$this->checkValidatePass($this->data);
	        if ($validate->passes() && $flag==TRUE) {
	        	$username = Input::get('username');
	        	$password = Input::get('re-password');
	        	$firstName= Input::get('first_name');
	        	$lastName = Input::get('last_name');
	        	$email    = Input::get('email');

	        	$updateData=[
	        		'company'			=>Input::get('company_name'),
					'city'				=>Input::get('city'),
					'address_contact'	=>Input::get('address_contact'),
					'state'				=>Input::get('state'),
					'postcode'			=>Input::get('postcode'),
					'name_contact'		=>Input::get('first_name_contact'),
					'email_contact'		=>Input::get('email_contact'),
					'phone_contact'		=>Input::get('phone_contact'),
	        			];
	        	//update info contact publisher
	        	$item=$this->model->where('id',$currentUser->publisher_id)->update($updateData);	

				try
				{
					$userData = Sentry::findUserById($id);
					$userData->username = $username;
					if($password != ""){
						$userData->password = $password;
					}
					$userData->email 		= $email;
					$userData->first_name 	= $firstName;
					$userData->last_name 	= $lastName;

					if($userData->save()){
						$data['id']			= $userData->id;
						$messages=trans("backend::publisher/text.update_success");				
						Session::flash('msg',$messages);
			            return Redirect::to($this->moduleURL .'profile');
					}

				}
				catch (\Cartalyst\Sentry\Users\WrongPasswordException $e)
				{
					$this->data['message'] = "Passwords do not exactly";
				}
	        } else {
	            $this->data['validate'] = $validate->messages();
	        }
        }

        $this->layout->content = View::make('myProfile', $this->data);
    }

   	
   	public function paymentRequest(){
   		$pubInfo = Sentry::getUser();
   		$uid = $pubInfo->id;
        $item = PublisherBaseModel::where('user_id', $uid)->first();
        if (!$item) {
            return Redirect::to($this->moduleURL . 'show-list');
        }
        $this->data['id'] = $item->id;

        $item->createMonthlyPaymentRequest();


        $this->data['listPaymentRequests'] = PaymentRequestBaseModel::where(array(
            'publisher_id'  =>   $item->id,
        ))->orderBy('created_at','desc')->get();
        $this->data['routeExport'] = "ToolsPublisher";
        
        $this->layout->content = View::make('advertiser_manager.publisher_advertiser_manager.showPaymentRequest', $this->data);

    }

    public function paymentRequestDetail($id){
    	$model = new PaymentRequestDetailBaseModel;
        $data['data'] = PaymentRequestDetailBaseModel::where('payment_request_id', $id)->with('campaign','publisher')->get();

        if( $data['data']->count() ){
         	
	        $data['data'] = $model->where('payment_request_id', $id)->with('campaign','publisher')->get();

	        if( $data['data']->count() ){
	            $data['publisher'] = $data['data']['0']->publisher;
	            $data['pubName'] = Sentry::getUser()->username;
	            return $model->exportExcel($data);
	        }

	        return false;

        }

    }

}