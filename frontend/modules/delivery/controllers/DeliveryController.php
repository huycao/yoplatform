<?php

class DeliveryController extends BaseController
{
    public $MakeOvaHandle;

    public function __construct(MakeOvaHandle $MakeOvaHandle)
    {
        parent::__construct(pathinfo(dirname(__DIR__), PATHINFO_BASENAME));
        $this->MakeOvaHandle = $MakeOvaHandle;
    }

    public function makeOva()
    {
        $data = Input::all();

        if ($this->MakeOvaHandle->checkInputValid($data)) {
            View::addLocation(base_path() . '/frontend/theme/default/views/delivery');
            $this->data['vast'] = url() . "/make-vast?" . $_SERVER['QUERY_STRING'];
            return Response::view('ova', $this->data)->header('Content-Type', 'text/xml; charset=UTF-8');
        }

        exit();

    }

    public function makeVast()
    {

        $adID = Input::get('aid', 0);
        $flightWebsiteID = Input::get('fpid', 0);
        $publisherAdZoneID = Input::get('zid', 0);
        $checksum = Input::get('cs');
        $vast = new Advalue\VAST;
        return $vast->makeVAST($adID, $flightWebsiteID, $publisherAdZoneID, $checksum);
    }

    public function adsProcess()
    {
       //Cache::flush();
        $startProcess = microtime(1);
        ignore_user_abort(true);
        $this->layout = null;
        $response = null;
        $responseType = '';
        $expandFields = array();
        $deliveryStatus = '';

        $requestType = Input::get('rt', Delivery::REQUEST_TYPE_AD);
        $flightWebsiteID = Input::get('fpid', 0);
        $zoneID = Input::get('zid', 0);
        $websiteID = Input::get('wid', 0);
        $data = Input::all();

        $trackingModel = new Tracking;
        $deliveryModel = new Delivery;
        $vast = new Advalue\VAST;

        $isOverReport = $data['ovr'] = false;
        //ghi log trước khi xử lý
        $logPreProcess = $trackingModel->logPreProcess($requestType, $data);
        if ($logPreProcess) {
            //kiểm tra referrer
            $hostReferer = $trackingModel->getRequestReferer();
            $responseType = $trackingModel->checkPreProcess($requestType, $hostReferer, $zoneID);
            //pre validate ok
            if (empty($responseType)) {
                $adZone = $deliveryModel->getAdzone($zoneID);
                if (isset($data['type'])) {
                    $data['type'] = strtolower($data['type']);
                }

                if ($zoneID && $websiteID) {
                    if ($adZone && !empty($adZone->site)) {
                        $expandFields['ad_format_id'] = $adZone->ad_format_id;

                        if ($adZone->publisher_site_id == $websiteID) {
                            //kiểm tra referrer đúng với site đã đăng ký
                            // if(1){//test only
                            if (isSameDomain($hostReferer, getWebDomain($adZone->site->url)) || Input::get('ec') == 0 || isLocal()) {
                                $flightWebsites = $deliveryModel->getAvailableAds($adZone->publisher_site_id, $adZone->ad_format_id);
                                // shuffle($flightWebsites);
                                if ($flightWebsites) {
                                    //sort available flights base on priority and retargeting
                                    //TO DO retargeting
                                    $flightWebsites = $deliveryModel->sortAvailableFlightWebsites($flightWebsites);
                                    //lấy ad từ list thỏa điều kiện để trả về

                                    $deliveryInfo = $deliveryModel->getFullFlightInfo($flightWebsites, $adZone->publisher_site_id, $adZone->ad_format_id);

                                    foreach ($flightWebsites as $k => $flightWebsite) {

                                        if (!empty($deliveryInfo['flightDates'][$flightWebsite->flight_id]) && !empty($deliveryInfo['flights'][$flightWebsite->flight_id])) {

                                            $flightDates = $deliveryInfo['flightDates'][$flightWebsite->flight_id];
                                            $flight = $deliveryInfo['flights'][$flightWebsite->flight_id];
                                            $ad = $deliveryInfo['ads'][$flight->ad_id];
                                            $checkFlightDate = $deliveryModel->checkFlightDate($flightDates, $flight);
                                            //flight date ok
                                            if ($checkFlightDate) {

                                                $deliveryStatus = $deliveryModel->deliveryAd($ad, $flightWebsite, $flight, $flightDates);

                                                if ($deliveryStatus == Delivery::DELIVERY_STATUS_OK || $deliveryStatus == Delivery::DELIVERY_STATUS_OVER_REPORT) {
                                                    //pr($flight);
                                                    //trả về ad này
                                                    $serveAd = $ad;
                                                    $data['ad'] = $ad;
                                                    $data['aid'] = $ad->id;
                                                    $data['fpid'] = $flightWebsite->id;
                                                    //over report
                                                    if ($deliveryStatus == Delivery::DELIVERY_STATUS_OVER_REPORT) {
                                                        $data['ovr'] = $isOverReport = true;
                                                    }
                                                     $responseType = Delivery::RESPONSE_TYPE_ADS_SUCCESS;
                                                    // update number show retargeting
                                                    $url = $flight->retargeting_url;
                                                    if($url != ""){
                                                        $campaign = $deliveryModel->getCampaign($flight->campaign_id);
                                                        $tracking = new Tracking();
                                                        $key = "Retargeting:{$campaign->advertiser_id}:{$tracking->getVisitorId()}";

                                                        $cache = RedisHelper::get($key);

                                                        if (isset($cache->$url)) {
                                                            $keyNumberTarget = "RetargetingNumber:{$campaign->advertiser_id}:{$flight->id}:{$flight->ad_id}:{$tracking->getVisitorId()}";

                                                            $cacheNumberTarget = RedisHelper::get($keyNumberTarget);

                                                            if ($cacheNumberTarget) {
                                                                RedisHelper::increment($keyNumberTarget);
                                                            } else {
                                                                 RedisHelper::set($keyNumberTarget, 1);
                                                            }
                                                        }
                                                    }
                                                    break;
                                                }
                                            }
                                        }
                                    }
                                    //endforeach
                                }
                                //no ads available
                                if ($responseType != Delivery::RESPONSE_TYPE_ADS_SUCCESS) {
                                    $responseType = Delivery::RESPONSE_TYPE_NOT_AVAILABLE;
                                }
                            } else {
                                $responseType = Delivery::RESPONSE_TYPE_REFERRER_NOT_MATCH;
                            }
                        }
                    }
                }
            }

        }
        //invalid ads request
        if (empty($responseType)) {
            $responseType = Delivery::RESPONSE_TYPE_INVALID;
        } elseif ($responseType == Delivery::RESPONSE_TYPE_ADS_SUCCESS) {
            $expandFields = array(
                'flight_id' => $flightWebsite->flight_id,
                'ad_format_id' => $adZone->ad_format_id,
                'ad_id' => $flight->ad_id,
                'campaign_id' => $flight->campaign_id,
                'publisher_ad_zone_id' => $adZone->id,
                'flight_website_id' => $flightWebsite->id,
                'website_id' => $flightWebsite->website_id,
            );
            if ($isOverReport) {
                $expandFields['ovr'] = 1;
            }

            $expandFields['checksum'] = $checksum = $trackingModel->makeChecksumHash($flightWebsite->id, $trackingModel->created_at);
            $eventChecksum = Delivery::RESPONSE_TYPE_ADS_SUCCESS;
            $trackingModel->setChecksumTrackingEvent($checksum, Delivery::RESPONSE_TYPE_ADS_SUCCESS);

            (new RawTrackingSummary())->addSummary('ads_request', $flightWebsite->website_id, $adZone->id, $adZone->ad_format_id, $flightWebsite->flight_id, $flightWebsite->id, $flight->ad_id, $flight->campaign_id);

        }
        //serve Ad
        // if(0){
        if (!empty($serveAd)) {
            View::addLocation(base_path() . '/frontend/theme/default/views/delivery');
            if (isset($data['ec'])) {
                if ($data['ec'] == 1) {
                    $data['checksum'] = $expandFields['checksum'];
                    $this->data['data'] = $data;
                    $data['type'] = $serveAd->ad_view ? $serveAd->ad_view : strtolower($data['type']);
                    if (Input::get('test') == 1) {
                        return View::make($data['type'], $this->data);
                    } else {
                        $response = Response::view($data['type'], $this->data)->header('Content-Type', 'text/javascript; charset=UTF-8');
                    }
                } else {
                    $response = $vast->makeVAST($data['aid'], $data['fpid'], $data['zid'], $expandFields['checksum'], $isOverReport);
                }

            }

        } else {
            //TO DO : return backup ads
            if (!empty($adZone)) {
                $alternateAds = $deliveryModel->getAlternateAds($adZone->id);
                if (isset($adZone) && $alternateAds) {
                    if (isset($data['ec']) && !$data['ec']) {
                        $response = $vast->makeEmptyVast();
                    } else {
                        $this->data['listAlternateAd'] = $alternateAds;
                        $this->data['zid'] = $adZone->id;
                        View::addLocation(base_path() . '/frontend/theme/default/views/delivery');
                        $response = Response::view('rotator', $this->data)->header('Content-Type', 'text/javascript; charset=UTF-8');
                    }
                } else {
                    if (isset($data['ec']) && !$data['ec']) {
                        $response = $vast->makeEmptyVast();
                    }
                }

                (new RawTrackingSummary())->addSummaryRequestEmptyAd($adZone->id, $adZone->ad_format_id, $websiteID);
            }
        }
        //ghi log process
        $trackingModel->logAfterProcess($responseType, $expandFields, $logPreProcess);


        //response to client
        $endProcess = microtime(1);
        pr($deliveryStatus);
        pr($responseType, 1);
        return $response;
    }

    public function trackEvent()
    {
        ignore_user_abort(true);
        $this->layout = null;
        $response = null;
        $responseType = '';
        $expandFields = array();
        $deliveryStatus = '';

        $event = strtolower(Input::get('evt', ''));
        $requestType = Input::get('rt', Delivery::REQUEST_TYPE_TRACKING_BEACON);
        $checksum = Input::get('cs', '');
        $flightWebsiteID = Input::get('fpid', 0);
        $zoneID = Input::get('zid', 0);
        $isOverReport = Input::get('ovr');

        //custom code for VIB 068 Relaunch form complete tracking
        if (Input::get('wid') == 48 && $event == 'complete') {
            $flightWebsiteID = 172;
            $event = "impression";
        }

        $trackingModel = new Tracking;
        $deliveryModel = new Delivery;
        //ghi log trước khi xử lý
        $logPreProcess = $trackingModel->logPreProcess($requestType, Input::get());

        if ($logPreProcess) {
            //kiểm tra referrer
            $hostReferer = $trackingModel->getRequestReferer();
            $responseType = $trackingModel->checkPreProcess($requestType, $hostReferer, $zoneID);
            if (empty($responseType)) {
                $adZone = $deliveryModel->getAdzone($zoneID);

                if ($adZone) {
                    if (isSameDomain($hostReferer, getWebDomain($adZone->site->url)) || isLocal()) {
                        $flightWebsite = $deliveryModel->getFullFlightWebsite($flightWebsiteID);
                        if ($flightWebsite) {
                            //checksum
                            if ($flightWebsite->flight->ad_format_id == Delivery::TRACKING_CODE_ADID) {
                                $responseType = Delivery::RESPONSE_TYPE_TRACKING_BEACON_SUCCESS;
                            } elseif ($trackingModel->isValidTrackingBeacon($checksum, $event)) {
                                $responseType = Delivery::RESPONSE_TYPE_TRACKING_BEACON_SUCCESS;
                                //set cookie for retargeting
                                $trackingModel->rememberRetarget($flightWebsite->flight->campaign_id, $event);
                            } else {
                                $responseType = Delivery::RESPONSE_TYPE_CHECKSUM_ERROR;
                            }
                        }
                        //else invalid
                    }
                }
            }
            if (empty($responseType)) {
                $responseType = Delivery::RESPONSE_TYPE_INVALID;
            } elseif ($responseType == Delivery::RESPONSE_TYPE_TRACKING_BEACON_SUCCESS) {
                $expandFields = array(
                    'flight_id' => $flightWebsite->flight_id,
                    'ad_format_id' => $adZone->ad_format_id,
                    'ad_id' => $flightWebsite->flight->ad_id,
                    'campaign_id' => $flightWebsite->flight->campaign_id,
                    'publisher_ad_zone_id' => $adZone->id,
                    'flight_website_id' => $flightWebsite->id,
                    'website_id' => $flightWebsite->website_id,
                );


                $expandFields['checksum'] = $checksum;
                $eventChecksum = $event;
                $trackingModel->setChecksumTrackingEvent($checksum, $event);

                //udpate inventory
                //$inventoryMetric = $trackingModel->getTrackingEventType($flightWebsite->flight->cost_type);
                $inventoryMetric = $trackingModel->getTrackingEventType($flightWebsite->flight->cost_type);
                if ($event == $inventoryMetric) {
                    $trackingModel->updateInventory($flightWebsite->flight->id, $flightWebsite->id, $inventoryMetric, $isOverReport);
                }

                if (isset($flightWebsite->flight->event) && $flightWebsite->flight->event != '') {
                    $flightEvent = $flightWebsite->flight->event;
                } else {
                    // Truong hop nhung flight truoc day khong co setting event
                    $flightEvent = $inventoryMetric;
                }

                if ($event == $flightEvent) {
                    //incre today capped this ad by 1
                    $trackingModel->incFreCap($flightWebsite->flight);
                }

                //update tracking summary
                $rawTrackingSummary = new RawTrackingSummary();
                $rawTrackingSummary->addSummary($event, $flightWebsite->website_id, $adZone->id, $adZone->ad_format_id, $flightWebsite->flight_id, $flightWebsite->id, $flightWebsite->flight->ad_id, $flightWebsite->flight->campaign_id);

                $uniqueEvent = '';
                //unique impression
                if ($event == 'impression') {
                    $uniqueEvent = 'unique_impression';
                    $expandFields['unique_impression'] = $trackingModel->isUniqueImpression($flightWebsite->id);

                }
                //unique click
                if ($event == 'click') {
                    $uniqueEvent = 'unique_click';
                    $expandFields['unique_click'] = $trackingModel->isUniqueClick($flightWebsite->id);
                }

                //add summary unique click or impression
                if (!empty($expandFields[$uniqueEvent])) {
                    $rawTrackingSummary->addSummary($uniqueEvent, $flightWebsite->website_id, $adZone->id, $adZone->ad_format_id, $flightWebsite->flight_id, $flightWebsite->id, $flightWebsite->flight->ad_id, $flightWebsite->flight->campaign_id);
                }
            }
        }


        //ghi log process
        $logAfterProcess = $trackingModel->logAfterProcess($responseType, $expandFields, $logPreProcess);


        //response to client
        pr($expandFields);
        pr($responseType, 1);
        if ($event == 'click' && Input::get('to')) {
            //redirect to ad's destination url on click event
            return Redirect::to(urldecode(Input::get('to')));
        } else {
            //return 1x1 transparent GIF
            $response = $trackingModel->outputTransparentGif();
            // exit();
        }
    }

    public function retargeting() {
        $adv = Input::get("adv");
        if($adv <= 0){
            return "";
        }
        $referer_url = "";
        if (isset($_SERVER['HTTP_REFERER'])) {
            $referer_url = $_SERVER['HTTP_REFERER'];
        }

        if ($referer_url != "") {
            $tracking = new Tracking();
            $key = "Retargeting:{$adv}:{$tracking->getVisitorId()}";
            $key_referer_url = $referer_url;
            $cache = RedisHelper::get($key);
            if ($cache == null) {
                $array = new stdClass();
                $array->$referer_url = $referer_url;
                RedisHelper::set($key, $array);
            }else{
                $array = $cache;
                $array->$referer_url = $referer_url;
                RedisHelper::set($key, $array);
            }
        }
    }
    
    public function retargetingtest()
    {
        
    }
}