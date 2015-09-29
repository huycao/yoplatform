<?php
class PublisherManagerController extends BackendController {

	function __construct($module = NULL){
		$layout = "layout.default";
		parent::__construct($module, $layout);
	}

	public function index(){
		pr(__FUNCTION__,1);
		return Redirect::route('PublisherManagerDashboard');
	}

}
