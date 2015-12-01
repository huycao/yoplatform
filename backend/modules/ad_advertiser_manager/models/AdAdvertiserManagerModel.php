<?php

class AdAdvertiserManagerModel extends AdBaseModel {

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
		'ad_type',
		'width',
		'height',
		'width_2',
		'height_2',
        'width_after',
        'height_after',
		'source_url',
		'source_url2',
		'main_source',
		'destination_url',
		'video_duration',
		'flash_wmode',
		'video_linear',
		'video_type_vast',
		'video_wrapper_tag',
		'third_impression_track',
		'third_click_track',
		'video_bitrate',
		'third_party_tracking',
		'created_by',
		'updated_by',
        'platform',
        'ad_view',
        'ad_view_type',
        'source_url_backup',
        'html_source',
        'display_type',
		'bar_height',
        'vast_include',
        'audience_id'
    );

    /**
     *     Get field will display in list
     */
	public function getShowField(){        
	    return array(
	        'name'         =>  array(
	            'label'         =>  trans("text.name"),
	            'type'          =>  'text',
	            'sortable'		=>	FALSE
	        )
	    );   
	}

	/**
	 *     Get validate rule when update
	 */
	public function getUpdateRules(){
		return array(
			'campaign_id'					=>	'required',
			'ad_format_id'					=>	'required',
			'ad_type'						=>	'required',
		);
	}

	/**
	 *     Get validate message when update
	 */
	public function getUpdateLangs(){
		return array(
			'campaign_id.required'					=>	trans('ad::validate.campaign_id.required'),
			'ad_format_id.required'					=>	trans('ad::validate.ad_format_id.required'),
			'ad_type.required'							=>	trans('ad::validate.type.required'),
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
                        case 'id':
                            $query->where($search['name'], '=', $search['value']);
                            break;
                        case 'name':
                            $query->where($search['name'], 'LIKE', "%{$search['value']}%");
                            break;
                		case 'campaign_id':
                            $query->where($search['name'], '=', $search['value']);
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

    public function searchByCapital($keyword, $parent) {
        $query = $this;
        if( !empty($keyword) ){
           $query = $this->where('name', 'LIKE' ,'%'.$keyword.'%');
        }
        return $query
			->whereHas
			('campaign', function($q) use ($parent){
				$q->where('campaign_id', $parent);
			})
			->with('campaign')
        	->where('is_select', 0)
        	->orderBy('name','asc')->get();
    }
}
