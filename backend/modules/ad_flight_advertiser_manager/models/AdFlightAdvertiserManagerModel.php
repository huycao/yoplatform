<?php

class AdFlightAdvertiserManagerModel extends AdFlightBaseModel {

	/**
	 *     Append attribute
	 *     @var array
	 */
    // protected $appends = array('statusText');

	/**
	 *     Mass Assignment
	 *     @var array
	 */
    protected $fillable = array(
		'name',
		'campaign_id',
		'ad_format_id',
		'type',
		'width',
		'height',
		'wmode',
		'source_url',
		'destination_url',
		'created_by',
		'updated_by'
    );

    /**
     *     Get field will display in list
     */
	public function getShowField(){        
	    return array(
	        'ad_name'         =>  array(
	            'label'         =>  trans("text.ad_name"),
	            'type'          =>  'text',
	            'sortable'		=>	FALSE
	        ),
	        'campaign'         =>  array(
	            'label'         =>  trans("text.campaign"),
	            'type'          =>  'text',
	            'sortable'		=>	FALSE
	        ),
	        'flight'         =>  array(
	            'label'         =>  trans("text.flight"),
	            'type'          =>  'text',
	            'sortable'		=>	FALSE
	        ),
	        'section'         =>  array(
	            'label'         =>  trans("text.section"),
	            'type'          =>  'text',
	            'sortable'		=>	FALSE
	        ),
	        'ad_type'         =>  array(
	            'label'         =>  trans("text.ad_type"),
	            'type'          =>  'text',
	            'sortable'		=>	FALSE
	        ),
	    );   
	}

	/**
	 *     Get validate rule when update
	 */
	public function getUpdateRules(){
		return array(
			'campaign_id'					=>	'required',
			'ad_format_id'					=>	'required',
			'type'							=>	'required',
			'width'							=>	'required',
			'height'						=>	'required',
			'wmode'							=>	'required',
			'source_url'					=>	'required',
			'destination_url'				=>	'required'
		);
	}

	/**
	 *     Get validate message when update
	 */
	public function getUpdateLangs(){
		return array(
			'campaign_id.required'					=>	trans('ad::validate.campaign_id.required'),
			'ad_format_id.required'					=>	trans('ad::validate.ad_format_id.required'),
			'type.required'							=>	trans('ad::validate.type.required'),
			'width.required'						=>	trans('ad::validate.width.required'),
			'height.required'						=>	trans('ad::validate.height.required'),
			'wmode.required'						=>	trans('ad::validate.wmode.required'),
			'source_url.required'					=>	trans('ad::validate.source_url.required'),
			'destination_url.required'				=>	trans('ad::validate.destination_url.required'),
		);
	}

	/**
	 *     Filter in list
	 *     @param  object $query      
	 *     @param  array  $searchData 
	 *     @return object
	 */
	public function scopeSearch($query, $searchData = array())
    {
        if( !empty($searchData) ){
            foreach ($searchData as $search) {
                if( $search['value'] != '' ){
                	switch ($search['name']) {

                		case 'ad_type':
                			$adType = $search['value'];
                			$query->whereHas
			    			('ad', function($q) use ($adType){
			    				$q->where('type', "$adType");
			    			});
                			break;

                		case 'ad_name':
                			$adName = $search['value'];
                			$query->whereHas
			    			('ad', function($q) use ($adName){
			    				$q->where('name', 'LIKE', "%${adName}%");
			    			});
                			break;

                		case 'campaign_id':
                			$campaignId = $search['value'];
                			$query->whereHas
			    			('flight', function($q) use ($campaignId){
			    				$q->where('campaign_id', $campaignId);
			    			});
                			break;

                		case 'publisher_id':
                			$publisherId = $search['value'];
                			$query->whereHas
			    			('flight', function($q) use ($publisherId){
			    				$q->where('publisher_id', $publisherId);
			    			});
                			break;

                		case 'publisher_site_id':
                			$publisherSiteId = $search['value'];
                			$query->whereHas
			    			('flight', function($q) use ($publisherSiteId){
			    				$q->where('publisher_site_id', $publisherSiteId);
			    			});
                			break;
                		
                		default:
                    		$query->where($search['name'], $search['value']);
                			break;
                	}
                }
            }
        }
        return $query;
    }


}
