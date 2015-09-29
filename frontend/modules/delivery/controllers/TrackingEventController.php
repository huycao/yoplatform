<?php 
class TrackingController extends FrontendController
{
	public $trackingEvents = array(
		'impression','click','start','firstquartile','midpoint','thirdquartile','complete','mute','fullscreen'
		);

	public $flightPublisherModel;

	public $adFlightModel;

	public $publisherModel;

	public $deliveryModel;

	public $trackingModel;

	public function __construct(
		Tracking $trackingModel, 
		FlightPublisherBaseModel $flightPublisherModel, 
		AdFlightBaseModel $adFlightModel,
		publisherBaseModel $publisherModel,
		Delivery $deliveryModel
	)
	{
		parent::__construct(pathinfo(dirname(__DIR__), PATHINFO_BASENAME));
		$this->flightPublisherModel = $flightPublisherModel;
		$this->adFlightModel        = $adFlightModel;
		$this->publisherModel       = $publisherModel;
		$this->deliveryModel        = $deliveryModel;
		$this->trackingModel        = $trackingModel;
	}

	public function track(){
		$event = Input::get('evt');
		if(in_array($event, $this->trackingEvents)){

		}

		return $this->trackingModel->outputTransparentGif();
	}

	public function adsProcess(){
		$responseType = '';
		$expandFields = array();

		$zoneID      = Input::get('zid', 0);
		$publisherID = Input::get('pid', 0);
		$requestType = Input::get('type', Delivery::REQUEST_TYPE_AD);
		
		$trackingModel   = new Tracking;
		$deliveryModel   = new Delivery;
		$flightDateModel = new FlightDateBaseModel;
		//ghi log trước khi xử lý
		$logPreProcess = $trackingModel->logPreProcess($requestType);
		if($logPreProcess){
			
			//kiểm tra referrer
			$hostReferer = $trackingModel->getRequestReferer();
			if(empty($zoneID)){
				$responseType = Delivery::RESPONSE_TYPE_INVALID;
			}
			elseif( empty($hostReferer) ){
				$responseType = Delivery::RESPONSE_TYPE_EMPTY_REFERRER;
			}
			elseif($trackingModel->countLatestRequest(1) < Delivery::ANTI_CHEAT_MAX_REQUEST_PER_1MIN && $trackingModel->countLatestRequest(5) < Delivery::ANTI_CHEAT_MAX_REQUEST_PER_5MIN){
				$responseType = Delivery::RESPONSE_TYPE_ANTI_MANY_REQUEST;
			}
			//pre validate ok
			if(empty($responseType)){
			
				//default invalid
				if($zoneID && $publisherID){
					$adZone = PublisherAdZoneBaseModel::find($zoneID);
					if($adZone && $adZone->publisher){
						if($adZone->publisher_id == $publisherID){
							$flightPublishers = FlightPublisherBaseModel::where('publisher_id', $publisherID)->with('flightDate', function($query){
								$today = date('Y-m-d');
								$query->where('start', '<=', $today)->where('end', '>=', $today);
							})->where('publisher_ad_zone_id', $zoneID)->orderBy('order', 'asc')->get();
							if($flightPublishers){
								if($requestType == Delivery::REQUEST_TYPE_AD){
									//lấy ad từ list thỏa điều kiện để trả về
									foreach ($flightPublishers as $k => $flightPublisher) {
										if($flightPublisher->flightDate){
											$runningInventory = $trackingModel->runningInventory($flightPublisher->id);
											if($flightPublisher->total_inventory < $runningInventory ){
												$deliveryStatus = $deliveryModel->deliveryAd($flightPublisher->ad, $flightPublisher->flight);
												if($deliveryStatus == Delivery::DELIVERY_STATUS_OK){
													//trả về ad này
													$serveAd = $flightPublisher->ad;
													$expandFields = array(
														'flight_id'            =>	$flightPublisher->flight_id,
														'ad_format_id'         =>	$flightPublisher->ad_format_id,
														'ad_id'                =>	$flightPublisher->ad_id,
														'campaign_id'          => 	$flightPublisher->campaign_id,
														'publisher_ad_zone_id' => 	$flightPublisher->publisher_ad_zone_id,
														'flight_publisher_id'  => 	$flightPublisher->id,
														'publisher_id'         => 	$flightPublisher->publisher_id,
														'flight_publisher_id'  => 	$flightPublisher->id,
													);
													break;
												}
											}
										}
									}
									//endforeach
								}
								//tracking impression, click , events....
								elseif($requestType == Delivery::REQUEST_TYPE_TRACKING_BEACON){
									//tracking beacon TO DO, now : do nothing
									if($trackingModel->isKnownVisitor()){
										
									}
									else{
										$responseType = Delivery::RESPONSE_TYPE_EMPTY_REFERRER;
									}
								}
							}
						}
						//serve Ad
						if(!empty($serveAd)){

						}
						else{

						}

					}

				}
			}
			
		}
		
		if(empty($responseType)){
			$responseType = Delivery::RESPONSE_TYPE_INVALID;
		}

		//ghi log process
		$trackingModel->logAfterProcess($responseType, $expandFields);
		
		return $deliveryModel->emptyAd();
	}
}