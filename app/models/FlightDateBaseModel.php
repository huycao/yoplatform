<?php

class FlightDateBaseModel extends Eloquent {

    protected $table = 'flight_date';


    public function flight(){
    	return $this->belongsTo('FlightBaseModel');
    }


    public function availableFlight($flightID = 0){
    	$now = date('Y-m-d');
    	return $this->where('flight_id', $flightID)->where('start', '<=', $now)->where('end','>=',$now)->first();
    }
}