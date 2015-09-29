<?php

class ContactBaseModel extends Eloquent {

	/**
	 *     Table name of model used
	 *     @var string
	 */
	protected $table = 'contact';

	/**
	 *     Relation : Contact - Agency : n-n
	 */
	public function agency(){
        return $this->belongsToMany('AgencyBaseModel', 'agency_contact', 'contact_id', 'agency_id');
    }
			
	/**
	 *     Relation : Contact - Advertiser : n-n
	 */
	public function advertiser(){
        return $this->belongsToMany('AdvertiserBaseModel', 'advertiser_contact', 'contact_id', 'advertiser_id');
    }
			
	/**
     *     Fillable
     *     @var array
     */
	public $fillable = array(
		'name',
		'email',
		'phone',
		'fax',
		'status',
		'created_by',
		'updated_by'
	);

	/**
	 *     Get validate rule when update
	 */
	public function getUpdateRules(){
		return array(
			'name'		=>	'required',
			'email'		=>	'required',
			'phone'		=>	'required'
		);
	}

	/**
	 *     Get validate message when update
	 */
	public function getUpdateLangs(){
		return array(
			'name.required'		=>	trans('contact::validate.name.required'),
			'email.required'	=>	trans('contact::validate.email.required'),
			'phone.required'	=>	trans('contact::validate.phone.required'),
			'fax.required'		=>	trans('contact::validate.fax.required')
		);
	}

	public function storeRelation($type, $typeID){
		switch ($type) {
			case 'agency':
				$this->agency()->attach($typeID);
				return $this->agency->first()->contact;
				break;
			case 'advertiser':
				$this->advertiser()->attach($typeID);
				return $this->advertiser->first()->contact;
				break;

		}
	}

	public function deleteRelation($type, $typeID){
		switch ($type) {
			case 'agency':
				if($this->agency()->detach($typeID)){
					if($this->delete()){
						return AgencyAdvertiserManagerModel::find($typeID)->contact;
					}
				}
				break;
			case 'advertiser':
				if($this->advertiser()->detach($typeID)){
					if($this->delete()){
						return AdvertiserAdvertiserManagerModel::find($typeID)->contact;
					}
				}
				break;
		}		
	}

	public function searchAdvertiserContactByCapital($keyword, $parent){

    	if( !empty($keyword) ){
			return $this->whereHas
	    			('agency', function($q) use ($parent){
	    				$q->where('agency_id', $parent);
	    			})
	    			->with('agency')
	    			->where('name', 'LIKE' ,"{$keyword}")
	    			->where('status', 1)
	    			->get();        		
    	}else{
	    	return $this->whereHas
	    			('agency', function($q) use ($parent){
	    				$q->where('agency_id', $parent);
	    			})
	    			->with('agency')
	    			->where('status', 1)
	    			->get();    	
    	}
  	
	}			
}