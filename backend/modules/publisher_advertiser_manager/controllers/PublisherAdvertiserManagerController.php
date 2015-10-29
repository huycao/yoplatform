<?php
use Carbon\Carbon;

class PublisherAdvertiserManagerController extends AdvertiserManagerController
{

    public function __construct(PublisherBaseModel $model)
    {
        parent::__construct(pathinfo(dirname(__DIR__), PATHINFO_BASENAME));
        $this->model = $model;
    }

    /**
     *     trigger before show list render view
     */
    function beforeShowList()
    {
        $this->loadLeftMenu('menu.publisherList');
    }

    public function getListData()
    {
        if (!empty($this->searchData)) {
            $this->searchData = array_reindex($this->searchData, 'name');
        }

        $this->data['lists'] = $this->model
            ->searchAd($this->searchData)
            ->where('status', 3)
            ->orderBy($this->defaultField, $this->defaultOrder)
            ->paginate($this->showNumber);
    }

    function redirectAfterSaveSite($type)
    {

        switch ($type) {
            case 'save-return':
                return Redirect::to($this->moduleURL . 'show-list');
                break;

            case 'save-new':
                return Redirect::to($this->moduleURL . $this->data['pid'] . '/create-site');
                break;

            case 'save':
                return Redirect::to($this->moduleURL . $this->data['pid'] . '/update-site/' . $this->data['id']);
                break;

            default:
                return Redirect::to($this->moduleURL . 'show-list');
                break;
        }
    }

    public function reviewPublisher($pid)
    {

        $publisher = $this->model->find($pid);

        if (is_null($publisher) || is_null($publisher->user)) {
            Session::flash('flash-message', "User account of $publisher->site_name not exist");
            if ($publisher) {
                return Redirect::to($this->moduleURL . 'view/' . $publisher->id);
            } else {
                return Redirect::to($this->moduleURL . 'show-list');
            }
        }
        Session::put('reviewUid', $publisher->user->id);
        Session::put('reviewPid', $publisher->id);
        return Redirect::to('control-panel/publisher');
    }

    public function showListSite($pid)
    {
        $this->loadLeftMenu('menu.publisherListSite');
        $publisher = $this->model->find($pid);
        if (!$publisher) {
            return Redirect::to($this->moduleURL . 'show-list');
        }

        $this->data['item'] = $publisher;

        $this->layout->content = View::make('showListSite', $this->data);

    }

    public function showUpdateSite($pid = 0, $id = 0)
    {
        $publisher = $this->model->find($pid);
        if (!$publisher) {
            return Redirect::to($this->moduleURL . 'show-list');
        }

        if ($id != 0) {
            $item = PublisherSiteBaseModel::find($id);
            $this->data['item'] = $item;
            if (!$item) {
                return Redirect::to($this->moduleURL . 'show-list');
            }
        }

        if (Request::isMethod('post')) {
            if ($this->postUpdateSite($pid, $id)) {
                return Redirect::to($this->moduleURL . 'view/' . $pid);
            }
        }

        $this->loadLeftMenu('menu.publisherUpdate', array(
            'pid' => $pid
        ));
        $this->layout->content = View::make('showUpdateSite', $this->data);

    }

    public function postUpdateSite($pid = 0, $id = 0)
    {

        $validate = Validator::make(
            Input::all(),
            array(
                'name' => 'required',
                'url' => 'required'
            ),
            array(
                'name.required' => trans('Please Enter Site Name'),
                'url.required' => trans('Please Enter Site Url'),

            )
        );

        if ($validate->passes()) {

            if ($id == 0) {
                $item = new PublisherSiteBaseModel;
                if ($item->insertData($this->user->id, $pid, Input::all())) {
                    $this->data['id'] = $item->id;
                    $this->data['pid'] = $pid;
                    Session::flash('flash-message', 'Create Website Success!');
                    return TRUE;
                }
            } else {
                $item = PublisherSiteBaseModel::find($id);
                if ($item) {
                    if ($item->updateData($this->user->id, $pid, Input::all())) {
                        (new Delivery())->renewCache('publisher_site', $item->id);
                        $this->data['id'] = $item->id;
                        $this->data['pid'] = $pid;
                        Session::flash('flash-message', 'Update Website Success!');
                        return TRUE;
                    }
                }
            }

        } else {
            $this->data['errors'] = $validate->messages();
        }

    }

    public function showUpdateZone($pid = 0, $wid = 0, $zid = 0)
    {
        $publisher = $this->model->find($pid);
        if (!$publisher) {
            return Redirect::to($this->moduleURL . 'show-list');
        }

        $website = PublisherSiteBaseModel::find($wid);
        if (!$website) {
            return Redirect::to($this->moduleURL . 'show-list');
        }

        $this->data['id'] = $zid;
        $this->data['listAlternateAd'] = NULL;
        // WHEN UPDATE SHOW CURRENT INFOMATION
        if ($zid != 0) {
            $item = PublisherAdZoneBaseModel::find($zid);
            if ($item) {
                $this->data['item'] = $item;

                $listAlternateAdData['lists'] = $item->alternateAd;
                $this->data['listAlternateAd'] = View::make('alternateAdList', $listAlternateAdData)->render();
            } else {
                return Redirect::to($this->moduleURL . 'show-list');
            }
        }
        $this->data['listadformat'] = AdFormatBaseModel::all();

        if (Request::isMethod('post')) {
            if ($this->postUpdateZone($wid, $zid)) {
                return Redirect::to($this->moduleURL . $pid . '/view-site/' . $wid);
            }
        }

        $this->loadLeftMenu('menu.publisherUpdate', array(
            'pid' => $pid
        ));
        $this->layout->content = View::make('showUpdateZone', $this->data);

    }

    public function postUpdateZone($wid = 0, $zid = 0)
    {

        $adZoneModel = new PublisherAdZoneBaseModel;
        $validate = Validator::make(Input::all(), $adZoneModel->getUpdateRules(), $adZoneModel->getUpdateLangs());

        if ($validate->passes()) {
            $updateData = array(
                'name' => Input::get('name'),
                'publisher_site_id' => $wid,
                'platform' => Input::get('platform', 0),
                'ad_format_id' => Input::get('ad_format_id'),
                'adplacement' => Input::get('adplacement', 0),
                'element_id' => Input::get('element_id', ''),
                'width' => Input::get('width', 0),
                'height' => Input::get('height', 0),
            );

            if ($zid == 0) { // INSERT 
                if ($item = $adZoneModel->create($updateData)) {
                    (new Delivery())->renewCache('adzone', $item->id);
                    $this->data['id'] = $item->id;
                    Session::flash('flash-message', 'Create Zone Success !');
                    return TRUE;
                }
            } else { // UPDATE
                // GET CURRENT ITEM
                $item = $adZoneModel->find($zid);

                if ($item) {

                    if ($item->update($updateData)) {
                        (new Delivery())->renewCache('adzone', $zid);
                        Session::flash('flash-message', 'Update Zone Success !');
                        return TRUE;
                    }
                }
            }
        } else {
            $this->data['errors'] = $validate->messages();
        }

        return FALSE;
    }

    function showGetCode($pid = 0, $wid = 0, $zid = 0)
    {
        $adZoneModel = new PublisherAdZoneBaseModel;
        $item = $adZoneModel->where('id', $zid)->first();
        if ($item) {
            View::addLocation(base_path() .'/backend/theme/'.$this->theme.'/views/partials');
            $view = "code".$item->adFormat->code_view;
            $data['wid'] = $item->publisher_site_id;
            $data['zid'] = $zid;
            $data['pid'] = $pid;
            $data['el_id'] = $item->element_id;
            $data['width'] = $item->width;
            $data['height'] = $item->height;
            $this->data['code'] = View::make($view, $data)->render();
            $this->data['item'] = $item;

            $this->loadLeftMenu('menu.publisherGetCode', array(
                'pid' => $pid,
                'wid' => $wid
            ));
            $this->layout->content = View::make('showGetCode', $this->data);
        }
    }


    function saveGetCode($pid = 0, $wid = 0, $zid = 0)
    {

        $adZoneModel = new PublisherAdZoneBaseModel;
        $item = $adZoneModel->where('id', $zid)->first();

        if ($item) {
            View::addLocation(base_path() .'/backend/theme/'.$this->theme.'/views/partials');
            $view = "code".$item->adFormat->code_view;
            //$view = Config::get("ad_format_code.$item->ad_format_id");


            $data['wid'] = $item->publisher_site_id;
            $data['zid'] = $zid;
            $data['pid'] = $pid;
            $data['el_id'] = $item->element_id;
            $data['width'] = $item->width;
            $data['height'] = $item->height;

            $contents = View::make($view . 'Save', $data);
            $response = Response::make($contents, '200');

            $response->header('Content-Description', 'File Transfer');
            $response->header('Content-Type', 'application/octet-stream');
            $response->header('Content-Disposition', "attachment; filename={$item->site->name}_{$item->adFormat->name}.txt");
            $response->header('Content-Transfer-Encoding', 'binary');
            $response->header('Expires', '0');
            $response->header('Cache-Control', 'must-revalidate');
            $response->header('Pragma', 'public');


            return $response;
        }

    }

    public function showViewSite($pid = 0, $id = 0)
    {
        $publisher = $this->model->find($pid);
        if (!$publisher) {
            return Redirect::to($this->moduleURL . 'show-list');
        }

        if ($id != 0) {
            $item = PublisherSiteBaseModel::find($id);
            $this->data['item'] = $item;
            if (!$item) {
                return Redirect::to($this->moduleURL . 'show-list');
            }
        }

        $this->loadLeftMenu('menu.publisherUpdate', array(
            'pid' => $pid,
            'wid' => $id
        ));
        $this->data['pid'] = $pid;
        $this->data['wid'] = $id;
        $this->layout->content = View::make('showViewSite', $this->data);

    }

    public function showDelSite($pid = 0, $wid = 0)
    {
        if ($pid == 0 || $wid == 0) {
            return Redirect::to($this->moduleURL . 'show-list');
        }

        $item = PublisherSiteBaseModel::find($wid);
        if (!$item) {
            return Redirect::to($this->moduleURL . 'show-list');
        }
        if ($item->publisher_id != $pid) {
            return Redirect::to($this->moduleURL . 'show-list');
        }
        if ($item->delete()) {
            return Redirect::to($this->moduleURL . 'view/' . $pid);
        }

    }

    function showView($id = 0)
    {
        $this->data['id'] = $id;
        $item = $this->model->find($id);
        if (!$item) {
            return Redirect::to($this->moduleURL . 'show-list');
        }

        //get site language
        $this->data['languageSelected'] = $item->language->lists('name', 'id');
        //get serve country
        $this->data['countryServeSelected'] = $item->serveCountry->lists('country_name', 'id');
        //get site channel
        $this->data['channelSelected'] = $item->channel->lists('name', 'id');

        $user = FALSE;
        if ($item->user_id != 0) {
            $user = Sentry::findUserById($item->user_id);
        }
        $this->data['user'] = $user;

        $this->data['item'] = $item;
        $this->loadLeftMenu('menu.publisherUpdate', array(
            'pid' => $id
        ));
        $this->layout->content = View::make('showView', $this->data);
    }

//    public function paymentRequest($id)
//    {
//        $this->data['id'] = $id;
//        $item = $this->model->find($id);
//        if (!$item) {
//            return Redirect::to($this->moduleURL . 'show-list');
//        }
//
//        $item->createMonthlyPaymentRequest();
//
//        $this->loadLeftMenu('menu.publisherUpdate', array(
//            'pid' => $id
//        ));
//
//        $this->data['listPaymentRequests'] = PaymentRequestBaseModel::where(array(
//            'publisher_id' => $id,
//        ))->orderBy('created_at', 'desc')->get();
//
//        $this->layout->content = View::make('showPaymentRequest', $this->data);
//
//    }
//
//    public function paymentRequestDetail($id)
//    {
//        $model = new PaymentRequestDetailBaseModel;
//        $data['data'] = $model->where('payment_request_id', $id)->with('campaign', 'publisher')->get();
//
//        if ($data['data']->count()) {
//            $data['publisher'] = $data['data']['0']->publisher;
//            $data['pubName'] = $data['publisher']->user->username;
//            return $model->exportExcel($data);
//        }
//
//        return false;
//    }

    /**
     *     Delete Item of module
     */
    function delete()
    {
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
     * @param  integer $id
     * @return Response
     */
    public function loadModal()
    {
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

    /**
     * Store a newly created resource in storage.
     * @param  array Form Data
     * @return Response
     */
    public function updateFlight()
    {
        if (Request::ajax()) {

            $status = FALSE;
            $message = NULL;
            $view = NULL;

            $publisherBaseCost = Input::get('publisher_base_cost');
            $flightPublisherId = Input::get('flightPublisherId');

            $flightPublisher = FlightPublisherAdvertiserManagerModel::where('id', $flightPublisherId)->first();

            if ($flightPublisher) {

                $flightPublisher->publisher_base_cost = $publisherBaseCost;
                if ($flightPublisher->save()) {

                    $status = TRUE;
                    $fpm = new FlightWebsiteBaseModel;
                    $this->data['listFlightPublisher'] = $fpm->getListByPublisherId($flightPublisher->publisher_id);

                    $view = View::make('flightList', $this->data)->render();
                }


            }

            return Response::json(array(
                'status' => $status,
                'message' => $message,
                'view' => $view
            ));
        }
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function deleteFlight()
    {

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

    public function ShowSelectFlight($id)
    {

        $this->loadLeftMenu('menu.Ad');

        View::share('jsTag', HTML::script("{$this->assetURL}js/select.js") . HTML::script("{$this->assetURL}js/Ad.js"));
        $item = $this->model->with('adFormat', 'campaign', 'flight')->find($id);

        if (!$item) {
            return Redirect::to($this->moduleURL . 'show-list');
        }
        $this->data['data'] = $item;
        $this->layout->content = View::make('ShowSelectFlight', $this->data);
    }

    function saveOrder()
    {
        if (Request::ajax()) {

            $listorder = Input::get('sort');

            if (is_array($listorder)) {
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

    public function loadModalAlternateAd()
    {

        $status = FALSE;
        $view = NULL;

        if (Request::ajax()) {
            $id = Input::get('id');

            $this->data = array(
                'id' => $id
            );

            if ($id != 0) {
                $item = AlternateAdBaseModel::find($id);
                $this->data['item'] = $item;
            }

            $status = TRUE;
            $view = View::make('alternateAdModal', $this->data)->render();

        }

        return Response::json(array(
            'status' => $status,
            'view' => $view
        ));

    }

    public function updateAlternateAd()
    {

        $status = FALSE;
        $view = NULL;

        if (Request::ajax()) {

            $id = Input::get('id');
            $zoneId = Input::get('zoneId');
            $name = trim(Input::get('name'));
            $code = trim(Input::get('code'));
            $weight = trim(Input::get('weight'));

            $zone = PublisherAdZoneBaseModel::find($zoneId);

            if ($zone) {

                if ($id == 0) {
                    $item = new AlternateAdBaseModel();
                    $item->created_by = $this->user->id;
                } else {
                    $item = AlternateAdBaseModel::find($id);
                }

                if ($item) {

                    $item->publisher_ad_zone_id = $zoneId;
                    $item->name = $name;
                    $item->code = $code;
                    $item->weight = $weight;
                    $item->updated_by = $this->user->id;

                    if ($item->save()) {
                        (new Delivery())->renewCache('adzone', $zoneId);
                        $status = TRUE;
                        $listAlternateAdData['lists'] = $zone->alternateAd;
                        $view = View::make('alternateAdList', $listAlternateAdData)->render();
                    }

                }

            }

        }

        return Response::json(array(
            'status' => $status,
            'view' => $view
        ));
    }


    public function deleteAlternateAd()
    {
        $status = FALSE;
        $view = NULL;

        if (Request::ajax()) {
            $id = Input::get('id');
            $zoneId = Input::get('zoneId');

            $zone = PublisherAdZoneBaseModel::find($zoneId);

            if ($zone) {
                $item = AlternateAdBaseModel::find($id);
                if ($item) {
                    if ($item->delete()) {
                        (new Delivery())->renewCache('adzone', $zoneId);
                        $status = TRUE;
                        $listAlternateAdData['lists'] = $zone->alternateAd;
                        $view = View::make('alternateAdList', $listAlternateAdData)->render();
                    }
                }

            }
        }

        return Response::json(array(
            'status' => $status,
            'view' => $view
        ));
    }

    /**
     *
     * Hien thi danh sach flight dang chay cua website
     */
    public function showListFlight()
    {
        if (Request::ajax()) {
            $wid = Input::get('website');
            $ad_format = Input::get('ad_format');
            $flightWebsiteBaseModel = new FlightWebsiteBaseModel();
            $this->data['data'] = $flightWebsiteBaseModel->getFlight($wid, $ad_format);
            return View::make('ajaxListFlight', $this->data);
        }
    }

    /**
     *
     * Change status
     */
    function changeStatus()
    {
        if(Request::ajax()){
            $id = Input::get('id');
            $currentStatus = Input::get('status');
            $status = ($currentStatus) ? 0 : 1;

            $flightWebsite = FlightWebsiteBaseModel::find($id);

            if($flightWebsite){
                $flightWebsite->status = $status;
                if($flightWebsite->save()){
                    (new Delivery())->renewCache('flight_website', $flightWebsite->id);

                    return View::make('ajaxChangeStatus', compact('flightWebsite'));
                }
            }
        }

        return "fail";
    }

    public function showPreview($fwid = 0, $id = 0)
    {
        if ($fwid != 0 && $id != 0) {
            $item = FlightBaseModel::with('ad', 'flightWebsite')->find($id);
            $flightWebsite = FlightWebsiteBaseModel::find($fwid);
            $isActive = isset($flightWebsite->status) ? $flightWebsite->status : 0;
            if ($item) {
                $data = $item;
                switch ($item->ad_format_id) {
                    case '8':
                        $view = View::make('previewVideo', compact('data', 'isActive'));
                        break;
                    case '9':
                        $view = '';
                        break;
                    case '12':
                        $view = View::make('previewBalloon', compact('data', 'isActive'));
                        break;
                    case '14':
                        $view = '';
                        break;
                    case '16':
                        $view = View::make('previewImage', compact('data', 'isActive'));
                        break;
                    default:
                        $view = '';
                        break;
                }
                return $view;
            }
        }
    }

    /**
     *
     * Make vast
     * @param $id
     */
    public function previewVast($id = 0)
    {
        if ($id != 0) {
            $ad = (new \Delivery())->getAd($id);
            if ($ad) {
                $XMLView = 'none';
                if (!empty($ad->id)) {
                    if ($ad->video_type_vast == 'inline') {
                        $XMLView = 'inline';
                    } else {
                        $XMLView = 'wrapper';
                    }
                }
                $header['Content-Type'] = 'application/xml';
                $header['Access-Control-Allow-Origin'] = '*';
                $header['Access-Control-Allow-Credentials'] = 'true';
                $header['Cache-Control'] = 'no-store, no-cache, must-revalidate, max-age=0';
                $header['Cache-Control'] = 'post-check=0, pre-check=0';
                $header['Pragma'] = 'no-cache';
                $body = View::make($XMLView)->with('ad', $ad);
            }
        } else {
            $body = '<VAST version="2.0"/>';
            $header['Content-Type'] = 'application/xml';
            $header['Cache-Control'] = 'no-store, no-cache, must-revalidate, max-age=0';
            $header['Cache-Control'] = 'post-check=0, pre-check=0';
            $header['Pragma'] = 'no-cache';
        }

        return Response::make($body, 200, $header);
    }

    function beforeReport()
    {

        $this->loadLeftMenu('menu.publisherList');
    }

    function report()
    {
        $this->beforeReport();
        $this->layout->content = View::make('showReport', $this->data);
    }

    function reportExport()
    {
        $monthArray = explode("/", Input::get("showmonth"));
        $month = 0;
        $year = 0;
        if (isset($monthArray[0]) && $monthArray[0] > 0 && isset($monthArray[1]) && $monthArray[0] > 0) {
            $month = $monthArray[0];
            $year = $monthArray[1];
            $firstOfMonth = Carbon::createFromDate($year, $month, 1)->firstOfMonth();
            $lastOfMonth = Carbon::createFromDate($year, $month, 1)->lastOfMonth();
            $Earn = new ReportEarningsPublisherModel;
            $rs = $Earn->getEarnReport($firstOfMonth, $lastOfMonth);
            $data = array();
            $dataSite = array();
            foreach ($rs as $item) {
                if ($item->flight != null) {
                    if ($item->website != null) {
                        $dataSite[$item->website->name]  = 1;
                        if(!isset($data[$item->flight->name][$item->website->name])){
                            $data[$item->flight->name][$item->website->name] = 0;
                        }
                    switch ($item->cost_type) {
                        case 'cpm':
                            $data[$item->flight->name][$item->website->name] += $item->amount_impression;
                            break;
                        case 'cpc':
                            $data[$item->flight->name][$item->website->name] += $item->amount_click;
                            break;
                    }
                    }
                }
            }
            foreach ($data as $key => $values) {
                $sum = 0;
                foreach ($values as $k => $v) {
                    $sum += (int)$v;
                }
                if ($sum == 0) {
                    unset($data[$key]);
                }
            }
            foreach ($dataSite as $site => $val) {
                $sum = 0;
                foreach ($data as $flight => $dataflight) {
                    if (isset($data[$flight]) && isset($data[$flight][$site])) {
                        $sum += (int)$data[$flight][$site];
                    }
                }
                if ($sum == 0) {
                    unset($dataSite[$site]);
                }
            }

            $data['data'] = $data;

            $data['dataSite'] = $dataSite;
            if(Input::get("submit") == "Show"){
                $this->beforeReport();
                $this->layout->content  = View::make('showReport', $data);
            }else{
                $excel = Excel::create("Payement_" . $month . "_" . $year);
                $excel->sheet("Payement_" . $month . "_" . $year, function ($sheet) use ($data) {
                    $sheet->loadView('reportExcel', $data);
                    $fromCell = PHPExcel_Cell::stringFromColumnIndex(count($data['data'])+1);
                    $toCell = count($data['dataSite'])+5;
                    $sheet->getStyle('B3:'.$fromCell.$toCell)->getNumberFormat()->setFormatCode('#,##0.00');
                });
                $excel->export('xls');
            }
        } else {
            return Redirect::to($this->moduleURL . 'report');
        }

    }
    function updateTrackingSumary(){
        $datas =  FlightWebsiteBaseModel::where("publisher_base_cost",">",0)->get();
        foreach($datas as $data){
            DB::table('tracking_summary')
                ->where('flight_website_id', $data->id)
                ->update(['publisher_base_cost' => $data->publisher_base_cost]);
        }
        return "";
    }
}
