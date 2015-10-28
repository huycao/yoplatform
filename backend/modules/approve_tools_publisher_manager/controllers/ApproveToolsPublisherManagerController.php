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

	/**
	 * function name: paymentRequest
	 * @return mixed
	 */
	public function paymentRequest($status='', $page=1){
		$paymentReq = new PaymentRequestBaseModel;
		$options = array('status'=>$status);
		$this->data['status'] = $status;

		$publisher = Input::has('publisher') ? Input::get('publisher') : '';
		$month = Input::has('month') ? Input::get('month'): 0;
		$year = Input::has('year') ? Input::get('year'):0;
		$field = Input::has('field') ? Input::get('field'):'';
		$order = Input::has('order') ? Input::get('order'):'';

		$options['publisher'] = $publisher;
		$options['month'] = $month;
		$options['year'] = $year;
		$options['field'] = $field;
		$options['order'] = $order;

		$dataPaging['items'] = $paymentReq->getItems('',ITEM_PER_PAGE, $page, $options);
		$dataPaging['options'] = array('publisher'=>$publisher, 'month'=>$month, 'year'=>$year, 'field'=>$field, 'order'=>$order);
		if(Request::ajax()){
			return View::make('publisher_manager.approve_tools_publisher_manager.paymentRequestPaging', $dataPaging);
		}else{
			$this->data['listItems'] = View::make('publisher_manager.approve_tools_publisher_manager.paymentRequestPaging', $dataPaging);
		}
		$this->layout->content = View::make('publisher_manager.approve_tools_publisher_manager.paymentRequest', $this->data);
	}

	public function paymentRequestDetail($id){
		$model = new PaymentRequestDetailBaseModel;
		$data['payment'] = PaymentRequestBaseModel::find($id);
		$items = $model->getItemsByPaymentRequestId($id);
		$data['items'] = $items;
		$this->layout->content = View::make('publisher_manager.approve_tools_publisher_manager.paymentRequestDetail',$data);
	}

	public function changeStatusPaymentRequest(){
		$id = Input::has('id')?Input::get('id'):'';
		$status = Input::has('status') ? Input::get('status'):'';
		if($id!=""){
			$paymentRe = new PaymentRequestBaseModel();
			$paymentRe->updateItem($id, array('status'=>$status));
		}
	}
	/*----------------------------- END DELETE --------------------------------*/
}