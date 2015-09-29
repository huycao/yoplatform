<?php

class UserAdminController extends AdminController 
{
	public function __construct(User $model) {
		parent::__construct(pathinfo(dirname(__DIR__), PATHINFO_BASENAME));
		$this->model = $model;
	}	
	/**
	 * Action show user list.
	 */
	public function showList(){
		$this->data['groupList'] = UserGroup::all();
		parent::showList();
	}
	
	/**
	 * Rewrite function getListData for case filter.
	 */
	public function getListData(){
		$tempModel = $this->model;
		if(!empty($this->searchData)) {
			$searchData = $this->searchData;
			$tempModel= $tempModel->search($searchData);
			$i = 0;
			while (isset($searchData[$i])) {
				if(isset($searchData[$i]['name'])
					&&isset($searchData[$i]['value'])
				) {
					$groupName = $searchData[$i]['name'];
					$groupValue = $searchData[$i]['value'];

					if ($groupName == 'group') {
						if ($groupValue) {
							$tempModel = $tempModel
								->whereHas('groups',
									function($q) use ($groupValue) {
										$q->where('id', '=', $groupValue);
									}
								);
						}
					} elseif($groupName == 'activated') {
						$tempModel = $tempModel->where('activated', '=', $groupValue);
						if ($groupValue) {
							$tempModel = $tempModel->where('activated', '=', 1);
						} else {
							$tempModel = $tempModel->where('activated', '<>', 1);
						}
					} else {
						$tempModel = $tempModel
						->search(
							$groupValue,
							$groupName
						);
					}
				}
				$i ++;
			}
		}

        $this->data['lists'] = $tempModel
        ->orderBy($this->defaultField, $this->defaultOrder)
        ->paginate($this->showNumber);
    }

	/*----------------------------- LIST --------------------------------*/
	function changeStatus(){

		if( Request::ajax() ){

			$id = Input::get('id');
			$currentStatus = Input::get('status');
			$status = ( $currentStatus == 1 ) ? 0 : 1;

			$item = $this->model->find($id);

			if( $item ){
				// CHECK SUPER USER
				if( !$item->isSuperUser() ){
					$item->activated = $status;
					if( $item->save() ){
						return View::make('ajaxChangeStatus', array(
							'item'	=>	$item
						));
					}
				}
				// END SUPER USER
			}

		}

		return "fail";

	}
	/*----------------------------- END LIST --------------------------------*/

	/*----------------------------- CREATE & UPDATE --------------------------------*/
	function showUpdate($id = 0){

		$this->data['id'] = $id;
		$this->data['groups'] = UserGroup::get();

		// WHEN UPDATE SHOW CURRENT INFOMATION
		if( $id != 0 ){
			
			$item = $this->model->find($id);
			// CHECK SUPER USER
			if( $item->isSuperUser() ){
				return Redirect::to($this->moduleURL.'show-list');
			}
			// END SUPER USER

			$item->group = $item->getGroups()->lists('id');

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

	function postUpdate($id = 0, &$data){


		// check validate
		$username 	= trim(Input::get('username'));
		$password 	= trim(Input::get('password'));
		$groupID 	= Input::get('group');


		$UpdateRules = $this->model->getUpdateRules();

		if( $id != 0 ){
			if( empty($password) ){
				unset($UpdateRules['password']);
			}
		}
		$validate 		= Validator::make(Input::all(), $UpdateRules, $this->model->getUpdateLangs());


		if( $validate->passes() ){

			if( $id == 0 ){ // INSERT

				try{
				    $user = Sentry::createUser(array(
				        'username'  => $username,
				        'password'  => $password,
				        'activated' => TRUE,
				    ));

				    if (is_array($groupID)) {
				    	foreach ($groupID as $aGroupID) {
				    		if( $aGroupID != 0 && is_numeric($aGroupID) ){
						    	$groupItem = Sentry::findGroupById($groupID);
							    $user->addGroup($groupItem);
							}
				    	}
				    	// $user->save();
				    }
				    
					$data['id']				= $user->id;
					return TRUE;
				}
				catch (\Cartalyst\Sentry\Users\UserExistsException $e)
				{
				    $data['message'] = 'Tên đăng nhập đã tồn tại. Vui lòng nhập tên đăng nhập khác';
				}


			}else{ // UPDATE

				try
				{
					$userData = Sentry::findUserById($id);
					$userData->username = $username;
					$oldGroup = $userData->getGroups()->lists('id');

					if( !empty($password) ){
						$userData->password = $password;
					}

					if($userData->save()){
						if (!is_array($groupID)) {
							$groupID = array($groupID);
						}
						if(!empty($oldGroup)) {
							$oldGroupMustRm = array_diff($oldGroup, $groupID);
							foreach ($oldGroupMustRm as $aGroupID) {
								$aOldGroup = Sentry::findGroupById($aGroupID);
								$userData->removeGroup($aOldGroup);
							}
						} else {
							$oldGroup = array();
						}
						$newGroupMustAdd = array_diff($groupID, $oldGroup);
						foreach ($newGroupMustAdd as $aGroupID) {
							if( $aGroupID != 0 && is_numeric($aGroupID) ){
								$aNewGroup = Sentry::findGroupById($aGroupID);
								$userData->addGroup($aNewGroup);
							}
						}
						$data['id']			= $userData->id;
						return TRUE;
					}
				}
				catch (\Cartalyst\Sentry\Users\WrongPasswordException $e)
				{
					$messageArray['message'] = "Mật khẩu không chính xác";
				}
			}

		}else{
			$data['validate'] = $validate->messages();
		}

		return FALSE;

	}


	function showPermission( $id ){

		if($userData = Sentry::findUserById($id)){
			if( $userData->isSuperUser() ){
				return Redirect::to($this->moduleURL.'show-list');
			}
		}else{
			return Redirect::to($this->moduleURL.'show-list');
		}

		$this->data['status'] = (Session::has("status")) ? Session::get("status") : FALSE ;
		$this->data['message'] = (Session::has("message")) ? Session::get("message") : "" ;
		$this->data['id'] = $id;

		
		// GET ALL PERMISSION
		$permissions = Permission::get()->toArray();
		$permissionMap = array();

		// GET ALL MODULE
		$moduleData = Modules::get()->toArray();

		if( !empty($permissions) ){
			foreach( $permissions as $permission ){
				$permissionMap[$permission['module_id']][] = $permission;
			}
		}

		if( !empty($moduleData) ){
			$moduleData = array_column($moduleData, 'name', 'id');
		}

		// GET USER PERMISSION
		$userPermissions = Sentry::findUserById($id)->getPermissions();

		$this->data['permissionMap'] 	= $permissionMap;
		$this->data['moduleData']		= $moduleData;
		$this->data['userPermissions']	= $userPermissions;

		if (Request::isMethod('post'))
		{
			$this->postPermission($id,$userData, $this->data);
			if( $this->data['status'] === TRUE ){
				return Redirect::to($this->moduleURL.'permission/'.$this->data['id']);
			}
		}

		$this->layout->content 			= View::make('showPermission', $this->data);

	}

	function postPermission( $id, $userData, &$data ){

		$allData = Input::all();
		if( isset( $allData['_token'] ) ){
			unset( $allData['_token'] );
		}

		$userData->permissions = array();
		$userData->permissions = $allData;
		
		if($userData->save()){
			$data['status'] 	= TRUE;
		}

	}


	/*----------------------------- END CREATE & UPDATE --------------------------------*/

	/*----------------------------- DELETE --------------------------------*/

	function delete(){

		if( Request::ajax() ){
			$id 	= Input::get('id');
			$item 	= $this->model->find($id);
			if( $item ){

				// CHECK SUPER USER
				if( !$item->isSuperUser() ){
					if($item->delete()){
						return "success";
					}					
				}
				// END SUPER USER

			}
		}
		return "fail";

	}

	/*----------------------------- END DELETE --------------------------------*/


	public function changePassword()
	{
		if (Request::isMethod('post'))
		{
			$this->data['status'] = FALSE;
			$this->data['message'] = "";
			$this->postChangePassword( $this->data );
		}
        $this->layout->content = View::make('changePassword', $this->data);
	}

	public function postChangePassword( &$messageArray )
	{	
		$validate = Validator::make(Input::all(), User::$changePasswordRules, User::$changePasswordLangs);
		if( $validate->passes() )
		{
			$oldPassword = Input::get('oldPassword');
			$newPassword = Input::get('newPassword');
			try
			{
				$userData = Sentry::findUserByCredentials(array(
			        'username'      => Sentry::getUser()->username,
			        'password'   	=> $oldPassword
			    ));
				$userData->password = $newPassword;
				if($userData->save()){
					$messageArray['status'] 	= TRUE;
					$messageArray['message'] 	= "Đổi mật khẩu thành công";
				}else{
					$messageArray['message'] 	= "Đã có lỗi xảy ra trong quá trình đổi mật khẩu. Bạn vui lòng thử lại sau";
				}
			}
			catch (\Cartalyst\Sentry\Users\WrongPasswordException $e)
			{
				$messageArray['message'] = "Mật khẩu không chính xác";
			}
		}
		else
		{
			$messageArray['validate'] = $validate->messages();
		}
	}

}
