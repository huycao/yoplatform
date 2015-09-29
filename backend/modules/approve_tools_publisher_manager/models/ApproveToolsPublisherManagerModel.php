<?php

class ApproveToolsPublisherManagerModel extends PublisherBaseModel {

    protected $appends = array('statusText');


   

    
    
    public function getSearchField(){
        return array(
            'username'         =>  trans("backend::publisher/text.username"),
            'first_name'       =>  trans("backend::publisher/text.first_name"),
            'email'            =>  trans("backend::publisher/text.email"),
        );
    }

    public function scopeSearch($query, $searchData = array())
    {
        if( !empty($searchData) ){
            
            $typeName   =$searchData[0]['value'];
            $keyword    =$searchData[1]['value'];
           
            if(!empty($keyword)){
                if($typeName=="name"){
                    $query->where(DB::raw("(first_name"),"LIKE",DB::raw("'%{$keyword}%'"));
                    $query->orWhere("last_name","LIKE",DB::raw("'%{$keyword}%')"));
                }elseif($typeName=="username"){
                    $query->orWhere("username","LIKE",DB::raw("'%{$keyword}%')"));
                }else
                    $query->where('email', 'LIKE', DB::raw("'%{$keyword}%'"));
            }
        }     
        // echo $query->toSql();
        return $query;
    }

    
    public function getCategoryByIdAttribute(){
        $modelCate=new CategoryBaseModel;      
        $item=$modelCate->find($this->category)->select('id','name')->first();
        if(!empty($item)) return $item->name;
        else return FALSE;
    }
    public function user(){
        return $this->belongsTo('User');        
    }


}
