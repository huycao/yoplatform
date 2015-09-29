<?php

class AdvertiserBaseModel extends Eloquent {

	/**
	 *     Table name of model used
	 *     @var string
	 */
	protected $table = 'advertiser';

	/**
	 *     Relation : Advertiser - Country : 1-n
	 */
	public function country(){
		return $this->belongsTo('CountryBaseModel');
	}

	/**
	 *     Relation : Advertiser - Contact : n-n
	 */
	public function contact(){
        return $this->belongsToMany('ContactBaseModel', 'advertiser_contact', 'advertiser_id', 'contact_id');
    }			

}