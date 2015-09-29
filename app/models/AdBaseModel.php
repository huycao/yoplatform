<?php

class AdBaseModel extends Eloquent {

	/**
	 *     Table name of model used
	 *     @var string
	 */
	protected $table = 'ad';

	/**
	 *     Relation : Ad - Campaign : n-1
	 */
	public function adFormat(){
		return $this->belongsTo('AdFormatBaseModel');
	}

	/**
	 *     Relation : Ad - Campaign : n-1
	 */
	public function campaign(){
		return $this->belongsTo('CampaignBaseModel');
	}

	public function flight(){
		return $this->hasOne('FlightBaseModel', 'ad_id');
	}
        
    public function flightAd(){
		return $this->hasMany('AdFlightBaseModel','ad_id');
	}

	public function getDimensionAttribute(){
		return $this->width.' x '.$this->height;
	}


	public function checkAge($clientAge){
		$targetAge = json_decode($this->target_age);
		if($targetAge){
			foreach ($targetAge as $bot => $top) {
				if($clientAge >= $bot && $clientAge <= $top){
					return true;
				}
			}
		}
		return false;
	}

	public function checkGeo(){
		$targetGeo = json_decode($this->target_geo);
		if($targetGeo){
			$clientCountry = strtolower(geoip_country_code_by_name(getClientIp()));
			if(in_array($clientCountry, $targetGeo)){
				return true;
			}
		}
		return false;
	}

}