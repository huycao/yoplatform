<?php

class PublisherAdvertiserManagerModel extends PublisherBaseModel {

	/**
	 *     Append attribute
	 *     @var array
	 */

    /**
     *     Get field will display in list
     */
    public function getShowField(){        
        return array(
            'company'         =>  array(
                'label'         =>  trans("backend::publisher/text.company"),
                'type'          =>  'text'
            )
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
                        case 'search[\'keyword\']':
                            break;

                        case 'search[\'field\']':
                            pr($search['value'],1);
                            $query->where($search['value'], 'LIKE', "%{$searchData['search[\'keyword\']']['value']}%");
                            break;

                		default:
                    		// $query->where($search['name'], $search['value']);
                			break;
                	}
                }
            }
        }
        return $query;
    }


}
