<?php

class FlightWebsiteBaseModel extends Eloquent {

    /**
     *     Table name of model used
     *     @var string
     */
    protected $table = 'flight_website';

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
        'category_id',
        'campaign_id',
        'publisher_id',
        'publisher_site_id',
        'publisher_ad_zone_id',
        'flight_objective',
        'allow_over_delivery_report',
        'remark',
        'date',
        'day',
        'total_inventory',
        'value_added',
        'cost_type',
        'status',
        'regional_buy',
        'publisher_base_cost',
        'total_profit',
        'sale_profit',
        'company_profit',
        'created_by',
        'updated_by'
    );

    /**
     *     Get field will display in list
     */
    public function getShowField(){        
        return array(
            'campaign_id'         =>  array(
                'label'         =>  trans("text.campaign"),
                'type'          =>  'text',
                'sortable'      =>  FALSE
            ),
            'publisher_id'         =>  array(
                'label'         =>  trans("text.publisher"),
                'type'          =>  'text',
                'sortable'      =>  FALSE
            ),
            'publisher_site_id'  =>  array(
                'label'         =>  trans("text.section"),
                'type'          =>  'text',
                'sortable'      =>  FALSE
            ),
            'publisher_ad_zone_id'  =>  array(
                'label'         =>  trans("text.zone"),
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
     *     Get validate rule when update
     */
    public function getUpdateRules(){
        return array(
            'campaign_id'                   =>  'required',
            'category_id'                   =>  'required',
            'publisher_id'                  =>  'required',
            'publisher_site_id'             =>  'required',
            'publisher_ad_zone_id'          =>  'required',
            'flight_objective'              =>  'required',
            'allow_over_delivery_report'    =>  'required',
            'date'                          =>  'required',
            'total_inventory'               =>  'required',
            'value_added'                   =>  'required',
            'cost_type'                     =>  'required',
            'base_media_cost'               =>  'required',
            'media_cost'                    =>  'required'
        );
    }

    /**
     *     Get validate message when update
     */
    public function getUpdateLangs(){
        return array(
            'campaign_id.required'                  =>  trans('flight::validate.campaign_id.required'),
            'category_id.required'                  =>  trans('flight::validate.category_id.required'),
            'publisher_id.required'                 =>  trans('flight::validate.publisher_id.required'),
            'publisher_site_id.required'            =>  trans('flight::validate.publisher_site_id.required'),
            'publisher_ad_zone_id.required'         =>  trans('flight::validate.publisher_ad_zone_id.required'),
            'flight_objective.required'             =>  trans('flight::validate.flight_objective.required'),
            'allow_over_delivery_report.required'   =>  trans('flight::validate.allow_over_delivery_report.required'),
            'date.required'                         =>  trans('flight::validate.date.required'),
            'total_inventory.required'              =>  trans('flight::validate.total_inventory.required'),
            'value_added.required'                  =>  trans('flight::validate.value_added.required'),
            'cost_type.required'                    =>  trans('flight::validate.cost_type.required'),
            'base_media_cost.required'              =>  trans('flight::validate.base_media_cost.required'),
            'media_cost.required'                   =>  trans('flight::validate.media_cost.required')
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

    public function ad(){
        return $this->hasOne('AdBaseModel', 'id', 'ad_id');
    }

    public function website() {
        return $this->hasOne('PublisherSiteBaseModel', 'id', 'website_id');
    }

    public function flight() {
        return $this->belongsTo('FlightBaseModel', 'flight_id')->with("campaign");
    }

    public function getsite() {
        return $this->belongsTo('SitePublisherModel', 'publisher_site_id');
    }

    public function flightDate() {
        return $this->hasMany('FlightDateBaseModel', 'flight_id', 'flight_id');
    }

    public function getPriorityFlightId($wid){
        $rs = $this->select('flight_id')->where('website_id', $wid)->where('status', 1)->orderBy('sort', 'asc')->first();
        if( $rs ){
            return $rs->flight_id;
        }else{
            return false;
        }
    }
    
    /**
     * 
     * Get nhung flight dang chay theo website va ad format zone
     * @param $wid website ID
     * @param $ad_format ad format zone
     */
    public function getFlight($wid, $ad_format){
        $rs = DB::table('flight_website')
                    ->join('flight', 'flight_website.flight_id', '=', 'flight.id')
                    ->where('flight_website.website_id', $wid)
                    ->where('flight.ad_format_id', $ad_format)
                    ->where('flight.status', 1)
                    ->select('flight_website.id','flight.id as flight_id', 'flight.name', 'flight_website.status', 'flight_website.publisher_base_cost', 'flight_website.website_id')
                    ->orderBy('flight.id', 'DESC')
                    ->get();
        if($rs){
            return $rs;
        }else{
            return false;
        }
    }

    public function getListByWebsiteId($wid){
        return $this->where('website_id', $wid)->orderBy('order', 'asc')->get();        
    }

    public function getListByRangeWebsite( $range = array() ){
        if( !empty($range) ){
            return $this
                ->whereIn('website_id', $range)
                ->where('finish_update', 0)
                ->get()->toArray();
        }
        return false;
    }

}
