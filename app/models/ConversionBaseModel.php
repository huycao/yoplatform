<?php

class ConversionBaseModel extends Eloquent {

    protected $table = 'conversion';

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
        'param',
        'source',
        'status',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at'
    );

    /**
     *     Get field will display in list
     */
    public function getShowField(){        
        return array(
            'id' =>  array(
                'label'         =>  trans("text.id"),
                'type'          =>  'text',
                'sortable'      =>  FALSE
            ),
            'name'  =>  array(
                'label'         =>  trans("text.section"),
                'type'          =>  'text',
                'sortable'      =>  FALSE
            ),
            'campaign_id' =>  array(
                'label'         =>  trans("text.campaign"),
                'type'          =>  'text',
                'sortable'      =>  FALSE
            )
        );   
    }

    /**
     *     Get validate rule when update
     */
    public function getUpdateRules($campaignID = 0, $id = 0){
        return array(
            'name'        =>  'required|unique:conversion,name,' . $id . ',id,campaign_id,' . $campaignID,
            'campaign_id' =>  'required',
            'status'      =>  'required',
            'param'	 	  =>  'variable'
        );
    }

    /**
     *     Get validate message when update
     */
    public function getUpdateLangs(){
        return array(
            'name.required'        =>  trans('conversion::validate.name.required'),
            'name.unique'          =>  trans('conversion::validate.name.unique'),
            'campaign_id.required' =>  trans('conversion::validate.campaign_id.required'),
            'status.required'      =>  trans('conversion::validate.status.required'),
            'param.variable'       =>  trans('conversion::validate.validation.variable')
        );
    }

    
    public function campaign() {
        return $this->belongsTo('CampaignBaseModel');
    }
    
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
    
    public function getByRangeId($range) {
        if (!empty($range)) {
            return $this->with('campaign')->whereIn('id', $range)->orderBy('id')->get();
        } else {
            return FALSE;
        }
    }
}
