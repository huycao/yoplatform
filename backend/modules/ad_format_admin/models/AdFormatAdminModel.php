<?php

class AdFormatAdminModel extends AdFormatBaseModel {

	/**
	 *     Append attribute
	 *     @var array
	 */
    // protected $appends = array('statusText');

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
			'name'							=>	'required',
			'width'							=>	'required',
			'height'						=>	'required',
		);
	}

	/**
	 *     Get validate message when update
	 */
	public function getUpdateLangs(){
		return array(
			'name.required'							=>	trans('ad_format::validate.name.required'),
			'width.required'						=>	trans('ad_format::validate.width.required'),
			'height.required'						=>	trans('ad_format::validate.height.required')
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


}
