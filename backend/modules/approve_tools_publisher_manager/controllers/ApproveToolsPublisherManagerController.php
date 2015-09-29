<?php

class ApproveToolsPublisherManagerController extends PublisherManagerController 
{

	public function __construct(PublisherBaseModel $model) {
		parent::__construct(pathinfo(dirname(__DIR__), PATHINFO_BASENAME));
		$this->model = $model;
		$this->layout = 'layout.indexPublisher';
	}

	
	
	public function getUploadPath( $dateString ){
		$filePath = PUBLISHER_TRAFFIC_REPORT_FILE_PATH.$dateString;
		newFolder($filePath);
		return $filePath;
	}
	
	

	/*----------------------------- END DELETE --------------------------------*/

}