<?php

class MenuAdminController extends AdminController 
{

	public function __construct(Menus $model) {
		parent::__construct(pathinfo(dirname(__DIR__), PATHINFO_BASENAME));
		$this->model = $model;
		$this->modulePath = base_path()."/backend/modules/";
	}

	function showList(){
		$this->render();

		$this->data['defaultField'] = $this->defaultField;
		$this->data['defaultOrder'] = $this->defaultOrder;
		$this->data['defaultURL'] 	= $this->moduleURL;
		$this->data['searchField'] 	= $this->model->getSearchField();

		$this->layout->content = View::make('showList', $this->data);
	}

	/*----------------------------- CREATE & UPDATE --------------------------------*/
	function showUpdate($id = 0){

		$this->render();

		$this->data['status'] = (Session::has("status")) ? Session::get("status") : FALSE ;
		$this->data['message'] = (Session::has("message")) ? Session::get("message") : "" ;
		$this->data['id'] = $id;
		$this->data['modules'] = Modules::where('status', 1)->get();

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
			$this->postUpdate($id, $this->data);
			if( $this->data['status'] === TRUE ){
				return $this->redirectAfterSave(Input::get('save'), $this->data['message'], $this->data['status']);
			}
		}
		$this->layout->content = View::make('showUpdate', $this->data);

	}

	function postUpdate($id = 0, &$data){

		// check validate
		$validate 		= Validator::make(Input::all(), $this->model->UpdateRules, $this->model->UpdateLangs);

		if( $validate->passes() ){

			$updateData = array(
				'status'		=>	(int) Input::get('status'),
				'name'			=>	trim(Input::get('name')),
				'module_id'		=>	trim(Input::get('module')),
				'slug'			=>	trim(Input::get('slug')),
				'icon'			=>	trim(Input::get('icon')),
			);

			if( $id == 0 ){ // INSERT
				if( $item = $this->model->create($updateData) ){
					$data['status'] 	= TRUE;
					$data['id'] 		= $item->id;
				}
			}else{ // UPDATE
				if( $this->model->where("id",$id)->update($updateData) ){
					$data['status'] 		= TRUE;
				}
			}

		}else{
			$data['validate'] = $validate->messages();
		}

	}

	function showNestable(){


		$this->data['defaultURL'] 	= $this->moduleURL;
		$this->data['listMenus'] = $this->getMenu();

		$this->layout->content = View::make('ShowNestable', $this->data);
	}

	function getMenu(){
		$listMenusTMP 	= Menus::getList();
		$listMenus 		= array();

		if( !empty($listMenusTMP) ){

			foreach( $listMenusTMP as $lm ){
				if( $lm['parent_id'] == 0 ){
					$listMenus[$lm['id']] = $lm;
				}
			}

			foreach( $listMenusTMP as $lm ){
				if( $lm['parent_id'] != 0 ){
					$listMenus[$lm['parent_id']]['children'][] = $lm;
				}
			}

		}

		return $listMenus;

	}

	function postNestable(){

		$listMenus = Input::get('menu');
		$order = 0;

		if( !empty($listMenus) ){
			foreach( $listMenus as $id => $parent ){
				$order++;
				$menu = Menus::where('id', $id)->update(array('parent_id' => intval($parent), 'order' => $order));
			}
		}

		return Response::Json(TRUE);

	}

	function render(){

		$listModuleFile = array();
		$listIgnores = array(
			'dashboard',
			'home',
			'chat',
			'search',
			'.',
			'..',
			'.DS_Store',
			'.svn',
		);
		$primaryArray = array(
			'Create','Read','Edit','Delete'
		);
		$listFiles = array_diff(scandir( $this->modulePath ), $listIgnores);

		// GET LIST FILE IN FOLDER
		if( !empty($listFiles) ){
			foreach( $listFiles as $file ){
				$file = str_replace("_backend","", $file);
				
				$fileName = ucwords(str_replace("_"," ", $file));				
				$fileSlug = str_replace("_","-", $file);

				$listModuleFile[$fileSlug] = $fileName;
			}
		}

		// GET LIST FILE IN DATABASE
		$listModuleStore = Modules::get()->toArray();
		$listModuleStore = array_column($listModuleStore, 'name', 'slug');

		// NEW MODULE
		$diffInsert = array_diff($listModuleFile, $listModuleStore);
		$insertData = array();
		if( !empty($diffInsert) ){
			foreach( $diffInsert as $k => $v ){
				$insertData = array(
					'slug'	=>	$k,
					'name'	=>	$v,
					'status'	=>	1
				);

				if( $item = Modules::create($insertData) ){
					if($item->save()){

						// Insert Menu
						$menuInsert = array(
							'status'		=>	0,
							'name'			=>	$item->name,
							'module_id'		=>	$item->id,
							'slug'			=>	$item->slug.'/show-list',
						);
						Menus::create($menuInsert);

						// Create Primary Permission
						foreach($primaryArray as $p ){
							$primaryInsert = array(
								'name'			=>	$item->name." ".$p,
								'slug'			=>	$item->slug."-".strtolower($p),
								'module_id'		=>	$item->id,
								'action'		=>	strtolower($p)
							);
							Permission::create($primaryInsert);
						}
					}
				}

			}	
		}

		// REMOVE MODULE
		$diffRemove = array_diff($listModuleStore, $listModuleFile);

		if( !empty($diffRemove) ){
			foreach( $diffRemove as $k => $v ){
				$item = Modules::where(array('slug'	=>	$k,'name'	=>	$v))->first();

				$deleteID = $item->id;
				if( $item->delete() ){
					Menus::where('module_id', $deleteID)->delete();
					Permission::where('module_id', $deleteID)->delete();
				}
			}
		}

	}
	/*----------------------------- END CREATE & UPDATE --------------------------------*/

	/*----------------------------- DELETE --------------------------------*/

	function delete(){

		if( Request::ajax() ){
			$id 	= Input::get('id');
			$item 	= $this->model->find($id);
			if( $item ){
				$parent_id = $item->parent_id;
				if($item->delete()){
					if( $parent_id == 0 ){
						$this->model->where('parent_id', $id)->update(array(
							'parent_id'	=>	0
						));
					}
					return "success";
				}
			}
		}
		return "fail";

	}

	/*----------------------------- END DELETE --------------------------------*/

	
}
