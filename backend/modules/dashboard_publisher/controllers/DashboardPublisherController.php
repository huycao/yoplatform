<?php

use Carbon\Carbon;

class DashboardPublisherController extends PublisherBackendController {

    public function __construct() {
        parent::__construct(pathinfo(dirname(__DIR__), PATHINFO_BASENAME));
    }

    public function showIndex() {

        $trackingSummary = new TrackingSummaryBaseModel;

        $firstOfMonth   = Carbon::now()->firstOfMonth();
        $lastOfMonth    = Carbon::now()->lastOfMonth();

        $firstOfLastMonth   = Carbon::now()->firstOfMonth()->subMonth();
        $LastOfLastMonth    = Carbon::now()->firstOfMonth()->subMonth()->lastOfMonth();
        
        $websiteLists   = $this->getPublisher()->publisherSite->lists('id');

        // $this->data['earnPast3Month']     = $trackingSummary->getEarnPerMonth( $websiteLists, $firstOfLastMonth, $lastOfMonth);

        $this->data['earnToday']      = $trackingSummary->getEarnTotal( $websiteLists, date('Y-m-d'), date('Y-m-d') );
        $this->data['earnThisMonth']  = $trackingSummary->getEarnTotal( $websiteLists, $firstOfMonth, $lastOfMonth);
        $this->data['earnLastMonth']  = $trackingSummary->getEarnTotal( $websiteLists, $firstOfLastMonth, $LastOfLastMonth);
        $this->data['earnPast30']     = $trackingSummary->getEarnPerDate( $websiteLists, 30);

        $this->data['earnPast3Month'] = $trackingSummary->getEarnPerMonth( $websiteLists, 3);

        $this->layout->content = View::make('index', $this->data);
        
    }

}
