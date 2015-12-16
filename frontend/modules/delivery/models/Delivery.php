<?php
use Illuminate\Database\Eloquent\Model as Eloquent;
class Delivery extends Eloquent{
	const TRACKING_CODE_ADID                          = 14; //ad format tracking code ID
	const REQUEST_TYPE_TRACKING_BEACON                = 1;
	const REQUEST_TYPE_AD                             = 2;
	const REQUEST_TYPE_TRACKING_CODE                  = 3;
	const AD_CACHE_TIME                               = 30;
	const FLIGHT_CACHE_TIME                           = 30;
	const RESPONSE_TYPE_FLIGHTDATE_NOT_AVAILABLE      = 'flightdate_not_available';
	const RESPONSE_TYPE_INVALID                       = 'invalid_request';
	const RESPONSE_TYPE_EMPTY_REFERRER                = 'empty_referrer';
	const RESPONSE_TYPE_REFERRER_NOT_MATCH            = 'referrer_not_match';
	const RESPONSE_TYPE_LOG_PREPROCESS_SUCCESS        = 'log_preprocess';
	const RESPONSE_TYPE_TRACKING_BEACON_SUCCESS       = 'tracking_beacon_success';
	const RESPONSE_TYPE_ADS_SUCCESS                   = 'ads_success';
	const RESPONSE_TYPE_GEO_LIMIT                     = 'geo_not_suitable';
	const RESPONSE_TYPE_GENDER_LIMIT                  = 'gender_not_suitable';
	const RESPONSE_TYPE_AGE_LIMIT                     = 'age_not_suitable';
	const RESPONSE_TYPE_AUDIENCE_LIMIT                = 'audience_not_suitable';
	const RESPONSE_TYPE_AD_ZONE_INVENTORY_LIMIT       = 'ad_zone_inventory_limited';
	const RESPONSE_TYPE_AD_ZONE_DAILY_INVENTORY_LIMIT = 'ad_zone_daily_inventory_limited';
	const RESPONSE_TYPE_INVENTORY_LIMIT               = 'inventory_limited';
	const RESPONSE_TYPE_DAILY_INVENTORY_LIMIT         = 'daily_inventory_limited';
	const RESPONSE_TYPE_CHANNEL_LIMIT                 = 'channel_not_suitable';
	const RESPONSE_TYPE_NOT_AVAILABLE                 = 'no_ads_available';
	const RESPONSE_TYPE_ANTI_MANY_REQUEST             = 'too_many_request';
	const RESPONSE_TYPE_EMPTY_VISITOR_ID              = 'empty_visitor_id';
	const RESPONSE_TYPE_FREQUENCY_CAPPED              = 'frequency_capped';
	const RESPONSE_TYPE_FLIGHT_VALUE_ADDED            = 'flight_does_not_apply_value_added';
	const RESPONSE_TYPE_FLIGHT_WEBSITE_VALUE_ADDED    = 'flight_website_does_not_apply_value_added';
	const DELIVERY_STATUS_OK                          = 'ready_to_deliver';
	const RESPONSE_TYPE_CHECKSUM_ERROR                = 'checksum_error';
	const DELIVERY_STATUS_OVER_REPORT				  = 'delivery_over_report';
	const ANTI_CHEAT_MAX_REQUEST_PER_1MIN             = 500;
	const ANTI_CHEAT_MAX_REQUEST_PER_5MIN             = 2000;


	/**
	 * kiểm tra status của ad và client trước khi trả về browser
	 */
	public function deliveryAd($ad, $flightWebsite, $flight, $dateRange){
		//kiểm tra limit inventory
		$deliveredAdStatus = $this->deliveredAdStatus($ad->id, $flightWebsite, $flight, $dateRange);

		return $deliveredAdStatus;

	}
	/**
	 * check client province in ad's geo target
	 * input array province number
	 * return boolean
	 */
	public function checkGeo($listCountries, $listProvinces){
		if(empty($listCountries)){
			return true;
		}

		$retval = false;
		$ip = getClientIp(); //live
		//test tren local
		if (isLocal()) {
		    $ip = '115.78.162.134'; // test
		}

        $geoip = GeoBaseModel::getGeoByIp($ip);
	    if($geoip){
	        if (empty($listProvinces)) {
	            $retval = in_array($geoip->country_code, $listCountries);
	        } else {
    	        $province = "{$geoip->country_code}:{$geoip->region}";
                $retval = in_array($province, $listProvinces);
	        }
        }
        // pr($geoip);
        // pr($retval);
        return $retval;
	}

	/**
	 * check client's age
	 * input array client's age range
	 * return boolean
	 */
	public function checkAge($listAge, $age = 0){
		if(empty($listAge)){
			return true;
		}
		return in_array($age, $listAge) ? true : false;
	}

	/**
	 * check client's age
	 * input array client's age range
	 * return boolean
	 */
	public function checkGender($targetGender, $clientGender){
		if(empty($targetGender)){
			return true;
		}
		else{
			if($clientGender == $targetGender){
				return true;
			}
		}
		return false;

	}

	/**
	 * check client's viewed an ad not greater than frequency cap
	 * input array client's age range
	 * return boolean
	 */
	/*public function checkFrequencyCap($flightId, $frequencyCap){
		$trackingModel = new Tracking;
		$todayCapped = $trackingModel->getTodayFreCap($flightId);
		if($todayCapped >= $frequencyCap){
			return false;
		}
		else{
			return true;
		}
	}*/
    public function checkFrequencyCap($flight, $flightDates){

		$todayCapped = (new Tracking())->getTodayFreCap($flight);
		$now = strtotime(date('Y-m-d 00:00:00'));
		if (!empty($flightDates)) {
    		foreach ($flightDates as $date) {
    			if(strtotime($date->start) <= $now && strtotime($date->end) >= $now){
        			if($date->frequency_cap > 0 && $todayCapped >= $date->frequency_cap){
            			return false;
            		}
    			}
    		}
		}
		return true;
	}

	/**
	 *  check inventory limit of requested flight
	 */
	public function checkInventory($flight, $flightWebsite, $event, $dateRange){
		$RawTrackingSummarry = new RawTrackingSummary;
		
		$rate = $flight->cost_type == 'cpm' ? 1000 : 1;
        $flightWebsiteInventory = !empty($flightWebsite) ? $flightWebsite->total_inventory * $rate : 0;
		$flightInventory        = $flight->total_inventory * $rate;
		if( $flightWebsiteInventory > 0 ){
			// tổng số inventory của flightWebsite (all time)
			$totalAdZoneInventory = $RawTrackingSummarry->getTotalAdZoneInventory($flight->id, $flightWebsite->id, $event);
			if($totalAdZoneInventory >= $flightWebsiteInventory){
				return self::RESPONSE_TYPE_AD_ZONE_INVENTORY_LIMIT;
			}

		}

		// tổng số inventory của flight (all time)
        $flightInventoryAllTime = $RawTrackingSummarry->getTotalInventory($flight->id, $event);

        if($flightInventoryAllTime >= $flightInventory){
			return self::RESPONSE_TYPE_INVENTORY_LIMIT;
		}

		if( $flight->is_fix_inventory == 1 && $flight->day){
			$flightInventoryPerDay = ceil($flightInventory / ($flight->day) );
			$flightInventoryThisTime = 0;
			$inventory = FlightBaseModel::getCurrentDayRun($dateRange, $flightInventoryPerDay);

			$flightInventoryThisTime = ($inventory['inventory_current']) * $rate;
            $flightInventoryInDay = $RawTrackingSummarry->getTotalInventoryInDay($flight->id, $event);

            $flightInventoryAllTimeExp = ($inventory['inventory_exp'] + $inventory['inventory_current']) * $rate;
            
			if(($flightInventoryAllTime >= $flightInventoryAllTimeExp) && ($flightInventoryInDay >= $flightInventoryThisTime)){
				return self::RESPONSE_TYPE_AD_ZONE_DAILY_INVENTORY_LIMIT;
			}
			
		}
		return true;
	}
	/**
	 *  check over inventory limit of requested flight
	 */
	public function checkOverInventory($flight, $flightWebsite, $event){
		$RawTrackingSummarry = new RawTrackingSummary;
		
		$rate = $flight->cost_type == 'cpm' ? 1000 : 1;

		$flightWebsiteInventoryOvr = $flightWebsite->value_added * $rate;
		$flightInventoryOvr = $flight->value_added * $rate;
        $flightRateOvr = 0;
        
        //Check flight co setup over report
        if ($flightInventoryOvr <= 0) {
            return self::RESPONSE_TYPE_FLIGHT_VALUE_ADDED;
        }
        
        //Check flight webiste co setup over report
	    if ($flightWebsiteInventoryOvr < 0) {
            return self::RESPONSE_TYPE_FLIGHT_WEBSITE_VALUE_ADDED;
        }
        
	    $flightRateOvr = $this->changePercentage($flight->value_added, $flight->total_inventory);
		// tổng số over inventory của flight (all time)
		$flightInventoryAllTimeOvr = $RawTrackingSummarry->getTotalInventory($flight->id, $event, true);
		$flightInventoryAllTime = $RawTrackingSummarry->getTotalInventory($flight->id, $event);

		$flightRateAllTimeOvr = $this->changePercentage($flightInventoryAllTimeOvr, $flightInventoryAllTime);

		if($flightInventoryAllTime <= 0 && $flightRateAllTimeOvr >= $flightRateOvr || $flightInventoryAllTimeOvr >= $flightInventoryOvr){
			return self::RESPONSE_TYPE_INVENTORY_LIMIT;
		}
		
	    if ($flightWebsiteInventoryOvr == 0) {
	        $fwRateOvr = $flightRateOvr;
	    } else {
	        $fwRateOvr = $this->changePercentage($flightWebsite->value_added, $flightWebsite->total_inventory);
	    }
	    
	    if ($flightWebsiteInventoryOvr > $flightInventoryOvr || $flightWebsiteInventoryOvr == 0) {
	        $flightWebsiteInventoryOvr = $flightInventoryOvr;
	    }
		
		$totalAdZoneInventoryOvr = $RawTrackingSummarry->getTotalAdZoneInventory($flight->id, $flightWebsite->id, $event, true);
		$totalAdZoneInventory = $RawTrackingSummarry->getTotalAdZoneInventory($flight->id, $flightWebsite->id, $event);

		$fwRateAllTimeOvr = $this->changePercentage($totalAdZoneInventoryOvr, $totalAdZoneInventory);

		if($totalAdZoneInventory <= 0 || $fwRateAllTimeOvr >= $fwRateOvr || $totalAdZoneInventoryOvr >= $flightWebsiteInventoryOvr) {
		    return self::RESPONSE_TYPE_AD_ZONE_INVENTORY_LIMIT;
		}
		
		return TRUE;
	}

	/**
	 * check delivery status and condition of requested flight
	 */

	public function deliveredAdStatus($adID, $flightWebsite, $flight, $dateRange){

		$trackingModel = new Tracking;

		//kiểm tra độ tuổi
		if($flight->age && !$this->checkAge( json_decode($flight->age), \Input::get('age') ) ){
			return self::RESPONSE_TYPE_AGE_LIMIT;
		}
		//kiểm tra giới tính
		if($flight->sex && !$this->checkGender($flight->sex, \Input::get('g') ) ){
			return self::RESPONSE_TYPE_GENDER_LIMIT;
		}

		//kiểm tra vị trí địa lí
		if($flight->country && $flight->province && !$this->checkGeo($flight->country,$flight->province) ){
			return self::RESPONSE_TYPE_GEO_LIMIT;
		}
		//kiểm tra frequency capping
		/*if( $flight->frequency_cap && (!$this->checkFrequencyCap($flight->id, $flight->frequency_cap) || Cookie::get(md5("FrequencyCap:$flightWebsite->id")) ) ){
			return self::RESPONSE_TYPE_FREQUENCY_CAPPED;
		}*/
	    if( !empty($dateRange) && (!$this->checkFrequencyCap($flight, $dateRange) || Cookie::get(md5("FrequencyCap:$flightWebsite->id")) ) ){
			return self::RESPONSE_TYPE_FREQUENCY_CAPPED;
		}

		// TODO : kiểm tra channel

		if( $flight->cost_type == 'cpm' || $flight->cost_type == 'cpc' ){
			$event = Tracking::getTrackingEventType($flight->cost_type);
			
		    $overReport = FALSE;
			$checkInventory = $this->checkInventory($flight, $flightWebsite, $event, $dateRange);
			if($checkInventory !== TRUE){
				//full inventory trong ngày
				// $checkOverInventory = $this->checkOverInventory($flight, $flightWebsite, $event);
				// if($checkOverInventory !== TRUE){
					return $checkInventory;
				// }
				// else{
				// 	$overReport = TRUE;
				// }
			} else {
			    $checkOvrInventory = $this->checkOverInventory($flight, $flightWebsite, $event);
		        pr($checkOvrInventory);
    			if ($checkOvrInventory === TRUE) {
        		    $overReport = TRUE;
        		}
			}
		}

		// WHEN READY TO DELIVERY
		//if( $flight->frequency_cap ){
		if (!empty($dateRange)) {
			$todayCapped = $trackingModel->getTodayFreCap($flight);
    		$now = strtotime(date('Y-m-d 00:00:00'));
    		foreach ($dateRange as $date) {
    			if(strtotime($date->start) <= $now &&  strtotime($date->end) >= $now){
    			    if($date->frequency_cap > 0 && $todayCapped >= ($date->frequency_cap-1) &&  $date->frequency_cap_time > 0 ){
        				$trackingModel->rememberFrequencyCap($flightWebsite->id, $date->frequency_cap_time);
        				$trackingModel->setTimeFreeCap($flight, $date->frequency_cap_time);
        			}
    			}
    		}
			/*if(  $todayCapped >= $flight->frequency_cap_free &&  $flight->frequency_cap_time > 0 ){
				$trackingModel->rememberFrequencyCap($flightWebsite->id, $flight->frequency_cap_time);
			}*/
		}

		return $overReport ? self::DELIVERY_STATUS_OVER_REPORT : self::DELIVERY_STATUS_OK;
	}
	/**
	 * sort available flights base on priority and retargeting
	 */
    public function sortAvailableFlightWebsites($listFlightWebsites){
        shuffle($listFlightWebsites);
        /*$arrayKey = array_keys($listFlightWebsites);
        foreach($listFlightWebsites as $k =>$flightWebsite) {
            $tracking = new Tracking();
            $cacheKey = "Retargeting";
            $cacheField = "{$flightWebsite->advertiser_id}_{$tracking->getVisitorId()}";
            $retargeting = RedisHelper::hGet($cacheKey, $cacheField, false);
            if ($retargeting) {
                $url = $flightWebsite->retargeting_url;
                $show = $flightWebsite->retargeting_show;
                $number = $flightWebsite->retargeting_number;
                $keyNumberTarget = "RetargetingNumber";
                $fieldNumberTarget = "{$flightWebsite->advertiser_id}_{$flightWebsite->id}_{$flightWebsite->ad_id}_{$tracking->getVisitorId()}";
                $retargeting_number =  RedisHelper::hGet($keyNumberTarget, $fieldNumberTarget);

                if (isset($retargeting->$url)) {
                    if($retargeting_number <= $number){
                        if ($show == 2) {
                             unset($listFlightWebsites[$k]);
                             unset($arrayKey[array_search($k, $arrayKey)]);
                        } elseif ($show == 1) {
                            if ($k != 0) {
                                $firstKey = array_shift($arrayKey);
                                $tmpflight = $listFlightWebsites[$firstKey];
                                $listFlightWebsites[$firstKey] = $flightWebsite;
                                $listFlightWebsites[$k] = $tmpflight;
                            } else {
                                unset($arrayKey[array_search($k, $arrayKey)]);
                            }
                        }
                    }else{
                       unset($listFlightWebsites[$k]);
                       unset($arrayKey[array_search($k, $arrayKey)]);
                    }
                }
            }
        }*/

		return $listFlightWebsites;
	}

	public function renewCache($object, $objectID ){
		$object = strtolower($object);
		$renewCache = true;
		switch ($object) {
			case 'flight':
				$flight = $this->getFlight($objectID, $renewCache);
				if($flight){
				    $this->getFlightDate($flight->id, $renewCache);
					$flightWebsites = FlightWebsiteBaseModel::where("flight_id", $flight->id)
															->whereRaw("( SELECT count(*) FROM `pt_flight` WHERE `ad_format_id` = {$flight->ad_format_id} AND id = `pt_flight_website`.`flight_id` AND `status` = 1) > 0")
															->get();
															
					if($flightWebsites){
						foreach ($flightWebsites as $fw) {
							$this->getFlightWebsite($fw->id, $fw->website_id, $flight->ad_format_id, $renewCache);
						}
					}
					
				}
				break;
			case 'flight_website':
			    $flightWebsite = DB::table('flight_website')
                    			->join('flight', 'flight_website.flight_id', '=', 'flight.id')
                    			->join('campaign', 'flight.campaign_id', '=', 'campaign.id')
                    			->where('flight_website.id', $objectID)
                    			->select('flight_website.id','flight_website.website_id','flight.ad_format_id')
                    			->first();
		         if ($flightWebsite) {
					$this->getFlightWebsite($objectID, $flightWebsite->website_id, $flightWebsite->ad_format_id, $renewCache);
				 }
			    break;
			case 'flight_date':
		        $this->getFlightDate($objectID, $renewCache);
			    break;
		    case 'ad':
			    $this->getAd($objectID, $renewCache);
				break;
			case 'adzone':
			    $this->getPublisherAdZone($objectID, $renewCache);
			    $this->getAlternateAds($objectID, $renewCache);
				$this->getAdzone($objectID, $renewCache);
				break;
			case 'publisher_site':
			    $this->getPublisherSite($objectID, $renewCache);
				break;
			case 'campaign':
			    $this->getCampaign($objectID, $renewCache);
				break;
			default:
				return false;
		}
		return true;
	}
	
    public function removeCache($object, $objectID ){
		$object = strtolower($object);
		$renewCache = true;
		switch ($object) {
			case 'flight':
				$flight = $this->getFlight($objectID);
				if($flight){
					$flightWebsites = FlightWebsiteBaseModel::where("flight_id", $flight->id)
															->whereRaw("( SELECT count(*) FROM `pt_flight` WHERE `ad_format_id` = {$flight->ad_format_id} AND id = `pt_flight_website`.`flight_id` AND `status` = 1) > 0")
															->get();
															
					if($flightWebsites){
					    $redis = new RedisBaseModel(Config::get('redis.redis_2.host'), Config::get('redis.redis_2.port'), false);
						foreach ($flightWebsites as $fw) {
						    $cacheKey = "FlightWebsite_{$fw->website_id}_{$flight->ad_format_id}";
		                    $cachField = $fw->id;
							$redis->hDel($cacheKey, $cachField);
						}
					}					
				}
				break;
			default:
				return false;
		}
		return true;
	}
	
    public function getAvailableAds($websiteID, $adFormat){
		$retval = $this->getFlightWebsite('', $websiteID, $adFormat);
		
		return $retval;		
	}

	public function getFullFlightInfo($flightWebsites, $websiteID, $adFormat, $renewCache = false){
		if(empty($flightWebsites)){
			return false;
		}
		
		$retval = [];
		foreach ($flightWebsites as $k => $fw) {
		    $flight = $this->getFlight($fw->flight_id);
		    if ($flight && $flight->status) {
    			$retval['flights'][$fw->flight_id] = $flight;
		        $retval['flightDates'][$fw->flight_id] = $this->getFlightDate($fw->flight_id);
		        $adID = $retval['flights'][$fw->flight_id]->ad_id;			
    			$retval['ads'][$adID] = $this->getAd($adID);	
		    }	
		}
		
		return $retval;
	}

	public function getFlightWebsite($flightWebsiteID = '', $websiteID, $adFormatID, $renewCache = false){
	    $redis = new RedisBaseModel(Config::get('redis.redis_2.host'), Config::get('redis.redis_2.port'), false);
		$cacheKey = "FlightWebsite_{$websiteID}_{$adFormatID}";
		$cachField = $flightWebsiteID;
		if ($cachField != '') {
		    $retval = $redis->hGet($cacheKey, $cachField);
		} else {
		    $retval = $redis->hGetAll($cacheKey);
		}
		if(Input::get('cleared') || $renewCache){
			$retval = 0;
			if ($flightWebsiteID != '') {
			    $redis->hDel($cacheKey, $cachField);
			}
		}
		if(!$retval){
		    $arrWhere['flight_website.status'] = 1;
		     $arrWhere['flight.status'] = 1;
		    
		    if ($flightWebsiteID != '') {
		        $arrWhere['flight_website.id'] = $flightWebsiteID;
		    }
		    if ($websiteID != '') {
		        $arrWhere['flight_website.website_id'] = $websiteID;
		    }
		    if ($adFormatID != '') {
		        $arrWhere['flight.ad_format_id'] = $adFormatID;
		    }
		   
			$retval = DB::table('flight_website')
			->join('flight', 'flight_website.flight_id', '=', 'flight.id')
			->join('campaign', 'flight.campaign_id', '=', 'campaign.id')
			->where($arrWhere)
			->select('flight_website.id','flight_website.platform','flight_website.flight_id',
					'flight_website.website_id','flight_website.total_inventory','flight_website.value_added',
					'flight_website.status','flight_website.publisher_base_cost','flight.ad_format_id',
			        'flight.retargeting_url','flight.retargeting_show','retargeting_number','campaign.advertiser_id','flight.ad_id')
			->get();
			if (!empty($retval)) {
			    foreach ($retval as $flightWebsite) {
			        $cachField = $flightWebsite->id;
			        $redis->hSet($cacheKey, $cachField, $flightWebsite);
			    }
			}
		}
		
		return $retval;
	}
	
	public function getAdzone($zoneID, $renewCache = false){
	    $redis = new RedisBaseModel(Config::get('redis.redis_2.host'), Config::get('redis.redis_2.port'), false);
		$cacheKey = "Adzone";
	    $cacheField = $zoneID;
		$retval = $redis->hGet($cacheKey, $cacheField);
		if(Input::get('cleared') || $renewCache){
		    $redis->hDel($cacheKey, $cacheField);
			$retval = 0;
		}
		if(!$retval){
			$retval = DB::table('publisher_ad_zone')->select('id','publisher_site_id','ad_format_id','alternatead','width','height','alternateadtype','alternatead','element_id')->where('id', $zoneID)->first();
			if($retval){
				//get site url
				$retval->site = DB::table('publisher_site')->select('url')->where('id', $retval->publisher_site_id)->first();
				$retval->alternateAds = DB::table('publisher_alternate_ad')->select('code','weight')->where('publisher_ad_zone_id', $zoneID)->get();
			}
			
			$redis->hSet($cacheKey, $cacheField, $retval);
		}
		
		return $retval;
	}

	public function getAd($adID, $renewCache = false){
	    $redis = new RedisBaseModel(Config::get('redis.redis_2.host'), Config::get('redis.redis_2.port'), false);
		$cacheKey = "Ad";
		$cacheField = $adID;
		$retval = $redis->hGet($cacheKey, $cacheField);
		if(Input::get('cleared') || $renewCache){
		    $redis->hDel($cacheKey, $cacheField);
			$retval = false;
		}
		if(!$retval){
			$retval = DB::table('ad')->where('id', $adID)->first();
			$redis->hSet($cacheKey, $cacheField, $retval);
		}
		return $retval;

	}

	public function checkFlightDate($listFlightDates, $flight){
		$retval = false;
		$now = strtotime(date('Y-m-d 00:00:00'));
		foreach ($listFlightDates as $flightDate) {
			if(strtotime($flightDate->start) <= $now &&  strtotime($flightDate->end) >= $now){
				//check active hour
				// -- Start -- Phuong-VM -- Comment -- 12-05-2015
				/*$startTime = $flight->start_hour ? intvalFromTimeText($flight->start_hour) : 0;
				$endTime = $flight->end_hour ? intvalFromTimeText($flight->end_hour) : 0;
				$nowTime = intvalFromTimeText(date('H:i:s'));
				if( ($startTime == 0 || $startTime <= $nowTime) && ($endTime == 0 || $endTime >= $nowTime) ){
					//passed
					$retval = true;
					break;
				}*/
				// -- Start -- Phuong-VM -- Comment -- 12-05-2015
				
				// -- Start -- Phuong-VM -- add -- 12-05-2015
				//$listHours = json_decode($flightDate->hour);
				if (!empty($flightDate->hour)) {
    				foreach ($flightDate->hour as $hour) {
    				    $startTime = $hour->start ? intvalFromTimeText($hour->start) : 0;
    				    $endTime = $hour->end? intvalFromTimeText($hour->end) : 0;
    				    $nowTime = intvalFromTimeText(date('H:i:s'));
        				if( ($startTime == 0 || $startTime <= $nowTime) && ($endTime == 0 || $endTime >= $nowTime) ){
        					//passed
        					$retval = true;
        					break;
        				}
    				}
				} else {
				    $retval = true;
				}
				// -- Start -- Phuong-VM -- add -- 12-05-2015
			}
		}
		return $retval;
	}

	public function getAlternateAds($zoneID, $renewCache = false){
	    $redis = new RedisBaseModel(Config::get('redis.redis_3.host'), Config::get('redis.redis_3.port'),false);
		$cacheKey = "PublisherAlternateAd";
		$cacheField= $zoneID;
		$retval = $redis->hGet($cacheKey, $cacheField);
		if(Input::get('cleared') || $renewCache){
		    $redis->hDel($cacheKey, $cacheField);
			$retval = false;
		}		
		if(!$retval){
			$retval = DB::table('publisher_alternate_ad')->select('code','weight')->where('publisher_ad_zone_id', $zoneID)->get();
			$redis->hSet($cacheKey, $cacheField, $retval);
		}

		return $retval;
	}
    
    /**
     * 
     * Get flight
     * @param int $id
     * @param bool $renewCache
     */
    public function getFlight($id, $renewCache=false) {
        $redis = new RedisBaseModel(Config::get('redis.redis_2.host'), Config::get('redis.redis_2.port'),false);
        $cacheKey = "Flight";
        $cacheField= $id;
        $retval = $redis->hGet($cacheKey, $cacheField);
        if(Input::get('cleared') || $renewCache){
            $redis->hDel($cacheKey, $cacheField);
			$retval = false;
		}
        if (!$retval) {
            $retval = DB::table('flight')->select('id','name','ad_id','ad_format_id','campaign_id','start_hour','end_hour',
            								'frequency_cap','frequency_cap_time','campaign_retargeting','age','sex','country',
            								'province','total_inventory','value_added','cost_type','event','is_fix_inventory',
            								'day','status','retargeting_url','retargeting_show','retargeting_number','category_id', 'audience', 'filter')
                                         ->where('id', $id)
                                         ->where('status', 1)
                                         ->first();
            if ($retval) {
                $retval->country = json_decode($retval->country);
                $retval->province = json_decode($retval->province);
            }
            $redis->hSet($cacheKey, $cacheField, $retval);
        }
        return $retval;
    }
    
    public function getFlightDate($flightID, $renewCache=false) {
        $redis = new RedisBaseModel(Config::get('redis.redis_2.host'), Config::get('redis.redis_2.port'),false);
        $cacheKey = "FlightDate";
        $cacheField = $flightID;
        $retval = $redis->hGet($cacheKey, $cacheField);
        if(Input::get('cleared') || $renewCache){
            $redis->hDel($cacheKey, $cacheField);
			$retval = false;
		}
        if (!$retval) {
            $flightDates = DB::table('flight_date')->select('flight_id','start','end','diff','hour','frequency_cap','frequency_cap_time','daily_inventory')
                                              ->orderBy('start','asc')
                                              ->where('flight_id', $flightID)
                                              ->get();
            if ($flightDates) {
                foreach ($flightDates as $flighDate) {
                    $flighDate->hour = json_decode($flighDate->hour);
                    $retval[] = $flighDate;
                }
            }
            $redis->hSet($cacheKey, $cacheField, $retval);
        }
        return $retval;
    }
	
    public function getFullFlightWebsite($flightWebsiteID, $websiteID, $adFormatID, $renewCache = false){
		$retval = array();
        $flightWebsite = $this->getFlightWebsite($flightWebsiteID, $websiteID, $adFormatID);
        
        if(!empty($flightWebsite) && count($flightWebsite) > 0){
		    $retval = $flightWebsite;
			$retval->flight = $this->getFlight($retval->flight_id);
			if($retval->flight){
				$retval->ad     = $this->getAd($retval->flight->ad_id);
			}
		}
		return $retval;
	}
	
	/**
	 * 
	 * Get publisher's site
	 * @param int $id
	 * @param bool $renewCache
	 */
	public function getPublisherSite($id, $renewCache=false) {
	    $redis = new RedisBaseModel(Config::get('redis.redis_2.host'), Config::get('redis.redis_2.port'),false);
	    $cacheKey = "PublisherSite";
	    $cacheField = $id;
		$retval = $redis->hGet($cacheKey, $cacheField);
		if(Input::get('cleared') || $renewCache){
		    $redis->hDel($cacheKey, $cacheField);
			$retval = 0;
		}
		if(!$retval){
			$retval = DB::table('publisher_site')->select('url')
			                                     ->where('id', $id)
			                                     ->first();
			$redis->hSet($cacheKey, $cacheField, $retval);
		}
		return $retval;
	}
	
    /**
     * 
     * Get add zone
     * @param int $zoneID
     * @param bool $renewCache
     */
	public function getPublisherAdZone($zoneID, $renewCache = false){
	    $redis = new RedisBaseModel(Config::get('redis.redis_2.host'), Config::get('redis.redis_2.port'),false);
		$cacheKey = "PublisherAdZone";
		$cacheField = $zoneID;
		$retval = $redis->hGet($cacheKey, $cacheField);
		if(Input::get('cleared') || $renewCache){
			$redis->hDel($cacheKey, $cacheField);
			$retval = 0;
		}
		if(!$retval){
			$retval = DB::table('publisher_ad_zone')->select('id','publisher_site_id','ad_format_id','alternatead','width','height','alternateadtype','alternatead')
			                                        ->where('id', $zoneID)
			                                        ->first();
            $redis->hSet($cacheKey, $cacheField, $retval);
		}
		return $retval;
	}
	
	/**
	 * 
	 * Get campaign
	 * @param int $campaignID
	 * @param bool $renewCache
	 */
	public function getCampaign($campaignID, $renewCache = false) {
	    $redis = new RedisBaseModel(Config::get('redis.redis_2.host'), Config::get('redis.redis_2.port'),false);
	    $cacheKey = "Campaign";
	    $cacheField = $campaignID;
		$retval = $redis->hGet($cacheKey, $cacheField);
		if(Input::get('cleared') || $renewCache){
		    $redis->hDel($cacheKey, $cacheField);
			$retval = 0;
		}
		if(!$retval){
			$retval = DB::table('campaign')->select('id','name','advertiser_id','category_id')
			                                     ->where('id', $campaignID)
			                                     ->first();
			$redis->hSet($cacheKey, $cacheField, $retval);
		}
		return $retval;
	}
	
	/**
	 * Detect device
	 */
	
	public function getPlatform() {
	    $detect = new MobileDetect;
	    if ($detect->isMobile() || $detect->isTablet()){
	        return 'mobile';
	    } else {
	        return 'pc';
	    }
	}
	
	public function changePercentage($value, $total, $type = '') {
	    if ($total <= 0) {
	        return 0;
	    } else {
	        $rate = $value / $total * 100;
	        switch($type) {
	            case 1:
	                $rate = floor($rate);
                    break;
                case 2:
	                $rate = round($rate, 4);
                    break;
                case 3:
	                $rate = ceil($rate);
                    break;
                default:
	                $rate = round($rate, 4);
                    break;
	        }
	        
	        return $rate;
	    }
	    
	}
}