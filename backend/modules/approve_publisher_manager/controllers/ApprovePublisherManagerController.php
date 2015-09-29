<?php

class ApprovePublisherManagerController extends PublisherManagerController 
{

	public function __construct(PublisherBaseModel $model) {
		parent::__construct(pathinfo(dirname(__DIR__), PATHINFO_BASENAME));
		$this->model = $model;
		$this->layout = 'layout.indexPublisher';
	}
	

	/**
	 *     List item of module
	 */
	function showList(){
		$this->data['defaultField'] = $this->defaultField;
		$this->data['defaultOrder'] = $this->defaultOrder;
		$this->data['defaultURL'] 	= $this->moduleURL;

		//get country
		$this->data['itemCountry']=CountryBaseModel::select('id','country_name')->get();
		//get category
        $this->data['itemCate']=CategoryBaseModel::select('id','name')->where('parent_id', 0)->where('status',1)->get();

		if( method_exists($this, 'beforeShowList') ){
			$this->beforeShowList();
		}
		$this->layout->content = View::make('showList', $this->data);
	}

	/*----------------------------- CREATE & UPDATE --------------------------------*/
	function showUpdate($id = 0){
		$this->data['id'] = $id;

		$this->data['user'] = FALSE;

		$this->data['statusLists'] = Config::get('data.approve_status');

		//get country
		$this->data['countryLists']=CountryBaseModel::select('id','country_name')->get();

		//get language
		$this->data['languageLists']=LanguageBaseModel::select('id','name')->get();

		//get category
        $this->data['channelLists']=CategoryBaseModel::select('id','name')->where('parent_id', 0)->where('status',1)->get();

		// WHEN UPDATE SHOW CURRENT INFOMATION
		if( $id != 0 ){
			$item = $this->model->find($id);
						
			if( $item ){

				//get site language
				$this->data['languageSelected'] = $item->language->lists('id');
				//get serve country
				$this->data['countryServeSelected'] = $item->serveCountry->lists('id');
				//get site channel
				$this->data['channelSelected']= $item->channel->lists('id');

				$this->data['item'] 		= $item;

				if( $item->user_id != 0 ){
					$user = Sentry::findUserById($item->user_id);
		            $this->data['user'] = $user;
				}

			}else{

				return Redirect::to($this->moduleURL);

			}
		}	

		if (Request::isMethod('post'))
		{
			if( $this->postUpdate($id) ){
				return Redirect::to($this->moduleURL);
			}
		}

		$this->layout->content = View::make('showCreate', $this->data);

	}

	

	function postUpdate($id = 0){

		$validate 		= Validator::make(Input::all(), $this->model->getUpdateRules(), $this->model->getUpdateLangs());

		if( $validate->passes() ){

			if( $id == 0 ){
				$item = $this->model->insertData($this->user->id);
				if( $item){
					$this->data['id'] = $item->id;
					Session::flash('success', 'Create New Publisher Success');
					return TRUE;
				}
			}else{
				$item = $this->model->find($id);
				if( $item){
					$item->updateData($this->user->id);
					Session::flash('success', 'Update Publisher Success');
					return TRUE;
				}
			}

		}else{	
            $this->data['errors'] = $validate->messages();
		}

		return FALSE;

	}	
	/*----------------------------- END CREATE & UPDATE --------------------------------*/

    public function ShowView($id){
    	$item = $this->model->find($id);    	
    	$this->data['item']=$item;

		//get user publisher
		$user = FALSE;
		if( $item->user_id != 0 ){
			$user = Sentry::findUserById($item->user_id);
		}
		$this->data['user'] = $user;
		$this->data['languageSelected'] = $item->language->lists('name','id');
		$this->data['countryServeSelected'] = $item->serveCountry->lists('country_name', 'id');
		$this->data['channelSelected']= $item->channel->lists('name' ,'id');

    	$this->layout->content=View::make('showView',$this->data);
    }
    //move status pulisher 
    public function moveStatus(){    	
    	$id=Input::get('id'); 
    	$status=Input::get('status');    	
    	$data=array('status'=>$status);
    	try{
    		$item=$this->model->where('id',$id)->update($data);
    		if($item){
    			$this->insertUserApprovedPublisher($id,$status);
    		}    		  
    	}catch(Exception $e){
    		echo "<pre>{$e}</pre>";
    	}
    	
    	if($item) return 1;
    	else return 0;
    }
    //insert user approved publisher
    public function insertUserApprovedPublisher($id,$status){
    	//get info login
		$userCurrent=Session::get('currentUserSess');
		//check exists user approve
		$checkExists=$this->checkExistsUserApprove($id,$userCurrent->id);

		$updateData=[
			'user_id'			=>$userCurrent->id,
			'username'			=>$userCurrent->username,
			'publisher_id'		=>$id,
			'publisher_status'	=>$status
			];
		if($checkExists==FALSE) //insert info user current approve
			PublisherApproveBaseModel::create($updateData);	
		else //update status_publisher    				
			PublisherApproveBaseModel::where(['user_id'=>$userCurrent->id,'publisher_id'=>$id])->update($updateData);
		
    }
    //check exists user approve
    public function checkExistsUserApprove($id,$id_user){
    	$item=PublisherApproveBaseModel::where(['user_id'=>$id_user,'publisher_id'=>$id])->first();
    	if($item) return TRUE;
    	else return FALSE;
    }
    //resend mail publisher
    public function resendMail(){
    	$id=Input::get('id');
    	$item=$this->model->find($id);
    	
    	$currentPublisher=Sentry::getUser();
    	$currentPublisher->emailPubisher=$item->email;
    	
    	$data['item']=$item;
    	try{
            // send email
            $count = Mail::send(Config::get("auth.reminder.email"), $data, function($message) use ($currentPublisher) {                          
                $message->to($currentPublisher->email, $currentPublisher->emailPubisher)->subject("Send mail");                           
            });
            return 1;
        }catch(Exception $e){
            echo "<pre>".$e."</pre>";    
        }
        return 0;
    }

    public function showPdfTracfic($id){
    	$item=$this->model->find($id);
    	$filePdf=$item->traffic_report_file;
    	if($filePdf)
    		$this->data["linkPdf"]=URL::to('')."/".PUBLISHER_TRAFFIC_REPORT_FILE_PATH.$filePdf;
    	else $this->data["linkPdf"]="";
    	$this->layout=View::make('approve_publisher_manager.showPdfTracfic',$this->data);
    }
	/*----------------------------- DELETE --------------------------------*/
	//set again category
	public function setAgainCategory(){
		$id=Input::get('id');
		$cate=Input::get('cate');
		$item=$this->model->find($id);
		if($item){
			list($idCate,$nameCate)=explode(",", $cate[0]);
			$item->category=$idCate;
			$item->save();
			return 1;
		}
		return 0;
	}
	//
	function delete(){

		if( Request::ajax() ){
			$id 	= Input::get('id');
			$item 	= $this->model->find($id);
			if( $item ){
				if($item->delete()){
					return "success";
				}
			}
		}
		return "fail";

	}

	/*----------------------------- END DELETE --------------------------------*/

}