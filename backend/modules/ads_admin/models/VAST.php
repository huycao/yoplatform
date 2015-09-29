<?php namespace Advalue;
use Eloquent;
use View;
use Response;
use DeviceDetector\DeviceDetector;
use DeviceDetector\Parser\Device\DeviceParserAbstract;
use DeviceDetector\Cache\CacheFile;
use Piwik\Common;
use AdBaseModel;
use Input;

class VAST extends Eloquent {
    const VAST_INLINE = 'inline';
    const VAST_WRAPPER = 'wrapper';

	protected $append = array('impTracksTag','linearTracks','nonLinearTracks','durationText', 'creativeType','trackClick');

	public function getImpTracksTagAttribute(){
		$tag = '';
        $impTracks = json_decode($this->video_impression_track, 1);
		if(!empty($impTracks)){
			foreach($impTracks as $link){
				$tag .= '<Impression><![CDATA['.url_encode($link).']]></Impression>';
			}
		}
		$tag .= '<Impression><![CDATA['.urlTracking('impression', $this->id, $this->flight_publisher_id, $this->publisher_ad_zone_id, $this->checksum, $this->ovr ).']]></Impression>';
		return $tag;
	}

	public function getLinearTracksAttribute(){
		$tag = '<TrackingEvents>';
		$TrackingEvents = array('start','firstQuartile','midpoint','thirdQuartile','complete', 'mute', 'unmute', 'pause', 'fullscreen');
        foreach ($TrackingEvents as $event){
        	$tag .= '<Tracking event="'.$event.'"><![CDATA['.urlTracking($event, $this->id, $this->flight_publisher_id, $this->publisher_ad_zone_id, $this->checksum, $this->ovr ).']]></Tracking>';
    	}
		$tag .= '</TrackingEvents>';
		return $tag;
	}

	public function getNonLinearTracksAttribute(){
		$tag = '<TrackingEvents>';
		$TrackingEvents = array('start','firstQuartile','midpoint','thirdQuartile','complete');
        foreach ($TrackingEvents as $event){
        	$tag .= '<Tracking event="'.$event.'"><![CDATA['.urlTracking($event, $this->id, $this->flight_publisher_id, $this->publisher_ad_zone_id , $this->checksum, $this->ovr ).']]></Tracking>';
    	}
		$tag .= '</TrackingEvents>';
		return $tag;
	}

    public function getTrackClickAttribute(){
        return urlTracking('click', $this->id, $this->flight_publisher_id, $this->publisher_ad_zone_id, $this->checksum, $this->url );
    }

	public function getDurationTextAttribute(){
		return secsToDuration($this->duration);
	}

    public function getCreativeTypeAttribute(){
        $array_source = explode('.', trim($this->file));
        $ext = end($array_source);
        $creativeType = '';
        switch ($ext) {
            case 'flv':
                $creativeType = 'video/x-flv';
                break;
            case 'mp4':
                $creativeType = 'video/mp4';
                break;
            case 'swf':
                $creativeType = 'application/x-shockwave-flash';break;
            case 'png':
                $creativeType = 'image/png';break;
            case 'jpg':
                $creativeType = 'image/jpeg';break;
            case 'gif':
                $creativeType = 'image/gif';break;
        }
        return $creativeType;
    }

	function makeVAST($adID, $flightPublisherID, $publisherAdZoneID, $checksum = '', $isOverReport = false){
        // get ad data
        $ad                         = (new \Delivery())->getAd($adID);
        if($ad && $flightPublisherID && $publisherAdZoneID){
            $XMLView                    = 'none';
            $this->initVast($ad, $flightPublisherID, $publisherAdZoneID, $checksum, $isOverReport);
            if(!empty($this->id)){
                if($this->type_vast == self::VAST_INLINE){
                    $XMLView = 'inline';
                }
                else{
                    $XMLView = 'wrapper';
                }
            }
            $header['Content-Type']                     = 'application/xml';
            $header['Access-Control-Allow-Origin']      = '*';
            $header['Access-Control-Allow-Credentials'] = 'true';
            $header['Cache-Control']                    = 'no-store, no-cache, must-revalidate, max-age=0';
            $header['Cache-Control']                    = 'post-check=0, pre-check=0';
            $header['Pragma']                           = 'no-cache';
            View::addLocation(base_path() .'/backend/theme/default/views/admin/vast_admin');
            $body = View::make($XMLView)->with('ad',$this);
            return Response::make($body, 200, $header);
        }
        else{
            return $this->makeEmptyVast();
        }
        
    }

    function makeBackupVast($zoneId, $wrapperTag){
        $ad              = new StdClass();
        $ad->id          = $zoneID;
        $ad->wrapper_tag = $wrapperTag;
        $ad->isBackupAd  = true;
        View::addLocation(base_path() .'/backend/theme/default/views/admin/vast_admin');
        $body = View::make('wrapper')->with('ad',$ad);
        return Response::make($body, 200, $header);
    }

    public function initVast($ad, $flightPublisherID, $publisherAdZoneID, $checksum, $isOverReport = false){
        if($ad && $flightPublisherID && $publisherAdZoneID){
            $this->id                   = $ad->id;
            $this->flight_publisher_id  = $flightPublisherID;
            $this->publisher_ad_zone_id = $publisherAdZoneID;
            $this->linear               = $ad->video_linear;
            $this->width                = 640;
            $this->height               = 480;
            $this->duration             = 15;
            $this->type_vast            = $ad->video_type_vast;
            $this->file                 = $ad->source_url;
            $this->title                = $ad->name;
            $this->wrapper_tag          = $ad->video_wrapper_tag;
            $this->bitrate              = $ad->video_bitrate;
            $this->url                  = $ad->destination_url;
            $this->impr_tracks          = $ad->video_impression_track;
            $this->checksum             = $checksum;
            $this->ovr                  = $isOverReport;
            return true;
        }
        return false;
    }

    public function makeEmptyVast(){
        $body                    = '<VAST version="2.0"/>';
        $header['Content-Type']  = 'application/xml';
        $header['Cache-Control'] = 'no-store, no-cache, must-revalidate, max-age=0';
        $header['Cache-Control'] = 'post-check=0, pre-check=0';
        $header['Pragma']        = 'no-cache';
        return Response::make($body, 200,$header);
    }

}
