<?php
class PublisherBackendController extends BackendController {

	function __construct($module = NULL){
		$layout = "layout.default";
		parent::__construct($module, $layout);
		$this->updateData();
	}

	public function index(){
		return Redirect::route('PublisherDashboard');
	}

	public function getPublisher(){
		if( Session::get('reviewPid') ){
			return PublisherBaseModel::find(Session::get('reviewPid'));
		}else{
			if( $this->user ){
				return $this->user->publisher;
			}else{
				return FALSE;
			}
		}
	}

	public function updateData(){
		// get list flight website
		if($publisher = $this->getPublisher()){

			$websiteRange = $publisher->publisherSite->lists('id');
			$flightWebsite = new FlightWebsiteBaseModel();
			$lists = $flightWebsite->getListByRangeWebsite($websiteRange);

			if( !empty($lists) ){
				foreach( $lists as $item ){
					
				}
			}
		}

	}

}
