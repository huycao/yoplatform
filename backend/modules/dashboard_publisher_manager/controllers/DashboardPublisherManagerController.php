<?php

class DashboardPublisherManagerController extends PublisherManagerController 
{	

	public function __construct() {
		parent::__construct(pathinfo(dirname(__DIR__), PATHINFO_BASENAME));
	}


	public function showIndex()
	{
        // $this->layout->content = View::make('index');
       // return Redirect::to(Route('ApprovePublisherManagerShowList'));
	}

	public function showListDashboard(){
		if(Request::ajax()){
			
			return View::make('ajaxShowList', $this->data);

		}	
	}
	
}
