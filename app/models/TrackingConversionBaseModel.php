<?php

class TrackingConversionBaseModel extends Eloquent {

    protected $table = 'tracking_conversion';
    
    protected $fillable = array(
        'object_id',
        'conversion_id',
        'campaign_id',
        'param',
        'created_at'
    );

    public function conversion() {
        return $this->belongsTo('ConversionBaseModel','conversion_id')->select(array('id', 'name', 'source'));
    }
    public function campaign() {
        return $this->belongsTo('CampaignBaseModel','campaign_id')->select(array('id', 'name'));
    }
    
public function getShowField(){        
        return array(
            'id' =>  array(
                'label'         =>  trans("text.id"),
                'type'          =>  'text',
                'sortable'      =>  FALSE
            ),
            'conversion_id'  =>  array(
                'label'         =>  'Conversion id',
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
    
    public function scopeSearch($query, $searchData = array())
    {       
        if( !empty($searchData) ){
            foreach ($searchData as $search) {
                if( $search['value'] != '' ){
                    switch ($search['name']) {
                        case 'start_date_range':
                            $query->whereRaw('DATE_FORMAT(created_at, "%Y-%m-%d") >= ? ', array(date('Y-m-d', strtotime($search['value']))));
                            break;
                        case 'end_date_range':
                            $query->whereRaw('DATE_FORMAT(created_at, "%Y-%m-%d") <= ? ', array(date('Y-m-d', strtotime($search['value']))));
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
    
    public function getConversionSummary($campaignId){
        $retval = [];
        $retval = $this
            ->with('conversion')
            ->select(
                'conversion_id',
                DB::raw('COUNT(id) as total_conversion')
            )
            ->where('campaign_id', $campaignId)
            ->groupBy('conversion_id')
            ->orderBy('conversion_id', 'asc')
            ->get()->toArray();

        return $retval;
    }
    
    public function getConversionChart($campaignId, $limit = 4){
    	return $this
    			->select(
    				DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d") as date'),
    				DB::raw('COUNT(id) as total_conversion')
    			)
                ->where('campaign_id', $campaignId)
    			->groupBy('date')
    			->orderBy('date', 'asc')
    			->get();
    }
    
    public function getListConversionTracking($range){
        $listConversionTrackingTMP = $this->getConversionDayByRangeConversionId($range);
        return $this->calculateSummary($listConversionTrackingTMP);
    }
    
    public function getConversionDayByRangeConversionId($range){
        $retval = [];
        if( !empty($range) ){
            $retval = $this->select(
                        'conversion_id',
                        DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d") as date'),
                        DB::raw('COUNT(id) as total_conversion')
                    )
                    ->whereIn('conversion_id', $range)
                    ->groupBy('conversion_id','date')
                    ->orderBy('date','asc')
                    ->get()
                    ->toArray();
            
        }
        
        return $retval;
    }
    
    public function calculateSummary( $listConversionTrackingTMP = array() ){
        $listConversionTracking = array();
        if(!empty($listConversionTrackingTMP)){
            $tracking = [];
            foreach( $listConversionTrackingTMP as $tracking ){
                $listConversionTracking[$tracking['conversion_id']][] = $tracking;
            }
        }

        return $listConversionTracking;
    }
    
    public function getDataPerDate($date, $campaign, $conversion){
        $retval = [];
        if(!empty($date) && !empty($campaign) && !empty($conversion)){
            $retval = $this->select(
                        'conversion_id',
                        'campaign_id',
                        DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d") as date'),
                        DB::raw('DATE_FORMAT(created_at, "%H") as hour'),
                        DB::raw('COUNT(id) as total_conversion')
                    )
                    ->whereRaw('DATE_FORMAT(created_at, "%Y-%m-%d") = ? ', array($date))
                    ->where('campaign_id', $campaign)
                    ->where('conversion_id', $conversion)
                    ->groupBy('hour')
                    ->orderBy('hour','asc')
                    ->get()
                    ->toArray();
        }
        
        return $retval;
    }
}
    