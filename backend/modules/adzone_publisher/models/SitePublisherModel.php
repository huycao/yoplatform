<?php

//use Eloquent;
class SitePublisherModel extends \Eloquent {

    protected $table = 'publisher_site';

    protected $fillable =[
    		"name","publisher_id"
    		];

     public function getShowField(){        
        return array(
            'name'         =>  array(
                'label'         =>  trans("backend::publisher/text.username"),
                'type'          =>  'text'
            ), 
        );   
    }
    
    public function adzones(){
        return $this->hasMany('AdzonePublisherModel','publisher_site_id');
    }
    public function getSearchField(){
        return array(
            'name'         =>  trans("backend::publisher/text.name"),
           
        );
    }
    public function scopeSearch($query, $searchData = array())
    {
        if( !empty($searchData) ){
            
            $typeName   =$searchData[0]['value'];
            $keyword    =$searchData[1]['value'];
           
            if(!empty($keyword)){ 
                    $query->where(DB::raw("(name"),"LIKE",DB::raw("'%{$keyword}%'"));                  
                 
            }
        }      
        return $query;
    }
}
