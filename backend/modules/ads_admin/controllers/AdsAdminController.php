<?php

class AdsAdminController extends AdminController 
{

    public function __construct(User $model) {
        parent::__construct(pathinfo(dirname(__DIR__), PATHINFO_BASENAME));
        $this->model = $model;
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
                            'item'  =>  $item
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

            $item->group = $item->getGroups()->first();

            if( $item ){
                $this->data['item']         = $item;
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
        $username   = trim(Input::get('username'));
        $password   = trim(Input::get('password'));
        $groupID    = Input::get('group');


        $UpdateRules = $this->model->getUpdateRules();

        if( $id != 0 ){
            if( empty($password) ){
                unset($UpdateRules['password']);
            }
        }
        $validate       = Validator::make(Input::all(), $UpdateRules, $this->model->getUpdateLangs());


        if( $validate->passes() ){

            if( $id == 0 ){ // INSERT

                try{
                    $user = Sentry::createUser(array(
                        'username'  => $username,
                        'password'  => $password,
                        'activated' => TRUE,
                    ));

                    if( $groupID != 0 && is_numeric($groupID) ){
                        $groupItem = Sentry::findGroupById($groupID);
                        $permissions = $groupItem->getPermissions();
                        // dump_exit($permissions);
                        $user->addGroup($groupItem);
                        $user->permissions = $permissions;
                        $user->save();
                    }
                    $data['id']             = $user->id;
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
                    $oldGroup = $userData->getGroups()->first();

                    if( !empty($password) ){
                        $userData->password = $password;
                    }

                    if($userData->save()){
                        if( $oldGroup != NULL){
                            if( $groupID != $oldGroup->id  ){
                                $userData->removeGroup($oldGroup);
                                if( $groupID != 0 && is_numeric($groupID) ){
                                    $newGroup = Sentry::findGroupById($groupID);
                                    $permissions = $newGroup->getPermissions();
                                    $userData->addGroup($newGroup);
                                    $userData->permissions = $permissions;
                                    $userData->save();
                                }
                            }
                        }else{
                            if( $groupID != 0 && is_numeric($groupID) ){
                                $newGroup = Sentry::findGroupById($groupID);
                                $userData->addGroup($newGroup);
                            }
                            
                        }


                        $data['id']         = $userData->id;
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


    /*----------------------------- END CREATE & UPDATE --------------------------------*/


}
