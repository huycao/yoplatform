<?php

class CampaignAdvertiserManagerModel extends CampaignBaseModel {

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
		'category_id',
		'advertiser_id',
		'agency_id',
		'contact_id',
		'name',
		'sale_id',
		'campaign_manager_id',
		'expected_close_month',
		'start_date',
		'end_date',
		'sale_status',
		'status',
		'invoice_number',
        //'cost_type',
        'total_inventory',
        'sale_revenue',
        //'retargeting_show',
        //'retargeting_url',
		'created_by',
		'updated_by'
    );

    // public function setStartDateAttribute($value)
    // {
    //     $this->attributes['start_date'] = date('Y-m-d', strtotime($value));
    // }

    // public function setEndDateAttribute($value)
    // {
    //     $this->attributes['end_date'] = date('Y-m-d', strtotime($value));
    // }

    // public function setBillingDateAttribute($value)
    // {
    //     $this->attributes['billing_date'] = date('Y-m-d', strtotime($value));
    // }

    /**
     *     Get display country in list
     */
    public function getCountryTextAttribute(){
    	return $this->country['country_name'];
    }

	/**
	 *     Get display status in list
	 */
    public function getStatusTextAttribute(){
        if( $this->status == 0 ){
            $text   = trans("text.unactive");
            $class  = "label-warning";
        }else{
            $text = trans("text.active");
            $class  = "label-success";
        }

        return '<span class="label '.$class.'">'.$text.'</span>';

    }
    
    /**
     *     Get field will display in list
     */
	public function getShowField(){        
	    return array(
	        'name'         =>  array(
	            'label'         =>  trans("text.campaign"),
	            'type'          =>  'text'
	        ),
	        'advertiser_id'         =>  array(
	            'label'         =>  trans("text.advertiser"),
	            'type'          =>  'text',
	            'sortable'		=>	FALSE
	        ),
	        'start_date'  =>  array(
	            'label'         =>  trans("text.start_date"),
	            'type'          =>  'text'
	        ),
	        'end_date'  =>  array(
	            'label'         =>  trans("text.end_date"),
	            'type'          =>  'text'
	        ),
	        'sale_id'  =>  array(
	            'label'         =>  trans("text.by"),
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
			'category_id'			=>	'required',
			'advertiser_id'			=>	'required',
			'agency_id'				=>	'required',
			'contact_id'			=>	'required',
			'name'					=>	'required',
			'sale_id'				=>	'required',
			'campaign_manager_id'	=>	'required',
			'expected_close_month'	=>	'required',
			'start_date'			=>	'required',
			'end_date'				=>	'required'
		);
	}

	/**
	 *     Get validate message when update
	 */
	public function getUpdateLangs(){
		return array(
			'category_id.required'				=>	trans('campaign::validate.category_id.required'),
			'advertiser_id.required'			=>	trans('campaign::validate.advertiser_id.required'),
			'agency_id.required'				=>	trans('campaign::validate.agency_id.required'),
			'contact_id.required'				=>	trans('campaign::validate.contact_id.required'),
			'name.required'						=>	trans('campaign::validate.name.required'),
			'sale_id.required'					=>	trans('campaign::validate.sale_id.required'),
			'campaign_manager_id.required'		=>	trans('campaign::validate.campaign_manager_id.required'),
			'expected_close_month.required'		=>	trans('campaign::validate.expected_close_month.required'),
			'start_date.required'				=>	trans('campaign::validate.start_date.required'),
			'end_date.required'					=>	trans('campaign::validate.end_date.required'),
			'invoice_number.required'			=>	trans('campaign::validate.invoice_number.required'),
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
                		case 'sale_status[\'wilcard\']':
                			break;

                		case 'sale_status[\'status\']':
                    		$query->where('sale_status', $searchData['sale_status[\'wilcard\']']['value'], $search['value']);
                			break;

                		case 'name':
                            $query->where($search['name'], 'LIKE', "%{$search['value']}%");
                			break;

                		case 'created_at':
	            			$date = date('Y-m-d', strtotime($search['value']));
	                		$query->where($search['name'], ">=" , $date." 00:00:00");
	                		$query->where($search['name'], "<=" , $date." 23:59:59");
                			break;
                		case 'start_start_date':
	                		$date = date('Y-m-d', strtotime($search['value']));
	                		$query->where("start_date", ">=" , $date);
                			break;
                        case 'end_start_date':
                            $date = date('Y-m-d', strtotime($search['value']));
                            $query->where("start_date", "<=" , $date);
                            break;
                		case 'start_end_date':
                			$date = date('Y-m-d', strtotime($search['value']));
                			$query->where("end_date", ">=" , $date);
                			break;
                        case 'end_end_date':
                            $date = date('Y-m-d', strtotime($search['value']));
                            $query->where("end_date", "<=" , $date);
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

    /**
     *     
     */
    public function searchByCapital($keyword) {
        $query = $this;
        if( !empty($keyword) ){
           $query = $this->where('name', 'LIKE' ,"{$keyword}");
        }
        return $query->orderBy('name','asc')->get();
    }
    /*public function getProcess($sumTotalImpression){
        $rate = $this->cost_type == 'cpm' ? 1000 : 1;
		$campaignInventory        = $this->total_inventory * $rate;
        $process = 0;
        if($campaignInventory>0) {
            $process = round(($sumTotalImpression / $campaignInventory) * 100, 2);
            if ($process > 100) {
                $process = 100;
            }
        }
        return $process;
    }*/
}
