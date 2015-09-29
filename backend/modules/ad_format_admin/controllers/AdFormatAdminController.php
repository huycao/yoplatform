<?php

class AdFormatAdminController extends AdminController 
{

	public function __construct(AdFormatAdminModel $model) {
		parent::__construct(pathinfo(dirname(__DIR__), PATHINFO_BASENAME));
		$this->model = $model;
	}	

	/**
	 *     trigger before show list render view
	 */
	function beforeShowList(){}

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

		// get list Type
		$this->data['listAdType'] = Config::get('data.ad_type');
		$this->data['listAdFormatType'] = Config::get('data.ad_format_type');
		


		// WHEN UPDATE SHOW CURRENT INFOMATION
		if( $id != 0 ){
			
			$item = $this->model->find($id);

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

			if( $id == 0 ){ // INSERT
				$item = $this->model;
				$item->created_by = $this->user->id;
			}else{ // UPDATE
				// GET CURRENT ITEM
				$item = $this->model->find($id);
			}

			$item->name 		= Input::get('name');
			$item->width 		= Input::get('width');
			$item->height 		= Input::get('height');
			$item->ad_view 		= Input::get('ad_view');
			$item->type 		= Input::get('type');
			$item->updated_by 	= $this->user->id;

			if( $item->save() ){
				$this->data['id'] 		= $item->id;
				return TRUE;
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
