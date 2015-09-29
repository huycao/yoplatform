<?php
use DeviceDetector\Parser\Device\DeviceParserAbstract;
use DeviceDetector\DeviceDetector;
use Piwik\Common;
class Tracking extends Moloquent{
	const ENCRYPT_KEY = "WX77h2pVRTTEPEP5halkbrw9NIBvIKkHT";
	protected $table = 'trackings_2015_05';
	protected $connection = 'mongodb';


    public function __construct(){
        $this->table = 'trackings_' . date("Y_m");
    }

	public function getDates()
	{
	    return [];
	}

	public $clientInfo = array();

	public function checkPreProcess($requestType, $hostReferer, $zoneID){
		$retval = '';
		if(empty($zoneID)){
			$retval = Delivery::RESPONSE_TYPE_INVALID;
		}
		elseif( empty($hostReferer) && Input::has('ec') && Input::get('ec')  && !isLocal()){
			$retval = Delivery::RESPONSE_TYPE_EMPTY_REFERRER;
		}
		elseif( !isLocal()){
			$isBlocked = $this->isBlockedIp($zoneID);
			if($isBlocked || ($this->countLatestRequest($zoneID , 1) > Delivery::ANTI_CHEAT_MAX_REQUEST_PER_1MIN || $this->countLatestRequest($zoneID,5) > Delivery::ANTI_CHEAT_MAX_REQUEST_PER_5MIN)){

				$retval = Delivery::RESPONSE_TYPE_ANTI_MANY_REQUEST;
				if(!$isBlocked){
					$this->setBlockIp($zoneID);
				}
			}
		}
		return $retval;
	}

	public function setBlockIp($zoneID){
		$ip = getIP();
		$cacheKey = "BlockIP:{$zoneID}:{$ip}";
		return RedisL4::set($cacheKey, true, CACHE_2D);
	}

	public function isBlockedIp($zoneID){
		$ip = getIP();
		$cacheKey = "BlockIP:{$zoneID}:{$ip}";
		if(RedisHelper::exist($cacheKey)){
			return true;
		}
		return false;
	}

	public function logPreProcess($requestType, $inputData = array()){
		if($requestType != Delivery::REQUEST_TYPE_TRACKING_BEACON){
			//tăng bộ đếm số lần request từ IP client
			$this->incLatestRequest(Input::get('zid', 0));
		}

		$clientInfo = $this->getClientInfo();
		if($clientInfo){
			if( isset($clientInfo['os']['name']) ){
				$this->os               = $clientInfo['os']['name'];
			}
			if( isset($clientInfo['client']['name']) ){
				$this->browser          = $clientInfo['client']['name'];
			}
			if( isset($clientInfo['client']['browser_language']) ){
				$this->browser_language = $clientInfo['client']['browser_language'];
			}
		}

		if( isset($inputData['ovr']) ){
			$this->ovr = $inputData['ovr'];
		}

		if($requestType == Delivery::REQUEST_TYPE_TRACKING_BEACON){
			//tracking beacon
			$this->response_type = Delivery::RESPONSE_TYPE_TRACKING_BEACON_SUCCESS;
		}
		else{
			$this->response_type = Delivery::RESPONSE_TYPE_LOG_PREPROCESS_SUCCESS;
		}
		$this->status               = 0;
		$this->user_agent           = $_SERVER['HTTP_USER_AGENT'];
		$this->visitor_ip           = getClientIp();
		$this->referer              = $this->getRequestReferer();
		$this->request_type         = $requestType;
		$this->hour                 = date('G');
		$this->date                 = date('Y-m-d');
		$this->event                = !empty($inputData['evt']) ? strtolower($inputData['evt']) : '';
		$this->query                = $_SERVER['QUERY_STRING'];
		$this->visitor_id           = $this->getVisitorId();
		$this->flight_id            = Input::get('fid', 0);
		$this->ad_format_id         = 0;
		$this->ad_id                = Input::get('aid', 0);
		$this->campaign_id          = 0;
		$this->publisher_ad_zone_id = Input::get('zid', 0);
		$this->flight_website_id    = Input::get('fpid', 0);
		$this->website_id           = Input::get('wid', 0);
		$this->unique_impression    = 0;
		
		if($this->save()){
			return $this;
		}
		return false;
	}


	/**
	 * kết thúc request, update status
	 */
	public function logAfterProcess($responseType, $expandFields = array()){
		//remember visitor
		$this->setVisitorId($this->visitor_id);

		if($expandFields && is_array($expandFields)){
			foreach ($expandFields as $key => $val) {
				$this->{$key}	= is_numeric($val) ? intval($val) : $val;
			}
		}
		$this->response_type = $responseType;
		$this->status = 1;
		if( $this->save() ){
			return $this;
		}else{
			return FALSE;
		}
	}

	public function getRequestReferer(){
		return !empty($_SERVER['HTTP_REFERER']) ? getWebDomain($_SERVER['HTTP_REFERER']) : '';
	}

	/**
	 * số lượng request từ 1 ip trong 1 khoảng thời gian
	 */
	public function countLatestRequest($zoneID, $minute = 1, $ip = ''){
		$ip = $ip ? $ip : getClientIp();
		$now = time();
		$from = strtotime("-{$minute} " . $minute > 1 ? "minutes" : "minute");
		$cacheKey = "LatestRequest:{$zoneID}:{$ip}";
		return RedisL4::zcount($cacheKey, $from, $now);
	}

	/**
	 *  tăng số lượng request từ 1 ip trong 1 khoảng thời gian
	 */
	public function incLatestRequest($zoneID , $ip = ''){
		$ip = $ip ? $ip : getClientIp();
		$cacheKey = "LatestRequest:{$zoneID}:{$ip}";
		RedisL4::zadd($cacheKey, time(), microtime());
		return RedisL4::expire($cacheKey, strtotime("+10 minutes"));
	}

	/**
	 * detect request from BOT via user agent
	 */

	public function isBot($userAgent = ''){
		$userAgent = $userAgent ? $userAgent : $_SERVER['HTTP_USER_AGENT'];
		DeviceParserAbstract::setVersionTruncation(DeviceParserAbstract::VERSION_TRUNCATION_NONE);
        $dd = new DeviceDetector($userAgent);

        // OPTIONAL: If called, getBot() will only return true if a bot was detected  (speeds up detection a bit)
        $dd->discardBotInformation();

        $dd->parse();

        return $dd->isBot();
	}
	/**
	 * Information about client requesting
	 * cache base on  user agent + client ip
	 */
	public function getClientInfo($userAgent = ''){
		if($this->clientInfo){
			return $this->clientInfo;
		}
		$userAgent = $userAgent ? $userAgent : @$_SERVER['HTTP_USER_AGENT'];
		$UAHash    = $this->makeUserAgentHash($userAgent);
		$cacheKey  = "ClientInfo:{$UAHash}";
		$fromCache = RedisHelper::get($cacheKey);
		if(!$fromCache){
			DeviceParserAbstract::setVersionTruncation(DeviceParserAbstract::VERSION_TRUNCATION_NONE);
	        $dd = new DeviceDetector($userAgent);

	        // OPTIONAL: If called, getBot() will only return true if a bot was detected  (speeds up detection a bit)
	        $dd->discardBotInformation();

	        $dd->parse();

	        if ($dd->isBot()) {
	          // handle bots,spiders,crawlers,...
	          // $clientInfo = $dd->getBot();
	        	return false;
	        } else {
				$clientInfo['client']           = $dd->getClient(); // holds information about browser, feed reader, media player, ...
				$clientInfo['os']               = $dd->getOs();
				$clientInfo['device']           = $dd->getDevice();
				$clientInfo['brand']            = $dd->getBrand();
				$clientInfo['model']            = $dd->getModel();
				$piwik                          = new Common;
				$clientInfo['client']['browser_language'] = $piwik::getBrowserLanguage();
	        }

	        RedisHelper::set($cacheKey, json_encode($clientInfo) ,Config::get('cache_time.defaultCacheTimeInSeconds'));
		}
		else{
			$clientInfo = json_decode($fromCache, 1);
		}
        $this->clientInfo = $clientInfo;

        return $clientInfo;
    }


    /**
     * ouput 1x1 transparent gif
     */
    public function outputTransparentGif(){
        header('Content-Type: image/gif');
        header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
		echo base64_decode("R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==");
		exit();
    }

    public function setVisitorId($visitorId = ''){
		if(!$visitorId){
    		$visitorId = $this->makeVisitorId();
    		$this->visitor_id = $visitorId;
    	}
    	return Cookie::make('Tracking:VisitorId', $visitorId, Config::get('cache_time.dayInSeconds'));
    }

    public function getVisitorId(){
    	if(empty($this->visitor_id)){
    		$this->setVisitorId();
    	}
    	return $this->visitor_id;
    }
    /**
     * make unique visitor id base on client IP and client Browser User Agent
     */
    public function makeVisitorId($userAgent = '', $clientIp = ''){	
		$userAgent = $userAgent ? $userAgent : $_SERVER['HTTP_USER_AGENT'];
		$clientIp  = $clientIp ? $clientIp : getClientIp();
    	return md5( $userAgent . $clientIp);
    }

    public function makeUserAgentHash($userAgent = ''){
    	$userAgent = $userAgent ? $userAgent : $_SERVER['HTTP_USER_AGENT'];
    	return md5($userAgent);
    }


    public function reportSchedule($numRecord = 30000){
    	set_time_limit(0);
    	$tblTSS = 'tracking_summary_schedule';
    	$cacheKey = "Report:Schedule";
    	if(RedisHelper::get($cacheKey)){
    		return false;
    	}
    	RedisHelper::set($cacheKey, 1, 2);
		// begin transaction
		DB::beginTransaction();

		$beginAt    = new MongoDate(strtotime('2015-03-31 14:46:18'));
		$lastReport = DB::table($tblTSS)->orderBy('id','desc')->first();
		if($lastReport){
			// time - 1 để chắc rằng ko bị sót record
			$beginAt = new MongoDate($lastReport->last_record_sec - 2);
		}
		
		$endAt          = new MongoDate(strtotime("-1 minute"));
		$data = $this->where('created_at', '>=', $beginAt )
					 	->where('created_at', '<', $endAt)
						->take($numRecord)
						->get();
		pr($data->count());
		// pr($endAtTimestamp);
		// pr($data->toArray());
		try{

			if($data->count() > 0) {
				// insert new report schedule
				$trackingSummaryScheduleID = DB::table($tblTSS)->insertGetId(
					array(
						'begin_at'	=>	date('Y-m-d H:i:s')
					)
				);
				$reportArr = array();
				$uniqueVisitor = array();
				$lastRecord = '';
				foreach ($data as $k => $record) {

					//check duplicate record on report
					if($lastReport && $record->_id == $lastReport->last_record_id){
						$reportArr = array();
						continue;
					}

					$record->event = strtolower($record->event);
					$isOverReport = !empty($record->ovr) ? 'OverReport' : "NormalReport";
					$key = "{$isOverReport}:{$record->date}:{$record->hour}:{$record->publisher_ad_zone_id}:{$record->website_id}:{$record->flight_website_id}";
					if(empty($reportArr[$key])){
						$reportArr[$key] = array(
							'publisher_ad_zone_id'=>	$record->publisher_ad_zone_id,
							'ad_id'               =>	$record->ad_id,	
							'ad_format_id'        =>	$record->ad_format_id,
							'campaign_id'         =>	$record->campaign_id,
							'flight_id'           =>	$record->flight_id,
							'flight_website_id'   =>	$record->flight_website_id,
							'website_id'       	  =>	$record->website_id,
							'hour'                =>	$record->hour,
							'date'                =>	$record->date
						);
					}
					//ads reponses summary
					$reportArr[$key][$record->response_type] = empty($reportArr[$key][$record->response_type]) ? 1 : $reportArr[$key][$record->response_type] + 1;
					//ads request summary
					if($record->request_type == Delivery::REQUEST_TYPE_AD){
						$reportArr[$key]['ads_request'] = empty($reportArr[$key]['ads_request']) ? 1 : $reportArr[$key]['ads_request'] + 1;
					}
					
					if($record->status){
						if($record->response_type == Delivery::RESPONSE_TYPE_TRACKING_BEACON_SUCCESS){
							if(!empty($reportArr[$key][$record->event])){
								$reportArr[$key][$record->event]++;	
							}
							else{
								$reportArr[$key][$record->event] = 1;
							}
							if($record->event == 'impression' && !empty($record->unique_impression)){
								$reportArr[$key]['unique_impression'] = empty($reportArr[$key]['unique_impression']) ? 1 : $reportArr[$key]['unique_impression'] + 1;
							}
							if($record->event == 'click' && !empty($record->unique_click)){
								$reportArr[$key]['unique_click'] = empty($reportArr[$key]['unique_click']) ? 1 : $reportArr[$key]['unique_click'] + 1;
							}
						}
						
					}
					else{
						$reportArr[$key]['failed_request'] = empty($reportArr[$key]['failed_request']) ? 1 : $reportArr[$key]['failed_request'] + 1;
					}
						
				}
				//đánh dấu record cuối cùng đã xử lý
				$lastRecord = $record;
				// pr($lastRecord);
				pr($record->created_at);
				// no record -> return
				if(!$lastRecord){
					throw new Exception();
				}
				
				$incrFields = array('impression','unique_impression','ads_request', 'click','unique_click','start','firstquartile','midpoint','thirdquartile','complete','fullscreen','mute','invalid_request','empty_referrer','referrer_not_match','log_preprocess','tracking_beacon_success','ads_success','geo_not_suitable','gender_not_suitable','age_not_suitable','audience_not_suitable','ad_zone_inventory_limited','ad_zone_daily_limited', 'inventory_limited','daily_inventory_limited','channel_not_suitable','no_ads_available','too_many_request','empty_visitor_id','ready_to_deliver','frequency_capped','checksum_error','failed_request');
				$affectedRows = 0;
				// pr($reportArr);	
				foreach ($reportArr as $key => $record) {
					$isOVR = strpos($key, 'OverReport') !== FALSE ? 1 : 0;
					$checkRecord = TrackingSummaryBaseModel::where(
					[
						'flight_website_id'    => $record['flight_website_id'],
						'publisher_ad_zone_id' => $record['publisher_ad_zone_id'],
						'website_id'           => $record['website_id'],
						'date'                 => $record['date'],
						'hour'                 => $record['hour'],
						'ovr'                  => $isOVR	
					])
					->first();

					if(!$checkRecord){
						$trackingSummary = new TrackingSummaryBaseModel;
						$update = false;
					}
					else{
						$trackingSummary = $checkRecord;
						$update = true;
					}
					foreach ($record as $k => $v) {
						$trackingSummary->ovr = $isOVR;
						if($update){
							if(in_array($k, $incrFields)){
								$trackingSummary->{$k} = $trackingSummary->{$k} + $v;	
							}
						}
						else{
							$trackingSummary->{$k} = $v;
						}
						
					}	
					$trackingSummary->save();
					$affectedRows++;
				}
				DB::table($tblTSS)->where('id', $trackingSummaryScheduleID)->update(
					array(
						'finish_at'        =>	date('Y-m-d H:i:s'),
						'last_record_id'   =>	$lastRecord->_id,
						'last_record_sec'  =>	$lastRecord->created_at->sec,
						'last_record_usec' =>	$lastRecord->created_at->usec,
					)
				);
				
				if(!empty($lastRecord)){
					DB::commit();
					echo "Mongo Records: " . $data->count();
					echo "\r\n<br/> Last Mongo Date : " . date('H:i:s d-m-Y', $lastRecord->created_at->sec);
					echo "\r\nTracking Summary rows affected : ". $affectedRows;
					echo "\r\n";
					pr($affectedRows);
					return $affectedRows;
				}

				
			}

		}
		catch(\Exception $e){
			DB::rollback();
			// throw $e;
			return false;
		}
		
	}
    
    public function isUniqueImpression($flight_website_id, $date = ''){
    	$visitorId = $this->getVisitorId();
    	$cacheKey = "UniqueImpression:{$flight_website_id}:{$date}:{$visitorId}";
    	$retval = RedisHelper::exist($cacheKey);
    	if(!$retval){
    		RedisHelper::set($cacheKey, true, CACHE_1D);
    		return true;
    	}
    	return false;
    }
    public function isUniqueClick($flight_website_id, $date = ''){
    	$visitorId = $this->getVisitorId();
    	$cacheKey = "UniqueClick:{$flight_website_id}:{$date}:{$visitorId}";
    	$retval = RedisHelper::exist($cacheKey);
    	if(!$retval){
    		RedisHelper::set($cacheKey, true, CACHE_1D);
    		return true;
    	}
    	return false;
    }

    /*public function incFreCap($flightId){
    	$visitorId = $this->getVisitorId();
    	$today = date('Y_m_d');
    	$cacheKey = "Tracking:FrequencyCap:{$flightId}:{$visitorId}:{$today}";
    	$todayFreCap = $this->getTodayFreCap($flightId);
    	if(!$todayFreCap){
    		return Cache::put($cacheKey, 1, CACHE_1D);
    	}
    	else{
    		return Cache::increment($cacheKey);
    	}

    }*/
    public function incFreCap($flight){
    	$visitorId = $this->getVisitorId();
    	$today = date('Y_m_d');
    	$cacheKey = "Tracking:FrequencyCap:{$flight->id}:{$visitorId}:{$flight->event}:{$today}";
    	$todayFreCap = $this->getTodayFreCap($flight);
    	if(!$todayFreCap){
    		return RedisHelper::set($cacheKey, 1, CACHE_1D);
    	}
    	else{
    		return RedisHelper::increment($cacheKey);
    	}

    }

    /*public function getTodayFreCap($flightId){
    	$visitorId = $this->getVisitorId();
    	$today = date('Y_m_d');
    	$cacheKey = "Tracking:FrequencyCap:{$flightId}:{$visitorId}:{$today}";
    	$fromCache = Cache::get($cacheKey);
    	if($fromCache){
    		return $fromCache;
    	}
    	return 0;
    }*/
    public function getTodayFreCap($flight){
    	$visitorId = $this->getVisitorId();
    	$today = date('Y_m_d');
    	$cacheKey = "Tracking:FrequencyCap:{$flight->id}:{$visitorId}:{$flight->event}:{$today}";
    	$fromCache = RedisHelper::get($cacheKey);
    	if($fromCache){
    		return $fromCache;
    	}
    	return 0;
    }
    
    public function setTimeFreeCap($flight, $expire) {
        $visitorId = $this->getVisitorId();
    	$today = date('Y_m_d');
    	$cacheKey = "Tracking:FrequencyCap:{$flight->id}:{$visitorId}:{$flight->event}:{$today}";
    	$cap = RedisHelper::get($cacheKey);
    	RedisHelper::set($cacheKey, $cap, $expire);
    }

    public function previousTrackingEvent($event){
    	switch ($event) {
    		case 'start':
    			$retval = 'beforeStart';
    			break;
    		case 'impression':
    			$retval = 'beforeImpression';
    			break;
    		case 'click': 
    			$retval = 'ads_success';
    			break;
    		default:
    			$events = array(
	    			'impression',
	    			'firstquartile',
		    		'midpoint',
		    		'thirdquartile',
		    		'complete'
	    		);
	    		$searchKey = array_search($event, $events);
	    		if($searchKey !== FALSE && $searchKey != 0){
	    			$retval = $events[$searchKey - 1];
	    		}
	    		else{
	    			$retval = false;
	    		}
    			break;
    	}
    	return $retval;
    }

    public function isValidTrackingBeacon($checksum, $event){
    	return true;
    	$eventsCheck = array(
    		'start',
    		'click',
    		'impression',
    		'firstquartile',
    		'midpoint',
    		'thirdquartile',
    		'complete'
    	);
    	if(in_array($event, $eventsCheck)){
    		$previousEvent = $this->previousTrackingEvent($event);
    		$cacheKey = "Checksum:{$checksum}:{$previousEvent}";
    		$retval = RedisHelper::get($cacheKey);
    		if($retval){
    			//remove key cache -> chỉ chấp nhận request tracking đầu tiên
    			RedisHelper::set($cacheKey);
    		}
    		return $retval;
    	}
		return false;
    }

    public function setChecksumTrackingEvent($checksum, $event){
    	if($event == Delivery::RESPONSE_TYPE_ADS_SUCCESS){
    		//custom đối với event ads_success do 2 event impression và start thứ tự call random theo từng request . P/S: fucking jwplayer
    		RedisHelper::set("Checksum:{$checksum}:beforeImpression", true, 10);
    		RedisHelper::set("Checksum:{$checksum}:beforeStart", true, 10);
    	}

		$cacheKey = "Checksum:{$checksum}:{$event}";	
    	return RedisHelper::set($cacheKey, true, 10);
    }

    public function makeChecksumHash($flightWebsiteID, $timestamp){
    	$visitorId = $this->getVisitorId();
    	return md5(self::ENCRYPT_KEY . $flightWebsiteID . $visitorId . $timestamp);
    }

    public function rememberFrequencyCap($fwid, $expire){
	    $cookieName = md5("FrequencyCap:$fwid");
    	if( !Cookie::get($cookieName) ){
    		// Log::info(Cookie::get($cookieName));
    		// Log::info("Cookie:$cookieName");
	    	//Cookie::queue($cookieName, time(), $time);
	    	Cookie::make($cookieName, time(), $expire);
    	}
    }

    public function rememberRetarget($campaignId, $event){
    	$cookieName = "Retargeting:{$campaignId}:{$event}";
    	return Cookie::forever($cookieName, time());
    }
    /**
     * tính độ quan tâm của user đối với campaign (cho retargeting)
     */
    public function calculateRetargetpoint($listCampaignId){
    	$retval = 0;
    	$listCampaignId = json_decode($listCampaignId);
    	if(!empty($listCampaignId)){
	    	$eventsFocus = [
	    		'impression'	=>	1,
	    		'complete'		=>  2,
	    		'click'			=>	3 // click tính điểm cao nhất
	    	];
	    	foreach ($listCampaignId as $campaign) {
	    		foreach ($eventsFocus as $event => $point) {
		    		$cookieName = "Retargeting:{$campaign->id}:{$event}";
		    		$retval += Cookie::get($cookieName) ? $point : 0;
		    	}
	    	}

    	}
    	return $retval;
    }

    public static function getTrackingEventType($costType){
    	if( $costType == 'cpm' || $costType == 'cpc' ){
    		if( $costType == 'cpm' ){
    			return 'impression';
    		}else{
    			return 'click';
    		}
    	}else{
    		return false;
    	}
    }

   	public function updateInventory($flightID, $flightWebsiteID, $event, $overReport = false){
   	    $trackInventory = $overReport ? new TrackingOverInventory : new TrackingInventory;
        try{
        	$trackInventory->incTotalAdZoneInventory($flightID, $flightWebsiteID, $event);
        	$trackInventory = $overReport ? new TrackingOverInventory : new TrackingInventory;
        	$trackInventory->incTotalInventory($flightID, $event);
        	return true;
        }
        catch(Exception $exception){
        	Log::error($exception);
        	throw $exception;
        	return false;
        }
    }

    //create expand event tracking link
    public static function expandTrackingLink($adID, $flightWebsiteID, $adzoneID, $checksum){
    	$params = array(
    		'evt'	=>	'expand',
    		'aid'	=>	$adID,
    		'fpid'	=>	$flightWebsiteID,
    		'zid'	=>	$adzoneID,
    		'rt'	=>	Delivery::REQUEST_TYPE_TRACKING_BEACON,
    		'cs'	=>	$checksum
    	);
    	return self::createTrackingLink($params);
    }

 	//create click event tracking link
    public static function clickTrackingLink($toURL, $adID, $flightWebsiteID, $adzoneID, $checksum){
    	$params = array(
    		'evt'	=>	'click',
    		'aid'	=>	$adID,
    		'fpid'	=>	$flightWebsiteID,
    		'zid'	=>	$adzoneID,
    		'rt'	=>	Delivery::REQUEST_TYPE_TRACKING_BEACON,
    		'cs'	=>	$checksum,
    		'to'	=>	$toURL
    	);
    	return self::createTrackingLink($params);
    }

    //create expand event tracking link
    public static function impressionTrackingLink($adID, $flightWebsiteID, $adzoneID, $checksum){
    	$params = array(
    		'evt'	=>	'impression',
    		'aid'	=>	$adID,
    		'fpid'	=>	$flightWebsiteID,
    		'zid'	=>	$adzoneID,
    		'rt'	=>	Delivery::REQUEST_TYPE_TRACKING_BEACON,
    		'cs'	=>	$checksum
    	);
    	return self::createTrackingLink($params);
    	
    }
    public static function createTrackingLink($params){
    	return URL::to('track?') . http_build_query($params);
    }
}
