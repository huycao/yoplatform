<?php

class PublisherSiteBaseCostBaseModel extends Eloquent {

	/**
	 *     Table name of model used
	 *     @var string
	 */
	protected $table = 'publisher_site_base_cost';

	public function adFormat(){
		return $this->hasOne('AdFormatBaseModel', 'id', 'ad_format_id');
	}

	public function insertData($uid){
        $this->created_by = $uid;
        $this->storeData($uid);
        return $this->isSave();
	}

	public function updateData($uid){
		$this->storeData($uid);
		return $this->isSave();
	}	

	public function storeData($uid){

        $this->publisher_site_id = Input::get('wid');
        $this->ad_format_id = Input::get('ad_format_id');
        $this->cpm = Input::get('cpm');
        $this->cpc = Input::get('cpc');
        $this->cpd = Input::get('cpd');
        $this->cpa = Input::get('cpa');
        $this->cpa_percent = Input::get('cpa_percent');
        $this->updated_by = $uid;
	}

	public function isSave(){
        if( $this->save() ){
        	return $this;
        }else{
        	return FALSE;
        }
	}

	public function getListByWebsiteId($wid){
        return $this->where('publisher_site_id', $wid)->orderBy('id', 'asc')->get();        
    }


}