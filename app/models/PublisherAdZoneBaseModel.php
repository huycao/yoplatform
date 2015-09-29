<?php

class PublisherAdZoneBaseModel extends Eloquent {

	/**
	 *     Table name of model used
	 *     @var string
	 */
	protected $table = 'publisher_ad_zone';

    public function searchByCapital($keyword, $parent = null){

    	$query = $this;

        if( !empty($keyword) ){
            $query->where('name', 'LIKE' ,"{$keyword}");
        }

    	if( !empty($parent) ){
    		$query->where('publisher_site_id', $parent);
    	}
        
    	return $query->get();
    }

    public function adFormat(){
        return $this->belongsTo('AdFormatBaseModel');
    }

    public function alternateAd(){
        return $this->hasMany('AlternateAdBaseModel', 'publisher_ad_zone_id');
    }

    public function publisher(){
        return $this->belongsTo('PublisherBaseModel');
    }

    public function getAdFormat($zoneId){

        $zone = $this->find($zoneId);

        if( $zone ){
            return $zone->adFormat;
        }

        return false;

    }

    protected $fillable = array(
        'name',
        'publisher_site_id',
        'publisher_id',
        'platform',
        'ad_format_id',
        'adplacement',
        'alternateadtype',
        'alternatead',
        'element_id',
        'width',
        'height',
    );
    
    public function getShowField() {
        return array(
            'name' => array(
                'label' => trans("backend::publisher/text.name"),
                'type' => 'text'
            ),
            'publisher_site_id' => array(
                'label' => trans("backend::publisher/text.zone_name"),
                'type' => 'text'
            ),
            'platform' => array(
                'label' => trans("backend::publisher/text.platform"),
                'type' => 'text',
            ),
            'ad_format_id' => array(
                'label' => trans("backend::publisher/text.ad_format"),
                'type' => 'text',
            ),
            'adplacement' => array(
                'label' => trans("backend::publisher/text.adplacement"),
                'type' => 'text',
            ),
            'alternateadtype' => array(
                'label' => trans("backend::publisher/text.alternateadtype"),
                'type' => 'text',
            ),
            
        );
    }

    public function getUpdateRules() {
        return array(
            "name" => "required",            
            "ad_format_id" => "required",            
        );
    }

    public function getUpdateLangs(){
        return array(
            "name.required"         =>  trans("backend::publisher/validation.name.required"),
            "ad_format_id.required"         =>  trans("backend::publisher/validation.adformat.required"),
            "selected_alternatead.required"         =>  trans("backend::publisher/validation.selected_alternatead.required"),
        );
       
    }

    public function site() {
        return $this->belongsTo('SitePublisherModel', 'publisher_site_id', 'id');
    }    

    public function format() {
        return $this->belongsTo('AdFormatBaseModel', 'ad_format_id');
    }    
    public function getSearchField() {
        return array(
            'name' => trans("backend::publisher/text.name"),
        );
    }

    public function scopeSearch($query, $searchData = array()) {
        if (!empty($searchData)) {

            $typeName = $searchData[0]['value'];
            $keyword = $searchData[1]['value'];

            if (!empty($keyword)) {
                $query->where(DB::raw("(name"), "LIKE", DB::raw("'%{$keyword}%'"));
            }
        }
        return $query;
    }


}