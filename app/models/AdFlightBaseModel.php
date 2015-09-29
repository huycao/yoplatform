<?php

class AdFlightBaseModel extends Eloquent {

	/**
	 *     Table name of model used
	 *     @var string
	 */
	protected $table = 'ad_flight';

	/**
	 *     Relation : Ad - Campaign : 1-1
	 */
	public function ad(){
		return $this->hasOne('AdBaseModel', 'id', 'ad_id');
	}

	/**
	 *     Relation : Ad - Flight : 1-1
	 */
	public function flight(){
		return $this->hasOne('FlightBaseModel', 'id', 'flight_id');
	}
        
        /**
	 *     Relation : Ad - Flight : 1-1
	 */
	public function flightinfo(){
		return $this->belongsTo('FlightBaseModel', 'flight_id');
	}
	public function adinfo(){
		return $this->belongsTo('AdBaseModel', 'ad_id');
	}

    public function getPriorityAdId($flightId){
        $rs = $this->select('ad_id')->where('flight_id', $flightId)->orderBy('order', 'asc')->first();
        if($rs){
        	return $rs->ad_id;
        }else{
        	return false;
        }
    }
}