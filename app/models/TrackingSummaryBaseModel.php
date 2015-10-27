<?php

use \Carbon\Carbon;

class TrackingSummaryBaseModel extends Eloquent {

    protected $table = 'tracking_summary';
    public $timestamps = false;

    public function flight() {
        return $this->belongsTo('FlightBaseModel','flight_id');
    }
    public function campaign() {
        return $this->belongsTo('CampaignBaseModel','campaign_id');
    }
    public function ad() {
        return $this->belongsTo('AdBaseModel','ad_id');
    }
    public function website() {
        return $this->belongsTo('PublisherSiteBaseModel','website_id');
    }

    public function flightWebsite() {
        return $this->belongsTo('FlightWebsiteBaseModel', 'flight_website_id');
    }

    public function ad_format() {
        return $this->belongsTo('AdformatBaseModel');
    }

    public function getsite() {
        return $this->belongsTo('PublisherSiteBaseModel','publisher_site_id');
    }

    public function getFlightSummary($campaignId){
        $retval = [];
        $data = $this->select(
                'flight_id',
                'ovr',
                DB::raw('SUM(ads_request) as total_ads_request'),
                DB::raw('SUM(impression) as total_impression'),
                DB::raw('SUM(unique_impression) as total_unique_impression'),
                DB::raw('SUM(click) as total_click'),
                DB::raw('SUM(unique_click) as total_unique_click'),
                DB::raw('SUM(start) as total_start'),
                DB::raw('SUM(firstquartile) as total_firstquartile'),
                DB::raw('SUM(midpoint) as total_midpoint'),
                DB::raw('SUM(thirdquartile) as total_thirdquartile'),
                DB::raw('SUM(complete) as total_complete'),
                DB::raw('SUM(pause) as total_pause'),
                DB::raw('SUM(mute) as total_mute'),
                DB::raw('SUM(fullscreen) as total_fullscreen'),
                DB::raw('SUM(unmute) as total_unmute')
            )
            ->where('campaign_id', $campaignId)
            ->groupBy('flight_id','ovr')
            ->orderBy('ovr', 'asc')
            ->get();
        if($data){
            //buil data
            $arrEvent = Config::get('data.event_tracking');
            foreach ($data as $k => $v) {
                if($v->ovr){
                    foreach ($arrEvent as $event) {
                        $total_event = "total_{$event}";
                        if (!isset($retval[$v->flight_id][$total_event])) {
                            $retval[$v->flight_id][$total_event] = 0;
                        } 
                        
                        $retval[$v->flight_id]["{$total_event}_over"] = $v->$total_event;
                        
                        unset($v->$total_event);
                    }
                    $retval[$v->flight_id] = array_merge($retval[$v->flight_id],$v->toArray());
                }
                else{
                    $retval[$v->flight_id] = $v->toArray();
                    foreach ($arrEvent as $event) {
                        $total_event = "total_{$event}";
                        
                        if (!isset($retval[$v->flight_id]["{$total_event}_over"])) {
                            $retval[$v->flight_id]["{$total_event}_over"] = 0;
                        } 
                    }
                }

            }
        }

        return $retval;
    }
    
    public function getFlightSummaryByID($flight_id){
        $retval = [];
        $data = $this->select(
                'flight_id',
                'ovr',
                DB::raw('SUM(ads_request) as total_ads_request'),
                DB::raw('SUM(impression) as total_impression'),
                DB::raw('SUM(unique_impression) as total_unique_impression'),
                DB::raw('SUM(click) as total_click'),
                DB::raw('SUM(unique_click) as total_unique_click'),
                DB::raw('SUM(start) as total_start'),
                DB::raw('SUM(firstquartile) as total_firstquartile'),
                DB::raw('SUM(midpoint) as total_midpoint'),
                DB::raw('SUM(thirdquartile) as total_thirdquartile'),
                DB::raw('SUM(complete) as total_complete'),
                DB::raw('SUM(pause) as total_pause'),
                DB::raw('SUM(mute) as total_mute'),
                DB::raw('SUM(fullscreen) as total_fullscreen'),
                DB::raw('SUM(unmute) as total_unmute')
            )
            ->where('flight_id', $flight_id)
            ->groupBy('ovr')
            ->orderBy('ovr', 'asc')
            ->get();
        if($data){
            //buil data
            foreach ($data as $k => $v) {
                if($v->ovr){
                    if(empty($retval)){
                        $retval = $v->toArray();
                    }
                    $retval['total_ads_request_over']       = $v->total_ads_request;
                    $retval['total_impression_over']        = $v->total_impression;
                    $retval['total_unique_impression_over'] = $v->total_unique_impression;
                    $retval['total_click_over']             = $v->total_click;
                    $retval['total_unique_click_over']      = $v->total_unique_click;
                }
                else{
                    $retval = $v->toArray();
                    $retval['total_ads_request_over']       = 0;
                    $retval['total_impression_over']        = 0;
                    $retval['total_unique_impression_over'] = 0;
                    $retval['total_click_over']             = 0;
                    $retval['total_unique_click_over']      = 0;
                }
            }
        }

        return $retval;
    }

    public function getListFlightTracking($range){
        $listFlightTrackingTMP = $this->getFlightSummaryDayByRangeFlightId($range);
        return $this->calculateSummary( $listFlightTrackingTMP );
    }

    public function getListWebsiteTracking($range,$websites = array() ,$start_date_range = "",$end_date_range = ""){
        $listFlightTrackingTMP = $this->getFlightSummaryWebsiteByRangeFlightId($range,$websites,$start_date_range,$end_date_range);
        return $this->calculateSummary( $listFlightTrackingTMP );
    }

    public function getCampaignTracking($range){
        return $this->getCampaignSummaryDayByListFlightId($range)->toArray();
    }

    public function calculateSummary( $listFlightTrackingTMP = array() ){
        $listFlightTracking = array();
        if( !empty( $listFlightTrackingTMP ) ){
            // $listFlightTrackingTMP = $listFlightTrackingTMP->toArray();
            $tracking = [];
            foreach( $listFlightTrackingTMP as $tracking ){
                $listFlightTracking[$tracking['flight_id']][] = $tracking;
            }
        }

        return $listFlightTracking;

    }

    public function getFlightSummaryDayByRangeFlightId($range){
        $retval = [];
        if( !empty($range) ){
            $data = $this->select(
                        'flight_id',
                        'date',
                        'ovr',
                        DB::raw('SUM(ads_request) as total_ads_request'),
                        DB::raw('SUM(impression) as total_impression'),
                        DB::raw('SUM(unique_impression) as total_unique_impression'),
                        DB::raw('SUM(click) as total_click'),
                        DB::raw('SUM(unique_click) as total_unique_click'),
                        DB::raw('SUM(start) as total_start'),
                        DB::raw('SUM(firstquartile) as total_firstquartile'),
                        DB::raw('SUM(midpoint) as total_midpoint'),
                        DB::raw('SUM(thirdquartile) as total_thirdquartile'),
                        DB::raw('SUM(complete) as total_complete'),
                        DB::raw('SUM(pause) as total_pause'),
                        DB::raw('SUM(mute) as total_mute'),
                        DB::raw('SUM(fullscreen) as total_fullscreen'),
                        DB::raw('SUM(unmute) as total_unmute')
                    )
                    ->whereIn('flight_id', $range)
                    ->groupBy('flight_id','date', 'ovr')
                    ->orderBy('date','asc')
                    ->orderBy('ovr','asc')
                    ->get();
            if($data){
                //build data
                $arrEvent = Config::get('data.event_tracking');
                foreach ($data as $k => $v) {
                    $key = $v->date. "-" . $v->flight_id;
                    if($v->ovr){
                        
                        foreach ($arrEvent as $event) {
                            $total_event = "total_{$event}";
                            
                            if (!isset($retval[$key][$total_event])) {
                               $retval[$key][$total_event] = 0;
                            } 
                            
                            $retval[$key]["{$total_event}_over"] = $v->$total_event;
                            unset($v->$total_event);
                        }
                        $retval[$key] = array_merge($retval[$key],$v->toArray());
                    }
                    else{
                        $retval[$key] = $v->toArray();
                        foreach ($arrEvent as $event) {
                            $total_event = "total_{$event}";
                            if (!isset($retval[$key]["{$total_event}_over"])) {
                                $retval[$key]["{$total_event}_over"] = 0;
                            }
                        }
                    }

                }
            }
        }
        // pr($retval);
        return $retval;
    }

    public function getCampaignSummaryDayByListFlightId($range){
        if( !empty($range) ){
            $query = $this->select(
                        'date',
                        DB::raw('SUM(ads_request) as total_ads_request'),
                        DB::raw('SUM(impression) as total_impression'),
                        DB::raw('SUM(unique_impression) as total_unique_impression'),
                        DB::raw('SUM(click) as total_click'),
                        DB::raw('SUM(unique_click) as total_unique_click'),
                        DB::raw('SUM(start) as total_start'),
                        DB::raw('SUM(firstquartile) as total_firstquartile'),
                        DB::raw('SUM(midpoint) as total_midpoint'),
                        DB::raw('SUM(thirdquartile) as total_thirdquartile'),
                        DB::raw('SUM(complete) as total_complete'),
                        DB::raw('SUM(pause) as total_pause'),
                        DB::raw('SUM(mute) as total_mute'),
                        DB::raw('SUM(fullscreen) as total_fullscreen'),
                        DB::raw('SUM(unmute) as total_unmute')
                    )
                    ->whereIn('flight_id', $range)
                    ->groupBy('date')
                    ->get();

            return $query;

        }else{
            return FALSE;
        }
    }

    public function getFlightSummaryWebsiteByRangeFlightId($range,$website = array(), $start_date_range = "",$end_date_range = ""){
        if( !empty($range) ){
            $query = $this;
            $query = $query
                    ->with('website')
                    ->select(
                        'tracking_summary.flight_id',
                        'tracking_summary.flight_website_id',
                        'tracking_summary.publisher_base_cost',
                        'tracking_summary.website_id',
                        'tracking_summary.ovr',
                        DB::raw('SUM(ads_request) as total_ads_request'),
                        DB::raw('SUM(impression) as total_impression'),
                        DB::raw('SUM(unique_impression) as total_unique_impression'),
                        DB::raw('SUM(click) as total_click'),
                        DB::raw('ROUND(pt_tracking_summary.publisher_base_cost/1000*SUM(impression),2) as amount_impression'),
                        DB::raw('ROUND(pt_tracking_summary.publisher_base_cost*SUM(click),2) as amount_click'),
                        DB::raw('SUM(unique_click) as total_unique_click'),
                        DB::raw('SUM(start) as total_start'),
                        DB::raw('SUM(firstquartile) as total_firstquartile'),
                        DB::raw('SUM(midpoint) as total_midpoint'),
                        DB::raw('SUM(thirdquartile) as total_thirdquartile'),
                        DB::raw('SUM(complete) as total_complete'),
                        DB::raw('SUM(mute) as total_mute'),
                        DB::raw('SUM(fullscreen) as total_fullscreen'),
                        DB::raw('SUM(unmute) as total_unmute'),
                        DB::raw('SUM(pause) as total_pause'),
                        DB::raw('SUM(mute) as total_mute'),
                        DB::raw('SUM(fullscreen) as total_fullscreen'),
                        DB::raw('SUM(unmute) as total_unmute')
                    )
                    // ->where('ovr', 0)
                    ->whereIn('tracking_summary.flight_id', $range);

            if(!empty($website)){
                $query = $query->whereIn('tracking_summary.website_id',$website);
            }
            if($start_date_range !="" && $end_date_range !=""){
                $query = $query->where('tracking_summary.date','>=',$start_date_range)
                    ->where('tracking_summary.date','<=',$end_date_range);
            }

            $query = $query->join('flight_website', 'flight_website.id', '=', 'tracking_summary.flight_website_id')
                    ->groupBy('tracking_summary.flight_id', 'tracking_summary.website_id', 'tracking_summary.ovr', 'tracking_summary.publisher_base_cost')
                    ->orderBy('ovr','asc')
                    ->get();
         
            if($query){
                //buil data
                $arrEvent = Config::get('data.event_tracking');
                foreach ($query as $v) {
                    $key = "{$v->website_id}-{$v->flight_id}";
                    if (!isset($retval[$key]['total_impression_pay'])) {
                        $retval[$key]['total_impression_pay'] = 0;
                    }
                    
                    if (!isset($retval[$key]['total_click_pay'])) {
                        $retval[$key]['total_click_pay'] = 0;
                    }
                    
                    if($v->ovr){                        
                        foreach ($arrEvent as $event) {
                            $total_event = "total_{$event}";
                            
                            if (!isset($retval[$key][$total_event])) {
                               $retval[$key][$total_event] = 0;
                            } 
                            
                            if (!isset($retval[$key]["{$total_event}_over"])) {
                                $retval[$key]["{$total_event}_over"] = $v->$total_event;
                            } else {
                                $retval[$key]["{$total_event}_over"] += $v->$total_event;
                            }
                            
                            unset($v->$total_event);
                        }
                        $retval[$key] = array_merge($retval[$key],$v->toArray());
                    }
                    else{                        
                        foreach ($arrEvent as $event) {
                            $total_event = "total_{$event}";
                            if (!isset($retval[$key]["{$total_event}_over"])) {
                                $retval[$key]["{$total_event}_over"] = 0;
                            }
                            
                            if (!isset($retval[$key][$total_event])) {
                                $retval[$key][$total_event] = $v->$total_event;
                            } else {
                                $retval[$key][$total_event] += $v->$total_event;
                            }
                            
                            if ('total_impression' == $total_event) {
                                $retval[$key]['total_impression_pay'] += round($v->publisher_base_cost * ($v->total_impression/1000), 2);
                            }
                            
                            if ('total_click' == $total_event) {
                                $retval[$key]['total_click_pay'] += $v->publisher_base_cost * $v->total_click;
                            }
                            
                            unset($v->$total_event);
                        }
                        
                        $retval[$key] = array_merge($retval[$key],$v->toArray());
                    }
    
                }
            }       
             
            return $retval;

        }else{
            return FALSE;
        }
    }

    public function getFlightChart($campaignId, $limit = 4){

    	return $this
    			->select(
    				'date',
    				DB::raw('SUM(impression) as total_impression'),
    				DB::raw('SUM(click) as total_click')
    			)
                ->where('campaign_id', $campaignId)
    			->groupBy('date')
                ->orderBy('date','desc')
                // ->limit($limit)
    			->get();
    }

    public function getEarnByDateRange( $websiteLists, $startDate, $endDate, $groupDay = false, $groupMonth = false, $isPub = true ){

        $rs =  $this->with('flightWebsite');

        if( $groupMonth ){
            $rs = $rs->select(
                'flight_website_id',
                'date',
                'tracking_summary.publisher_base_cost',
                DB::raw('SUM(impression) as total_impression'),
                DB::raw('SUM(click) as total_click'),
                DB::raw('ROUND(pt_tracking_summary.publisher_base_cost/1000*SUM(impression),2) as amount_impression'),
                DB::raw('ROUND(pt_tracking_summary.publisher_base_cost*SUM(click),2) as amount_click'),
                DB::raw('MONTH(date) as month')
            );
        }else{
            $rs = $rs->select(
                'flight_website_id',
                'date',
                'tracking_summary.publisher_base_cost',
                DB::raw('SUM(impression) as total_impression'),
                DB::raw('ROUND(pt_tracking_summary.publisher_base_cost/1000*SUM(impression),2) as amount_impression'),
                DB::raw('ROUND(pt_tracking_summary.publisher_base_cost*SUM(click),2) as amount_click'),
                DB::raw('SUM(click) as total_click')
            );
        }

        if( $isPub ){
            $rs = $rs->where('ovr',0);
        }

        $rs = $rs->whereIn('tracking_summary.website_id', $websiteLists)
            ->where('date', '>=', $startDate)
            ->where('date', '<=', $endDate)
            ->where('flight_website_id', '!=', 0)
            ->join('flight_website', 'flight_website.id', '=', 'tracking_summary.flight_website_id')
            ->orderBy('date')
            ->groupBy('flight_website_id', 'publisher_base_cost');

        if( $groupDay ){
            $rs = $rs->groupBy('date');
        }

        if( $groupMonth ){
            $rs = $rs->groupBy('month');
        }

        return $rs->get();

    }

    public function getEarnTotal( $websiteLists, $startDate, $endDate, $isPub = true){

        $rs = $this->getEarnByDateRange($websiteLists, $startDate, $endDate, false, false, $isPub);
        $totalCost = 0;
        if( !$rs->isEmpty() ){
            foreach( $rs as $item ){
                if( isset( $item->flightWebsite ) ){

                    switch ($item->flightWebsite->flight->cost_type) {

                        case 'cpm':
                            $totalCost += $item->amount_impression;
                            break;

                        case 'cpc':
                            $totalCost += $item->amount_click;
                            break;

                        default:
                            break;
                    }

                    // pr($item->flightWebsite->flight, 1);
                    // $flight = $item->flightWebsite->flight;
                    // $baseCost = $item->flightWebsite->publisher_base_cost;
                    // $totalCost += getCost($flight->cost_type, $item->total_impression, $item->click, $baseCost);
                }
            }
        }


        return $totalCost;
    }

    public function getEarnPerDate( $websiteLists, $dateDiff, $isPub = true){

        $startDate = new Carbon("- {$dateDiff}day");

        $data = $this->getEarnByDateRange($websiteLists, $startDate, date('Y-m-d'), true, false, $isPub);
        $rs = array(
            'date'  =>  array(),
            'earn'  =>  array()
        );
        $tmp = array();
        if( !$data->isEmpty() ){
            foreach ($data as $item) {

                if( isset( $item->flightWebsite ) ){
                    // $flight = $item->flightWebsite->flight;
                    // $baseCost = $item->flightWebsite->publisher_base_cost;
                    // $cost = getCost($flight->cost_type, $item->total_impression, $item->click, $baseCost);

                    $cost = 0;

                    switch ($item->flightWebsite->flight->cost_type) {

                        case 'cpm':
                            $cost += $item->amount_impression;
                            break;

                        case 'cpc':
                            $cost += $item->amount_click;
                            break;

                        default:
                            break;
                    }

                    if( isset($tmp[$item['date']]) ){
                        $tmp[$item['date']] += $cost;
                    }else{
                        $tmp[$item['date']] = $cost;
                    }
                }

            }

            if( !empty($tmp) ){
                foreach( $tmp as $key => $value){
                    $rs['date'][] = $key;
                    $rs['earn'][] = $value;
                }
            }


        }

        $rs['date'] = json_encode($rs['date']);
        $rs['earn'] = json_encode($rs['earn'], JSON_NUMERIC_CHECK);
        return $rs;

    }

    public function sumEarnPerCampaign($websiteLists, $startDate, $endDate){

        $data = $this->getEarnPerFlight($websiteLists, $startDate, $endDate);

        $campaign = array();
        $total = 0;

        if( count($data)){

            foreach( $data as $item ){

                $cost = 0;

                switch ($item->cost_type) {

                    case 'cpm':
                        $cost = $item->amount_impression;
                        break;

                    case 'cpc':
                        $cost = $item->amount_click;
                        break;

                    default:
                        break;
                }

                if( isset($campaign[$item->campaign_id]) ){
                    $campaign[$item->campaign_id]['cost'] += $cost;
                    $campaign[$item->campaign_id]['impression'] += $item->total_impression;
                    $campaign[$item->campaign_id]['click'] += $item->total_click;
                }else{
                    $campaign[$item->campaign_id]['cost'] = $cost;
                    $campaign[$item->campaign_id]['impression'] = $item->total_impression;
                    $campaign[$item->campaign_id]['click'] = $item->total_click;
                }

                $total += $cost;

            }

        }

        $result = array(
            'campaign'  =>  $campaign,
            'total' =>  $total
        );

        return $result;

    }

    public function getEarnPerFlight($websiteLists, $startDate, $endDate){
        $this->select(
                'flight.campaign_id',
                'flight.cost_type',
                'tracking_summary.flight_id',
                'tracking_summary.flight_website_id',
                DB::raw('ROUND(pt_flight_website.publisher_base_cost,2) as ecpm'),
                DB::raw('SUM(impression) as total_impression'),
                DB::raw('SUM(unique_impression) as total_unique_impression'),
                DB::raw('SUM(click) as total_click'),
                DB::raw('ROUND(SUM(impression)/SUM(unique_impression),2) as frequency'),
                DB::raw('ROUND(SUM(click)/SUM(impression)*100,2) as ctr'),
                DB::raw('ROUND(pt_tracking_summary.publisher_base_cost/1000*SUM(impression),2) as amount_impression'),
                DB::raw('ROUND(pt_tracking_summary.publisher_base_cost*SUM(click),2) as amount_click')
            )
            ->join('flight_website', 'tracking_summary.flight_website_id', '=', 'flight_website.id')
            ->join('flight', 'flight.id', '=', 'flight_website.flight_id')
            ->whereIn('tracking_summary.website_id', $websiteLists)
            ->where('tracking_summary.date', '>=', $startDate)
            ->where('tracking_summary.date', '<=', $endDate)
            ->where('ovr',0)
            ->groupBy('flight_website.flight_id','tracking_summary.publisher_base_cost')
            ->get();
    }
    public function getEarnReport($startDate, $endDate){

        return $this->select(
            'flight.campaign_id',
            'flight.cost_type',
            'tracking_summary.flight_id',
            'tracking_summary.website_id',
            'tracking_summary.flight_website_id',
            'tracking_summary.publisher_base_cost',
            DB::raw('ROUND(pt_flight_website.publisher_base_cost,2) as ecpm'),
            DB::raw('SUM(impression) as total_impression'),
            DB::raw('SUM(unique_impression) as total_unique_impression'),
            DB::raw('SUM(click) as total_click'),
            DB::raw('ROUND(SUM(impression)/SUM(unique_impression),2) as frequency'),
            DB::raw('ROUND(SUM(click)/SUM(impression)*100,2) as ctr'),
            DB::raw('ROUND(pt_tracking_summary.publisher_base_cost/1000*SUM(impression),2) as amount_impression'),
            DB::raw('ROUND(pt_tracking_summary.publisher_base_cost*SUM(click),2) as amount_click')
        )
            ->join('flight_website', 'tracking_summary.flight_website_id', '=', 'flight_website.id')
            ->join('flight', 'flight.id', '=', 'flight_website.flight_id')
            ->where('tracking_summary.date', '>=', $startDate)
            ->where('tracking_summary.date', '<=', $endDate)
            ->where('ovr',0)
            ->groupBy('tracking_summary.flight_id','tracking_summary.flight_website_id','tracking_summary.publisher_base_cost')
            ->get();
    }
    public function getEarnPerMonth( $websiteLists, $monthDiff, $isPub = true){

        $startDate = Carbon::now()->firstOfMonth()->subMonths($monthDiff-1);
        $endDate = Carbon::now()->lastOfMonth();

        $listMonth = array();


        $listMonth[$startDate->month] = 0;
        for ($i=1; $i < $monthDiff-1; $i++) {
            $listMonth[Carbon::now()->firstOfMonth()->subMonths($monthDiff-1-$i)->month] = 0;
        }
        $listMonth[$endDate->month] = 0;
        $data = $this->getEarnByDateRange($websiteLists, $startDate, $endDate, false, true, $isPub);

        $rs = array(
            'month' =>  array(),
            'earn'  =>  array()
        );

        if( !$data->isEmpty() ){
            foreach ($data as $item) {

                if( isset( $item->flightWebsite ) ){
                    // $flight = $item->flightWebsite->flight;
                    // $baseCost = $item->flightWebsite->publisher_base_cost;
                    // $cost = getCost($flight->cost_type, $item->total_impression, $item->click, $baseCost);

                    $cost = 0;

                    switch ($item->flightWebsite->flight->cost_type) {

                        case 'cpm':
                            $cost += $item->amount_impression;
                            break;

                        case 'cpc':
                            $cost += $item->amount_click;
                            break;

                        default:
                            break;
                    }

                    $listMonth[$item['month']] += $cost;
                }
            }

            if( !empty($listMonth) ){
                foreach( $listMonth as $key => $value){
                    $rs['month'][] = $key;
                    $rs['earn'][] = $value;
                }
            }
        }

        if( !empty($rs['month']) ){
            $tmp = array();
            foreach( $rs['month'] as $month ){
                $dt = DateTime::createFromFormat('!m', $month);
                $tmp[] = $dt->format('F');
            }
            $rs['month'] = $tmp;
        }


        $rs['month'] = json_encode($rs['month']);
        $rs['earn'] = json_encode($rs['earn'], JSON_NUMERIC_CHECK);

        return $rs;

    }
    static  function getDataPerDate($date,$campaign,$ad,$flight,$typeapp = 'hour'){
        $data = null;
        $retval = [];
        if( !empty($date) && !empty($campaign) && !empty($ad) && !empty($flight) ){

            $data = TrackingSummaryBaseModel::select(
                '*',
                DB::raw('SUM(ads_request) as total_ads_request'),
                DB::raw('SUM(impression) as total_impression'),
                DB::raw('SUM(unique_impression) as total_unique_impression'),
                DB::raw('SUM(click) as total_click'),
                DB::raw('SUM(unique_click) as total_unique_click'),
                DB::raw('SUM(start) as total_start'),
                DB::raw('SUM(firstquartile) as total_firstquartile'),
                DB::raw('SUM(midpoint) as total_midpoint'),
                DB::raw('SUM(thirdquartile) as total_thirdquartile'),
                DB::raw('SUM(complete) as total_complete'),
                DB::raw('SUM(pause) as total_pause'),
                DB::raw('SUM(mute) as total_mute'),
                DB::raw('SUM(fullscreen) as total_fullscreen'),
                DB::raw('SUM(unmute) as total_unmute')
            )
                ->where('flight_id', '=', $flight)
                ->where('campaign_id', '=', $campaign)
                ->where('ad_id', '=', $ad)
                ->where('date', '=', $date);
            if($typeapp == 'site'){
                $data = $data->groupBy('website_id', 'ovr');
                $keyIndex = 'website_id';
            }else{
                $data = $data->groupBy('hour', 'ovr');
                $keyIndex = 'hour';
            }

            $data =  $data->orderby($keyIndex)->orderby('ovr')->with("campaign",'flight','ad_format','ad','website')
                ->get();

            if($data){
                $arrEvent = Config::get('data.event_tracking'); 
                                        
                foreach ($data as $k => $v) {
                    $retval['campaign'] = $v->campaign->toArray();
                    $retval['flight'] = $v->flight->toArray();
                    $retval['ad_format'] = $v->ad_format->toArray();
                    $retval['ad'] = $v->ad->toArray();
                    $retval['date'] = $v->date;
                    unset($v->ad);
                    unset($v->campaign);
                    unset($v->flight);
                    unset($v->ad_format);     
                    if($v->ovr){
                        foreach ($arrEvent as $event) {
                            $total_event = "total_{$event}";
                            if (!isset($retval['summary'][$v->$keyIndex][$total_event])) {
                                $retval['summary'][$v->$keyIndex][$total_event] = 0;
                            } 
                            
                            $retval['summary'][$v->$keyIndex]["{$total_event}_over"] = $v->$total_event;
                            
                            unset($v->$total_event);
                        }
                        $retval['summary'][$v->$keyIndex] = array_merge($retval['summary'][$v->$keyIndex],$v->toArray());
                    }
                    else{                        
                        foreach ($arrEvent as $event) {
                            $total_event = "total_{$event}";
                            
                            if (!isset($retval['summary'][$v->$keyIndex]["{$total_event}_over"])) {
                                $retval['summary'][$v->$keyIndex]["{$total_event}_over"] = 0;
                            } 
                        }
                        
                        $retval['summary'][$v->$keyIndex] = array_merge($retval['summary'][$v->$keyIndex],$v->toArray());
                    }

                }
            }
        }
        
        return $retval;
    }
    static  function getDataPerWebsite($start,$end,$site,$campaign,$ad,$flight){
        $data = null;
        $retval = [];
        if(!empty($campaign) && !empty($ad) && !empty($flight) && !empty($site) ){

            $data = TrackingSummaryBaseModel::select(
                '*',
                DB::raw('SUM(ads_request) as total_ads_request'),
                DB::raw('SUM(impression) as total_impression'),
                DB::raw('SUM(unique_impression) as total_unique_impression'),
                DB::raw('SUM(click) as total_click'),
                DB::raw('SUM(unique_click) as total_unique_click'),
                DB::raw('SUM(start) as total_start'),
                DB::raw('SUM(firstquartile) as total_firstquartile'),
                DB::raw('SUM(midpoint) as total_midpoint'),
                DB::raw('SUM(thirdquartile) as total_thirdquartile'),
                DB::raw('SUM(complete) as total_complete'),
                DB::raw('SUM(pause) as total_pause'),
                DB::raw('SUM(mute) as total_mute'),
                DB::raw('SUM(fullscreen) as total_fullscreen'),
                DB::raw('SUM(unmute) as total_unmute')
            )
                ->where('flight_id', '=', $flight)
                ->where('campaign_id', '=', $campaign)
                ->where('ad_id', '=', $ad)
                ->where('website_id', '=', $site);
            if(!empty($start) && !empty($end)) {
                $data = $data->where('date', '>=', $start)
                    ->where('date', '<=', $end);
            }
            $data = $data->groupBy('date', 'ovr');

            $data =  $data->orderby("date")->orderby('ovr')->with("campaign",'flight','ad_format')
                ->get();

            if($data){
                $arrEvent = Config::get('data.event_tracking');
                foreach ($data as $k => $v) {
                    $key = $v->date. "-" . $v->flight_id;
                    $retval['campaign'] = $v->campaign->toArray();
                    $retval['flight'] = $v->flight->toArray();
                    $retval['ad_format'] = $v->ad_format->toArray();
                    $retval['ad'] = $v->ad->toArray();
                    $retval['date'] = $v->date;
                    unset($v->ad);
                    unset($v->campaign);
                    unset($v->flight);
                    unset($v->ad_format);
                    
                    if($v->ovr){                        
                        foreach ($arrEvent as $event) {
                            $total_event = "total_{$event}";
                            if (!isset($retval['summary'][$key][$total_event])) {
                                $retval['summary'][$key][$total_event] = 0;
                            } 
                            
                            $retval['summary'][$key]["{$total_event}_over"] = $v->$total_event;
                            
                            unset($v->$total_event);
                        }
                        $retval['summary'][$key] = array_merge($retval['summary'][$key],$v->toArray());
                    }
                    else{
                        foreach ($arrEvent as $event) {
                            $total_event = "total_{$event}";
                            
                            if (!isset($retval['summary'][$key]["{$total_event}_over"])) {
                                $retval['summary'][$key]["{$total_event}_over"] = 0;
                            } 
                        }
                        
                        $retval['summary'][$key] = array_merge($retval['summary'][$key],$v->toArray());
                    }

                }
            }
        }
        
        return $retval;
    }
    
    //lists Website By Flight
    function getListsWebsite($rangeFlight){
       return $this->with('website')
                ->whereIn('flight_id', $rangeFlight)
                ->groupBy('website_id')
                ->get();

    }
    //lists Flight base on campaign_id
    static function getListFlight($campaignId, $month, $year){
       $query = TrackingSummaryBaseModel::select(
            'flight.campaign_id',
            'flight.cost_type',
            'tracking_summary.flight_id',
            'tracking_summary.flight_website_id',
            DB::raw('ROUND(pt_flight_website.publisher_base_cost,2) as ecpm'),
            DB::raw('SUM(impression) as impression'),
            DB::raw('SUM(unique_impression) as total_unique_impression'),
            DB::raw('SUM(click) as click'),
            DB::raw('ROUND(SUM(impression)/SUM(unique_impression),2) as frequency'),
            DB::raw('ROUND(SUM(click)/SUM(impression)*100,2) as ctr'),
            DB::raw('ROUND(pt_tracking_summary.publisher_base_cost/1000*SUM(impression),2) as amount_impression'),
            DB::raw('ROUND(pt_tracking_summary.publisher_base_cost*SUM(click),2) as amount_click')
        )
        ->join('flight_website', 'tracking_summary.flight_website_id', '=', 'flight_website.id')
        ->join('flight', 'flight.id', '=', 'flight_website.flight_id')
        ->whereRaw('MONTH(pt_tracking_summary.date)="'.$month.'" AND YEAR(pt_tracking_summary.date)="'.$year.'"')
        ->where('ovr',0)
        ->where('flight.campaign_id', '=', $campaignId)
        ->groupBy('flight_website.flight_id','tracking_summary.publisher_base_cost')
        ->get();
        return $query;
    }
}
    