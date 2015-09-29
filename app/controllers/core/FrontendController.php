<?php
class FrontendController extends BaseController {

	public $data = array();
	public $layout = 'layout.default';


	function __construct($module){
		if( !session_id() ){
			session_start();
		}


		// set Custom Pagination
		Config::set('view.pagination', 'frontend.partial.pagination');

		//set Theme
		$this->theme = Config::get('frontend.theme');

		// set module
		$this->module = $module;

		// no use layout master when ajax
		if(Request::ajax()){
			$this->layout = null;
		}

		View::share('assetURL', 'frontend/theme/'.$this->theme.'/assets/');

		// add Location View
		View::addLocation(base_path() .'/frontend/theme/'.$this->theme.'/views/'.$this->module);
		View::addLocation(base_path() .'/frontend/theme/'.$this->theme.'/views');

		// add Lang
		Lang::addNamespace($this->module, base_path() .'/frontend/modules/'.$this->module.'/lang');
	}
	
}
