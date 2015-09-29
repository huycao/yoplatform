<?php

class AgencyBaseModel extends Eloquent {

	/**
	 *     Table name of model used
	 *     @var string
	 */
	protected $table = 'agency';

	/**
	 *     Relation : Agency - Country : 1-n
	 */
	public function country(){
		return $this->belongsTo('CountryBaseModel');
	}

	/**
	 *     Relation : Agency - Contact : n-n
	 */
	public function contact(){
        return $this->belongsToMany('ContactBaseModel', 'agency_contact', 'agency_id', 'contact_id');
    }			

}