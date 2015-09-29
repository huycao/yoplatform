<?php

class BackendController extends BaseController {

    /**
     *     Module name
     *     @var string
     */
    public $module;

    /**
     *     Module Segment
     *     @var string
     */
    public $moduleSegment;

    /**
     *     Model controller used
     */
    public $model;

    /**
     *     URL link to Module
     *     @var string
     */
    public $moduleURL;

    /**
     *     Section of backend
     *     @var string
     */
    public $section;

    /**
     *     Folder name of section
     *     @var [type]
     */
    public $sectionFolder;

    /**
     *     Folder name of module
     *     @var [type]
     */
    public $moduleFolder;

    /**
     *     asset url
     */
    public $assetURL;

    /**
     *     Default field sort in list
     *     @var string
     */
    public $defaultField 		= 'created_at';

    /**
     *     Default type sort in list
     *     @var string
     */
    public $defaultOrder 		= 'desc';

    /**
     *     Theme folder of layout
     *     @var [type]
     */
    public $theme;

    /**
     *     Current user access to system
     *     @var [type]
     */
    public $user;

    /**
     *     Store Data in view
     *     @var array
     */
    public $data = array();

    /**
     *     Store error form
     *     @var array
     */
    public $errors = array();

    public function __construct($module, $layout){
        if (session_id() == '') {
            @session_start();
        }

        //CUSTOM PAGINATION BACKEND
        Config::set('view.pagination', 'partials.pagination');

        // set section name by segment
        $this->section = Request::segment(2);

        // set folder name of section
        $this->sectionFolder = str_replace("-", "_", $this->section);

        // set user
        $this->user = Sentry::getUser();

        if( $this->user ){
            $this->beforeFilter(function(){
                if(  !$this->checkUserSection() ){
                    return $this->logout();
                }
            });
        }

        // set module name
        $this->moduleName = $module;

        // share global module route prefix
        View::share('moduleRoutePrefix', Str::studly($module));

        // set module name by segment
        $this->moduleSegment = Request::segment(3);

        // set folder name of module
        $this->moduleFolder = str_replace("-", "_", $this->moduleName);

        // set url of module
        $this->moduleURL = URL::to('/').'/'.Config::get('backend.uri').'/'.$this->section.'/'.$this->moduleSegment.'/';


        // set theme
        $this->theme = Config::get('backend.theme');

        // set asset url
        $this->assetURL = url().'/backend/theme/'.$this->theme.'/assets/';

        // set view path for autoload
        View::addLocation(base_path() .'/backend/theme/'.$this->theme.'/views/'.$this->sectionFolder.'/'.$this->moduleFolder);
        View::addLocation(base_path() .'/backend/theme/'.$this->theme.'/views/'.$this->sectionFolder);
        View::addLocation(base_path() .'/backend/theme/'.$this->theme.'/views/general');
        View::addLocation(base_path() .'/backend/theme/'.$this->theme.'/views');

        // set asset url for all view
        View::share('assetURL', $this->assetURL);

        // Set lang namespace
        Lang::addNamespace("backend", base_path() .'/backend/lang');
        Lang::addNamespace($this->moduleSegment, base_path() .'/backend/modules/'.$this->moduleFolder.'/lang');

        // no use layout master when ajax
        if(Request::ajax()){
            $this->layout = null;
        }else{
            $this->layout = View::make($layout);
        }
    }

    /**
     *     Redirect after save data when add/update
     *     @param  string $type
     */
    function redirectAfterSave($type){

        switch ($type) {
            case 'save-return':
                return Redirect::to($this->moduleURL.'show-list');
                break;

            case 'save-new':
                return Redirect::to($this->moduleURL.'create');
                break;

            case 'save':
                return Redirect::to($this->moduleURL.'update/'.$this->data['id']);
                break;
                	
            default:
                return Redirect::to($this->moduleURL.'show-list');
                break;
        }
    }

    /**
     *     List item of module
     */
    function showList(){
        $this->data['defaultField'] = $this->defaultField;
        $this->data['defaultOrder'] = $this->defaultOrder;
        $this->data['defaultURL'] 	= $this->moduleURL;

        if( method_exists($this, 'beforeShowList') ){
            $this->beforeShowList();
        }
        if(!empty($this->layout))
            $this->layout->content = View::make('showList', $this->data);
        else
            return View::make('showList', $this->data)->render();
    }

    /**
     *     Handle Ajax list item of module
     */
    function getList(){
        if(Request::ajax()){
            $this->defaultField 	= Input::get('defaultField');
            $this->defaultOrder 	= Input::get('defaultOrder');
            $this->searchData 		= Input::get('searchData');
            $this->showNumber 		= Input::get('showNumber');
            $this->isReset 			= Input::get('isReset');

            $this->data['defaultField'] = $this->defaultField;
            $this->data['defaultOrder'] = $this->defaultOrder;
            $this->data['defaultURL'] 	= $this->moduleURL;

            if( method_exists($this, 'beforeGetList') ){
                $this->beforeGetList();
            }else{
                $this->data['showField'] 	= $this->model->getShowField();
            }

            if( $this->isReset == 1 ){
                Paginator::setCurrentPage(1);
            }
            $this->getListData();
            return View::make('ajaxShowList', $this->data);
        }
    }

    public function getListData(){
        $this->data['lists'] = $this->model->search($this->searchData)
        ->orderBy($this->defaultField, $this->defaultOrder)
        ->paginate($this->showNumber);
    }


    /**
     *     Load left menu
     *     @param  string $viewName
     *     @return Response
     */
    public function loadLeftMenu($viewName, $data = array()){
        if( !Request::ajax() ){
            $this->layout->left = View::make($viewName, $data);
        }
    }

    function changeBooleanType(){

        if( Request::ajax() ){
            $id 			= Input::get('id');
            $field 			= Input::get('field');
            $currentValue 	= Input::get('value');

            $value = ( $currentValue == 1 ) ? 0 : 1;

            $item = $this->model->find($id);
            if( $item ){
                $item->{$field} = $value;
                if( $item->save() ){
                    return View::make('ajaxChangeBooleanType', array(
						'field'	=>	$field,
						'item'	=>	$item
                    ));
                }
            }
        }

    }

    function uploadImageFTP($name, $dirUpload, $imgName, $width = 0, $height = 0){
        if(Input::hasFile($name)){

            $input = Input::file($name);

            $fileExtension = strtolower($input->getClientOriginalExtension());
            $fileExtension = $fileExtension == 'jpeg' ? 'jpg' : $fileExtension;
            $realPath = $input->getRealPath();

            if( $width != 0 && $height != 0 ){
                $uploadFile = Image::make($input)->resize($width, $height)->save($realPath);
            }

            $MyFTP = new MyFTP();
            $uploadSuccess = $MyFTP->uploadFtp($dirUpload, $realPath, $imgName.'.'.$fileExtension);
            if( $uploadSuccess ){
                return $imgName.'.'.$fileExtension;
            }else{
                return FALSE;
            }
        }else{
            return FALSE;
        }
    }

    public function login()
    {

        $this->layout = NULL;

        if (Request::isMethod('post'))
        {
            if( $this->postLogin() ){
                $_SESSION['isLoggedIn'] 	= TRUE;
                return Redirect::route(Str::studly($this->sectionFolder).'Dashboard');
            }
        }

        return View::make('layout.login', $this->data);
    }

    public function postLogin(){

        $validate = Validator::make(Input::all(), User::$loginRules, User::$loginLangs);

        if( $validate->passes() )
        {
            try {
                $remember = FALSE;
                $dataLogin = array(
					'username'	=>	Input::get("loginUsername"),
					'password'	=>	Input::get("loginPassword")
                );

                Sentry::authenticate($dataLogin, $remember);

            } catch (\Cartalyst\Sentry\Users\WrongPasswordException $e) {
                $this->data['message'] = "username or password not correct";
            } catch (\Cartalyst\Sentry\Users\UserNotFoundException $e) {
                $this->data['message'] = "username or password not correct";
            } catch (\Cartalyst\Sentry\Users\UserNotActivatedException $e) {
                $this->data['message'] = "username or password not correct";
            }


            $this->user = Sentry::getUser();

            if( $this->checkUserSection() ){
                return TRUE;
            }else{
                $this->data['message'] = "username or password not correct";
                if( $this->user ){
                    Sentry::logout();
                    Session::flush();
                    $_SESSION = array();
                    @session_destroy();
                    Session::regenerateToken();
                }
                return FALSE;
            }
        }
        else
        {
            $this->data['validate'] = $validate->messages();
        }

        return FALSE;
    }

    public function getUserGroupID(){
        if( $this->user ){
            $group = $this->user->getGroups();
            if( !$group->isEmpty() ){
                return $group->lists('id');
            }
        }
        return FALSE;
    }

    public function getSectionGroupID(){
        switch ($this->section) {
            case Config::get('backend.group_admin_url'):
                return Config::get('backend.group_admin_id');
                break;
            case Config::get('backend.group_publisher_manager_url'):
                return Config::get('backend.group_publisher_manager_id');
                break;
            case Config::get('backend.group_advertiser_manager_url'):
                return Config::get('backend.group_advertiser_manager_id');
                break;
            case Config::get('backend.group_publisher_url'):
                return Config::get('backend.group_publisher_id');
                break;
            case Config::get('backend.group_advertiser_url'):
                return Config::get('backend.group_advertiser_id');
                break;
        }
    }

    public function checkUserSection(){
        if( is_array( $listGroup = $this->getUserGroupID() ) ){
            if( in_array(Config::get('backend.group_advertiser_manager_id'), $this->getUserGroupID()) && Session::has('reviewUid') && Session::has('reviewPid') ){
                return TRUE;
            }else{
                return in_array($this->getSectionGroupID(), $this->getUserGroupID());
            }
        }
        return FALSE;
    }

    public function logout(){
        Sentry::logout();
        Session::flush();
        $_SESSION = array();
        @session_destroy();
        Session::regenerateToken();
        return Redirect::route(Str::studly($this->sectionFolder).'Login');
    }

    public function getAccessDenied(){
        $this->layout->content = View::make('denied');
    }

    //get user list of an group
    function getListUser(){
        if(Request::ajax()){
            $this->user=new User;
            $defaultField 	= 'users.'.Input::get('defaultField');
            $defaultOrder 	= Input::get('defaultOrder');
            $searchData 	= Input::get('searchData');
            $showNumber 	= Input::get('showNumber');
            $isReset 		= Input::get('isReset');

            $this->data['defaultField'] = str_replace("users.", "", $defaultField);
            $this->data['defaultOrder'] = $defaultOrder;
            $this->data['defaultURL'] 	= $this->moduleURL;
            $this->data['showField'] 	= $this->user->getShowFieldUser();

            if( $isReset == 1 ){
                Paginator::setCurrentPage(1);
            }
            //get id group
            $idGroup=['2','4'];

            $this->data['lists'] = User::ShowListUser($searchData)->whereIn('groups.id',$idGroup)->orderBy($defaultField, $defaultOrder)->paginate($showNumber);
            	
            return View::make('manager_user.ajaxShowList', $this->data);
        }
    }
    //show list user
    public function showUserList(){
        $this->data['defaultField'] = $this->defaultField;
        $this->data['defaultOrder'] = $this->defaultOrder;
        $this->data['defaultURL'] 	= $this->moduleURL;

        $this->layout->content=View::make('manager_user.showUsersList',$this->data);
    }


    function delete(){
        if( Request::ajax() ){
            $id     = Input::get('id');
            $item   = $this->model->find($id);
            if( $item ){
                if($item->delete()){
                    return "success";
                }
            }
        }
        return "fail";
    }
    //delete user
    function deleteUser(){
        if( Request::ajax() ){
            $id 	= Input::get('id');
            $item 	= User::find($id);
            if( $item ){
                if($item->delete()){
                    return "success";
                }
            }
        }
        return "fail";

    }
    //change stauts user
    function changeStatusUser(){

        if( Request::ajax() ){
            $id 			= Input::get('id');
            $field 			= Input::get('field');
            $value 			= Input::get('value');
            $setValue		= ($value == 0) ? 1 : 0;
            $setText		= ($value == 0) ? "Off" : "Active";
            $setClass		= ($value == 0) ? "text-warning" : "text-success";
            $setClassI		= ($value == 0) ? "glyphicon glyphicon-remove" : "glyphicon glyphicon-ok";
            	
            $userData = Sentry::findUserById($id);
            if( $userData ){
                $userData->activated = $value;
                $userData->save();
                if( $userData->save() ){
                    return '<a href="javascript:;" class="'.$setClass.'" onclick="changeBooleanType('.$userData->id.', '.$setValue.','."'".$field."'".')">
					<span class="'.$setClassI.'"></span> '.$setText.'
					</a>';
                }
            }
        }

    }
    ///my profile

    public function myProfile(){
        //get list country
        $countryModel = new CountryBaseModel;
        $this->data['itemCountry'] = $countryModel->getAll();

        $this->data['item'] = $this->user;
        $id=$this->user->id;
        if (Request::isMethod('post')) {

            // check validate
            $validate = Validator::make(Input::all(), User::getUpdateUserRules(), User::getUpdateUserLangs());
            $flag=$this->checkValidatePass($this->data);
            if ($validate->passes() && $flag==TRUE) {
                $username = Input::get('username');
                $password = Input::get('re-password');
                $firstName= Input::get('first_name');
                $lastName = Input::get('last_name');
                $email    = Input::get('email');
                $address  = Input::get('address');
                $country  = Input::get('country');
                $phone    = Input::get('phone');
                $contact_phone=Input::get('contact_phone');

                try
                {
                    $userData = Sentry::findUserById($id);
                    $userData->username = $username;
                    if($password !=""){
                        $userData->password = $password;
                    }
                    $userData->email 		= $email;
                    $userData->first_name 	= $firstName;
                    $userData->last_name 	= $lastName;
                    $userData->address 		= $address;
                    $userData->country_id 	= $country;

                    $userData->phone 		= $phone;
                    $userData->phone_contact 	= $contact_phone;

                    if($userData->save()){
                        $data['id']			= $userData->id;
                        $messages=trans("backend::publisher/text.update_success");
                        Session::flash('mess',$messages);
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

        $this->layout->content = View::make('manager_user.myProfile', $this->data);
    }

    public function checkValidatePass(&$data){
        $flag_check_pass=Input::get('flag_check_pass');
        if($flag_check_pass==0) return TRUE;

        $password=Input::get('password');
        $rePassword=Input::get('re-password');

        if($password==""){
            $data['msgPass']=trans('backend::publisher/validation.password.required');
            return FALSE;
        }
        if($rePassword==""){
            $data['msgRePass']=trans('backend::publisher/validation.c-password.required');
            return FALSE;
        }
        if($password!=$rePassword){
            $data['msgRePass']=trans('backend::publisher/validation.c-password.same');
            return FALSE;
        }

        return TRUE;
    }

    //update & insert user
    function showUpdateUser($id = 0) {
        $this->data['id'] = $id;
        //get list country
        $countryModel = new CountryBaseModel;
        $this->data['itemCountry'] = $countryModel->getAll();
        // WHEN UPDATE SHOW CURRENT INFOMATION
        if ($id != 0) {
            $item = User::select('users.*','groups.id as groups_id')
            ->join('users_groups','users_groups.user_id','=','users.id')
            ->join('groups','groups.id','=','users_groups.group_id')
            ->where('users.id',$id)->first();
            //pr($item,1);
            if ($item) {
                $this->data['item'] = $item;
            } else {
                return Redirect::to($this->moduleURL . 'users-list');
            }
        }

        if (Request::isMethod('post')) {
            if ($this->postUpdateUser($id, $this->data)) {
                if($id != 0){
                    $messages=trans("backend::publisher/text.update_success");
                    $LastUrl='update/'.$id;
                }
                else{
                    $messages=trans("backend::publisher/text.insert_success");
                    $LastUrl='create';
                }
                Session::flash('mess',$messages);
                return Redirect::to($this->moduleURL .$LastUrl);

            }
        }

        $this->layout->content = View::make('manager_user.showUpdate', $this->data);
    }

    function postUpdateUser($id = 0, &$data) {
        // check validate
        $validate = Validator::make(Input::all(), User::getUpdateUserRules(), User::getUpdateUserLangs());
        $flag=$this->checkValidatePass($this->data);
        if ($validate->passes() && $flag==TRUE) {
            $username = Input::get('username');
            $password = Input::get('re-password');
            $groupID  = (int)Input::get('role');
            $firstName= Input::get('first_name');
            $lastName = Input::get('last_name');
            $activated= Input::get('status');
            $email    = Input::get('email');
            $address  = Input::get('address');
            $country  = Input::get('country');
            $phone    = Input::get('phone');
            $contact_phone=Input::get('contact_phone');

            if( $id == 0 ){ // INSERT

                try{
                    	
                    $user = Sentry::createUser(array(
				        'username'  => $username,
				        'password'  => $password,
				        'first_name'=> $firstName,
				        'last_name' => $lastName,
				        'email'  	=> $email,
				        'activated' => TRUE,
				        'address' 		=> $address,
						'country_id' 	=> $country,
						'phone' 		=> $phone,
						'phone_contact' => $contact_phone,
                    ));

                    if( $groupID != 0 && is_numeric($groupID) ){
                        $groupItem = Sentry::findGroupById($groupID);
                        $permissions = $groupItem->getPermissions();
                        $user->addGroup($groupItem);
                        $user->permissions = $permissions;
                        $user->save();
                    }
                    $data['id']				= $user->id;
                    return TRUE;
                }
                catch (\Cartalyst\Sentry\Users\UserExistsException $e)
                {
                    $data['message'] = 'Login name already exists. Please enter the log in different';
                }

            }else{ // UPDATE

                try
                {

                    $userData = Sentry::findUserById($id);
                    $userData->username = $username;
                    if($password!=""){
                        $userData->password = $password;
                    }
                    $userData->email 		= $email;
                    $userData->first_name 	= $firstName;
                    $userData->last_name 	= $lastName;
                    $userData->activated 	= $activated;

                    $userData->address 		= $address;
                    $userData->country_id 	= $country;
                    $userData->phone 		= $phone;
                    $userData->phone_contact 	= $contact_phone;

                    if( $groupID != 0 && is_numeric($groupID) ){
                        $groupItem = Sentry::findGroupById($groupID);
                        $permissions = $groupItem->getPermissions();
                        $userData->addGroup($groupItem);
                        $userData->permissions = $permissions;
                    }

                    if($userData->save()){
                        $data['id']			= $userData->id;
                        return TRUE;
                    }
                }
                catch (\Cartalyst\Sentry\Users\WrongPasswordException $e)
                {
                    $data['message'] = "Passwords do not exactly";
                }
            }
        } else {
            $data['validate'] = $validate->messages();
        }

        return FALSE;
    }

    /*----------------------------- END LIST --------------------------------*/

    /*--------------- LOG ACTION -----------------*/

    function inputLogs( $dataLog ){

        $date = new DateTime;
        $data = array(
            'module'	=> Request::segment(3),
            'type_task'	=> $dataLog['type_task'],
            'username'	=> Sentry::getUser()->email,
            'ipaddress'	=> Request::getClientIp(),
            'title'		=> $dataLog['title'],
            'content'	=> $dataLog['content'],
            'created_at'=> $date
        );

        if (isset($dataLog['pre_content'])) {
            $data['pre_content'] = $dataLog['pre_content'];
        }

        LogsBaseModel::insert($data);

    }

    /**
     * 
     * Revert data
     * @param $id
     */
    function revert($id) {
        $dataLog = LogsBaseModel::find($id);
       
        if ('update' == $dataLog->type_task && strlen($dataLog->pre_content) > 0) {
            $preContent = json_decode($dataLog->pre_content, true);
            $class = Str::studly($dataLog->module). Str::studly(Request::segment(2)).'Model';
            $model = new $class;
             
            if ($model->where('id',$preContent['id'])->update($preContent)) {
                Session::flash('flash-message', 'Revert Success !');
            }
        }

        return Redirect::to($this->moduleURL . 'show-list');
    }
}
