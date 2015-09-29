<?php

class CampaignBaseModel extends Eloquent {

	/**
	 *     Table name of model used
	 *     @var string
	 */
	protected $table = 'campaign';

	public function getDateRangeAttribute(){
		return date('d-m-Y', strtotime($this->start_date)).' -> '.date('d-m-Y', strtotime($this->end_date));
	}

	/**
	 *     Relation : campaign - flight : 1-n
	 */
	public function flight(){
		return $this->hasMany('FlightBaseModel','campaign_id');
	}

	/**
	 *     Relation : campaign - category : 1-n
	 */
	public function category(){
		return $this->hasOne('CategoryBaseModel','id','category_id');
	}

	/**
	 *     Relation : campaign - advertiser : 1-n
	 */
	public function advertiser(){
		return $this->hasOne('AdvertiserBaseModel','id','advertiser_id');
	}

	/**
	 *     Relation : campaign - agency : 1-n
	 */
	public function agency(){
		return $this->hasOne('AgencyBaseModel','id','agency_id');
	}

	/**
	 *     Relation : campaign - contact : 1-n
	 */
	public function contact(){	
		return $this->hasOne('ContactBaseModel','id', 'contact_id');
	}	

	/**
	 *     Relation : campaign - user : 1-n
	 */
	public function campaign_manager(){
		return $this->hasOne('User','id','campaign_manager_id');
	}

	/**
	 *     Relation : campaign - user : 1-n
	 */
	public function sale(){
		return $this->hasOne('User', 'id', 'sale_id');
	}

	/**
	 *     Relation : campaign - Country : 1-n
	 */
	public function country(){
		return $this->hasOne('CountryBaseModel', 'id', 'country_id');
	}

	/**
	 *     Relation : campaign - currency : 1-n
	 */
	public function currency(){
		return $this->hasOne('CurrencyBaseModel');
	}

	/**
	 *     Relation : campaign - contact : 1-n
	 */
	public function invoice_contact(){
		return $this->hasOne('ContactBaseModel','id','invoice_contact_id');
	}


	/*
	*	Relationship : campaign-adzone-adformat
	*/
	public function relationshipAdFormat(){
		return $this->hasManyThrough('AdFormatBaseModel','AdzonePublisherModel','adformat','id');
	}

	public function getCampaignRecent($limit){

		return $this->limit($limit)->orderBy('created_at', 'desc')->get();

	}

	public function getCampaignById($id){
		return $this->find($id);
	}

	public function getListFlightId(){
		return $this->flight->lists('id');
	}



			
}