<?php

use \Carbon\Carbon;

class TrackingAdRequestBaseModel extends Eloquent {

    protected $table = 'tracking_adrequest';
    public $timestamps = false;

    public function website() {
        return $this->belongsTo('PublisherSiteBaseModel','website_id');
    }

    public function adzone() {
        return $this->belongsTo('PublisherAdZoneBaseModel','publisher_ad_zone_id');
    }



    public function getAdRequestDate($website_ids = array(), $zone_ids = array(), $start_date_range = '', $end_date_range = '', $display = 1){
        $query = $this;
        $query = $query->with('website', 'adzone')
                       ->select(
                    'website_id',
                    'publisher_ad_zone_id',
                    'date',
                    DB::raw('SUM(count) as total_ad_request')
                );

        if(!empty($website_ids)){
            $query = $query->whereIn('website_id', $website_ids);
        }
        if(!empty($zone_ids)){
            $query = $query->whereIn('publisher_ad_zone_id', $zone_ids);
        }
        if($start_date_range != ''){
            $query = $query->where('date','>=',$start_date_range);
        }

        if($end_date_range != ''){
            $query = $query->where('date','<=',$end_date_range);
        }

        $retval = $query->orderBy('date')->orderBy('hour')->groupBy('date', 'website_id', 'publisher_ad_zone_id')->paginate($display); 
         
        return $retval;
    }

    public function getAdRequestHour($wid, $zid, $date){
        $query = $this;
        $query = $query->with('website', 'adzone')
                       ->select(
                    'hour',
                    DB::raw('SUM(count) as total_ad_request')
                );

        $query = $query->where('website_id', $wid);
        $query = $query->where('publisher_ad_zone_id', $zid);
        $query = $query->where('date', $date);

        $retval = $query->orderBy('hour')->groupBy('website_id', 'publisher_ad_zone_id', 'date', 'hour')->get(); 
         
        return $retval;
    }
}
    