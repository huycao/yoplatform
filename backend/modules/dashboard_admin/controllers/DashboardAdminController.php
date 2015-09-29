<?php

class DashboardAdminController extends AdminController 
{	

	public function __construct() {
		parent::__construct(pathinfo(dirname(__DIR__), PATHINFO_BASENAME));
	}


	public function showIndex()
	{
        $this->layout->content = View::make('index');
	}

}
