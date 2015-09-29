<?php
class AdvertiserManagerController extends BackendController {

	function __construct($module = NULL){
		$layout = "layout.default";
		parent::__construct($module, $layout);
	}

	public function index(){
		return Redirect::route('AdvertiserManagerDashboard');
	}
}
