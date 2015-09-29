<?php

class UserGroupAdminController extends AdminController 
{

	public function __construct(UserGroup $model) {
		parent::__construct(pathinfo(dirname(__DIR__), PATHINFO_BASENAME));
		$this->model = $model;
	}	

	/*----------------------------- CREATE & UPDATE --------------------------------*/
	function showUpdate($id = 0){

		$this->data['status'] = (Session::has("status")) ? Session::get("status") : FALSE ;
		$this->data['message'] = (Session::has("message")) ? Session::get("message") : "" ;
		$this->data['id'] = $id;

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

		$groupName = trim(Input::get('name'));

		if( $id == 0 ){
			try
			{
			    // Create the group
			    $group = Sentry::createGroup(array(
			        'name'        => $groupName
			    ));
			    $data['id'] 		= $group->id;
			    $data['status'] 	= TRUE;
			}
			catch (\Cartalyst\Sentry\Groups\NameRequiredException $e)
			{
				$data['message'] = "Vui lòng nhập tên nhóm";
			}
			catch (\Cartalyst\Sentry\Groups\GroupExistsException $e)
			{
				$data['message'] = "Tên nhóm đã tồn tại. Vui lòng nhập tên nhóm khác";
			}
		}else{

			try
			{
			    // Find the group using the group id
			    $group = Sentry::findGroupById($id);

			    // Update the group details
			    $group->name = $groupName;

			    if ($group->save())
			    {
			    	$data['status'] 			= TRUE;
			    }
			}
			catch (\Cartalyst\Sentry\Groups\NameRequiredException $e)
			{
				$data['message'] = "Vui lòng nhập tên nhóm";
			}
			catch (\Cartalyst\Sentry\Groups\GroupExistsException $e)
			{
				$data['message'] = "Tên nhóm đã tồn tại. Vui lòng nhập tên nhóm khác";
			}
			catch (\Cartalyst\Sentry\Groups\GroupNotFoundException $e)
			{
			    $data['message'] = "Nhóm không tồn tại";
			}

		}

	}

	function showPermission( $id ){

		$this->data['status'] = (Session::has("status")) ? Session::get("status") : FALSE ;
		$this->data['message'] = (Session::has("message")) ? Session::get("message") : "" ;
		$this->data['id'] = $id;

		
		// GET ALL PERMISSION
		$permissions = Permission::where('group_id', $id)->get()->toArray();
		$permissionMap = array();

		// GET ALL MODULE
		$moduleData = Modules::where('group_id', $id)->get()->toArray();

		if( !empty($permissions) ){
			foreach( $permissions as $permission ){
				$permissionMap[$permission['module_id']][] = $permission;
			}
		}

		if( !empty($moduleData) ){
			$moduleData = array_column($moduleData, 'name', 'id');
		}

		// GET USER PERMISSION
		$groupPermissions = Sentry::findGroupById($id)->getPermissions();
		$this->data['permissionMap'] 	= $permissionMap;
		$this->data['moduleData']		= $moduleData;
		$this->data['groupPermissions']	= $groupPermissions;

		if (Request::isMethod('post'))
		{
			$this->postPermission($id, $this->data);
			if( $this->data['status'] === TRUE ){
				return Redirect::to($this->moduleURL.'permission/'.$this->data['id']);
			}
		}

		$this->layout->content 			= View::make('showPermission', $this->data);

	}

	function postPermission( $id, &$data ){

		if( $groupData = Sentry::findGroupById($id) ){

			$allData = Input::all();
			if( isset( $allData['_token'] ) ){
				unset( $allData['_token'] );
			}
			$groupData->permissions = $allData;
			
			if($groupData->save()){
				$data['status'] 	= TRUE;
				$data['message'] 	= "Sửa quyền truy cập thành công";
			}
		}

	}

	/*----------------------------- END CREATE & UPDATE --------------------------------*/

	/*----------------------------- DELETE --------------------------------*/

	function delete(){

		if( Request::ajax() ){
			$id 	= Input::get('id');
			try
			{
			    $group = Sentry::findGroupById($id);
			    // Delete the group
			    if($group->delete()){
			    	return "success";
			    }
			}
			catch (\Cartalyst\Sentry\Groups\GroupNotFoundException $e)
			{
			    // echo 'Nhóm không tồn tại';
			    return "fail";
			}
			return "fail";
		}
		
	}

	/*----------------------------- END DELETE --------------------------------*/

}
