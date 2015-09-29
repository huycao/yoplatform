<?php

class AgencyAdvertiserManagerModel extends AgencyBaseModel {

	/**
	 *     Append attribute
	 *     @var array
	 */
    // protected $appends = array('statusText');

    /**
     *     Fillable
     *     @var array
     */
	public $fillable = array(
		'status',
		'name',
		'country_id',
		'created_by',
		'updated_by'		
	);

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
     *     Get display country in list
     */
    public function getCountryTextAttribute(){
    	return $this->country['country_name'];
    }

    /**
     *     Get field will display in list
     */
	public function getShowField(){        
	    return array(
	        'name'         =>  array(
	            'label'         =>  trans("text.name"),
	            'type'          =>  'text'
	        ),
	        'country_id'         =>  array(
	            'label'         =>  trans("text.country"),
	            'type'          =>  'text',
	            'alias'			=>	'countryText',
	            'sortable'		=>	FALSE
	        ),
	        'status'  =>  array(
	            'label'         =>  trans("text.status"),
	            'type'          =>  'text',
	            'alias'			=>	'statusText'
	        )
	    );   
	}

	/**
	 *     Get validate rule when update
	 */
	public function getUpdateRules(){
		return array(
			'name'			=>	'required',
			'country'		=>	'required'
		);
	}

	/**
	 *     Get validate message when update
	 */
	public function getUpdateLangs(){
		return array(
			'name.required'		=>	trans('agency::validate.name.required'),
			'country.required'	=>	trans('agency::validate.country.required')
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
                		case 'name':
                            $query->where($search['name'], 'LIKE', "%{$search['value']}%");
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

    public function searchByCapital($keyword){
        $query = $this->with('country');
        if( !empty($keyword) ){
           $query = $this->where('name', 'LIKE' ,"{$keyword}");
        }
        return $query
        		->orderBy('name','asc')
    			->where('status', 1)
    			->get();
    }


}
