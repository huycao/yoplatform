<?php

class FlightPublisherAdvertiserManagerController extends AdvertiserManagerController 
{

	public function __construct(FlightPublisherAdvertiserManagerModel $model, FlightAdvertiserManagerModel $flightModel) {
		parent::__construct(pathinfo(dirname(__DIR__), PATHINFO_BASENAME));
		$this->model = $model;
		$this->flightModel = $flightModel;
		$this->loadLeftMenu('menu.tool');
	}	

	/**
	 *     trigger before show list render view
	 */
	function beforeShowList(){

		$this->loadLeftMenu('menu.flightList');
		View::share('jsTag',HTML::script("{$this->assetURL}js/select.js"));

		// get list Category
		$categoryModel = new CategoryBaseModel;
		$this->data['listCategory'] = array('' =>	'-- Select Channel --') + $categoryModel->getAllForm(0,0,'Run of Network');

		// get list Model
		$this->data['listModel'] = array('' =>	'-- Select Model --') + Config::get('data.flight_model');
	}

	public function getListData(){

		$this->data['lists'] = $this->flightModel->with('campaign','publisher','publisherSite','publisher_ad_zone')
											->where('type','adnetwork')
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

		// get list Category
		$categoryModel = new CategoryBaseModel;
		$this->data['listCategory'] = $categoryModel->getAllForm(0,0,'Run of Network');

		// get list Flight Objective
		$this->data['listFlightObjective'] = Config::get('data.flight_objective');

		$this->loadLeftMenu('menu.flightList');

		// WHEN UPDATE SHOW CURRENT INFOMATION
		if( $id != 0 ){

			$this->loadLeftMenu('menu.flightUpdate');
			
			$item = $this->model->with('category','campaign','publisher','publisherSite','publisher_ad_zone')->find($id);

			if( $item ){
				$this->data['item'] 		= $item;
			}else{
				return Redirect::to($this->moduleURL.'show-list');
			}
		}
		if (Request::isMethod('post'))
		{
			if( $this->postUpdate($id, $this->data) ){
				return $this->redirectAfterSave(Input::get('save'));
			}
		}

		$this->layout->content = View::make('showUpdate', $this->data);

	}

	/**
	 *     handle form add/update agency
	 *     @param  integer $id 
	 */
	function postUpdate($id = 0){

		if( Input::get('category_id') == 0 ){
			Input::merge(
				array(
					'publisher_id'	=>	0,
					'publisher_site_id'	=>	0,
					'publisher_ad_zone_id'	=>	0
				)
			);
		}

		// check validate
		$validate 		= Validator::make(Input::all(), $this->model->getUpdateRules(), $this->model->getUpdateLangs());

		if( $validate->passes() ){

			$section                   = Input::get('publisher_site');
			$zone                      = Input::get('publisher_ad_zone');
			$campaignId                = Input::get('campaign_id');
			$costAfterAgencyCommission = str_replace(',', '', Input::get('cost_after_agency_commission'));
			$publisherCost             = str_replace(',', '', Input::get('publisher_cost'));
			$totalInventory            = Input::get('total_inventory');
			$baseMediaCost             = Input::get('base_media_cost');
			$mediaCost                 = Input::get('media_cost');
			$costAfterDiscount         = Input::get('cost_after_discount');
			$discount                  = Input::get('discount');
			$agencyCommission          = Input::get('agency_commission');
			$advalueCommission         = Input::get('advalue_commission');
			$realBaseMediaCost         = Input::get('real_base_media_cost');
			$realMediaCost             = Input::get('real_media_cost');

			$updateData = array(
				'campaign_id'					=>	$campaignId,
				'category_id'					=>	Input::get('category_id'),
				'publisher_id'					=>	Input::get('publisher_id'),
				'publisher_site_id'				=>	Input::get('publisher_site_id'),
				'publisher_ad_zone_id'			=>	Input::get('publisher_ad_zone_id'),
				'flight_objective'				=>	Input::get('flight_objective'),
				'allow_over_delivery_report'	=>	Input::get('allow_over_delivery_report'),
				'remark'						=>	Input::get('remark'),
				'date'							=>	json_encode(Input::get('date')),
				'day'							=>	Input::get('day'),
				'cost_type'						=>	Input::get('cost_type'),
				'total_inventory'				=>	Input::get('total_inventory'),
				'value_added'					=>	Input::get('value_added'),
				'base_media_cost'				=>	$baseMediaCost,
				'media_cost'					=>	$mediaCost,
				'real_media_cost'				=>	$realMediaCost,
				'real_base_media_cost'			=>	$realBaseMediaCost,
				'discount'						=>	$discount,
				'cost_after_discount'			=>	Input::get('cost_after_discount'),
				'total_cost_after_discount'		=>	str_replace(',', '', Input::get('total_cost_after_discount')),
				'agency_commission'				=>	$agencyCommission,
				'cost_after_agency_commission'	=>	$costAfterAgencyCommission,
				'advalue_commission'			=>	$advalueCommission,
				'publisher_cost'				=>	$publisherCost,
				'updated_by'					=>	$this->user->id
			);
	
			// store sale id from campaign
			$campaign = CampaignBaseModel::find($campaignId);
			$updateData['sale_id'] = $campaign->sale_id;

			if( empty($section) || empty($zone)  ){
				$updateData['name'] = 'Run of Network - '.strtoupper(Input::get('cost_type'));
			}else{
				$updateData['name']	= $section.' - '.$zone;
			}

			// publisher base cost
			$updateData['publisher_base_cost'] = $publisherCost/$totalInventory;

			// total profit
			$updateData['total_profit'] = $costAfterAgencyCommission - $publisherCost;

			// company profit
			$updateData['sale_profit'] = ($realMediaCost - $realBaseMediaCost) * $totalInventory;

			// sale profit
			$updateData['company_profit'] = $updateData['total_profit'] - $updateData['sale_profit'];


			if( $id == 0 ){ // INSERT
				$updateData['created_by']	= $this->user->id;
				if( $item = $this->model->create($updateData) ){
					$this->data['id'] 		= $item->id;
					return TRUE;
				}
			}else{ // UPDATE
				// GET CURRENT ITEM
				$item = $this->model->find($id);

				if( $item ){
					if( $this->model->where("id",$id)->update($updateData) ){
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
		$this->loadLeftMenu('menu.flightView');
		$item = $this->model->with('category','campaign','publisher','publisherSite','publisher_ad_zone','ad')->find($id);
		if( !$item ){
			return Redirect::to($this->moduleURL.'show-list');
		}
		$this->data['data'] = $item;
		$this->layout->content = View::make('showView', $this->data);
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

}
