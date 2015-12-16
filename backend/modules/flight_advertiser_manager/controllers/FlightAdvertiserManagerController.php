<?php

class FlightAdvertiserManagerController extends AdvertiserManagerController {

    public function __construct(FlightBaseModel $model) {
        parent::__construct(pathinfo(dirname(__DIR__), PATHINFO_BASENAME));
        $this->model = $model;
        $this->loadLeftMenu('menu.tool');
    }

    /**
     *     trigger before show list render view
     */
    function beforeShowList() {

        $this->loadLeftMenu('menu.flightList');
        View::share('jsTag', HTML::script("{$this->assetURL}js/select.js") . HTML::script("{$this->assetURL}js/preview.js"));

        // get list Category
        $categoryModel = new CategoryBaseModel;
        $this->data['listCategory'] = array('' => '-- Select Channel --') + $categoryModel->getAllForm(0, 0, 'Run of Network');

        // get list Model
        $this->data['listModel'] = array('' => '-- Select Model --') + Config::get('data.flight_model');
    }

    public function getListData() {
        $this->data['lists'] = $this->model->with('campaign', 'publisherSite', 'publisher_ad_zone')
        ->search($this->searchData)
        ->orderBy($this->defaultField, $this->defaultOrder)
        ->paginate($this->showNumber);
    }

    /**
     *     add/update agency
     *     @param  integer $id
     */
    function showUpdate($id = 0) {
        $this->data['id'] = $id;

        View::share('jsTag', HTML::script("{$this->assetURL}js/select.js") . HTML::script("{$this->assetURL}js/flight.js"));

        // get list Category
        $categoryModel = new CategoryBaseModel;
        $this->data['listCategory'] = $categoryModel->getAllForm(0, 0, 'Run of Network');
        $this->data['listEvent'] = array('' =>	'Metric for Frequency Capping') + Config::get('data.event');

        // get list Flight Objective
        //$this->data['provinceLists'] = ProvinceBaseModel::orderBy('order', 'asc')->get();

        // get list Flight Objective
        $this->data['listFlightObjective'] = Config::get('data.flight_objective');

        // get list flight type
        $this->data['listFlightType'] = Config::get('data.flight_type');
        $this->data['getdate'] = Input::get('date', array());

        //--Start--Phuong-VM add 05-05-2015
        $geoModel = new GeoBaseModel();
        $this->data['countryList'] = $geoModel->getCountry();
        $this->data['countrySelected'][] = 'VN';
        //--End--Phuong-VM add 05-05-2015

        //$campaignRetargetingSelected = array();

        $this->loadLeftMenu('menu.flightList');
        //$campaignRange = json_encode(array());
        
        // WHEN UPDATE SHOW CURRENT INFOMATION
        if (Request::isMethod('get')) {
            $this->data['listKeyword'] = array();
            $this->data['audiences'] = array();
            if ($id != 0) {
    
                $this->loadLeftMenu('menu.flightUpdate');
    
                $item = $this->model->with('category', 'ad', 'campaign', 'publisherSite', 'publisher_ad_zone')->find($id);

                if ($item) {
                    //--Start--Phuong-VM add 05-05-2015
                    $this->data['countrySelected'] = json_decode($item->country);
                    $this->data['provinceLists'] = $geoModel->getRegionByCountry($this->data['countrySelected']);
                    //--End--Phuong-VM add 05-05-2015
                    $this->data['provinceSelected'] = json_decode($item->province);
                    $this->data['ageSelected'] = json_decode($item->age);
                    $this->data['item'] = $item;
                    $this->data['getdate'] = $item->getDate;
                    $this->data['gettime'] = $item->getTime();                    
                    if (!empty($item->filter)) {
                        $this->data['listKeyword'] = explode(',', $item->filter);
                    }
    
                    /*if( !empty($item->campaign_retargeting) && $item->campaign_retargeting != "null" ){
                        $campaignRange = $item->campaign_retargeting;
                        $campaignRetargetingSelected = CampaignBaseModel::whereIn('id',json_decode($item->campaign_retargeting))->lists('name','id');
                    }*/
    
                } else {
                    return Redirect::to($this->moduleURL . 'show-list');
                }
            }
        } else {
            $this->data['countrySelected'] = Input::get('selected_country');
            $this->data['provinceLists'] = $geoModel->getRegionByCountry($this->data['countrySelected']);
            $this->data['provinceSelected'] = Input::get('selected_province');
            /*$campaign_retargeting_selected = Input::get('campaign-retargeting-selected',array());
            if (!empty($campaign_retargeting_selected)) {
                $campaignRetargetingSelected = CampaignBaseModel::whereIn('id',Input::get('campaign-retargeting-selected'))->lists('name','id');
            }*/
        }
        
        /*$this->data['campaignRange'] = $campaignRange;
        $this->data['campaignRetargetingSelected'] = $campaignRetargetingSelected;*/

        if (Request::isMethod('post')) {
            if ($this->postUpdate($id, $this->data)) {
                return Redirect::to($this->moduleURL.'view/'.$this->data['id']);
            }
        }

        $this->layout->content = View::make('showUpdate', $this->data);
    }

    /**
     *     handle form add/update agency
     *     @param  integer $id
     */
    function postUpdate($id = 0) {
        // if (Input::get('type') == 'adnetwork') {
        //     Input::merge(
        //             array(
        //                 'publisher_site_id' => 0,
        //                 'publisher_ad_zone_id' => 0
        //             )
        //     );
        // }

        // check validate
        $validate = Validator::make(Input::all(), $this->model->getUpdateRules(), $this->model->getUpdateLangs());

        if ($validate->passes()) {

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
            $retargeting_show             = Input::get('retargeting_show');
            $retargeting_url             = Input::get('retargeting_url');
            $retargeting_number             = Input::get('retargeting_number');
            $listKeyword               = Input::get('list_keyword', array());

            //use retargeting
            $retargeting = Input::get('use_retargeting', 2);
            if($retargeting == 1){
                $operator = Input::get('operator');
                $audience_id = Input::get('audience_id');
                
                if($operator!='' && $audience_id!=''){
                    $audience = json_encode(array('operator'=>$operator, 'audience_id'=>$audience_id));    
                }else{
                    $audience = "";
                }
            }else{
                $audience = "";
            }

            $updateData = array(
                'campaign_id'                  => $campaignId,
                'type'                         => Input::get('type'),
                'status'                       => Input::get('status'),
                'name'                         => Input::get('name'),
                'category_id'                  => Input::get('category_id'),
                'publisher_site_id'            => Input::get('publisher_site_id'),
                'publisher_ad_zone_id'         => Input::get('publisher_ad_zone_id'),
                //'remark'                       => Input::get('remark'),
                'date'                         => json_encode(Input::get('date')),
                'hour'                         => json_encode(Input::get('time')),
                'end_hour'                     => Input::get('end_hour'),
                //'frequency_cap'                => Input::get('frequency_cap'),
                //'frequency_cap_free'           => Input::get('frequency_cap_free'),
                //'frequency_cap_time'           => Input::get('frequency_cap_time'),
                'ad_id'                        => Input::get('ad_id'),
                //'campaign_retargeting'         => json_encode(Input::get('campaign-retargeting-selected')),
                'day'                          => Input::get('day'),
                //--Start--Phuong-VM add 05-05-2015
                'country'                     => json_encode(Input::get('selected_country')),
                //--End--Phuong-VM add 05-05-2015
                'province'                     => json_encode(Input::get('selected_province')),
                'age'                          => json_encode(Input::get('selected_age')),
                'sex'                          => Input::get('sex'),
                'cost_type'                    => Input::get('cost_type'),
                //--Phuong-VM -- add -- 11-05-2015
                'event'                   	   => Input::get('event'),
                'use_retargeting'              => Input::get('use_retargeting', 2),
                'total_inventory'              => Input::get('total_inventory'),
                'value_added'                  => Input::get('value_added'),
                'base_media_cost'              => $baseMediaCost,
                'media_cost'                   => $mediaCost,
                'real_media_cost'              => $realMediaCost,
                'real_base_media_cost'         => $realBaseMediaCost,
                'discount'                     => $discount,
                'cost_after_discount'          => Input::get('cost_after_discount'),
                'total_cost_after_discount'    => str_replace(',', '', Input::get('total_cost_after_discount')),
                'agency_commission'            => $agencyCommission,
                'cost_after_agency_commission' => $costAfterAgencyCommission,
                'advalue_commission'           => $advalueCommission,
                'publisher_cost'               => $publisherCost,
                'retargeting_url'               => $retargeting_url,
                'retargeting_show'               => $retargeting_show,
                'retargeting_number'               => $retargeting_number,
                'updated_by'                   => $this->user->id,
                //'filter'                       => !empty($listKeyword) ? implode(',', $listKeyword) : NULL,
                'filter'                       => trim(Input::get('keyword')),
                'audience'                     => $audience
            );

            // store sale id from campaign
            $campaign              = CampaignBaseModel::find($campaignId);
            $updateData['sale_id'] = $campaign->sale_id;

            // if (empty($section) || empty($zone)) {
            //     $updateData['name'] = 'Run of Network - ' . strtoupper(Input::get('cost_type'));
            // } else {
            //     $updateData['name'] = $section . ' - ' . $zone;
            // }

            // publisher base cost
            // $updateData['publisher_base_cost'] = $publisherCost / $totalInventory;

            // total profit
            $updateData['total_profit'] = $costAfterAgencyCommission - $publisherCost;

            // company profit
            $updateData['sale_profit'] = ($realMediaCost - $realBaseMediaCost) * $totalInventory;

            // sale profit
            $updateData['company_profit'] = $updateData['total_profit'] - $updateData['sale_profit'];

            $adModel = new AdBaseModel;

            $ad = null;
            if( Input::get('ad_id') ){
                $ad = $adModel->find(Input::get('ad_id'));
                $updateData['ad_format_id'] = $ad->ad_format_id;
            }

            //--Start--Phuong-VM add 05-05-2015
            $provinceList = Input::get('province');
            $provinceSelectedList = Input::get('selected_province');
            //--End--Phuong-VM add 05-05-2015
            if ($id == 0) { // INSERT

                if( !empty($ad) ){
                    $ad->is_select = 1;
                    $ad->save();
                }

                $updateData['created_by'] = $this->user->id;
                if ($item = $this->model->create($updateData)) {
                    $this->data['id'] = $item->id;

                    // if( $item->type == 'premium' ){
                    //     $flightWebsite = new FlightWebsiteBaseModel;
                    //     $this->cloneToFlightPublisher($item, $flightWebsite);
                    // }

                    foreach (Input::get('date') as $date) {
                        $flight_date = new FlightDateBaseModel();
                        $flight_date->flight_id = $item->id;
                        $flight_date->start = date('Y-m-d', strtotime($date['start']));
                        $flight_date->end = date('Y-m-d', strtotime($date['end']));
                        $flight_date->diff = $date['diff'];
                        
                        //--Start--Phuong-VM add 08-05-2015
                        if (isset($date['time'])&&!empty($date['time'])) {
                            $flight_date->hour = json_encode($date['time']);
                        }
                        $flight_date->frequency_cap = $date['frequency_cap'];
                        $flight_date->frequency_cap_time = $date['frequency_cap_time'];
                        
                        $flight_date->daily_inventory = $date['daily_inventory'];
                        $flight_date->created_by = $flight_date->updated_by = $this->user->id;
                        //--End--Phuong-VM add 08-05-2015
                        
                        $flight_date->save();
                    }

                    Session::flash('flash-message', 'Create Flight Success !');
                    (new Delivery())->renewCache('flight', $item->id);

                    //INPUT LOGS
                    $dataLog = array(
                        'title' => 'Create Flight ID: ' . $item->id,
                        'content' => json_encode($updateData),
                        'type_task' => Request::segment(4)
                    );
                    $this->inputLogs($dataLog);

                    return TRUE;
                }
            } else { // UPDATE
                // GET CURRENT ITEM
                $item = $this->model->find($id);
                
                if ($updateData['use_retargeting'] == 2) {
                    $updateData['retargeting_url'] = NULL;
                    $updateData['retargeting_show'] = NULL;
                    $updateData['retargeting_number'] = NULL;
                }
                
                if ( $updateData['retargeting_show'] == 2) {
                    $updateData['retargeting_number'] = NULL;
                }

                if( !empty($ad) ){
                    if( $item->ad_id != $ad->id ){
                        $ad->is_select = 1;
                        $ad->save();

                        $oldAd = $adModel->find($item->ad_id);
                        if( $oldAd ){
                            $oldAd->is_select = 0;
                            $oldAd->save();
                        }

                    }

                }
                
                $arrTmp = FlightDateBaseModel::where('flight_id', $id)->select('id')->get()->toArray();
                $oldFlightDate = array();
                foreach ($arrTmp as $oldDate) {
                    $oldFlightDate[$oldDate['id']] = $oldDate['id'];
                }
                
                foreach (Input::get('date') as $date) {
                    $flight_date = new FlightDateBaseModel();
                    //if(!isset($date['id'])){
                    if(isset($date['id'])){
                        $flight_date = $flight_date->find($date['id']);
                        unset($oldFlightDate[$date['id']]);
                        $flight_date->updated_by = $this->user->id;
                    } else {
                        $flight_date->created_by = $flight_date->updated_by = $this->user->id;
                    }
                    $flight_date->flight_id = $id;
                    $flight_date->start = date('Y-m-d', strtotime($date['start']));
                    $flight_date->end = date('Y-m-d', strtotime($date['end']));
                    $flight_date->diff = $date['diff'];
                    
                    //--Start--Phuong-VM add 08-05-2015
                    if (!empty($date['time'])) {
                        $flight_date->hour = json_encode($date['time']);
                    } else {
                        $flight_date->hour = '';
                    }
                    $flight_date->frequency_cap = $date['frequency_cap'];
                    $flight_date->frequency_cap_time = $date['frequency_cap_time'];
                    $flight_date->daily_inventory = $date['daily_inventory'];
                    
                    //--End--Phuong-VM add 08-05-2015
                    
                    $flight_date->save();
                    //}
                }
                
                if (!empty($oldFlightDate)) {
                    FlightDateBaseModel::destroy($oldFlightDate);
                }

                if ($item) {
                    (new Delivery())->removeCache('flight', $id);
                    if ($item->update($updateData)) {
                        // if( $item->type == 'premium' ){
                        //     $flightWebsite = FlightWebsiteBaseModel::where(array(
                        //         'publisher_id'  =>  $item->publisher_id,
                        //         'flight_id'     =>  $item->id,
                        //         'type'          =>  'premium'
                        //     ))->first();

                        //     if( empty($flightWebsite) ){
                        //         $flightWebsite = new FlightWebsiteBaseModel;
                        //     }
                        //     $this->cloneToFlightPublisher($item, $flightWebsite);
                        // }

                        (new Delivery())->renewCache('flight', $item->id);


                        Session::flash('flash-message', 'Update Flight Success !');


                        //INPUT LOGS
                        $dataLog = array(
                            'title'     => 'Update Flight ID: ' . $item->id,
                            'content'   => json_encode($updateData),
                            'type_task' => Request::segment(4)
                        );
                        $this->inputLogs($dataLog);


                        return TRUE;
                    }
                }

                (new Delivery())->renewCache('flight', $id);

            }
        } else {
            $this->data['errors'] = $validate->messages();
        }

        return FALSE;
    }

    public function cloneToFlightPublisher($flight, $flightWebsite){

        $flightWebsite->flight_id             = $flight->id;
        $flightWebsite->website_id            = $flight->publisher_site_id;
        $flightWebsite->type                  = 'premium';
        $flightWebsite->total_inventory       = $flight->total_inventory;
        $flightWebsite->value_added           = $flight->value_added;
        // $flightWebsite->publisher_base_cost   = $flight->publisher_base_cost;
        $flightWebsite->publisher_cost        = $flight->publisher_cost;
        $flightWebsite->total_profit          = $flight->total_profit;
        $flightWebsite->sale_profit           = $flight->sale_profit;
        $flightWebsite->company_profit        = $flight->company_profit;
        $flightWebsite->updated_by            = $this->user->id;
        if( empty($flightWebsite->id) ){
            $flightWebsite->created_by        = $this->user->id;
        }

        // pr($flightWebsite->total_inventory, 1);

        $flightWebsite->save();
        (new Delivery())->renewCache('flight', $flight->id);
    }

    public function showView($id) {
        $this->loadLeftMenu('menu.flightView');
        $item = $this->model->with('category', 'campaign', 'publisherSite', 'publisher_ad_zone', 'ad')->find($id);
        if (!$item) {
            return Redirect::to($this->moduleURL . 'show-list');
        }
        $this->data['data'] = $item;
        $this->layout->content = View::make('showView', $this->data);
    }

    public function ShowSelectWebsite($id) {
        $this->loadLeftMenu('menu.flightView');

        View::share('jsTag', HTML::script("{$this->assetURL}js/select.js") . HTML::script("{$this->assetURL}js/flight.js"));
        $item = $this->model->with('category', 'campaign', 'publisherSite', 'publisher_ad_zone', 'ad')->find($id);
        if (!$item) {
            return Redirect::to($this->moduleURL . 'show-list');
        }
        $this->data['data'] = $item;
        $this->layout->content = View::make('showSelectWebsite', $this->data);
    }

    /**
     *     Load Modal Add/Edit Publisher
     *     @param  integer  $id
     *     @return Response
     */
    public function loadModal(){
        if( Request::ajax() ){
            
            $id             = Input::get('id');
            $websiteId    = Input::get('websiteId');
            $websiteName  = Input::get('websiteName');
            $flightId       = Input::get('flightId');


            $status     = TRUE;
            $view       = NULL;

            $this->data['websiteId']        = $websiteId;
            $this->data['websiteName']      = $websiteName;
            $this->data['flightId']         = $flightId;
            $this->data['id']               = $id;

            // check if flightPublisher exist
            $flightWebsite = FlightWebsiteBaseModel::where('flight_id', $flightId)->where('website_id', $websiteId)->first();

            if( $id == 0 ){
                if($flightWebsite){
                    $status = FALSE;
                }else{
                    $view = View::make('websiteModal', $this->data)->render();
                }
            }else{
                if($flightWebsite){
                    $this->data['data'] = $flightWebsite;
                    $view = View::make('websiteModal', $this->data)->render();
                }
            }

            return Response::json(array(
                'status'    =>  $status,
                'view'      =>  $view
            ));

        }
    }

    public function addAllWebsite(){

        $status     = TRUE;
        $view       = NULL;

        $flightId       = Input::get('flightId');
        $flightData = FlightBaseModel::find($flightId);
        // get all website
        $listWebsite = PublisherSiteBaseModel::where('status',1)->lists('id');
        if( !empty($listWebsite) ){
            foreach( $listWebsite as $websiteId ){
                // check flightWebsite exist
                $exist = FlightWebsiteBaseModel::where(array(
                    'flight_id' =>  $flightId,
                    'website_id'    =>  $websiteId
                ))->first();
                if( empty($exist) ){
                    $item = new FlightWebsiteBaseModel();
                    $item->flight_id        = $flightId;
                    $item->website_id       = $websiteId;
                    $item->type             = 'adnetwork';
                    $item->created_by       = $this->user->id;
                    $item->updated_by       = $this->user->id;
                    $item->status           = 1;
                    $item->save();
                    (new Delivery())->renewCache('flight_website', $item->id);
                }
            }
        }

        $this->data['flightWebsiteList'] = $flightData->flightWebsite;
        $this->data['totalInventory'] = $flightData->total_inventory;
        $view = View::make('websiteList', $this->data)->render();

        return Response::json(array(
            'status'    =>  $status,
            'view'      =>  $view
        ));
    }


    /**
     * Store a newly created resource in storage.
     * @param  array Form Data
     * @return Response
     */
    public function updateWebsite(){
        if( Request::ajax() ){

            $status     = FALSE;
            $message    = NULL;
            $view       = NULL;

            $id             = Input::get('id');
            $flightId       = Input::get('flightId');
            $websiteId      = Input::get('websiteId');
            $isActive         = Input::get('status');
            $totalInventory = Input::get('total_inventory');
            $valueAdded     = Input::get('value_added');
            $publisherBaseCost  = Input::get('publisher_base_cost');
            $notApply = Input::get('not_apply');
            
            if ($notApply) {
                $valueAdded = -1;
            }
            $flightData = FlightBaseModel::find($flightId);

            if( $id == 0 ){

                $item = new FlightWebsiteBaseModel();
                $item->flight_id        = $flightId;
                $item->website_id       = $websiteId;
                $item->type             = 'adnetwork';
                $item->created_by       = $this->user->id;
            }else{
                $item = FlightWebsiteBaseModel::find($id);
            }

            $item->status              = $isActive;
            $item->total_inventory     = $totalInventory;
            $item->value_added         = $valueAdded;
            $item->publisher_base_cost = $publisherBaseCost;
            $item->updated_by          = $this->user->id;

            if( $item->save() ){
                (new Delivery())->renewCache('flight_website', $item->id);
                $status = TRUE;

                $this->data['flightWebsiteList'] = $flightData->flightWebsite;
                $this->data['totalInventory'] = $flightData->total_inventory;
                $view = View::make('websiteList', $this->data)->render();


            }


            return Response::json(array(
                'status'    =>  $status,
                'message'   =>  $message,
                'view'      =>  $view
            ));

        }
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function deleteWebsite(){

        if( Request::ajax() ){

            $id         = Input::get('id');
            $status     = FALSE;
            $view       = NULL;

            $item = FlightWebsiteBaseModel::find($id);

            if( $item ){
                $flightId = $item->flight_id;
                $flightData = FlightBaseModel::find($flightId);

                if( $item->delete() ){
                    (new Delivery())->renewCache('flight_website', $item->id);
                    $status = TRUE;
                    $this->data['flightWebsiteList'] = $flightData->flightWebsite;
                    $this->data['totalInventory'] = $flightData->total_inventory;
                    $view = View::make('websiteList', $this->data)->render();
                }
            }


            return Response::json(array(
                'status'    =>  $status,
                'view'      =>  $view
            ));

        }
    }

    /**
     *     Delete Item of module
     */
    function delete() {
        if (Request::ajax()) {
            $id = Input::get('id');
            $item = $this->model->find($id);
            if ($item) {
                if ($item->delete()) {
                    (new Delivery())->renewCache('flight', $id);

                    return "success";
                }
            }
        }
        return "fail";
    }

    function flightdatedelete() {
        if (Request::ajax()) {
            $id = $_POST['fid'];
            $item = FlightDateBaseModel::find($id);

            if ($item) {
                $flight = FlightBaseModel::find($item->flight_id);
                $flight->day = $flight->day - $item->diff;
                $flight->save();
				(new Delivery())->renewCache('flight', $item->flight_id);
                $item->delete();
                (new Delivery())->renewCache('flight_date', $item->flight_id);
            }
        }
    }
    
    /**
     *     Order
     *     @param  integer $id
     */
    function showOrder($id = 0) {
        $item =  new AdFlightAdvertiserManagerModel;
        $data = $item->where('flight_id',$id)->orderby('order', 'ASC')->get();
        $this->data['data'] =$data;
        $this->data['assetURL'] =$this->assetURL;
        $this->layout->content = View::make('showOrder', $this->data);
    }

    /**
     *     SaveOrder
     *     @param  integer $id
     */
    function saveOrder() {
        if (Request::ajax()) {
            $listorder = $_POST['menu'];
            if(is_array($listorder)){
                $order = 1;
                foreach ($listorder as $id => $value) {
                    $item = AdFlightAdvertiserManagerModel::find($id);
                    $item->order = $order;
                    $item->update();
                    $order++;
                }
                return "TRUE";
            }
            return "FALSE";
        }
         
    }
    
    /**
     * 
     * Show view add Date
     * @param $mode
     * @param $index
     */
    public function showUpdateDateInfo($mode, $index=-1){
        if( Request::ajax() ){
            $this->data['mode'] = $mode;
            $this->data['index'] = $index;
            
            $view       = NULL;            
            
            $view = View::make('addDateInfo', $this->data)->render();

            return Response::json(array(
                'view'      =>  $view
            ));

        }
    }
    
    /**
     * 
     * Change status
     */
    function changeStatus(){
		if( Request::ajax() ){
			$id = Input::get('id');
			$currentStatus = Input::get('status');
			$type = Input::get('type');
            $status = ($currentStatus == 1) ? 0 : 1;

			$item = $this->model->find($id);

			if( $item ){
				$item->status = $status;
			    if( $item->save() ){
			        $dataLog = array(
                        'title'     => 'Update Flight ID: ' . $item->id,
                        'content'   => json_encode(array('status'=>$status)),
                        'type_task' => Request::segment(4)
                    );
                    
                    $this->inputLogs($dataLog);
                    
                    (new Delivery())->renewCache('flight', $id);
                    if($type != ""){
                        return $status;
                    }
					return View::make('ajaxChangeStatus', compact('item'));
				}
			}
		}

		return "fail";
	}
	
	/**
     * 
     * Change status
     */
    function websiteChangeStatus(){
		if( Request::ajax() ){
			$id = Input::get('id');
			$currentStatus = Input::get('status');
			$status = ($currentStatus == 1) ? 0 : 1;

			$flightWebsite = FlightWebsiteBaseModel::find($id);

			if( $flightWebsite ){
				$flightWebsite->status = $status;
			    if( $flightWebsite->save() ){    
			        //Thuc hien ghi cache flight website da update (to do)              
                    (new Delivery())->renewCache('flight_website', $id);
                    
					return View::make('ajaxWebsiteChangeStatus', compact('flightWebsite'));
				}
			}
		}

		return "fail";
	}
	
	/**
     * renew cache of a flight
     */

    function renewCache($id){
        if (Request::ajax()) {
            if($id){
                (new Delivery())->renewCache('flight', $id);

                return "success";
            }
        }

        return "fail";

    }
    
	/**
     * 
     * Renew cache of a ad
     * @param $id
     */
    function renewCacheFlightWebsite($id){
        if (Request::ajax()) {
            if(isset($id) && $id > 0){
                (new Delivery())->renewCache('flight_website', $id);
                return "success";
            }
        }
        return "fail";

    }

    /*
    * get list audiences
    * @param int $id
    * @return
    */
    public function getListAudiences($id, $flight_id=0){
        $operator = '';
        $audience_id = '';
        if($flight_id!=0){
            $selectAudience =  $this->model->select('audience')->find($flight_id);            
            $selectAudience = json_decode($selectAudience->audience, true);
            $operator = $selectAudience['operator'];
            $audience_id = $selectAudience['audience_id'];
        }
        $audience = new AudienceModel;
        $audiences = $audience->getItems($id, 'campaign_id');
        return View::make('ajaxAudiences', compact('audiences', 'operator', 'audience_id'));
    }
}
