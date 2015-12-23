<?php
use FlightPublisherBaseModel as ModelFlightPub;
use CountryBaseModel as modelCountry;
use CategoryBaseModel as modelCategory;

class ToolAdvertiserManagerController extends AdvertiserManagerController
{

    public function __construct() {
        parent::__construct(pathinfo(dirname(__DIR__), PATHINFO_BASENAME));
        if(Route::currentRouteName() != "ToolAdvertiserManagerPreview"){
            $this->loadLeftMenu('menu.tool');
        }
    }

    public function tool(){
        $this->layout->content = View::make('tool');

    }

    public function getListSelect(){

        if( Request::ajax() ){
            $type 		= Input::get('type');
            $keyword 	= Input::get('keyword');
            $parent 	= Input::get('parent');
            $id 	= Input::get('id', 0);

            switch ($type) {
                case 'advertiser':
                    return $this->getListAdvertiser($keyword, $id);
                    break;

                case 'ad':
                    return $this->getListAd($keyword, $parent, $id);
                    break;

                case 'publisher':
                    return $this->getListPublisher($keyword, $id);
                    break;

                case 'publisher_site':
                case 'website':
                    return $this->getListPublisherSite($keyword, $parent, $id);
                    break;

                case 'publisher_ad_zone':
                    return $this->getListPublisherAdZone($keyword, $parent, $id);
                    break;

                case 'agency':
                    return $this->getListAgency($keyword, $id);
                    break;

                case 'campaign':
                    return $this->getListCampaign($keyword, $id);
                    break;
                    
                case 'campaignR2':
                    return $this->getListCampaignR2($keyword, $id);
                    break;
                    
                case 'campaign_retargeting':
                    return $this->getListCampaignRetargeting($keyword, $id);
                    break;

                case 'contact':
                case 'invoice_contact':
                    return $this->getListContact($keyword, $parent);
                    break;
                    
                case 'flight':
                    return $this->getListFlight($keyword, $id);
                    break;
                    
                case 'sale':
                case 'campaign_manager':
                    return $this->getListSale($keyword, $id);
                    break;
                    /* --Start--Add by Phuong-VM 06-05-2015 */
                case 'geo':
                    return $this->getListGeo($keyword);
                    break;
                    /* --End--Add by Phuong-VM 06-05-2015 */

            }



        }
    }

    public function getListGeo($keyword) {
        $model = new GeoBaseModel();
        $this->data['provinceLists'] = $model->getRegionByCountry($keyword);
        return View::make('provinceLists', $this->data)->render();
    }

    public function getListFlight($keyword, $id) {
        $model = new FlightBaseModel();
        if ($id > 0) {
            $this->data['listFlight'] = $model->where('id', $id)->get();
        } else {
            $this->data['listFlight'] = $model->searchByCapital($keyword);
        }
        return View::make('listFlight', $this->data)->render();
    }

    public function getListAdvertiser($keyword, $id){
        $model = new AdvertiserAdvertiserManagerModel;
        
        if ($id > 0) {
            $this->data['listAdvertiser'] = $model->where('id', $id)->get();
        } else {
            $this->data['listAdvertiser'] = $model->searchByCapital($keyword);
        }
        return View::make('listAdvertiser', $this->data)->render();
    }

    public function getListAd($keyword, $parent, $id){
        $model = new AdAdvertiserManagerModel;
        if ($id > 0) {
            $this->data['listAd'] = $model->where('id', $id)->get();
        } else {
            $this->data['listAd'] = $model->searchByCapital($keyword, $parent);
        }
        return View::make('listAd', $this->data)->render();
    }

    public function getListAgency($keyword, $id){
        $model = new AgencyAdvertiserManagerModel;
        if ($id > 0) {
            $this->data['listAgency'] = $model->where('id', $id)->get();
        } else {
            $this->data['listAgency'] = $model->searchByCapital($keyword);
        }
        return View::make('listAgency', $this->data)->render();
    }

    public function getListContact($keyword, $parent){
        $model = new ContactAdvertiserManagerModel;
        $this->data['listContact'] = $model->searchAdvertiserContactByCapital($keyword, $parent);
        return View::make('listContact', $this->data)->render();
    }

    public function getListSale($keyword, $id){
        $model = new User;
        if ($id > 0) {
            $this->data['listSale'] = $model->where('id', $id)->get();
        } else {
            $this->data['listSale'] = $model->searchSaleByCapital($keyword);
        }
        return View::make('listSale', $this->data)->render();
    }

    public function getListCampaign($keyword, $id){
        $model = new CampaignAdvertiserManagerModel;
        if ($id > 0) {
            $this->data['listCampaign'] = $model->where('id', $id)->get();
        } else {
            $this->data['listCampaign'] = $model->searchByCapital($keyword);
        }
        return View::make('listCampaign', $this->data)->render();
    }
    public function getListCampaignR2($keyword, $id){
        $model = new CampaignAdvertiserManagerModel;
        if ($id > 0) {
            $this->data['listCampaign'] = $model->where('id', $id)->get();
        } else {
            $this->data['listCampaign'] = $model->searchByCapital($keyword);
        }
        return View::make('listCampaignR2', $this->data)->render();
    }
    public function getListCampaignRetargeting($keyword, $id){
        $model = new CampaignAdvertiserManagerModel;
        if ($id > 0) {
            $this->data['listCampaign'] = $model->where('id', $id)->get();    
        } else {
            $this->data['listCampaign'] = $model->searchByCapital($keyword);
        }
        return View::make('listCampaignRetargeting', $this->data)->render();
    }

    public function getListPublisher($keyword, $id){
        $model = new PublisherBaseModel;
        if ($id > 0) {
            $this->data['listPublisher'] = $model->where('id', $id)->where('status', 3)->get();
        } else {
            $this->data['listPublisher'] = $model->searchByCapital($keyword);
        }
        return View::make('listPublisher', $this->data)->render();
    }

    public function getListPublisherSite($keyword, $parent, $id){
        $model = new PublisherSiteBaseModel;
        if ($id > 0) {
            $this->data['listPublisherSite'] = $model->where('id', $id)->get();
        } else {
            $this->data['listPublisherSite'] = $model->searchByCapital($keyword, $parent);
        }
        return View::make('listPublisherSite', $this->data)->render();
    }

    public function getListPublisherAdZone($keyword, $parent, $id){
        $model = new PublisherAdZoneBaseModel;
        if ($id > 0) {
            $this->data['listPublisherAdZone'] = $model->where('id', $id)->get();    
        } else {
            $this->data['listPublisherAdZone'] = $model->searchByCapital($keyword, $parent);
        }
        return View::make('listPublisherAdZone', $this->data)->render();
    }

    //get usermanager
    public function userManager(){
        // get list country
        $modelUser = new User;
        $countryModel = new CountryBaseModel;
        $this->data['listCountry'] = $countryModel->getAllForm();

        $this->data['defaultField'] = $this->defaultField;
        $this->data['defaultOrder'] = $this->defaultOrder;
        $this->data['defaultURL'] 	= $this->moduleURL;
        $this->data['showField'] 	= $modelUser->getShowFieldUserManager();

        $this->layout->content = View::make('userManager',$this->data);
    }

    function getList(){
        if(Request::ajax()){
            $modelUser = new User;
            $this->defaultField 	= Input::get('defaultField');
            $this->defaultOrder 	= Input::get('defaultOrder');
            $this->searchData 		= Input::get('searchData');
            $this->showNumber 		= Input::get('showNumber');
            $this->isReset 			= Input::get('isReset');

            $this->data['defaultField'] = $this->defaultField;
            $this->data['defaultOrder'] = $this->defaultOrder;
            $this->data['defaultURL'] 	= $this->moduleURL;
            $this->data['showField'] 	= $modelUser->getShowFieldUserManager();

            if( $this->isReset == 1 ){
                Paginator::setCurrentPage(1);
            }
            $userCurrent=$this->user;
             
            $this->data['lists']=User::searchUserManager($this->searchData)
            ->where('id',$userCurrent->id)->orderBy($this->defaultField, $this->defaultOrder)->paginate($this->showNumber);

            return View::make('ajaxShowList', $this->data);
        }
    }
    //get user by id
    public function getUserId(){
        $id=Input::get('user_id');
        $data['item']=User::find($id);
        return View::make('viewUser',$data);
    }

    ///my profile

    public function myProfile($idu=''){
         
        $currentUser=$this->user;
        $this->data['item'] = $currentUser;
        $id=$currentUser->id;

        //get list country
        $countryModel = new CountryBaseModel;
        $this->data['itemCountry'] = $countryModel->getAll();

        if (Request::isMethod('post')) {

            // check validate
            $validate = Validator::make(Input::all(), User::getUpdateUserRules(), User::getUpdateUserLangs());
             
            $flag=$this->checkValidatePass($this->data);
            if ($validate->passes() && $flag==TRUE) {
                $username = Input::get('username');
                $password = Input::get('re-password');
                $firstName= Input::get('first_name');
                $lastName = Input::get('last_name');
                $email    = Input::get('email');
                $address  = Input::get('address');
                $country  = Input::get('country');
                $phone    = Input::get('phone');
                $contact_phone=Input::get('contact_phone');

                try
                {
                     
                    $userData = Sentry::findUserById($id);
                    $userData->username = $username;
                    if($password != ""){
                        $userData->password = $password;
                    }
                    $userData->email 		= $email;
                    $userData->first_name 	= $firstName;
                    $userData->last_name 	= $lastName;

                    $userData->address 		= $address;
                    $userData->country_id 	= $country;

                    $userData->phone 		= $phone;
                    $userData->phone_contact 	= $contact_phone;

                    if($userData->save()){
                        $data['id']			= $userData->id;
                        $messages=trans("backend::publisher/text.update_success");

                        Session::flash('mess',$messages);
                        if($idu != 0) $url=Route('ToolAdvertiserManagerShowUpdate',$id);
                        else $url=Route('ToolAdvertiserManagerProfile');
                        return Redirect::to($url);
                    }

                }
                catch (\Cartalyst\Sentry\Users\WrongPasswordException $e)
                {
                    $this->data['message'] = "Passwords do not exactly";
                }
            } else {
                $this->data['validate'] = $validate->messages();
            }
        }

        $this->layout->content = View::make('myProfile', $this->data);
    }

    //show list publisher
    //get user list of an group publisher
    function getListPublisherManager(){
        if(Request::ajax()){
            $modelPublisher = new ApprovePublisherManagerModel;
            $defaultField 	= Input::get('defaultField');
            $defaultOrder 	= Input::get('defaultOrder');
            $searchData 	= Input::get('searchData');
            $showNumber 	= Input::get('showNumber');
            $isReset 		= Input::get('isReset');

            $this->data['defaultField'] = $defaultField;
            $this->data['defaultOrder'] = $defaultOrder;
            $this->data['defaultURL'] 	= $this->moduleURL;
            $this->data['showField'] 	= $modelPublisher->getShowField();

            if( $isReset == 1 ){
                Paginator::setCurrentPage(1);
            }
             
            $this->data['lists'] = ApprovePublisherManagerModel::Search($searchData,Config::get('backend.publisher_approved'))->orderBy($defaultField, $defaultOrder)->paginate($showNumber);
             
            return View::make('ajaxShowListPublisher', $this->data);
        }
    }
    //show list user publisher
    public function showListPublisher(){
        $this->data['defaultField'] = $this->defaultField;
        $this->data['defaultOrder'] = $this->defaultOrder;
        $this->data['defaultURL'] 	= $this->moduleURL;

        //get country
        $this->data['itemCountry']=modelCountry::select('id','country_name')->get();
        //get category
        $this->data['itemCate']=modelCategory::select('id','name')->get();
        $this->data['publisher_approved']=Config::get('backend.publisher_approved');

        if( method_exists($this, 'beforeShowList') ){
            $this->beforeShowList();
        }

        $this->layout->content=View::make('showListPublisher',$this->data);
    }

    // sort flight running
    public function sortFlightRunning(){
        if(Request::ajax()){

            $publisher_id=Input::get('publisher_id');
            //get flight of publisher running
            $this->data['items']=FlightPublisherBaseModel::with('flight')->where(array('status'=>1,'publisher_id'=>$publisher_id))
            ->orderBy('sort','ASC')
            ->get();
            return View::make('sortFlightRunning',$this->data);
        }
    }

    public function postSortFlightRunning(){
        if(Request::ajax()){
            $arrSort=Input::get('sort');
            if(count($arrSort) > 0){
                $i=1;
                foreach($arrSort as $key=>$value){
                    ModelFlightPub::where('id',$key)->update(['sort'=>$i]);
                    $i++;
                }
                return 1;
            }
            return 0;
        }
    }

    public function preview(){
        if( Request::ajax() ){
            $type 		= Input::get('type');
            $id 	= Input::get('id');

            switch ($type) {
                case 'campaign':
                    return $this->previewCampaign($id);
                    break;
                case 'flight':
                    return $this->previewFlight($id);
                    break;
            }
        }
    }
    
    public function previewCampaign($id) {
        $model = new CampaignAdvertiserManagerModel();
        $this->data['campaign'] = $model->with('agency', 'flight', 'advertiser', 'sale', 'campaign_manager')->find($id);

        $trackingSummaryModel             = new TrackingSummaryBaseModel;
		$this->data['listFlightTracking'] = $trackingSummaryModel->getFlightSummary($id);

		$view = View::make('campaign_advertiser_manager.showPreview', $this->data)->render();

        return Response::json(array(
            'view'      =>  $view
        ));
    }
    
    public function previewFlight($id) {
        $model = new FlightBaseModel();
        $this->data['flight'] = $model->with('category', 'ad', 'campaign', 'flightDate')->find($id);

        $trackingSummaryModel             = new TrackingSummaryBaseModel;
		$this->data['flightTracking'] = $trackingSummaryModel->getFlightSummaryByID($id);

		$view = View::make('flight_advertiser_manager.showPreview', $this->data)->render();

        return Response::json(array(
            'view'      =>  $view
        ));
    }
    public function getDashboard() {
        $flight_dates = FlightDateBaseModel::where("start","<=",date("Y-m-d"))->Where("end",">=",date("Y-m-d"))->orderBy("flight_id","DESC")->get();
        $data["data"] = array();
        foreach($flight_dates as $flight_date){
           $flight = $flight_date->flight;

            $campagin = $flight->campaign;
            $flight->daily_inventory = $flight_date->daily_inventory;
            if($flight->cost_type == 'cpm'){
                $flight->daily_inventory = $flight_date->daily_inventory * 1000;
            }


            $data["datas"][$campagin->name][$flight->id]= $flight;
        }

        $this->layout->content =  View::make('dashboard',$data);
    }

    public function getDashboardCampaign(){
        $id =  Input::get("campaign");
        if($id == ""){
            die();
        }
        $item = CampaignAdvertiserManagerModel::find($id);
        $this->data['campaign']               = $item;
        $trackingSummaryModel             = new TrackingSummaryBaseModel;
        $this->data['listFlightTracking'] = $trackingSummaryModel->getFlightSummary($id);
        return View::make('dashboardcampaign',$this->data);
    }

    public function getDashboardFilghtWebsite(){
         $flight = Input::get("flight");
         $campaign = Input::get("campaign");
         $ad = Input::get("ad");
        if($flight > 0 ){
            $datas = TrackingSummaryBaseModel::getDataPerDate(date('Y-m-d'),$campaign,$ad,$flight,'site');
            $this->data['datas'] =$datas;
            $this->data['flight'] =$flight;
            return View::make("dashboardFilghtWebsite",$this->data);
        }
        return "";
    }

    /*
    * Get URL Track GA 
    *
    */
    public function getUrlTrackGA(){
        $urlTrackGA = new URLTrackGAModel;

        if(Request::isMethod('POST')){
            $urlTrackGA->store(Request::all());
        }
        $this->data['active'] = 1;
         $this->data['run'] = 'all';
        $item = $urlTrackGA->getAll();
        if(sizeof($item)>0){
            foreach($item as $k){
                if(isset($k->active)){
                    $this->data['active'] = $k->active;
                }
                if(isset($k->run)){
                    $this->data['run'] = $k->run;
                }
            }
        }
        
        $this->data['item'] = $urlTrackGA->getAll();
        $this->layout->content = View::make('urlTrackGA', $this->data);
    }

    /*
    * Report Ad Request 
    *
    */
    public function getReportAdRequest(){
        $model = new PublisherSiteBaseModel;
        $this->data['listPublisherSite'] = $model->orderBy('name')->lists('name', 'id');

        $trackingAdRequestModel = new TrackingAdRequestBaseModel;

        ($trackingAdRequestModel->getAdRequestDate());
        $this->layout->content = View::make('listReportAdRequest', $this->data);
    }

    /*
    * Report Ad Request 
    *
    */
    public function showReportAdRequest(){
        $inputs = $this->getParameter(Input::get('searchData'));
        $trackingAdRequestModel = new TrackingAdRequestBaseModel;
        if (!empty($inputs['by_date'])) {
            $this->data['lists'] = $trackingAdRequestModel->getAdRequestDate($inputs['webiste'], $inputs['ad_zone'], $inputs['start_date_range'], $inputs['end_date_range'], Input::get('showNumber'));

            return View::make('ajaxShowReportAdRequestDate', $this->data);
        } else {
            if (empty($inputs['webiste'])) {
                $this->data['website'] = 'all';
            }

            if (empty($inputs['ad_zone'])) {
                $this->data['ad_zone'] = 'all';
            }
            $this->data['lists'] = $trackingAdRequestModel->getAdRequest($inputs['webiste'], $inputs['ad_zone'], $inputs['start_date_range'], $inputs['end_date_range'], Input::get('showNumber'));

            return View::make('ajaxShowReportAdRequest', $this->data);
        } 
    }

    public function reportAdRequestHour(){
        $wid = Input::get('wid');
        $zid = Input::get('zid');
        $date = Input::get('date');
        $website_name = Input::get('wname');
        $zone_name = Input::get('zname');
        $trackingAdRequestModel = new TrackingAdRequestBaseModel;
        $this->data['lists'] = $trackingAdRequestModel->getAdRequestHour($wid, $zid, $date);
        $this->data['website_name'] = $website_name;
        $this->data['zone_name'] = $zone_name;
        return View::make('reportAdRequestHour', $this->data);
    }

    public function getParameter($arrParam = array()) {
        $retval = array(
                'start_date_range' => '',
                'end_date_range' => '',
                'by_date' => '',
                'webiste' => array(),
                'ad_zone' => array()
            );
        foreach ($arrParam as $param) {
            switch ($param['name']) {
                case 'start_date_range':
                case 'end_date_range':
                case 'by_date':
                   $retval[$param['name']] = $param['value'];
                    break;
                case 'webiste':
                case 'ad_zone':
                   $retval[$param['name']][] = $param['value'];
                    break;
            }
        }

        return $retval;
    }

    public function getAdzone() {
        $model = new PublisherAdZoneBaseModel;
        $website_ids = Input::get('webiste', array());
        $listAdZone = $model->whereIn('publisher_site_id', $website_ids)->orderBy('publisher_site_id')->orderBy('id')->lists('name', 'id');

        return Response::json($listAdZone);
    }

}
