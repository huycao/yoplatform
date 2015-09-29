<?php
if ( ! function_exists('urlTracking'))
{
    function urlTracking($event = '', $adID, $flightPublisherID,$adZoneID, $checksum, $destinationUrl = '', $isOverReport = false){
    	$params = array(
    		'evt'	=>	$event,
    		'aid'	=>	$adID,
    		'fpid'	=>	$flightPublisherID,
    		'zid'	=>	$adZoneID,
    		'rt'	=>	Delivery::REQUEST_TYPE_TRACKING_BEACON,
            'cs'    =>  $checksum
    		);
        if($destinationUrl){
            $params['to'] = $destinationUrl;
        }
        if($isOverReport){
            $params['ovr'] = 1;
        }
        return URL::to("/track?") . http_build_query($params);
    }
}