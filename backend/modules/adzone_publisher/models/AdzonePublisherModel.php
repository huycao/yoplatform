<?php

//use Eloquent;
class AdzonePublisherModel extends \Eloquent {

    protected $table = 'publisher_ad_zone';
    
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
            "publisher_site_id" => "required",            
        );
    }
   public function getUpdateLangs(){
        return array(
            "name.required"         =>  trans("backend::publisher/validation.name.required"),
            "ad_format_id.required"         =>  trans("backend::publisher/validation.adformat.required"),
            "selected_alternatead.required"         =>  trans("backend::publisher/validation.selected_alternatead.required"),
            "publisher_site_id.required"         =>  trans("backend::publisher/validation.publisher_site_id.required"),
            
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
        // echo $query->toSql();
        return $query;
    }
}   
