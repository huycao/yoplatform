<?php

class AdFlightAdvertiserManagerController extends AdvertiserManagerController 
{

	public function __construct(AdFlightAdvertiserManagerModel $model) {
		parent::__construct(pathinfo(dirname(__DIR__), PATHINFO_BASENAME));
		$this->model = $model;
		$this->loadLeftMenu('menu.Ad');		
	}	

	/**
	 *     trigger before show list render view
	 */
	function beforeShowList(){
		View::share('jsTag',HTML::script("{$this->assetURL}js/select.js"));
		// get list ad type
		$this->data['listAdType'] = array('' =>	'-- Select Ad Type --') + Config::get('data.ad_type');
	}

	public function getListData(){
		$this->data['lists'] = $this->model
								->search($this->searchData)
								->orderBy($this->defaultField, $this->defaultOrder)
								->paginate($this->showNumber);
	}

	/**
	 *     add/update agency
	 *     @param  integer $id 
	 */
	function showUpdate($id = 0){


		$this->data['id'] = $id;

		View::share('jsTag',HTML::script("{$this->assetURL}js/select.js"));

		// get list Category
		$categoryModel = new CategoryBaseModel;
		$this->data['listCategory'] = $categoryModel->getAllForm(0);

		// get list Ad Format
		$AdFormatModel = new AdFormatBaseModel;
		$this->data['listAdFormat'] = $AdFormatModel->getAllForm();

		// get list Type
		$this->data['listAdType'] = Config::get('data.ad_type');

		// get list Wmode
		$this->data['listWmode'] = Config::get('data.wmode');


		// WHEN UPDATE SHOW CURRENT INFOMATION
		if( $id != 0 ){
			
			$item = $this->model->with('campaign','adFormat')->find($id);

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

			$campaignName 	= Input::get('campaign');
			$adFormatID = Input::get('ad_format_id');
			$adFormatName = AdFormatBaseModel::find($adFormatID)->name;


			$updateData = array(
				'campaign_id'					=>	Input::get('campaign_id'),
				'ad_format_id'					=>	Input::get('ad_format_id'),
				'type'							=>	Input::get('type'),
				'width'							=>	Input::get('width'),
				'height'						=>	Input::get('height'),
				'wmode'							=>	Input::get('wmode'),
				'source_url'					=>	Input::get('source_url'),
				'destination_url'				=>	Input::get('destination_url'),
				'updated_by'					=>	$this->user->id
			);

			if( !empty($campaignName) || !empty($adFormatName)  ){
				$updateData['name'] = $campaignName.' '.$adFormatName;
			}

			if( $id == 0 ){ // INSERT
				$updateData['created_by']	= $this->user->id;
				if( $item = $this->model->create($updateData) ){
					$this->data['id'] 		= $item->id;
					return TRUE;
				}
			}else{ // UPDATE
				// GET CURRENT ITEM
				$item = $this->model->find($id);

				if( $item ){
					if( $this->model->where("id",$id)->update($updateData) ){
						return TRUE;
					}
				}
			}

		}else{
			$this->data['errors'] = $validate->messages();
		}

		return FALSE;

	}

	public function showView($id){
		$item = $this->model->with('ad','flight')->find($id);
		if( !$item ){
			return Redirect::to($this->moduleURL.'show-list');
		}
		$this->data['data'] = $item;
		$this->layout->content = View::make('showView', $this->data);
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
