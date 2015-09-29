<?php

class AdvertiserAdvertiserManagerController extends AdvertiserManagerController 
{

	public function __construct(AdvertiserAdvertiserManagerModel $model) {
		parent::__construct(pathinfo(dirname(__DIR__), PATHINFO_BASENAME));
		$this->model = $model;
		$this->loadLeftMenu('menu.tool');
	}	

	/**
	 *     trigger before show list render view
	 */
	function beforeShowList(){
		// get list country
		$countryModel = new CountryBaseModel;
		$this->data['listCountry'] = $countryModel->getAllForm();
	}

	/**
	 *     add/update agency
	 *     @param  integer $id 
	 */
	function showUpdate($id = 0){
		$this->data['id'] = $id;

		// get list country
		$countryModel = new CountryBaseModel;
		$this->data['listCountry'] = $countryModel->getAllForm();

		// WHEN UPDATE SHOW CURRENT INFOMATION
		if( $id != 0 ){
			
			View::share('jsTag',HTML::script("{$this->assetURL}js/contact.js"));

			$item = $this->model->with('contact')->find($id);

			if( $item ){
				$this->data['item'] 		= $item;
			}else{
				return Redirect::to($this->moduleURL.'show-list');
			}
		}
		if (Request::isMethod('post'))
		{
			if( $this->postUpdate($id, $this->data) ){
				return $this->redirectAfterSave(Input::get('save'));
			}
		}

		$this->layout->content = View::make('showUpdate', $this->data);

	}

	/**
	 *     handle form add/update agency
	 *     @param  integer $id 
	 */
	function postUpdate($id = 0){
		// check validate
		$validate 		= Validator::make(Input::all(), $this->model->getUpdateRules(), $this->model->getUpdateLangs());

		if( $validate->passes() ){

			$updateData = array(
				'status'		=>	(int) Input::get('status'),
				'name'			=>	Input::get('name'),
				'country_id'	=>	Input::get('country'),
				'updated_by'	=>	$this->user->id
			);

			if( $id == 0 ){ // INSERT
				$updateData['created_by']	= $this->user->id;
				if( $item = $this->model->create($updateData) ){
					$this->data['id'] 		= $item->id;
                    Session::flash('flash-message', 'Create Advertiser Success!');
					return TRUE;
				}
			}else{ // UPDATE


				// GET CURRENT ITEM
				$item = $this->model->find($id);

				if( $item ){
					if( $this->model->where("id",$id)->update($updateData) ){
                    	Session::flash('flash-message', 'Update Advertiser Success!');
						return TRUE;
					}
				}
			}

		}else{
			$this->data['errors'] = $validate->messages();
		}

		return FALSE;

	}

	/**
	 *     Delete Item of module
	 */
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

}
