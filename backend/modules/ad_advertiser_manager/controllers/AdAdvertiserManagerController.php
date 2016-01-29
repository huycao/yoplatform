<?php

class AdAdvertiserManagerController extends AdvertiserManagerController {

    public function __construct(AdAdvertiserManagerModel $model, AudienceModel $audience) {
        parent::__construct(pathinfo(dirname(__DIR__), PATHINFO_BASENAME));
        $this->model = $model;
        $this->audience = $audience;
        $this->loadLeftMenu('menu.Ad');
    }

    /**
     *     trigger before show list render view
     */
    function beforeShowList() {
        $this->loadLeftMenu('menu.Ad');
        // get list country
        $countryModel = new CountryBaseModel;
        $this->data['listCountry'] = $countryModel->getAllForm();
        View::share('jsTag', HTML::script("{$this->assetURL}js/select.js"));

        // get list Category
        $categoryModel = new CategoryBaseModel;
        $this->data['listCategory'] = array('' => '-- Select Channel --') + $categoryModel->getAllForm(0, 0, 'Run of Network');

        // get list Model
        $this->data['listModel'] = array('' => '-- Select Model --') + Config::get('data.flight_model');
    }

    public function getListData() {

        // $flightModel =  new FlightBaseModel;

        $this->data['lists'] = $this->model
                ->with('campaign','flight')
                ->search($this->searchData)
                ->orderBy($this->defaultField, $this->defaultOrder)
                ->paginate($this->showNumber);

    }

    /**
     *     add/update agency
     *     @param  integer $id 
     */
    function showUpdate($id = 0) {

        $this->loadLeftMenu('menu.Ad');

        $this->data['id'] = $id;

        View::share('jsTag', HTML::script("{$this->assetURL}js/select.js") . HTML::script("{$this->assetURL}js/selectize.js"));

        // get list Category
        $categoryModel = new CategoryBaseModel;
        $this->data['listCategory'] = $categoryModel->getAllForm(0);

        // get list Ad Format
        $AdFormatModel = new AdFormatBaseModel;
        $this->data['listAdFormat'] = json_encode($AdFormatModel->getAllForm());

        // get list Type
        $this->data['listAdType'] = Config::get('data.ad_type');

        // get list Wmode
        $this->data['listWmode'] = Config::get('data.wmode');

        // get list Video Linear
        $this->data['listVideoLinear'] = Config::get('data.video_linear');

        // get list Video Type Vast
        $this->data['listTypeVast'] = Config::get('data.video_type_vast');
        
        /* Phuong-VM 2015/06/30 */
        $this->data['listPlatform'] = Config::get('data.platform');
        $this->data['audiences'] = array();
        // WHEN UPDATE SHOW CURRENT INFOMATION
        if ($id != 0) {
             //get list Audience
            $this->data['audiences'] = $this->audience->getItems($id);
            $this->loadLeftMenu('menu.adUpdate');
            $item = $this->model->find($id);
            // $this->data['adMapFlight'] = $item->flight->lists('name', 'id');
            // $this->data['campaignMapFlight'] = $item->campaign->flight->lists('name', 'id');

            if ($item) {
                $item->platform = json_decode($item->platform);
                $this->data['item'] = $item;
            } else {
                return Redirect::to($this->moduleURL . 'show-list');
            }
        }
        if (Request::isMethod('post')) {
            if ($this->postUpdate($id, $this->data)) {
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
            $adFormat = AdFormatBaseModel::find($adFormatID);
            
            if ('HTML' == $adFormat->name && 'video' == Input::get('ad_type')) {
                $campaign_id = Input::get('campaign_id');
                $name = Input::get('name');
                
                if(!isset($_FILES['vast_file']) || empty($_FILES['vast_file']['name'])){
                    if (!empty($campaign_id) && !empty($name)) {
                        $file_name = str_replace(' ', '_', strtolower($name)) . '.xml';
                        $url = "http://static.yomedia.vn/xml/{$campaign_id}/{$file_name}";
                        $file_headers = @get_headers($url);
                        if($file_headers[0] == 'HTTP/1.1 404 Not Found') {
                            Session::flash('flash-message',  "Vast file is required");;
                            return FALSE;
                        }
                    }
                } else {
                    $file = $_FILES['vast_file'];
                    if(isset($file['name']) && $file['name'] !="" ){
                        $ftp = new MyFTP();
                        $type = substr($file['name'], strrpos($file['name'], '.'), strlen($file['name']));
                        if ('.xml' != $type) {
                            Session::flash('flash-message',  "Extension of vast file error");
                            return FALSE;
                        }
                        $file_name = str_replace(' ', '_', strtolower(Input::get('name'))) . '.xml';
                        $dirUpload = "xml/{$campaign_id}/";
                        if(!$ftp->uploadFtp($dirUpload,$file['tmp_name'],$file_name)){
                            Session::flash('flash-message',  "Upload file error");
                            return FALSE;
                        }
                    }
                }
            }

            $updateData = array(
                'campaign_id'            => Input::get('campaign_id'),
                'name'                   => Input::get('name'),
                'ad_format_id'           => $adFormatID,
                'ad_type'                => Input::get('ad_type'),
                'width'                  => Input::get('width'),
                'height'                 => Input::get('height'),
                'width_2'                => Input::get('width_2'),
                'height_2'               => Input::get('height_2'),
                'width_after'            => Input::get('width_after'),
                'height_after'           => Input::get('height_after'),
                'source_url'             => Input::get('source_url'),
                'source_url2'             => Input::get('source_url2'),
                'destination_url'        => Input::get('destination_url'),
                'flash_wmode'            => Input::get('flash_wmode','none'),
                'video_duration'         => Input::get('video_duration'),
                'video_linear'           => Input::get('video_linear'),
                'video_type_vast'        => Input::get('video_type_vast'),
                'video_wrapper_tag'      => Input::get('video_wrapper_tag'),
                'third_impression_track' => Input::get('third_impression_track'),
                'third_click_track'      => Input::get('third_click_track'),
                'video_bitrate'          => Input::get('video_bitrate'),
                'third_party_tracking'   => (Input::get('tracking') == "") ? "" : json_encode(Input::get('tracking')),
                'main_source'            => Input::get('main_source'),
                'updated_by'             => $this->user->id,
                'platform'               => json_encode(Input::get('platform')),
                'ad_view_type'           => Input::get('ad_view_type'),
                'source_url_backup'	     => Input::get('source_url_backup'),
                'html_source'            => Input::get('html_source'),
                'skipads'                => Input::get('skipads'),
                'display_type'           => Input::get('display_type'),
                'bar_height'             => Input::get('bar_height'),
                'vast_include'           => Input::get('vast_include', 0),
                'vpaid'           => Input::get('vpaid', 0),
                'audience_id'            => Input::get('audience_id',0),
                'position'            => Input::get('position')
            );
            
            if (!$updateData['ad_view_type']) {
                if ($adFormat->ad_view) {
                    $updateData['ad_view'] = $adFormat->ad_view;
                } else {
                    $updateData['ad_view'] = '';
                }
            } else {
                $updateData['ad_view'] = Input::get('ad_view');
            }

            // Upload FILE FTP
            if(isset($_FILES['file_source_url'])){
                $file = $_FILES['file_source_url'];
                if(isset($file['name']) && $file['name'] !="" ){
                    $ftp = new MyFTP();
                    $file_name = time().$file['name'];
                    if(!$ftp->uploadFtp("",$file['tmp_name'],$file_name)){
                        Session::flash('flash-message',  "Extension file error");;
                        return FALSE;
                    }
                    $updateData['source_url'] = STATIC_URL.date("Y")."/".date("m")."/".$file_name;
                }
            }
            // Upload FILE FTP
            if(isset($_FILES['file_source_url_2'])){
                $file = $_FILES['file_source_url_2'];
                if(isset($file['name']) && $file['name'] !="" ){
                    $ftp = new MyFTP();
                    $type = substr($file['name'], strrpos($file['name'], '.'), strlen($file['name']));
                    $file_name = time().$file['name'];
                    $ftp->uploadFtp("",$file['tmp_name'],$file_name);
                    if(!$ftp->uploadFtp("",$file['tmp_name'],$file_name)){
                        Session::flash('flash-message',  "Extension file error");;
                        return FALSE;
                    }
                    $updateData['source_url2'] = STATIC_URL.date("Y")."/".date("m")."/".$file_name;
                }
            }
             // Upload FILE BACKUP
            if(isset($_FILES['file_source_backup_url'])){
                $file = $_FILES['file_source_backup_url'];
                if(isset($file['name']) && $file['name'] !="" ){
                    $ftp = new MyFTP();
                    $type = substr($file['name'], strrpos($file['name'], '.'), strlen($file['name']));
                    $file_name = time().$file['name'];
                    if(!$ftp->uploadFtp("",$file['tmp_name'],$file_name)){
                        Session::flash('flash-message',  "Extension file error");;
                        return FALSE;
                    }
                    $updateData['source_url_backup'] = STATIC_URL.date("Y")."/".date("m")."/".$file_name;
                }
            }
            $mime = '';
            if ($updateData['ad_type'] == 'html') {
                $mime = 'text/html';
            } else {
                if ($updateData['ad_type'] != 'video' || empty($updateData['vpaid'])) {
                    if (!empty($updateData['source_url'])) {
                        $ch = curl_init($updateData['source_url']);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        curl_exec($ch);
                        $mime = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
                    }
                }
            }
            $updateData['mime'] = $mime;
            
            // if (!empty($campaignName) || !empty($adFormatName)) {
            //     $updateData['name'] = $campaignName . ' ' . $adFormatName;
            // }

            if ($id == 0) { // INSERT
                $updateData['created_by'] = $this->user->id;

                if ($item = $this->model->create($updateData)) {
                    $this->data['id'] = $item->id;
                    (new Delivery())->renewCache('ad', $item->id);
                    Session::flash('flash-message', 'Create Ad Success!');
                    return TRUE;
                }
            } else { // UPDATE
                // GET CURRENT ITEM
                $item = $this->model->find($id);

                if ($item) {
                    if ($this->model->where("id", $id)->update($updateData)) {
                        //update audience id
                        $this->audience->updateCampaign($id, Input::get('campaign_id'));

                        $flights = FlightBaseModel::where('ad_id', $item->id)->get();
                        if ($flights) {
                            foreach ($flights as $flight) {
                                (new Delivery())->removeCache('flight', $flight->id);
                                $flight->ad_format_id = $updateData['ad_format_id'];
                                if ($flight->save()) {
                                    (new Delivery())->renewCache('flight', $flight->id);
                                }
                            }
                        }
                        (new Delivery())->renewCache('ad', $id);
                        Session::flash('flash-message', 'Update Ad Success!');
                        return TRUE;
                    }
                }
            }
        } else {
            $this->data['errors'] = $validate->messages();
        }

        return FALSE;
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
                    (new Delivery())->renewCache('ad', $id);
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
            $flightId = Input::get('flightId');
            $flightName = Input::get('flightName');
            $adId = Input::get('adId');


            $status = TRUE;
            $view = NULL;

            $this->data['flightId'] = $flightId;
            $this->data['flightName'] = $flightName;
            $this->data['adId'] = $adId;
            $this->data['id'] = $id;

            // check if flightPublisher exist
            $flightAd = AdFlightAdvertiserManagerModel::where('ad_id', $adId)->where('flight_id', $flightId)->first();

            if ($id != 0 && $flightAd) {
                $this->data['data'] = $flightAd;
            }

            $view = View::make('flightModal', $this->data)->render();

            return Response::json(array(
                        'status' => $status,
                        'view' => $view
            ));
        }
    }


    public function showView($id){
        $this->loadLeftMenu('menu.adView');
        $item = $this->model->with('campaign','flight', 'adFormat')->find($id);
        if( !$item ){
            return Redirect::to($this->moduleURL.'show-list');
        }

        $this->data['data'] = $item;
        $this->layout->content = View::make('showView', $this->data);
    }

    public function showClone($id){
        View::share('jsTag', HTML::script("{$this->assetURL}js/select.js") . HTML::script("{$this->assetURL}js/Ad.js"));
        $item = $this->model->with('campaign','flight', 'adFormat')->find($id);
        if( !$item ){
            return Redirect::to($this->moduleURL.'show-list');
        }

        $this->data['data'] = $item;
        $this->layout->content = View::make('showClone', $this->data);
    }
    public function postClone($id){
        $item = $this->model->find($id);
        if( !$item ){
            return Redirect::to($this->moduleURL.'show-list');
        }
        $newItem =  new $this->model;
        $newItem->name = Input::get('name');
        $newItem->campaign_id = Input::get('campaign_id');
        $newItem->ad_format_id = $item->ad_format_id;
        $newItem->ad_type = $item->ad_type;
        $newItem->ad_view_type = $item->ad_view_type;
        $newItem->ad_view = $item->ad_view;
        $newItem->width = $item->width;
        $newItem->height = $item->height;
        $newItem->width_2 = $item->width_2;
        $newItem->height_2 = $item->height_2;
        $newItem->bar_height = $item->bar_height;
        $newItem->width_after = $item->width_after;
        $newItem->height_after = $item->height_after;
        $newItem->source_url = $item->source_url;
        $newItem->source_url2 = $item->source_url2;
        $newItem->main_source = $item->main_source;
        $newItem->source_url_backup = $item->source_url_backup;
        $newItem->destination_url = $item->destination_url;
        $newItem->flash_wmode = $item->flash_wmode;
        $newItem->video_duration = $item->video_duration;
        $newItem->video_linear = $item->video_linear;
        $newItem->video_type_vast = $item->video_type_vast;
        $newItem->video_wrapper_tag = $item->video_wrapper_tag;
        $newItem->video_bitrate = $item->video_bitrate;
        $newItem->third_party_tracking = $item->third_party_tracking;
        $newItem->third_impression_track = $item->third_impression_track;
        $newItem->third_click_track = $item->third_click_track;
        $newItem->created_by = $this->user->id;
        $newItem->updated_by = $this->user->id;
        $newItem->platform = $item->platform;
        $newItem->html_source = $item->html_source;
        $newItem->display_type = $item->display_type;
        $newItem->vast_include= $item->vast_include;
        $newItem->vpaid= $item->vpaid;
        $newItem->save();
        (new Delivery())->renewCache('ad', $newItem->id);
        return Redirect::to($this->moduleURL . 'show-list');

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
    public function showPreview($id) {
        if ($id != 0) {
            $item = $this->model->find($id);

            if($item){
                switch ($item->ad_format_id){
                    case "8":{
                        $view = View::make("previewVideo",array('data'=>$item));
                        break;
                    }
                    case "9":{
                        $view = "";
                        break;
                    }

                    case "12":{
                        $view = View::make("previewBalloon",array('data'=>$item));
                        break;
                    }
                    case "14":{
                        $view = "";
                        break;
                    }
                    case "16":{
                        $view = View::make("previewImage",array('data'=>$item));
                        break;
                    }
                    default:{
                        $view = Redirect::to($this->moduleURL . 'show-list');
                    }
                }
                return $view;
            }

        }
        return Redirect::to($this->moduleURL . 'show-list');
    }
    public function previewVast($id){

        $body                    = '<VAST version="2.0">';
        if($id > 0){
            $item = $this->model->find($id);

            if($item){
                $body .= View::make('previewvast',array('item'=>$item));
            }
        }
        $body  .='</VAST>';
        $header['Content-Type']                     = 'application/xml';
        $header['Access-Control-Allow-Origin']      = '*';
        $header['Access-Control-Allow-Credentials'] = 'true';
        $header['Cache-Control']                    = 'no-store, no-cache, must-revalidate, max-age=0';
        $header['Cache-Control']                    = 'post-check=0, pre-check=0';
        $header['Pragma']                           = 'no-cache';
        return Response::make($body, 200, $header);
    }
    
    /**
     * 
     * Renew cache of a ad
     * @param $id
     */
    function renewCache($id){
        if (Request::ajax()) {
            if(isset($id) && $id > 0){
                (new Delivery())->renewCache('ad', $id);
                return "success";
            }
        }

        return "fail";

    }
    /*
    * Show List Audiences
    *
    * @param int $id
    * @return Response
    */
    public function showListAudiences($id){
          $this->loadLeftMenu('menu.Ad');
        $this->data['id'] = $id;
        $this->layout->content = View::make('showListAudiences', $this->data);
    }

    /*
    * Get List Audiences
    *
    * @param int $id
    * @return Response
    */
    public function getListAudiences($id){
        $this->showNumber = 20; 
        $this->defaultField = 'audience_update';
        $this->defaultOrder = 'desc';
        $this->data['lists'] = $this->audience->getItems($id);    
        return View::make('ajaxShowListAudiences', $this->data);
    }

    /*
    * Show Create Audience
    *
    * @param int $id
    * @return 
    */
    public function showCreateAudience($id){
        $item = $this->model->find($id);
        if($item){
            $this->data['id'] = $id;
            $this->data['campaign_id'] = $item->campaign_id;
            $this->data['username'] = $this->user->username;
            $validate = Validator::make(Input::all(), $this->audience->getCreateRules(), $this->audience->getCreateLangs());
            
            if(Request::isMethod('post')){
                if($validate->passes()){
                    $this->audience->createItem(Input::all());
                    Session::flash('flash-message', 'Create Audience Success!');
                }else{
                    $this->data['errors'] = $validate->messages();    
                }
            }

            $this->layout->content = View::make('showCreateAudience', $this->data);
        }else{
            return Redirect::to($this->moduleURL . 'show-list');
        }
       
    }

     /*
    * Show Edit Audience
    *
    * @param int $id
    * @return 
    */
    public function ShowUpdateAudience($id){
        $item = $this->audience->getItemById($id);
        if($item){
            $this->data['item'] = $item;
            $ad_id = $item->ad_id;
            $this->data['id'] = $ad_id;
            $this->data['username'] = $this->user->username;
            $validate = Validator::make(Input::all(), $this->audience->getUpdateRules(), $this->audience->getUpdateLangs());
            
            if(Request::isMethod('post')){
                if($validate->passes()){
                    $this->audience->updateItem(Input::all(), $id);
                    Session::flash('flash-message', 'Update Audience Success!');
                    return Redirect::to($this->moduleURL . 'show-list-audiences/'.$ad_id);        
                }else{
                    $this->data['errors'] = $validate->messages();    
                }
            }
            
            $this->layout->content = View::make('showUpdateAudience', $this->data);
        }else{
            return Redirect::to($this->moduleURL . 'show-list');
        }
    }

    /*
    * Delete Audiences
    *
    * @param Request $request
    * @return boolean
    */
    public function deleteAudiences(){
        $ids = Input::get('ids');
        $this->audience->deleteAudiences($ids);
    }

    /*
    * Get List Audience By Campaign
    * @param Request $request
    * @return response
    */
    public function getListAudiencesByCampaign($id, $ad_id){
        $selected_audience='';
        if($ad_id!=0){
            $ad = $this->model->select('audience_id')->find($ad_id);
            $selected_audience = $ad->audience_id;
        }
        $audiences = $this->audience->getItems($id, 'campaign_id');
        return View::make('ajaxAudiences', compact('audiences', 'selected_audience'));
    }
}
