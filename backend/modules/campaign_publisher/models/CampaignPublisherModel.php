
<?php

class CampaignPublisherModel extends CampaignBaseModel{


	public function getShowField(){        
        return array(
            'status'         	=>  array(
                'label'         =>  trans("backend::publisher/text.status"),
                'type'          =>  'text'
            ),
            'name'         		=>  array(
                'label'         =>  trans("backend::publisher/text.title"),
                'type'          =>  'text'
            ),
            'category_id'  		=>  array(
                'label'         =>  trans("backend::publisher/text.channel"),
                'type'          =>  'text'
            ),            
            'advertiser_id'  	=>  array(
                'label'         =>  trans("backend::publisher/text.advertiser"),
                'type'          =>  'text'
            ),
            'start_date'  		=>  array(
                'label'         =>  trans("backend::publisher/text.campaign_duration"),
                'type'          =>  'text'
            )
        );   
    }
    //
    public function getStatusCampaignAttribute(){

    	if($this->status==1){
    		$span='<div class="status-'.$this->id.' text-success"><span class="glyphicon glyphicon-ok"></span> Accepted</div>';
    	}/*else{
    		$span='<div class="status-'.$this->id.'"><a href="javascript:;" onclick="changeBooleanType('.$this->id.',1,\'status\');" class="text-warning"><span class="glyphicon glyphicon-remove"></span> Reject</a></div>';
    	}*/
    	return $span;
    }

    public function getAdformatAttribute(){
        $currentUser=Session::get('currentUserSess');
        $item=self::where(['id'=>$this->id])->with('relationshipAdFlight','relationshipAdFormat')->get();
        pr($item);die();
        return $item->relationshipAdFormat;
    }
	//get list campaign
	public function scopegetSearchCampaign($query,$searchData=array()){
		$query=self::joinCampaign();
        if(count($searchData) > 0){
            $query=$query->where('cost_type',$searchData[0]['value']);
        }else{
            $query=$query->where('cost_type',"cpm");
        }
		return $query;
	}

	//join campaign
	public function scopejoinCampaign($query){
		$query=$query
        ->join('advertiser','campaign.advertiser_id','=','advertiser.id')
        ->join('category','campaign.category_id','=','category.id')
		->join('flight','flight.campaign_id','=','campaign.id')
        ->join('flight_website','flight.id','=','flight_website.flight_id');
     
		return $query;
	}

	///////////////////////////////////////////////////
}