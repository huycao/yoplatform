<?php

class ReportEarningsPublisherModel extends TrackingSummaryBaseModel {


	public function scopeSearch($query, $searchData = array(), $websiteRange)
    {

		$query->select(
                'flight.name',
                'flight.created_at',
                'flight.cost_type',
                DB::raw('ROUND(pt_flight_website.publisher_base_cost,2) as ecpm'),
                DB::raw('SUM(impression) as total_impression'),
                DB::raw('SUM(unique_impression) as total_unique_impression'),
                DB::raw('SUM(click) as total_click'),
                DB::raw('ROUND(SUM(impression)/SUM(unique_impression),2) as frequency'),
                DB::raw('ROUND(SUM(click)/SUM(impression)*100,2) as ctr'),
                DB::raw('ROUND(pt_flight_website.publisher_base_cost/1000*SUM(impression),2) as amount_impression'),
                DB::raw('ROUND(pt_flight_website.publisher_base_cost*SUM(impression),2) as amount_click')
            )
            ->join('flight_website', 'tracking_summary.flight_website_id', '=', 'flight_website.id')                                    
            ->join('flight', 'flight.id', '=', 'flight_website.flight_id')                                    
            ->whereIn('tracking_summary.website_id', $websiteRange)
            ->where('ovr',0)
            ->groupBy('flight_website.flight_id');

        if( !empty($searchData) ){
            foreach ($searchData as $search) {
                if( $search['value'] != '' ){
                	switch ($search['name']) {
                		case 'start_date':
	                		$date = date('Y-m-d', strtotime($search['value']));
	                		$query->where('tracking_summary.date', ">=" , $date);
                			break;
                		case 'end_date':
                			$date = date('Y-m-d', strtotime($search['value']));
                			$query->where('tracking_summary.date', "<=" , $date);
                			break;
                	}
                }
            }
        }
        return $query;
    }


}