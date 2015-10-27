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

	/**
	 * function name: paymentRequest
	 * @return mixed
	 */
   	public function paymentRequest($page = 1){
   		$pubInfo = Sentry::getUser();
   		$uid = $pubInfo->id;
		$paymentReq = new PaymentRequestBaseModel;
		$publisher = new PublisherBaseModel;
		$item = $publisher->getItem($uid);
		if (!$item) {
            return Redirect::to($this->moduleURL . 'show-list');
        }

        $this->data['routeExport'] = "ToolsPublisher";
		$options = array();
		if(Request::ajax()){
			$dataPaging['items'] = $paymentReq->getItems($item->id, ITEM_PER_PAGE, $page)->lists('id', 'amount', 'created_at');
			return Response::json($dataPaging);
		}else{
			$dataPaging['items'] = $paymentReq->getItems($item->id, ITEM_PER_PAGE, $page);
			$this->data['listItems'] = View::make('advertiser_manager.publisher_advertiser_manager.paymentRequestPaging', $dataPaging);
		}
        $this->layout->content = View::make('advertiser_manager.publisher_advertiser_manager.showPaymentRequest', $this->data);
    }

	/*
	 * ajax load for show payment request
	 */
	public function sendPaymentRequest(){
		//process send request
		$paymentReq = new PaymentRequestBaseModel;
		$ids = Input::has('ids') ? Input::get('ids'):'';
		$re = array();
		if(Request::ajax()){
			//return json
			$total = $paymentReq->sumItemsByIds($ids);
			if($total>=300){
				$paymentReq->updateStatus($ids);
				$re['status'] = 'ok';
			}else{
				$re['status'] = 'error';
			}
		}
		echo json_encode($re);
	}

    public function paymentRequestDetail($id){
    	$model = new PaymentRequestDetailBaseModel;
		$data['payment'] = PaymentRequestBaseModel::find($id);
		$items = $model->getItemsByPaymentRequestId($id);
		$data['items'] = $items;
		$this->layout->content = View::make('advertiser_manager.publisher_advertiser_manager.paymentRequestDetail',$data);
    }
}