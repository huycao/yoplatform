<?php

class LogsBaseModel extends Eloquent {

    protected $table = 'backend_logs';

    /**
     *     Get field will display in list
     */
    public function getShowField(){
        return array(
            'title'         =>  array(
                'label'         =>  trans("text.title"),
                'type'          =>  'text',
                'sortable'      =>  FALSE
            ),
            'publisher_site_id'  =>  array(
                'label'         =>  trans("text.section"),
                'type'          =>  'text',
                'sortable'      =>  FALSE
            ),
            'total_inventory'  =>  array(
                'label'         =>  trans("text.total_inventory"),
                'type'          =>  'text',
                'sortable'      =>  FALSE
            ),
            'day'  =>  array(
                'label'         =>  trans("text.days"),
                'type'          =>  'text',
                'sortable'      =>  FALSE
            ),
            'cost_type'  =>  array(
                'label'         =>  trans("text.cost_type"),
                'type'          =>  'text',
                'sortable'      =>  FALSE
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
                        case 'title':
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
