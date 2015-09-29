<?php

class WebsiteAdvertiserManagerController extends AdvertiserManagerController {

public function __construct(SitePublisherModel $model) {
        parent::__construct(pathinfo(dirname(__DIR__), PATHINFO_BASENAME));
        $this->model = $model;
        $this->loadLeftMenu('menu.websiteList');
    }

    /**
     *     trigger before show list render view
     */
    public function beforeShowList() {
        //get country

    }

    public function beforeGetList(){
        $this->data['showField'] = array(
            'name'         =>  array(
                'label'         =>  trans("text.name"),
                'type'          =>  'text'
            ),
            'url'         =>  array(
                'label'         =>  trans("text.url"),
                'type'          =>  'text'
            )
        );
    }

    public function getListData() {
        $this->data['lists'] = $this->model
                ->search($this->searchData)
                ->orderBy($this->defaultField, $this->defaultOrder)
                ->paginate($this->showNumber);
    }

    /**
     *     add/update agency
     *     @param  integer $id 
     */
    function showUpdate($id = 0) {

        View::share('jsTag', HTML::script("{$this->assetURL}js/select.js") . HTML::script("{$this->assetURL}js/Ad.js"));

        $this->data['id'] = $id;

        // WHEN UPDATE SHOW CURRENT INFOMATION

        if( $id == 0 ){

        }else{
            $item = $this->model->find($id);

            if ($item) {
                $this->data['data'] = $item;

                $fpm = new FlightWebsiteBaseModel;
                $this->data['listFlightWebsite'] = $fpm->getListByWebsiteId($id);

            } else {
                return Redirect::to($this->moduleURL . 'show-list');
            }
        }


        $this->layout->content = View::make('showUpdate', $this->data);
    }

    /**
     *     handle form add/update agency
     *     @param  integer $id 
     */
    function postUpdate($id = 0) {

        // check validate
        $validate = Validator::make(Input::all(), $this->model->getUpdateRules(), $this->model->getUpdateLangs());

        if ($validate->passes()) {

            $campaignName = Input::get('campaign');
            $adFormatID = Input::get('ad_format_id');
            $adFormatName = AdFormatBaseModel::find($adFormatID)->name;

            $updateData = array(
                'campaign_id' => Input::get('campaign_id'),
                'ad_format_id' => $adFormatID,
                'ad_type' => Input::get('ad_type'),
                'width' => Input::get('width'),
                'height' => Input::get('height'),
                'source_url' => Input::get('source_url'),
                'destination_url' => Input::get('destination_url'),
                'flash_wmode' => Input::get('flash_wmode'),
                'video_duration' => Input::get('video_duration'),
                'video_linear' => Input::get('video_linear'),
                'video_type_vast' => Input::get('video_type_vast'),
                'video_wrapper_tag' => Input::get('video_wrapper_tag'),
                'video_bitrate' => Input::get('video_bitrate'),
                'video_impression_track' => Input::get('video_impression_track'),
                'updated_by' => $this->user->id
            );

            if (!empty($campaignName) || !empty($adFormatName)) {
                $updateData['name'] = $campaignName . ' ' . $adFormatName;
            }

            if ($id == 0) { // INSERT
                $updateData['created_by'] = $this->user->id;
                if ($item = $this->model->create($updateData)) {
                    $this->data['id'] = $item->id;
                    return TRUE;
                }
            } else { // UPDATE
                // GET CURRENT ITEM
                $item = $this->model->with('flight')->find($id);

                if ($item) {
                    if ($this->model->where("id", $id)->update($updateData)) {
                        return TRUE;
                    }
                }
            }
        } else {
            $this->data['errors'] = $validate->messages();
        }

        return FALSE;
    }

    public function showCost($id){
        View::share('jsTag', HTML::script("{$this->assetURL}js/cost.js"));

        $item = $this->model->find($id);
        if (!$item) {
            return Redirect::to($this->moduleURL . 'show-list');
        }

        $this->data['id'] = $item->id;
        $this->data['lists'] = ( new PublisherSiteBaseCostBaseModel )->getListByWebsiteId($item->id);
        $this->layout->content = View::make('showCost', $this->data);

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
                    return "success";
                }
            }
        }
        return "fail";
    }

    /**
     *     Load Modal Add/Edit Flight
     *     @param  integer  $id
     *     @return Response
     */
    public function loadModal() {
        if (Request::ajax()) {

            $id = Input::get('id');
            $publisherId = Input::get('publisherId');
            $flightId = Input::get('flightId');
            $flightName = Input::get('flightName');

            $status = TRUE;
            $view = NULL;

            $this->data['id'] = $id;
            $this->data['publisherId'] = $publisherId;
            $this->data['flightId'] = $flightId;
            $this->data['flightName'] = $flightName;

            // check if flightPublisher exist
            $flightPublisher = FlightWebsiteBaseModel::where('id', $id)->first();

            if ($flightPublisher) {
                $this->data['item'] = $flightPublisher;
                $view = View::make('flightModal', $this->data)->render();
            }


            return Response::json(array(
                        'status' => $status,
                        'view' => $view
            ));
        }
    }

    public function loadModalCost() {
        if (Request::ajax()) {

            $wid = Input::get('wid');
            $aid = Input::get('aid');
            $waid = Input::get('waid');

            $this->data['wid'] = $wid;
            $this->data['aid'] = $aid;
            $this->data['waid'] = $waid;

            if( $waid != 0 ){
                $this->data['item'] = PublisherSiteBaseCostBaseModel::find($waid);
            }else{
                //get List Ad Format
                $this->data['adFormatLists'] = ( new AdFormatBaseModel )->getAllForm();
            }

            $status = TRUE;
            $view = View::make('costModal', $this->data)->render();

            return Response::json(array(
                'status' => $status,
                'view' => $view
            ));
        }
    }

    /**
     * Store a newly created resource in storage.
     * @param  array Form Data
     * @return Response
     */
    public function updateFlight() {
        if (Request::ajax()) {

            $status = FALSE;
            $message = NULL;
            $view = NULL;

            $publisherBaseCost = Input::get('publisher_base_cost');
            $flightWebsiteId = Input::get('flightWebsiteId');

            $flightWebsite = FlightWebsiteBaseModel::where('id', $flightWebsiteId)->first();

            if( $flightWebsite ){

                $flightWebsite->publisher_base_cost = $publisherBaseCost;
                if( $flightWebsite->save() ){

                    $status = TRUE;
                    $fpm = new FlightWebsiteBaseModel;
                    $this->data['listFlightWebsite'] = $fpm->getListByWebsiteId($flightWebsite->website_id);

                    $view = View::make('flightList', $this->data )->render();
                }


            }

            return Response::json(array(
                        'status' => $status,
                        'message' => $message,
                        'view' => $view
            ));
        }
    }

    public function updateCost() {
        if (Request::ajax()) {

            $wid = Input::get('wid');
            $aid = Input::get('ad_format_id');
            $waid = Input::get('waid');

            $psbsModel = new PublisherSiteBaseCostBaseModel;

            $status = FALSE;
            $message = NULL;
            $view = NULL;

            if( $waid == 0 ){ // insert

                if( empty($aid) ){
                    $message = View::make('partials.show_messages', array('error'=>'Please select Ad Format'))->render();
                }else{
                    $psbs = $psbsModel->where(array(
                        'publisher_site_id' =>  $wid,
                        'ad_format_id' =>  $aid                        
                    ))->first();

                    if( $psbs ){
                        $message = View::make('partials.show_messages', array('error'=>'Ad format base cost exist'))->render();
                    }else{
                        $item = $psbsModel->insertData($this->user->id);
                        if( $item ){
                            $status = TRUE;
                            $message = View::make('partials.show_messages', array('message'=>'Add base cost success'))->render();
                        }
                    }
                }

            }else{ // update

                $item = $psbsModel->find($waid);
                if( $item ){
                    $item->updateData($this->user->id);
                    if( $item ){
                        $status = TRUE;
                        $message = View::make('partials.show_messages', array('message'=>'Update base cost success'))->render();
                    }
                }
                
            }

            if( $status ){
                $this->data['lists'] = ( new PublisherSiteBaseCostBaseModel )->getListByWebsiteId($wid);
                $view = View::make('costList', $this->data)->render();
            }

            return Response::json(array(
                'status' => $status,
                'message' => $message,
                'view'  =>  $view
            ));
        }
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function deleteFlight() {

        if (Request::ajax()) {

            $id = Input::get('id');
            $status = FALSE;
            $view = NULL;

            $item = AdFlightAdvertiserManagerModel::find($id);

            if ($item) {
                $adId = $item->ad_id;
                $adData = AdBaseModel::find($adId);
                if ($item->delete()) {
                    $status = TRUE;
                    $this->data['flightAdList'] = $adData->flightAd;
                    $view = View::make('flightList', $this->data)->render();
                }
            }


            return Response::json(array(
                        'status' => $status,
                        'view' => $view
            ));
        }
    }

    public function ShowSelectFlight($id) {

        $this->loadLeftMenu('menu.Ad');

        View::share('jsTag', HTML::script("{$this->assetURL}js/select.js") . HTML::script("{$this->assetURL}js/Ad.js"));
        $item = $this->model->with('adFormat', 'campaign', 'flight')->find($id);

        if (!$item) {
            return Redirect::to($this->moduleURL . 'show-list');
        }
        $this->data['data'] = $item;
        $this->layout->content = View::make('ShowSelectFlight', $this->data);
    }

    function saveOrder() {
       if (Request::ajax()) {

            $listorder = Input::get('sort');

            if(is_array($listorder)){
                $order = 1;
                foreach ($listorder as $id => $value) {
                    $item = FlightWebsiteBaseModel::find($id);

                    $item->order = $order;
                    $item->update();
                    $order++;
                }
                return "TRUE";
            }
            return "FALSE";

        }
       
    }


}
