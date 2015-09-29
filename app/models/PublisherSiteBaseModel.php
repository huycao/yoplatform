<?php

class PublisherSiteBaseModel extends Eloquent {

	/**
	 *     Table name of model used
	 *     @var string
	 */
	protected $table = 'publisher_site';

    protected $fillable =[
            "name","publisher_id"
            ];


    public function getUrlAttribute($value){
        if( strpos($value,"http") !== 0 ){
            $value = "http://".$value;
        }
        return $value;
    }

     public function getShowField(){        
        return array(
            'name'         =>  array(
                'label'         =>  trans("backend::publisher/text.username"),
                'type'          =>  'text'
            ), 
        );   
    }

    public function getSearchField(){
        return array(
            'name'         =>  trans("backend::publisher/text.name"),
           
        );
    }

    public function publisherAdZone(){
        return $this->hasMany('PublisherAdZoneBaseModel','publisher_site_id');
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

    public function searchByCapital($keyword, $parent = null){
        $query = $this;
        if( !empty($keyword) ){
    	   $query = $query->where('name', 'LIKE' ,"{$keyword}");
        }
    	if( !empty($parent) ){
    		$query = $query->where('publisher_id', $parent);
    	}
        return $query
                ->where('status',1)
                ->orderBy('name','asc')
                ->get();
    }


    public function insertData($uid, $pid, $input){
        $this->created_by = $uid;
        $this->storeData($uid, $pid, $input);
        return $this;
    }

    public function updateData($uid, $pid, $input){
        $this->storeData($uid, $pid, $input);
        return $this;
    }

    public function storeData($uid, $pid, $input){
        $this->name = (isset($input['name'])) ? $input['name'] : 0;
        $this->url = (isset($input['url'])) ? $input['url'] : 0;
        $this->publisher_id = $pid;
        $this->premium_publisher = (isset($input['premium_publisher'])) ? $input['premium_publisher'] : 0;
        $this->domain_checking = (isset($input['domain_checking'])) ? $input['domain_checking'] : 0;
        $this->vast_tag = (isset($input['vast_tag'])) ? $input['vast_tag'] : 0;
        $this->network_publisher = (isset($input['network_publisher'])) ? $input['network_publisher'] : 0;
        $this->mobile_ad = (isset($input['mobile_ad'])) ? $input['mobile_ad'] : 0;
        $this->updated_by = $uid;
        $this->save();
    }
    
    public function updateAllStatus($pid, $status){
        return $this->where('publisher_id', $pid)->update(array(
            'status'    =>  $status
        ));
    }


}