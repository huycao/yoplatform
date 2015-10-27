<?php

class CampaignAdvertiserManagerController extends AdvertiserManagerController 
{

	public function __construct(CampaignAdvertiserManagerModel $model) {
		parent::__construct(pathinfo(dirname(__DIR__), PATHINFO_BASENAME));
		$this->model = $model;
	}	

	/**
	 *     trigger before show list render view
	 */	
	function beforeShowList(){
		$this->loadLeftMenu('menu.campaignList');
		View::share('jsTag',HTML::script("{$this->assetURL}js/select.js") . HTML::script("{$this->assetURL}js/preview.js"));

		// get list Category
		$categoryModel = new CategoryBaseModel;
		$this->data['listCategory'] = $categoryModel->getAllForm();

		// get list Sale Status
		$this->data['listSaleStatus'] = array('' =>	'-- Select Sale Status --') + Config::get('data.sale_status');

	}

	public function getListData(){

		if( !empty($this->searchData) ){
			$this->searchData = array_reindex($this->searchData,'name');
		}

		$this->data['lists'] = $this->model->with('advertiser','sale','country')
											->search($this->searchData)
											->orderBy($this->defaultField, $this->defaultOrder)
											->paginate($this->showNumber);
	}

	/**
	 *     add/update agency
	 *     @param  integer $id 
	 */
	function showUpdate($id = 0){
		$this->data['id'] = $id;

		View::share('jsTag',HTML::script("{$this->assetURL}js/select.js"));

		// get list country
		$countryModel = new CountryBaseModel;
		$this->data['listCountry'] = $countryModel->getAllForm();

		// get list Category
		$categoryModel = new CategoryBaseModel;
		$this->data['listCategory'] = $categoryModel->getAllForm();

		// get expected close month
		$this->data['listExpectedCloseMonth'] = getMonthRange();

		// get list Currency
		$currencyModel = new CurrencyBaseModel;
		$this->data['listCurrency'] = $currencyModel->getAllForm();

		// get list Sale Status
		$this->data['listSaleStatus'] = Config::get('data.sale_status');

		$this->loadLeftMenu('menu.campaignList');

		// WHEN UPDATE SHOW CURRENT INFORMATION
		if( $id != 0 ){
			$item = $this->model->with('agency','advertiser','sale', 'campaign_manager')->find($id);

			if( $item ){
				$this->data['item'] 		= $item;
				$this->loadLeftMenu('menu.campaignUpdate', array('item'=>$item));
			}else{
				return Redirect::to($this->moduleURL.'show-list');
			}
		}
		if (Request::isMethod('post'))
		{
			if( $this->postUpdate($id, $this->data) ){
                return Redirect::to($this->moduleURL.'view/'.$this->data['id']);
			}
		}
		$this->layout->content = View::make('showUpdate', $this->data);

	}

	/**
	 *     handle form add/update agency
	 *     @param  integer $id 
	 */
	function postUpdate($id = 0){
		// check validate
		$validate 		= Validator::make(Input::all(), $this->model->getUpdateRules(), $this->model->getUpdateLangs());

		if( $validate->passes() ){

			$updateData = array(
				'category_id'			=>	Input::get('category_id'),
				'agency_id'				=>	Input::get('agency_id'),
				'advertiser_id'			=>	Input::get('advertiser_id'),
				'contact_id'			=>	Input::get('contact_id'),
				'name'					=>	Input::get('name'),
				'campaign_manager_id'	=>	Input::get('campaign_manager_id'),
				'sale_status'			=>	Input::get('sale_status'),
				'status'				=>	Input::get('status'),
				'sale_id'				=>	Input::get('sale_id'),
				'expected_close_month'	=>	Input::get('expected_close_month'),
				'start_date'			=>	date('Y-m-d', strtotime(Input::get('start_date'))),
				'end_date'				=>	date('Y-m-d', strtotime(Input::get('end_date'))),
				'invoice_number'		=>	Input::get('invoice_number'),
                //'cost_type' => Input::get('cost_type'),
                'total_inventory' => Input::get('total_inventory'),
                'sale_revenue' => Input::get('sale_revenue'),
                //'retargeting_url' => Input::get('retargeting_url'),
                //'retargeting_show' => Input::get('retargeting_show'),
				'updated_by'			=>	$this->user->id
			);

			if( $id == 0 ){ // INSERT

				$updateData['created_by']	= $this->user->id;



                if( $item = $this->model->create($updateData) ){

					$this->data['id'] 		= $item->id;
					Session::flash('flash-message', 'Create Campaign Success !');
                    (new Delivery())->renewCache('campaign', $item->id);

                    //INPUT LOGS
                    $dataLog = array(
                        'title' => 'Create Campaign ID: ' . $item->id,
                        'content' => json_encode($updateData),
                        'type_task' => Request::segment(4)
                    );
                    $this->inputLogs($dataLog);
					return TRUE;
				}

			}else{ // UPDATE


				// GET CURRENT ITEM
				$item = $this->model->find($id);

				if( $item ){
					if( $this->model->where("id",$id)->update($updateData) ){
						Session::flash('flash-message', 'Update Campaign Success !');
                        (new Delivery())->renewCache('campaign', $item->id);
						
                        //INPUT LOGS
                        $dataLog = array(
                            'title' => 'Update Campaign ID: ' . $item->id,
                            'content' => json_encode($updateData),
                            'type_task' => Request::segment(4)
                        );
                        $this->inputLogs($dataLog);
						return TRUE;
					}
				}
			}

		}else{
			$this->data['errors'] = $validate->messages();
		}

		return FALSE;

	}

	public function showView($id){
		$item = $this->model->with('agency', 'flight', 'advertiser', 'sale', 'campaign_manager')->find($id);
		if( !$item ){
			return Redirect::to($this->moduleURL.'show-list');
		}

		$this->data['data'] = $item;
		$this->data['listSaleStatus'] = Config::get('data.sale_status');
		$this->loadLeftMenu('menu.campaignView', array('item'=>$item));
		$this->layout->content = View::make('showView', $this->data);
	}

	public function showReport($id){
		$item = $this->model->find($id);
		if( !$item ){
			return Redirect::to($this->moduleURL.'show-list');
		}
		$this->data['campaign']               = $item;
		// get list flight tracking
		$trackingSummaryModel             = new TrackingSummaryBaseModel;
		$this->data['listFlightTracking'] = $trackingSummaryModel->getFlightSummary($id);
		
		$listFlightChart                  = $trackingSummaryModel->getFlightChart($id)->toArray();
		
		$listDate                         = array();
		$listImpression                   = array();
		$listClick                        = array();

		if( !empty($listFlightChart) ){
			$listFlightChart = array_reverse($listFlightChart);

			foreach( $listFlightChart as $chart ){
				$listDate[]       = date('d/m/Y', strtotime($chart['date']));
				$listImpression[] = $chart['total_impression'];
				$listClick[]      = $chart['total_click'];
			}
		}

		$this->data['listDate']       = json_encode($listDate);
		$this->data['listImpression'] = json_encode($listImpression, JSON_NUMERIC_CHECK);
		$this->data['listClick']      = json_encode($listClick, JSON_NUMERIC_CHECK);
		$this->data['id']             =	$id;

		$this->layout->content = View::make('showReport', $this->data);
	}

	public function showFlightReport(){

		$range = Input::get('selected');
        if($range == null){
            return Redirect::to($this->moduleURL.'show-list');
        }
		$view = Input::get('view','normal');

		$flightModel = new FlightBaseModel;
		$this->data['listFlight'] = $flightModel->getByRangeId($range);
		$this->data['view'] = $view;
		$this->data['range'] = $range;
		$this->data['start_date_range'] = Input::get('start_date_range');
		$this->data['end_date_range'] =Input::get('end_date_range');
		$this->data['url'] = str_replace("&view=detail", "", URL::full());
        $start_date_range = "";
        $end_date_range = "";
        if($this->data['start_date_range'] != "" && $this->data['end_date_range'] != ""){
            $start_date_range = date("Y-m-d",strtotime($this->data['start_date_range']));
            $end_date_range = date("Y-m-d",strtotime($this->data['end_date_range']));
        }
		if( $view == "normal" ){
			$this->showFlightReportNormal($range);
		}else{
			$this->showFlightReportDetail($range,$start_date_range,$end_date_range);
		}

	}

	public function showFlightReportNormal($range){
        $trackingSummaryModel = new TrackingSummaryBaseModel;
		$this->data['listFlightTracking'] = $trackingSummaryModel->getListFlightTracking($range);
		$this->layout->content = View::make('showFlightReport', $this->data);
	}

	public function showFlightReportDetail($range,$start_date_range = "",$end_date_range = ""){
        $websites = Input::get('website');
        if($websites ==""){
            $websites = array();
        }
		$trackingSummaryModel = new TrackingSummaryBaseModel;
		$listswebsite = $trackingSummaryModel->getListsWebsite($range);
        $this->data['listswebsite'] = $listswebsite;
        $this->data['websites'] = $websites;
		$this->data['listWebsiteTracking'] = $trackingSummaryModel->getListWebsiteTracking($range,$websites,$start_date_range,$end_date_range);

		$this->layout->content = View::make('showFlightReportWebsite', $this->data);
	}


	public function reportExport(){

		$this->layout = null;
		$input = Input::all();
		if( !empty($input['option']) ){
			$options 	= $input['option'];
			$campaignId = $input['campaignId'];

			$flightModel = new FlightBaseModel;
			$campaignModel = new CampaignBaseModel;
			$trackingSummaryModel = new TrackingSummaryBaseModel;

			$campaign = $campaignModel->getCampaignById($campaignId);

			if( !empty($campaign) ){

				$range = $campaign->getListFlightId();
				$listFlight = $flightModel->getByRangeId($range);

				$excel = Excel::create($campaign->name);

				if( in_array("campaign", $options) ){
					$campaignTracking = $trackingSummaryModel->getCampaignTracking($range);
					$excel = $this->reportExportCampaign(
						$excel,
						array(
							'campaign'				=>	$campaign,
							'campaignTracking'		=>	$campaignTracking,
                            'filter'	=>	$input
						)
					);
				}

				if( in_array("flight", $options) ){

					$listFlightTracking = $trackingSummaryModel->getListFlightTracking($range);
					$excel = $this->reportExportFlight(
						$excel,
						array(
							'campaign'				=>	$campaign,
							'listFlight'			=>	$listFlight,
							'listFlightTracking'	=>	$listFlightTracking,
                            'filter'	=>	$input
						)
					);
				}

				if( in_array("website", $options) ){
					$listWebsiteTracking = $trackingSummaryModel->getListWebsiteTracking($range);
					$excel = $this->reportExportWebsite(
						$excel,
						array(
							'campaign'				=>	$campaign,
							'listFlight'			=>	$listFlight,
							'listWebsiteTracking'	=>	$listWebsiteTracking
						)
					);
				}

				$excel->export('xls');

			}else{
				return Redirect::to($this->moduleURL.'show-list');
			}


		}

	}

	public function reportExportFlight($excel, $data){

		$excel->sheet('Flight Report Summary', function($sheet) use($data) {
			$sheet->loadView('reportExportFlight', $data);
			$sheet->setColumnFormat(array(
			    'A' => '#,##0',
			    'B' => '#,##0',
			    'C' => '#,##0',
			    'E' => '#,##0',
			));				
		});		    

		return $excel;

	}

	public function reportExportCampaign($excel, $data){
		$excel->sheet('Campaign Report Summary', function($sheet) use($data) {
			$sheet->loadView('reportExportCampaign', $data);

			$sheet->setColumnFormat(array(
			    'A' => '#,##0',
			    'B' => '#,##0',
			    'C' => '#,##0',
			    'E' => '#,##0',
			));				
		});		    

		return $excel;

	}

	public function reportExportWebsite($excel, $data){

		$excel->sheet('Website Report Summary', function($sheet) use($data) {
			$sheet->loadView('reportExportWebsite', $data);

			$sheet->setColumnFormat(array(
			    'A' => '#,##0',
			    'B' => '#,##0',
			    'C' => '#,##0',
			    'E' => '#,##0',
			));
		});		   

		return $excel; 

	}


	/**
	 *     Delete Item of module
	 */
	function delete(){
		if( Request::ajax() ){
			$id 	= Input::get('id');
			$item 	= $this->model->find($id);
			if( $item ){
				if($item->delete()){
					return "success";
				}
			}
		}
		return "fail";
	}
    // Report date detail
    function getReportDateDetail(){
		$flight   = Input::get('flight');
		$campaign = Input::get('campaign');
		$ad       = Input::get('ad');
		$date     = Input::get('date');
		$typeapp  = Input::get('typeapp');
        if($typeapp == ""){
            $typeapp = 'hour';
        }
        $items['typeapp'] = $typeapp;
        $items['tracking'] = TrackingSummaryBaseModel::getDataPerDate($date,$campaign,$ad,$flight,$typeapp);
        
        return View::make("reportdate",$items);
    }
    // Report date website detail
    function getReportDateWebsiteDetail(){
        $flight 	= Input::get('flight');
        $campaign 	= Input::get('campaign');
        $ad 	= Input::get('ad');
        $start 	= Input::get('dstart');
        $end 	= Input::get('dend');
        $site 	= Input::get('site');

        $items['tracking'] = TrackingSummaryBaseModel::getDataPerWebsite($start,$end,$site,$campaign,$ad,$flight);

        return View::make("reportdateWebsite",$items);
    }
    
    public function showReportConversion($id){
		$item = $this->model->find($id);
		if( !$item ){
			return Redirect::to($this->moduleURL.'show-list');
		}
		$this->data['campaign']               = $item;
		
		$trackingConversionModel             = new TrackingConversionBaseModel;
		$this->data['listConversionTracking'] = $trackingConversionModel->getConversionSummary($id);
		$listConversionChart                  = $trackingConversionModel->getConversionChart($id)->toArray();

		$listDate                         = array();
		$listConversion                   = array();

		if( !empty($listConversionChart) ){
			foreach( $listConversionChart as $chart ){
				$listDate[]       = date('d/m/Y', strtotime($chart['date']));
				
				$listConversion[] = $chart['total_conversion'];
			}
		}

		$this->data['listDate']       = json_encode($listDate);
		$this->data['listConversion'] = json_encode($listConversion, JSON_NUMERIC_CHECK);
		$this->data['id']             =	$id;

		$this->layout->content = View::make('showReportConversion', $this->data);
	}
	
    public function showReportConversionDetail($conversionID = 0){
        if($conversionID == null){
            return Redirect::to($this->moduleURL.'show-list');
        }

		$conversionModel = new ConversionBaseModel();
		$this->data['conversion'] = $conversionModel->with('campaign')->find($conversionID);
		
		$this->data['conversionID'] = $conversionID;
		$this->data['start_date_range'] = Input::get('start_date_range');
		$this->data['end_date_range'] =Input::get('end_date_range');
		
        $start_date_range = "";
        $end_date_range = "";
        if($this->data['start_date_range'] != "" && $this->data['end_date_range'] != ""){
            $start_date_range = date("Y-m-d",strtotime($this->data['start_date_range']));
            $end_date_range = date("Y-m-d",strtotime($this->data['end_date_range']));
        }
		
		$this->layout->content = View::make('showReportConversionDetail', $this->data);
	}
	
    public function reportExportConversion(){

		$this->layout = null;
		$input = Input::all();
		if( !empty($input['cid']) ){
			$cids 	= $input['cid'];
			$campaignID = $input['campaign_id'];
            
			$trackingConversionModel = new TrackingConversionBaseModel;
			$campaign = CampaignBaseModel::find($campaignID);
			if (!empty($campaign) && '' != $campaign->name) {
			    $listConversionSummary = $trackingConversionModel->getConversionSummary($campaignID);
			    $excel = Excel::create("Report_Conversion_Of_{$campaign->name}");
			    $excel = $this->reportExportConversionCampaign(
					$excel,
					array(
					    'campaign'                    => $campaign,
						'listConversionSummary'		  => $listConversionSummary
					)
				);
			} else {
			    $excel = Excel::create('report_conversion');
			}
			
			foreach ($cids as $cid) {
			    $conversion = ConversionBaseModel::find($cid);
			    $listConversionTracking = $trackingConversionModel->where('conversion_id', $cid)->get();
			    if (!empty($listConversionTracking)) {
			        $excel = $this->reportExportConversionDetail(
						$excel,
						array(
						    'conversion'                    => $conversion,
							'listConversionTracking'		=> $listConversionTracking
						)
					);
			    }
			}
			$excel->export('xls');
		}
	}
	
    public function reportExportConversionDetail($excel, $data){
		$excel->sheet($data['conversion']->name, function($sheet) use($data) {
			$sheet->loadView('reportExportConversionDetail', $data);
			$sheet->setBorder('A2','dotted');
			$sheet->setBorder('B2','dotted');
			$sheet->setColumnFormat(array(
			    'A' => '#,##0',
			    'B' => '#,##0',
			));				
		});		    

		return $excel;

	}
	
    public function reportExportConversionCampaign($excel, $data){
		$excel->sheet('Summary', function($sheet) use($data) {
			$sheet->loadView('reportExportConversionCampaign', $data);
			$sheet->mergeCells('B2:D2');
			$sheet->setBorder('B2:D2','dotted');
			$sheet->setBorder('A2','dotted');
			$sheet->mergeCells('B3:D3');
			$sheet->setBorder('B3:D3','dotted');
			$sheet->setBorder('A3','dotted');
			$sheet->mergeCells('B4:D4');
			$sheet->setBorder('B4:D4','dotted');
			$sheet->setBorder('A4','dotted');
			$sheet->mergeCells('B5:D5');
			$sheet->setBorder('B5:D5','dotted');
			$sheet->setBorder('A5','dotted');
			$sheet->setColumnFormat(array(
			    'A' => '#,##0',
			    'B' => '#,##0',
			    'C' => '#,##0',
			    'E' => '#,##0',
			));						
		});		    

		return $excel;
	}
}
